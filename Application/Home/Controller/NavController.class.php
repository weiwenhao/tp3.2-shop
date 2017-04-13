<?php
namespace Home\Controller;
use Think\Controller;
class NavController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $nav_data = D('Admin/category')->getNav();
        $this->assign('nav_data',$nav_data);

    }

}