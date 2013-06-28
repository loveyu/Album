<?php
class Admin{
	private $user;
	private $setting;
	public function __construct(){
		$this->user = get_lib('LibUser');
		$this->setting = get_lib("LibSetting");
		if(!is_login()){
			redirect("Login");
		}
		if(!is_admin()){
			redirect("Error/deny");
		}
		if(!is_active()){
			redirect("Error/active");
		}
	}
	public function main(){
		header_html();
		get_template()->add_style(array(
			'css/jquery-ui.css',
			"css/admin.css"
		));
		get_template()->add_js(array(
			'js/jquery-1.10.1.js',
			"js/jquery-ui.js",
			"js/jquery.form.js",
			"js/admin.js",
		));
		get_template()->set_title("后台管理中心");
		get_core()->view("admin/admin");
  	}
	public function ajax($action=""){
		header_json();
		switch($action){
			case "user_add":
				echo $this->user->ajax_user_add();
				break;
			case "user_list":
				echo $this->user->ajax_user_list();
				break;
			case "user_del":
				echo $this->user->ajax_user_del();
				break;
			case "user_edit":
				echo $this->user->ajax_user_edit();
				break;
			case "user_password":
				echo $this->user->ajax_user_password();
				break;
			case "setting_post":
				echo $this->setting->ajax_setting();
				break;
			default:
				header_404();
				echo "异常页面";
		}
	}
	public function user_edit(){
		header_html();
		get_core()->view("admin/user_edit");
	}
}
?>