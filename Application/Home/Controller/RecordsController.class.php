<?php
namespace Home\Controller;
use \Home\Controller;

class RecordsController extends BaseController
{
    public function index()
    {
        $records = M('reader_logs');
        $map = array(
            'uid' => $_SESSION['user_info']['id']
        );
        $count = $records->where($map)->count();
        $page = new \Think\Page($count);
        $show = $page->show();
        $list = $records->where($map)->order('id desc')->select();
        $this->assign('records', $list);
        $this->assign('page', $show);
        $this->display('index');
    }
}