<?php
namespace Admin\Model;
use Think\Model;
class RoleModel extends Model 
{
	protected $insertFields = array('role_name');
	protected $updateFields = array('role_id','role_name');
	protected $_validate = array(
		array('role_name', 'require', '角色名称不能为空！', 1, 'regex', 3),
		array('role_name', '1,30', '角色名称的值最长不能超过 30 个字符！', 1, 'length', 3),
	);
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this
            ->field('a.*,group_concat(c.auth_name) auth_name')
            ->alias('a')
            ->join('LEFT JOIN __ROLE_AUTH__ b ON a.role_id=b.role_id')
            ->join('LEFT JOIN __AUTHORITY__ c ON b.auth_id=c.auth_id')
            ->where($where)
            ->group('a.role_id')
            ->limit($page->firstRow.','.$page->listRows)
            ->select();
		return $data;
	}
	// 添加前
	protected function _before_insert(&$data, $option)
	{
	}
	// 添加后
	protected function _after_insert($data, $option)
	{
        $role_id = $data['role_id'];
        $auth_ids = I('post.auth_ids');
        $model = D('role_auth');
        foreach ($auth_ids as $k => $v){
            $model->add(array(
               'role_id' => $role_id,
                'auth_id' => $v,
            ));
        }
	}
	// 修改前
	protected function _before_update(&$data, $option)
	{
        $role_id = $option['where']['role_id'];
        $auth_ids = I('post.auth_ids');
        $model = D('role_auth');
        //先清空原有数据
        $model->where(array(
            'role_id' => $role_id,
        ))->delete();
        //插入新增数据
        foreach ($auth_ids as $k => $v){
            $model->add(array(
                'role_id' => $role_id,
                'auth_id' => $v,
            ));
        }

	}
	// 删除前
	protected function _before_delete($option)
	{
        $role_id = $option['where']['role_id'];
        //根据role_id删除中间表 role_auth表中对应的信息
        D('role_auth')->where(array(
            'role_id'=>array('eq',$role_id)
        ))->delete();


	}
	/************************************ 其他方法 ********************************************/
}