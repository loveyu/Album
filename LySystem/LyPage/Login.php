<?php
class Login{
	function __construct(){
		header_html();
	}
	public function main(){
		header_html();
		get_lib("LibTemplate")->set_title("用户登录");
		get_lib("LibTemplate")->add_style(array(
			"css/home.css",
			"css/colorbox.css",
		));
		get_template()->add_js(array(
			'js/jquery-1.8.2.min.js',
			'js/jquery.colorbox.js',
		));
		get_core()->view("common/header");
		get_core()->view("login");
		get_core()->view("common/footer");
	}
	public function logout(){
		get_core()->load_lib("LibUser")->delete_cookie();
		redirect(get_redirect());
	}
	public function post(){
		$user = get_core("LyPost")->get('user');
		$password = get_core("LyPost")->get('password');
		$remember = get_core("LyPost")->get('remember');
		if($remember === "ok")$remember = true;
		else $remember = false;
		$redirect = get_core("LyPost")->get('redirect');
		if(($err = get_core()->load_lib("LibUser")->login($user,$password,$remember)) === true){
			if(filter_var($redirect,FILTER_VALIDATE_URL)){
				redirect($redirect);
			}else{
				redirect(get_url());
			}
		}else{
			redirect(get_url('Login?error='.$err));
		}
	}
	public function register(){
		header_html();
		get_lib("LibTemplate")->set_title("用户注册");
		get_lib("LibTemplate")->add_style(array(
			"css/home.css",
			"css/colorbox.css",
		));
		get_template()->add_js(array(
			'js/jquery-1.8.2.min.js',
			'js/jquery.colorbox.js',
		));
		get_core()->view("common/header");
		get_core()->view("register");
		get_core()->view("common/footer");
	}
	public function register_action(){
		$user = array(
			"user" => get_core("LyPost")->get("user"),
			"password" => get_core("LyPost")->get("password"),
			"confirm" => get_core("LyPost")->get("confirm"),
			"email" => get_core("LyPost")->get("email")
		);
		if(($err = get_core()->load_lib("LibUser")->register($user)) === true){
				redirect("User");
		}else{
			redirect("register?error=$err");
		}
	}
}
?>