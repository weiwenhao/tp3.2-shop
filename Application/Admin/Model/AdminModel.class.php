<?php
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model 
{
	protected $insertFields = array('admin_name','password','password2');
	protected $updateFields = array('admin_id','admin_name','password','password2');
	protected $_validate = array(
		array('admin_name', 'require', '管理员名称不能为空！', 1, 'regex', 3),
		array('admin_name', '', '管理员名称已经存在！', 1, 'unique', 1),
		array('admin_name', '1,30', '管理员名称的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('password', 'require', '密码不能为空！', 1, 'regex', 1),
		array('password', '0,12', '密码的值最长不能超过 12 个字符！', 1, 'length', 3),
        array('password2','password','两次输入的密码不相同!',1,'confirm',3),//密码二次验证,该字段不加入数据库
        //以下是create方法第二个参数为4时会进行验证的方法 , 即登录时进行的验证
        array('admin_name', 'require', '管理员名称不能为空！', 1, 'regex', 4),
        array('password', 'require', '密码不能为空！', 1, 'regex', 4),
		array('captcha', 'require', '验证码不能为空！', 1, 'regex', 4),
		array('captcha', 'checkCaptcha', '验证码错误！', 1, 'callback',4),
	);

    /**
     * 验证验证码是否正确
     * @param $code 用户输入的验证码,这里是验证规则captcha中的值
     * @return bool
     */
    public function checkCaptcha($code){
        //$code是验证规则中字段的值
        $verify = new \Think\Verify();
        return $verify->check($code);
    }

    /**
     * 验证用户名和密码
     * @return bool
     */
    public function checklogin(){
        /* dump($this->data);die; //$data中包含有 用户名信息和密码,不包括验证码 ,这是为什么????????????????
        *array(2) {
             ["admin_name"] => string(3) "123"
             ["password"] => string(4) "1234"}*/
        $admin_name = $this->admin_name;
        $password = $this->password;
        $admin_data = $this->where(array(
            'admin_name'=>array('eq',$admin_name),
        ))->find();
        if($admin_data){
            if($admin_data['password'] == md5($password) ){
                //把用户名和id,保存在session中
                session('admin_id',$admin_data['admin_id']);
                session('admin_name',$admin_data['admin_name']);
                return true;
            }
            $this->error = '密码错误!';
            return false;
        }
        $this->error = '用户名不存在';
        return false;
    }

    /**
     * 退出登录,清空session
     */
    public function logout(){
        session(null);
    }
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		if($admin_name = I('get.admin_name'))
			$where['admin_name'] = array('like', "%$admin_name%");
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this
            ->field('a.*,group_concat(c.role_name) role_name')
            ->alias('a')
            ->join('LEFT JOIN __ADMIN_ROLE__ b ON a.admin_id=b.admin_Id')
            ->join('LEFT JOIN __ROLE__ c ON b.role_id=c.role_id')
            ->where($where)
            ->group('a.admin_id')
            ->limit($page->firstRow.','.$page->listRows)
            ->select();
		return $data;
	}
	// 添加前
	protected function _before_insert(&$data, $option)
	{
        $data['password'] = md5($data['password']); //密码MD5加密
	}

	//添加后
    protected function _after_insert($data, $options)
    {
        //对应角色的添加
        $admin_id = $data['admin_id'];
        $role_ids = I('post.role_ids');
        $model = D('admin_role');
        foreach ($role_ids as $k => $role_id){
            $model->add(array(
                'admin_id' => $admin_id,
                'role_id' => $role_id
            ));
        }
    }

    // 修改前
	protected function _before_update(&$data, $option)
	{
        //$data中的数据是可以修改的数据,而修改操作时主键id不能被修改所以放在 $option中
        //对应角色的添加
        $admin_id = $option['where']['admin_id'];
        $role_ids = I('post.role_ids');
        $model = D('admin_role');

        //删除admin_role中该管理员id的角色id数据
        $model->where(array(
            'admin_id' => $admin_id,
        ))->delete();
        foreach ($role_ids as $k => $role_id){
            $model->add(array(
                'admin_id' => $admin_id,
                'role_id' => $role_id
            ));
        }

        //对密码进行MD5加密
        if($data['password']){
            $data['password'] = md5($data['password']);
        }else{
            unset($data['password']); //删除这个字段,则不进行修改
        }
	}
	// 删除前
	protected function _before_delete($option)
	{
        $admin_id = $option['where']['admin_id'];
        //超级管理员不允许删除操作
        if($admin_id == 0)
        {
            $this->error = '超级管理员不允许删除';
            return FALSE;
        }

        //删除 admin_role表中对应的信息
        D('admin_role')->where(array(
            'admin_id'=>array('eq',$admin_id)
        ))->delete();


	}
	/************************************ 其他方法 ********************************************/
}