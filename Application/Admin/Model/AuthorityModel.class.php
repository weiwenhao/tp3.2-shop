<?php
namespace Admin\Model;
use Think\Model;
class AuthorityModel extends Model 
{
	protected $insertFields = array('auth_name','module','controller','action','parent_id');
	protected $updateFields = array('auth_id','auth_name','module','controller','action','parent_id');
	protected $_validate = array(
		array('auth_name', 'require', '权限名称 不能为空！', 1, 'regex', 3),
		array('auth_name', '1,30', '权限名称 的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('module', '1,30', '模块的值最长不能超过 30 个字符！', 2, 'length', 3),
		array('controller', '1,30', '控制器的值最长不能超过 30 个字符！', 2, 'length', 3),
		array('action', '1,30', '操作方法的值最长不能超过 30 个字符！', 2, 'length', 3),
		array('parent_id', 'number', '父级id必须是一个整数！', 2, 'regex', 3),
	);
	/************************************* 递归相关方法 *************************************/
	public function getTree()
	{
		$data = $this->select();
		return $this->_reSort($data);
	}
	private function _reSort($data, $parent_id=0, $level=0, $isClear=TRUE)
	{
		static $ret = array();
		if($isClear)
			$ret = array();
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$v['level'] = $level;
				$ret[] = $v;
				$this->_reSort($data, $v['auth_id'], $level+1, FALSE);
			}
		}
		return $ret;
	}
	public function getChildren($auth_id)
	{
		$data = $this->select();
		return $this->_children($data, $auth_id);
	}
	private function _children($data, $parent_id=0, $isClear=TRUE)
	{
		static $ret = array();
		if($isClear)
			$ret = array();
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$ret[] = $v['auth_id'];
				$this->_children($data, $v['auth_id'], FALSE);
			}
		}
		return $ret;
	}

    /**
     * 验证当前管理员是否有权限访问当前的控制器和操作方法 返回bool
     * @return bool
     */
	public function checkAuth(){
        //管理员id
        $admin_id = session('admin_id');

        /*该管理员可以访问的权限
         * 思路为,根据管理员id找到对应的角色Id,
         * 根据角色ID在中间表中找到该角色拥有的权限id,
         * 根据权限id在authority表中找到对应的权限
         * */
        $res = D('admin_role')->field('a.admin_id,c.*')
            ->alias('a')
            ->join('__ROLE_AUTH__ b ON a.role_id=b.role_id')
            ->join('__AUTHORITY__ c ON b.auth_id=c.auth_id')
            ->where(array(
                'a.admin_id'=>array('eq',$admin_id),
                'c.module'=>array('eq',MODULE_NAME),
                'c.controller'=>array('eq',CONTROLLER_NAME),
                'c.action'=>array('eq',ACTION_NAME),
            ))->count();
        return ($res > 0); //如果大于0则返回true,否则返回false
    }

    /**
     * 根据当前登陆的管理员id,得到该管理员拥有的前两级权限的嵌套数组
     * @return $data
     */
    public function getAuth(){
        //管理员id
        $admin_id = session('admin_id');
        //当前管理员拥有的权限
        $auth_data = D('admin_role')->field('a.admin_id,c.*')
            ->alias('a')
            ->join('__ROLE_AUTH__ b ON a.role_id=b.role_id')
            ->join('__AUTHORITY__ c ON b.auth_id=c.auth_id')
            ->where(array(
                'a.admin_id'=>array('eq',$admin_id),
            ))->select();
        //超级管理员特例处理
        if($admin_id == 0){
            $auth_data = D('authority')->select();
        }
        //制作嵌套数组
        $data = array();
        foreach ($auth_data as $k => $v){ //得到顶级权限,特征parent_id=0;
            if($v['parent_id'] == 0){
                //找到该权限的次一级权限
                foreach ($auth_data as $k1 => $v1){
                    if($v1['parent_id'] == $v['auth_id']){
                        $v['child'][] = $v1;
                    }
                }
                $data[$v['auth_id']] = $v;
            }

        }
        return $data; //如果大于0则返回true,否则返回false
    }
	/************************************ 其他方法 ********************************************/
	public function _before_delete($option)
	{
		// 先找出所有的子分类
		$children = $this->getChildren($option['where']['auth_id']);
		// 如果有子分类都删除掉
		if($children)
		{
			$this->error = '有下级数据无法删除';
			return FALSE;
		}
	}
}