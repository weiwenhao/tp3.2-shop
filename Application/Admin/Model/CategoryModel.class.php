<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model 
{
	protected $insertFields = array('cat_name','pid','is_floor');
	protected $updateFields = array('cat_id','cat_name','pid','is_floor');
	protected $_validate = array(
		array('cat_name', 'require', '分类名称不能为空！', 1, 'regex', 3),
		array('cat_name', '1,30', '分类名称的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('pid', 'require', '父级id不能为空！', 1, 'regex', 3),
		array('pid', 'number', '父级id必须是一个整数！', 1, 'regex', 3),
	);
	// 添加前
	protected function _before_insert(&$data, $option)
	{
	}
	// 修改前
	protected function _before_update(&$data, $option)
	{
	}
	// 删除前
	protected function _before_delete(&$option)
	{
        $cat_id = $option['where']['cat_id'];
		/**************删除分类的子分类**********************/
		//递归删除
        $cat_ids = $this->getCatIds($cat_id);
            //把原有的id添加到数组中去
            $cat_ids[] = $cat_id;
            //重新构造$option['where']
            $option['where']['cat_id'] = array(
                0 => 'IN',
                1 => implode(',',$cat_ids),
            ) ;

	}
	/************************************ 其他方法 ********************************************/

    /**
     * 根据分类id查找父级分类id, 最后只保留顶级分类id和二级分类id
     * @param $cat_id
     * @return array 返回商品分类的一维度数组,长度为2
     */
	public function getCat12($cat_id){
        /*static $data = array();
        $cat_data = $this->find($cat_id);
        $data[] = $cat_data;
        if($cat_data['pid'] > 0){
            $this->getCat12($cat_data['pid']);
        }
        //数组倒置,和截取
        $data = array_reverse($data);
        $data = array_slice($data,0,2);
        return $data;*/
        $data = array();
        $cat_data = $this->select();
        foreach ($cat_data as $k => $v){
            if($v['cat_id'] == $cat_id){ //找到了一条数据,以这条数据的pid做为下一次查找的cat_id继续查找
                $data[] = $v; //找到了一条数据要存到数组里去,然后挂起
                $data = array_merge($data,$this->getCat12($v['pid']));
            }
        }
        $data = array_reverse($data);
        $data = array_slice($data,0,2);
        return $data;
    }


	/**
     * 前台导航条,只有三级 ,使用三层for嵌套
     * @return array 6维数组
     */
    public function getNav($pid=0,$level=0){
        //先查看缓存中是否有数据
        if(S('nav_data')){
            return S('nav_data');
        }
        $cat_data = $this->select();
        $data = array();
        //寻找顶级分类
        foreach ($cat_data as $k => &$v){
            if($v['pid'] == 0){ //顶级分类
//                寻找顶级分类下的二级分类
                foreach ($cat_data as $k1 => &$v1){
                    if($v1['pid'] == $v['cat_id']){
                        //寻找三级分类
                        foreach ($cat_data as $k2 => $v2){
                            if($v2['pid'] == $v1['cat_id']){
                                $v1['child'][] = $v2;
                            }
                        }
                        $v['child'][] = $v1;
                    }
                }
                $data[] = $v;
            }
        }
        //方法2 递归方法
        /*foreach ($cat_data as $k => $v){
            //先递归查找再进行保存,全部寻找完毕后,进行保存,不会造成数组元素的重置
            if($v['pid'] == $pid && $level <= 2 ){
                $v['child'] = $this->getNav($v['cat_id'],$level+1);
                $data[] = $v;
            }
        }*/
        //制作好数据后将数据存数到缓存中(默认的文件缓存)
        S('nav_data',$data,86400);
        return $data;
    }


	//获得分类的子cat_id
	public function getCatIds($cat_id=0){
        $cat_data = $this->select();
        return $this->_getCatIds($cat_data,$cat_id);
    }
    private function _getCatIds($cat_data,$cat_id){
        $data = array();
        foreach ($cat_data as $k => $v){
            if( $v['pid'] == $cat_id ){ //这里是先存储再继续递归寻找
                $data[] = $v['cat_id'];
                //如果中很多找完一组了,return回来的值如何保存起来? 答:直接追加给所在函数的$data;
                $data=array_merge($data,$this->_getCatIds($cat_data,$v['cat_id']));
            }
        }
        return $data;
    }


    //获得分类表的排序好并维护了 level_id的数据的二维数组, select方法
    public function getCatData($pid=0){
        $cat_data = $this->select();
        return $this->_getCatData($cat_data,$pid);
    }
    private function _getCatData($cat_data,$pid,$level=0){
        $data = array();
        foreach ($cat_data as $k => $v){
            if( $v['pid'] == $pid ){ //这里是先存储再继续递归寻找
                $v['level'] = $level;
                $data[] = $v;
                //如果中很多找完一组了,return回来的值如何保存起来? 答:直接追加给所在函数的$data;
                $data=array_merge($data,$this->_getCatData($cat_data,$v['cat_id'],$level+1));
            }
        }
        return $data;
    }

/*    public function getCatData($pid=0,$level=0){
        $data = array();
        foreach ($this->select() as $k => $v){
            if( $v['pid'] == $pid ){ //这里是先存储再继续递归寻找
                $v['level'] = $level;
                $data[] = $v;
                //如果中很多找完一组了,return回来的值如何保存起来? 答:直接追加给所在函数的$data;
                $data=array_merge($data,$this->getCatData($this->select(),$v['cat_id'],$level+1));
                dump($data);
                echo '出来了<br>';
            }
        }
        return $data;
    }*/
}