<?php
namespace Home\Controller;
use Think\Controller;

class BaseController extends Controller
{
    public function __construct()
    {
        dump($_SESSION['user_info']);
        if(empty($_SESSION['user_info'])){
            $this->redirect('index/index', [], 2, '请先登录！');
        }
    }
}