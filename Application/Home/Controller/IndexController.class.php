<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->display('index');
    }

    public function login()
    {
        $uname = trim($_POST['uname']);
        $pwd = trim($_POST['pwd']);
        $error_url = U('index/index');
        if(empty($uname) || empty($pwd)){
            $this->error('账号或者密码不能为空', $error_url);
        }
        $user_model = M('user');
        $map = array(
            'uname' => $uname,
            'passwd' => $this->build_pwd($pwd, $uname)
        );
        $user = $user_model->where($map)->find();
        if(empty($user)){
            $this->error('用户名或密码不正确！', $error_url);
        }
        $_SESSION['user_info'] = $user;
        $this->success('欢迎回来！', U('records/index'));
    }

    //注册
    public function register()
    {
        $this->display('register');
    }

    public function do_reg()
    {
        $uname = trim($_POST['uname']);
        $pwd = trim($_POST['pwd']);
        $re_pwd = trim($_POST['re_pwd']);
        $email = trim($_POST['email']);
        if(empty($uname) || empty($pwd) || empty($re_pwd)){
            $this->error('账号或者密码不能为空', $_SERVER["REQUEST_URI"]);
        }
        if($pwd != $re_pwd){
            $this->error('两次输入的密码不一致', $_SERVER["REQUEST_URI"]);
        }
        $user = M('user');
        $data = array(
            'uname' => $uname,
            'passwd' => $this->build_pwd($pwd, $uname),
            'email' =>$email,
            'create_at' => time(),
            'update_at' => time(),
            'ip' => get_client_ip()
        );
        $add_id = $user->data($data)->add();
        if(empty($add_id)){
            $this->error('注册失败，请稍微重试...', $_SERVER["REQUEST_URI"]);
        }else{
            $_SESSION['user_info'] = $user;
            $this->success('注册成功', U('records/index'));
        }
    }

    // 生成密码
    private function build_pwd($pwd, $uname)
    {
        return md5($pwd. C('PWD_PREFIX'). $uname);
    }
}