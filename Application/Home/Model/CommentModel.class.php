<?php
namespace Home\Model;
use Think\Model;
class CommentModel extends Model
{
	protected $insertFields = array('goods_id','comment_content','level');
	protected $_validate = array(
		array('goods_id', 'require', '数据格式错误', 1, 'regex', 3),
        array('comment_content', '1,200', '评论内容必须在1-200个字符之间', 1, 'length', 3),
        array('level', '1,2,3,4,5', '数据格式错误', 1, 'in', 3),
	);

    public function _before_insert(&$data, $options)
    {
        //登录验证
        $member_id = session('member_id');
        if($member_id == null){
            $this->error = '请先登录';
            return false;
        }
        //数据库字段维护
        $data['member_id'] = $member_id;
        $data['add_time'] = date('Y-m-d H:i:s',time());

        //印象数据维护
        $yx_data = I('post.trait_name');
        $yx_data = str_replace('，',',',$yx_data);//中文逗号替换 成英文
        $yx_data = explode(',',$yx_data); //转换成数组
        $model = D('trait');
        foreach($yx_data as $k=>&$v){
            $v = trim($v);
            if($v){
                //判断数据库中是否存在该印象
                $yx = $model->where(array(
                    'goods_id' => $data['goods_id'],
                    'trait_name' => $v,
                ))->find();
                if($yx){
                    $model->where(array(
                        'goods_id' => $data['goods_id'],
                        'trait_name' => $v,
                    ))->setInc('trait_count');
                }else{
                    $model->add(array(
                        'goods_id' => $data['goods_id'],
                        'trait_name' => $v,
                    ));
                }
            }

        }

        //已有印象数据维护
        $yy_yx = I('post.yy_yx');
        if($yy_yx){
            foreach ($yy_yx as $k=>$v){
                $model->where(array(
                    'goods_id' => $data['goods_id'],
                    'trait_name' => $v,
                ))->setInc('trait_count');
            }
        }
    }

    /**
     * @param $listRows 每页显示记录数
     */
    public function getPage($listRows){
        //得到当前页码
        $data = array();
        $p = max(1,I('get.p',1)); //页码数必须大于1
        //当页码数为1时,取出评价率和印象
        if($p == 1){
            $level = $this->field('level')->where(array(
                'goods_id' => I('get.goods_id'),
            ))->select();
            $hao=$zhong=$cha = 0;
            foreach ($level as $k=>$v){
                if($v['level'] == 3){
                    $zhong++;
                }
                if($v['level'] > 3){
                    $hao++;
                }
                if($v['level'] < 3){
                    $cha++;
                }
            }
            $sum = $zhong+$hao+$cha;
            $data['hao'] = (int)round($hao/$sum*100);
            $data['zhong'] = (int)round($zhong/$sum*100);
            $data['cha'] = (int)round($cha/$sum*100);
            //取出印象数据
            $data['yx_data'] = D('trait')->where(array(
                'goods_id'=>I('get.goods_id'),
            ))->select();


        }
        //总记录数
        $total = $this->where(array(
            'goods_id' => I('get.goods_id'),
        ))->count();
        //总的页码数
        $data['pageNum'] = ceil($total/$listRows);
        //计算偏移量
        $firstRow = ($p-1)*$listRows; //当前页码数-1乘每页记录数
        //取出一页数据, 连表取头像和会员名称
        $data['pageData'] = $this->alias('a')
            ->field('a.*,b.member_id,b.member_name,b.face,count(c.reply_id) reply_count')
            ->where(array(
                'a.goods_id' => I('get.goods_id'),
            ))
            ->join('LEFT JOIN __MEMBER__ b ON a.member_id=b.member_id')
            ->join('LEFT JOIN __REPLY__ c ON a.comment_id=c.comment_id')
            ->order('a.comment_id desc')
            ->group('a.comment_id')
            ->limit("$firstRow,$listRows")
            ->select();
        return $data;

    }


}