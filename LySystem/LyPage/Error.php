<?php
/**
 * Created by Loveyu.
 * User: loveyu
 * Date: 13-5-27
 * Time: 下午11:58
 * LyCore
 * Released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
 */
class Error
{
	public function sql(){
		get_core()->view("error/sql");
	}
	public function deny(){
		header_html();
		get_lib("LibTemplate")->set_title("404 未找到");
		get_lib("LibTemplate")->add_style(array(
			"css/common.css",
		));
		get_core()->view("common/header");
		get_core()->view("error/deny");
		get_core()->view("common/footer");
	}
	public function e404(){
		header_404();
		header_html();
		get_lib("LibTemplate")->set_title("404 未找到");
		get_lib("LibTemplate")->add_style(array(
			"css/common.css",
		));
		get_core()->view("common/header");
		get_core()->view("error/404");
		get_core()->view("common/footer");
	}
	public function active(){
		header_html();
		get_lib("LibTemplate")->set_title("账户未激活");
		get_lib("LibTemplate")->add_style(array(
			"css/common.css",
		));
		get_core()->view("common/header");
		get_core()->view("error/active");
		get_core()->view("common/footer");
	}
}
