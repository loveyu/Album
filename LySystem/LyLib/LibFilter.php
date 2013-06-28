<?php
class LibFilter
{
	public function URL()
	{
		return true;
	}

	public function LIB()
	{
		if(version_compare(PHP_VERSION,"5.4","<")){
			get_core()->view("error/version");
			exit;
		}
		$this->setTimeZone();
		$this->SQL();
		get_core()->load_helper('header');
		get_core()->load_lib('ApiUser','ApiTemplate','LibSetting','LibTemplate','LibUser');
		return true;
	}

	public function SQL()
	{
		$sql = get_core()->load_c_lib("CLibSql");
		if ($sql->status() === false) {
			get_core()->view("error/sql");
			exit;
		}
	}

	private function setTimeZone()
	{
		date_default_timezone_set('Asia/Shanghai');
	}
}

?>