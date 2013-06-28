<?php
function get_redirect()
{
	$redirect = "";
	if (($redirect = get_core('LyGet')->get('redirect')) != false) {
		$redirect = urldecode($redirect);
		if (!filter_var($redirect, FILTER_VALIDATE_URL)) {
			$redirect = "";
		}
	}
	if ($redirect == "" && isset($_SERVER['HTTP_REFERER'])) {
		$redirect = $_SERVER['HTTP_REFERER'];
	}
	if (in_array(parse_url($redirect, PHP_URL_HOST), array($_SERVER['HTTP_HOST']))) {
		return $redirect;
	}
	return "";
}
function get_site_name(){
	return get_lib('LibSetting')->get('site_name');
}
function get_template(){
	return get_lib("LibTemplate");
}
function get_site_description(){
	return get_lib("LibSetting")->get('site_description');
}
function get_upload_path($file=''){
	if(!defined('PATH_UPLOAD')){
		if(($path = get_config('picture','path'))==""){
			$path = "pic";
		}
		if(!is_dir(WEB_PATH.$path."/")){
			if(mkdir(WEB_PATH.$path."/")){
				return false;
			}
		}
		define('PATH_UPLOAD',str_replace("//","/",WEB_PATH.$path."/"));
	}
	return PATH_UPLOAD.$file;
}
function get_pic_max_size(){
	if(get_config('picture','max_size') > 0){
		return get_config('picture','max_size');
	}else{
		return 100000;
	}
}
function get_pic($file){
	if(!defined("PIC_URL")){
		if(($path = get_config('picture','path'))==""){
			$path = "pic";
		}
		$path = str_replace("\\","/",$path);
		if($path{0}=="/"){
			$path = substr($path,1);
		}
		if($path{strlen($path)-1}=="/"){
			$path = substr($path,1);
		}
		define('PIC_URL',WEB_FILE_URL.$path."/");
	}
	return PIC_URL.$file;
}
function get_pic_big($file){
	$arr = pathinfo($file);
	return get_pic($arr['filename']."_big.".$arr['extension']);
}
function get_pic_middle($file){
	$arr = pathinfo($file);
	return get_pic($arr['filename']."_middle.".$arr['extension']);
}
function get_pic_small($file){
	$arr = pathinfo($file);
	return get_pic($arr['filename']."_small.".$arr['extension']);
}
function get_pic_path($file){
	return get_upload_path($file);
}
function get_pic_big_path($file){
	$arr = pathinfo($file);
	return get_upload_path($arr['filename']."_big.".$arr['extension']);
}
function get_pic_middle_path($file){
	$arr = pathinfo($file);
	return get_upload_path($arr['filename']."_middle.".$arr['extension']);
}
function get_pic_small_path($file){
	$arr = pathinfo($file);
	return get_upload_path($arr['filename']."_small.".$arr['extension']);
}
function get_tags($tag){
	$tags = explode(",",$tag);
	$rt = "";
	foreach($tags as $v){
		$v = trim($v);
		if(!empty($v)){
			$rt.="<a href=\"#\">$v</a>";
		}
	}
	return $rt;
}
?>