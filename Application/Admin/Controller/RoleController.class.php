<?php
namespace Admin\Controller;
class RoleController extends BaseController
{
    public function add()
    {
    	if(IS_POST)
    	{
    		$model = D('Role');
    		if($model->create(I('post.'), 1))
    		{
    			if($id = $model->add())
    			{
    				$this->success('添加成功！', U('lst?p='.I('get.p')));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
        //得到权限分类
        $auth_data = D('authority')->getTree();
		// 设置页面中的信息
		$this->assign(array(
		    'auth_data'=>$auth_data,
			'_page_title' => '添加角色',
			'_page_btn_name' => '角色列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }
    public function edit()
    {
    	$role_id = I('get.role_id');
    	if(IS_POST)
    	{
    		$model = D('Role');
    		if($model->create(I('post.'), 2))
    		{
    			if($model->save() !== FALSE)
    			{
    				$this->success('修改成功！', U('lst', array('p' => I('get.p', 1))));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
    	$model = M('Role');
    	$data = $model->find($role_id);
    	$this->assign('data', $data);
        //权限列表
        $auth_data = D('authority')->getTree();
        //该角色拥有的权限id
        $ar_data = D('role_auth')->where(array(
            'role_id'=>$role_id,
        ))->select();
        $auth_ids = array();
        foreach ($ar_data as $k => $v){
            $auth_ids[] = $v['auth_id'];
        }
		// 设置页面中的信息
		$this->assign(array(
		    'auth_data' => $auth_data,
            'auth_ids' => $auth_ids,
			'_page_title' => '修改角色',
			'_page_btn_name' => '角色列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Role');
    	if($model->delete( ''.I('get.role_id').'' ) !== FALSE)
    	{
    		$this->success('删除成功！', U('lst', array('p' => I('get.p', 1))));
    		exit;
    	}
    	else 
    	{
    		$this->error($model->getError());
    	}
    }
    public function lst()
    {
    	$model = D('Role');
    	$data = $model->search();
    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));
		// 设置页面中的信息
		$this->assign(array(
			'_page_title' => '角色列表',
			'_page_btn_name' => '添加角色',
			'_page_btn_link' => U('add'),
		));
    	$this->display();
    }
}