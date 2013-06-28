<?php
/**
 * Created by Loveyu.
 * User: loveyu
 * Date: 13-5-27
 * Time: 下午10:34
 * LyCore
 * Released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
 */
require_once(CORE_PATH."library/medoo.php");
class CLibSql extends medoo{
	private $status = false;
	private $ex_message = "";
	function __construct(){
		$setting = get_config('sql');
		if(!is_array($setting)){
			return;
		}
		try{
			parent::__construct($setting);
			$this->status = true;
		}catch (PDOException $ex){
			$this->ex_message = $ex->getMessage();
		}
	}
	public function status(){
		return $this->status;
	}
	public function ex_message(){
		return $this->ex_message;
	}
	public function get_query_count(){
		return $this->count_number;
	}
}
?>