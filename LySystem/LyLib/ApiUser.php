<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-6-18
 * Time: 上午9:28
 * To change this template use File | Settings | File Templates.
 * API 用户
 */
function is_login(){
	return get_lib('LibUser')->login();
}
function is_admin(){
	return get_power()=="admin";
}
function is_active(){
	return get_lib('LibUser')->user['active'] == true;
}
function is_user(){
	return get_power() == "user";
}
function get_power(){
	$libUser = get_lib('LibUser');
	if($libUser->user != false && isset($libUser->user['power'])){
		return strtolower($libUser->user['power']);
	}
	return "";
}
function password($str,$md5=false){
	return hash("sha512",md5("\n".($md5?$str:md5($str))."yY\t")."dfh&43Jdf_||/./");
}
function get_user_id(){
	return 0+get_lib('LibUser')->user['id'];
}
function get_user_info($id){
	return get_lib('LibUser')->user_info($id);
}
function get_user_name(){
	return get_lib('LibUser')->user['user'];
}
function get_user_email(){
	return get_lib('LibUser')->user['email'];
}
function get_user_signa(){
	return get_lib('LibUser')->user['signa'];
}
function get_user_site(){
	return get_lib('LibUser')->user['site'];
}
function allow_register(){
	return get_lib('LibSetting')->get('allow_register') == "true";
}
?>