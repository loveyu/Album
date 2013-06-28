<?php
/**
 * Created by Loveyu.
 * User: loveyu
 * Date: 13-6-21
 * Time: 下午12:02
 * LyCore
 * Released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
 */
class LibSetting
{
	public $list = false;
	private $up_setting;
	private $sql;

	public function __construct()
	{
		$this->sql = get_core()->load_c_lib("CLibSql");
		$this->load_setting();
		$this->up_setting = array();
	}

	private function load_setting()
	{
		$sr = $this->sql->select("setting", array("name", "value"), array("auto_load" => true));
		if (is_array($sr)) {
			$this->list = array();
			foreach ($sr as $v) {
				$this->list[$v['name']] = $v['value'];
			}
		}
		if ($this->list === false || count($this->list) == 0) {
			redirect("error/sql?code=1");
		}
	}

	public function get($n = false)
	{
		if ($n === false) return $this->list;
		if (isset($this->list[$n])) {
			return $this->list[$n];
		}
		return false;
	}

	public function set($list)
	{
		foreach($list as $n => $v){
			if(isset($this->list[$n])){
				if($this->list[$n] != $v){
					$this->list[$n] = $v;
					$this->up_setting[$n] = $v;
				}
			}else{
				$this->list[$n] = $v;
				$this->up_setting[$n] = $v;
			}
		}
	}

	public function up_setting()
	{
		if(count($this->up_setting)<=0)return "没有改动的内容";
		foreach($this->up_setting as $n => $v){
			$this->sql->update("setting",array('value'=>$v),array("name"=>$n));
		}
		return true;
	}

	public function ajax_setting()
	{
		$rt = array('message' => '', 'status' => false);
		$post = get_core("LyPost");
		$list = array(
			"site_name" => trim(get_core("LySafe")->text($post->get('site_name'))),
			"site_description" => trim(get_core("LySafe")->text($post->get('site_description'))),
			"allow_register" => strtolower(trim($post->get("allow_register")))
		);
		if ($list['site_name'] == "") {
			$rt['message'] = "站点标题非法";
		} else if ($list['allow_register'] != "true" && $list['allow_register'] != "false") {
			$rt['message'] = "允许注册方法非法";
		} else {
			$this->set($list);
			if (($err = $this->up_setting()) !== true) {
				$rt['message'] = $err;
			} else {
				$rt['status'] = true;
			}
		}
		return json_encode($rt);
	}
}
