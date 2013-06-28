<?php
class LibTemplate
{
	private $title;
	private $head_list;
	private $foot_list;
	public $full_title;
	private $pagination_list;

	function __construct()
	{
		$this->title = get_site_name();
		$this->head_list = array();
		$this->foot_list = array();
		$this->full_title = "";
		$this->pagination_list = array();
	}

	public function set_title($title)
	{
		$this->title = $title;
	}

	public function get_title()
	{
		return $this->title;
	}

	public function the_title()
	{
		if (!empty($this->full_title)) {
			echo $this->full_title;
			return;
		}
		if ($this->title == get_site_name()) echo $this->title;
		else echo $this->title, " - ", get_site_name();
	}

	public function is_home()
	{
		return count(get_core('LyUrl')->get_req_list()) == 0;
	}

	public function add_head($list)
	{
		if (is_string($list)) array_push($this->head_list, $list);
		if (is_array($list)) {
			foreach ($list as $v) {
				array_push($this->head_list, $v);
			}
		}
	}

	public function add_foot($list)
	{
		if (is_string($list)) array_push($this->foot_list, $list);
		if (is_array($list)) {
			foreach ($list as $v) {
				array_push($this->foot_list, $v);
			}
		}
	}

	public function the_head($before = "", $after = "\n")
	{
		foreach ($this->head_list as $v) {
			echo $before, $v, $after;
		}
	}

	public function the_foot($before = "", $after = "\n")
	{
		foreach ($this->foot_list as $v) {
			echo $before, $v, $after;
		}
	}

	public function add_js($path, $foot = false)
	{
		if (!is_array($path)) {
			$path = array($path);
		}
		foreach ($path as $v) {
			if (!filter_var($v, FILTER_VALIDATE_URL)) {
				$v = get_file_url($v);
			}
			$t = "<script src=\"$v\" type=\"text/javascript\"></script>";
			if (!$foot) $this->add_head($t);
			else $this->add_foot($t);
		}
	}

	public function add_style($path, $foot = false)
	{
		if (!is_array($path)) {
			$path = array($path);
		}
		foreach ($path as $v) {
			if (!filter_var($v, FILTER_VALIDATE_URL)) {
				$v = get_file_url($v);
			}
			$t = "<link rel=\"stylesheet\" href=\"$v\" type=\"text/css\" />";
			if (!$foot) $this->add_head($t);
			else $this->add_foot($t);
		}
	}

	public function set_pagination($name, $count, $now)
	{
		$now += 0;
		$count += 0;
		if ($now <= 0) $now = 1;
		if ($now > $count) {
			$count = $now;
		}
		$this->pagination_list[$name] = array('count' => $count, "now" => $now);
	}
	public function the_pagination($name,$page = "page_[]"){
		if(!isset($this->pagination_list[$name])) return;
		$flag = false;
		$last = 0;
		for($i = 1; $i <= $this->pagination_list[$name]['count'];$i++){
			if($i==1 || $i==$this->pagination_list[$name]['count'] || abs($i - $this->pagination_list[$name]['now']) <= 2 ){
				if($last+1 != $i){
					echo "<span>...</span>\n";
				}
				$last = $i;
				echo "<a href=\"".str_replace("[]",$i,$page)."\"".($i==$this->pagination_list[$name]['now']?"class=\"active\"":"").">$i</a>\n";
			}else{

			}
		}
	}
}

?>