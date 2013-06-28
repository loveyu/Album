<?php
class Album
{
	public function main($page = 1)
	{
		$list = get_lib("LibGet")->get_list($page);
		if (count($list['list']) == 0) {
			get_core()->load("Error","e404");
		} else {
			header_html();
			get_lib("LibTemplate")->set_title("图汇列表");
			get_lib("LibTemplate")->add_style(array(
				"css/home.css",
				"css/colorbox.css",
			));
			get_template()->add_js(array(
				'js/jquery-1.8.2.min.js',
				'js/jquery.colorbox.js',
			));
			get_core()->view("common/header");
			get_core()->view("album/list",array("list"=>&$list['list'],"count"=>$list['pn']['count']));
			get_core()->view("common/footer");
		}
	}
	public function album_id($id=0){
		$list = get_lib("LibGet")->get_album($id);
		if ($list===false) {
			get_core()->load("Error","e404");
		} else {
			$list['user'] = get_user_info($list['album']['user']);
			header_html();
			get_lib("LibTemplate")->set_title($list['album']['name']);
			get_lib("LibTemplate")->add_style(array(
				"css/home.css",
				"css/colorbox.css",
			));
			get_template()->add_js(array(
				'js/jquery-1.8.2.min.js',
				'js/jquery.colorbox.js',
			));
			get_core()->view("common/header");
			get_core()->view("album/album",$list);
			get_core()->view("common/footer");
		}
	}
	public function picture($id=0){
		$list = get_lib("LibGet")->get_pic($id);
		if ($list===false) {
			get_core()->load("Error","e404");
		} else {
			header_html();
			get_lib("LibTemplate")->set_title($list['0']['title']);
			get_lib("LibTemplate")->add_style(array(
				"css/home.css",
				"css/colorbox.css",
			));
			get_template()->add_js(array(
				'js/jquery-1.8.2.min.js',
				'js/jquery.colorbox.js',
			));
			get_core()->view("common/header");
			get_core()->view("album/picture",array("info"=>$list[0]));
			get_core()->view("common/footer");
		}
	}
	public function user($id=0){
		$info = get_user_info($id);
		if ($info===false) {
			get_core()->load("Error","e404");
		} else {
			header_html();
			get_lib("LibTemplate")->set_title("用户 - ".$info['user']);
			get_lib("LibTemplate")->add_style(array(
				"css/home.css"
			));
			get_template()->add_js(array(
				'js/jquery-1.10.1.js',
			));
			get_core()->view("common/header");
			get_core()->view("album/user",array("info"=>$info));
			get_core()->view("common/footer");
		}
	}
}

?>