<?php
namespace Admin\Controller;
class AuthorityController extends BaseController
{
    public function add()
    {
    	if(IS_POST)
    	{
    		$model = D('Authority');
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
		$parentModel = D('Authority');
		$parentData = $parentModel->getTree();
		$this->assign('parentData', $parentData);

		// 设置页面中的信息
		$this->assign(array(
			'_page_title' => '添加权限',
			'_page_btn_name' => '权限列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }
    public function edit()
    {
    	$auth_id = I('get.auth_id');
    	if(IS_POST)
    	{
    		$model = D('Authority');
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
    	$model = M('Authority');
    	$data = $model->find($auth_id);
    	$this->assign('data', $data);
		$parentModel = D('Authority');
		$parentData = $parentModel->getTree();
		$children = $parentModel->getChildren($auth_id);
		$this->assign(array(
			'parentData' => $parentData,
			'children' => $children,
		));

		// 设置页面中的信息
		$this->assign(array(
			'_page_title' => '修改权限',
			'_page_btn_name' => '权限列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Authority');
    	if($model->delete(I('get.auth_id', 0)) !== FALSE)
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
    	$model = D('Authority');
		$data = $model->getTree();
    	$this->assign(array(
    		'data' => $data,
    	));

		// 设置页面中的信息
		$this->assign(array(
			'_page_title' => '权限列表',
			'_page_btn_name' => '添加权限',
			'_page_btn_link' => U('add'),
		));
    	$this->display();
    }
}