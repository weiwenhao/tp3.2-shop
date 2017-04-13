<?php
namespace Admin\Controller;
class CategoryController extends BaseController
{
    public function add(){
        $model = D('Category');
        if(IS_POST)
    	{
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

        //分类二维数组的重新排序,调用排序函数
        $cat_data = $model->getCatData();
		// 设置页面中的信息
		$this->assign(array(
		    'cat_data' => $cat_data,
			'_page_title' => '添加商品分类',
			'_page_btn_name' => '商品分类列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }
    public function edit()
    {
    	$cat_id = I('get.cat_id');
        $model = D('Category');
    	if(IS_POST)
    	{

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
    	$data = $model->find($cat_id);
    	$this->assign('data', $data);

        /*******************分类数据的获取和排序**********************/
        $cat_data = $model->getCatData();
        $not_cat_ids = $model->getCatIds($cat_id);
		// 设置页面中的信息
		$this->assign(array(
		    'not_cat_ids' => $not_cat_ids,
		    'cat_data' =>$cat_data,
			'_page_title' => '修改商品分类',
			'_page_btn_name' => '商品分类列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }
    public function delete()
    {
        $model = D('category');
//        $model = new \Think\Model('category'); //这样实例化走到钩子方法是父类的钩子方法
 	    if($model->delete(I('get.cat_id', 0)) !== FALSE)
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
    	$model = D('Category');
    	$data = $model->getCatData();
    	$this->assign(array(
    		'data' => $data,
    	));

		// 设置页面中的信息
		$this->assign(array(
			'_page_title' => '商品分类列表',
			'_page_btn_name' => '添加商品分类',
			'_page_btn_link' => U('add'),
		));
    	$this->display();
    }
}