<?php
namespace Home\Controller;
use Think\Controller;

class BaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if(empty($_SESSION['user_info'])){
            $this->redirect('index/index', [], 2, '请先登录！');
        }
    }
}