<?php
	class Welcome{
		public $sql;
		function __construct(){
			$this->sql = get_core()->load_c_lib("CLibSql");
		}
		public function main(){
			header_html();
			get_lib("LibTemplate")->add_style(array(
				"css/home.css",
				"css/colorbox.css",
			));
			get_template()->add_js(array(
				'js/jquery-1.8.2.min.js',
				'js/jquery.colorbox.js',
			));
			get_core()->view("common/header");
			get_core()->view("index",array('list'=>get_lib('LibGet')->get_rand(8)));
			get_core()->view("common/footer");
		}

	}
?>