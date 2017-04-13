<?php
/**
 * 根据传递过来的url中的get参数中的key值,进行url重写(删除该键值)
 * @param $field
 */
function fieldUrl($param){
    $url = __SELF__;
    $rec = "/\/$param\/[^\/]+/";
    $rec = preg_replace($rec,'',$url);
    return $rec;
}

/**
 * 制作标准下拉框
 * @param $tabName
 * @param $tableName
 * @param $fieldID
 * @param $fieldName
 * @param string $selectedID
 */
function showSelect($tabName,$tableName,$fieldID,$fieldName,$selectedID=''){
    //select标签的name,需要实例化模型的表名, option标签的value值,option的显示值,下拉框中默认显示的项
    //实例化模型得到数据
    $model = D($tableName);
    $data = $model->select(); //这里得到一个二维数组
    $s = "<select name='$tabName'>";
    $s .= "<option value=''>请选择</option>";
    //循环数据

    
    foreach ($data as $k => $v){ //$k是索引,$v是一个包含每条记录的一位数组
        
        //默认值判断
        $selected = '';  //每次循环selected的值都被清空,否则会造成一次赋值后,后续都会被赋值
        if($selectedID == $v[$fieldID]){
            $selected = "selected='selected'";
        }

        $s.="<option ".$selected." value='".$v[$fieldID]."'>".$v[$fieldName]."</option>";
    }
    $s .= "</select>";
    echo $s;

}
//删除图片函数 同showImage()函数
function deleteImage($image = array())
{
    $savePath = C('IMAGE_CONFIG');
    foreach ($image as $v)
    {
        unlink($savePath['rootPath'] . $v);
    }
}
/**
 * 上传图片并生成缩略图
 * 用法：
 * $ret = uploadOne('logo', 'Goods', array(
array(600, 600),
array(300, 300),
array(100, 100),
));
返回值：
if($ret['ok'] == 1)
{
$ret['images'][0];   // 原图地址
$ret['images'][1];   // 第一个缩略图地址
$ret['images'][2];   // 第二个缩略图地址
$ret['images'][3];   // 第三个缩略图地址
}
else
{
$this->error = $ret['error'];
return FALSE;
}
 *
 */
function uploadOne($imgName, $dirName, $thumb = array())
{
    // 上传LOGO
    if(isset($_FILES[$imgName]) && $_FILES[$imgName]['error'] == 0)
    {
        $ic = C('IMAGE_CONFIG');
        $upload = new \Think\Upload(array(
            'rootPath' => $ic['rootPath'],
            'maxSize' => $ic['maxSize'],
            'exts' => $ic['exts'],
        ));// 实例化上传类
        $upload->savePath = $dirName . '/'; // 图片二级目录的名称
        // 上传文件
        // 上传时指定一个要上传的图片的名称，否则会把表单中所有的图片都处理，之后再想其他图片时就再找不到图片了
        $info   =   $upload->upload(array($imgName=>$_FILES[$imgName]));
        if(!$info)
        {
            return array(
                'ok' => 0,
                'error' => $upload->getError(),
            );
        }
        else
        {
            $ret['ok'] = 1;
            $ret['images'][0] = $logoName = $info[$imgName]['savepath'] . $info[$imgName]['savename'];
            // 判断是否生成缩略图
            if($thumb)
            {
                $image = new \Think\Image();
                // 循环生成缩略图
                foreach ($thumb as $k => $v)
                {
                    $ret['images'][$k+1] = $info[$imgName]['savepath'] . 'thumb_'.$k.'_' .$info[$imgName]['savename'];
                    // 打开要处理的图片
                    $image->open($ic['rootPath'].$logoName);
                    $image->thumb($v[0], $v[1],2)->save($ic['rootPath'].$ret['images'][$k+1]);  //wwh_修改处
                }
            }
            return $ret;
        }
    }
}
//制作图片路径函数  showImage('数据库路径')
function showImage($url, $width = '', $height = '')
{
    $ic = C('IMAGE_CONFIG');
    if($width)
        $width = "width='$width'";
    if($height)
        $height = "height='$height'";
    echo "<img $width $height src='{$ic['viewPath']}$url' />";
}

//定义一个选择过滤函数,前台和后台都可以调用
function removeXSS($data){
    require_once './HtmlPurifier/HTMLPurifier.auto.php';
    $_clean_xss_config = HTMLPurifier_Config::createDefault();
    $_clean_xss_config->set('Core.Encoding', 'UTF-8');
    $_clean_xss_config->set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]');
    $_clean_xss_config->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
    $_clean_xss_config->set('HTML.TargetBlank', TRUE);
    $_clean_xss_obj = new HTMLPurifier($_clean_xss_config);
    //执行过滤
    return $_clean_xss_obj->purify($data);
}