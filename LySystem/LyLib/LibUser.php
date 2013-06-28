<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-6-18
 * Time: 上午9:29
 * To change this template use File | Settings | File Templates.
 * 用户操作接口
 */
class LibUser
{
	public $user = false;
	private $sql;

	public function __construct()
	{
		$this->sql = get_core()->load_c_lib("CLibSql");
	}

	public function power_list()
	{
		return array('admin', 'user');
	}

	public function login($user = false, $pwd = false, $rem = false)
	{
		if ($this->user != false) return true;
		if (!$user || !$pwd) return $this->cookie_login();
		if (filter_var($user, FILTER_VALIDATE_EMAIL))
			$list = $this->sql->get("user", "*", array('email' => $user));
		else
			$list = $this->sql->get("user", "*", array('user' => $user));
		if ($list) {
			if ($list['password'] == password($pwd)) {
				$this->user = $list;
				$this->set_cookie($pwd, $rem);
				return true;
			} else {
				return "密码错误";
			}
		} else {
			return "用户不存在";
		}
	}

	private function cookie_login()
	{
		$cookie = get_core("LyCookie")->get("login");
		if ($cookie == "") return false;
		$login = explode("\n", $cookie);
		if (count($login) != 3) return false;
		$list = $this->sql->get("user", "*", array('id' => $login[0]));
		if (trim($login[2]) !== $_SERVER['HTTP_USER_AGENT']) return false;
		if ($list) {
			if ($list['password'] == password($login[1], true)) {
				$this->user = $list;
				return true;
			}
		}
		return false;
	}

	private function set_cookie($pwd, $rem)
	{
		$cookie = get_core("LyCookie");
		$time = 0;
		if ($rem) $time = 604800 + time();
		$cookie->set("login", $this->user['id'] . "\n" . md5($pwd) . "\n" . $_SERVER['HTTP_USER_AGENT'], $time);
	}

	public function delete_cookie()
	{
		get_core("LyCookie")->del("login");
	}

	public function user_info($id)
	{
		if ((0 + $id) <= 0) return false;
		return $this->sql->select("user", array("id", "user", "email", "signa", "site", "power", "active"), array('id' => $id))[0];
	}

	public function register($user)
	{
		$user = $this->user_to_text($user);
		if (($err = $this->user_check($user, "reg")) !== true) {
			return $err;
		}
		if ($this->user_exists($user['user'])) return "用户已存在";
		if ($this->email_exists($user['email'])) return "邮件地址已存在";
		if (is_int($err = $this->register_sql($user))) {
			return true;
		}
		return $err;
	}

	public function user_exists($user)
	{
		if ($user == "" || strlen($user) < 4) return false;
		return $this->sql->has("user", array("user" => $user));
	}

	public function email_exists($email)
	{
		if ($email == "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
		return $this->sql->has("user", array("email" => $email));
	}

	private function register_sql($user)
	{
		unset($user['confirm']);
		$user['password'] = password($user['password']);
		if (isset($user['active']) && is_admin()) {
			if ($user['active'] === "true") {
				$user['active'] = true;
			} else {
				unset($user['active']);
			}
		}
		if (($id = $this->sql->insert("user", $user)) <= 0) {
			return "插入数据失败:" . $this->sql->error()[2];
		}
		return $id;
	}

	private function user_to_text($user)
	{
		$safe = get_core("LySafe");
		if (isset($user['user'])) {
			$user['user'] = $safe->text($user['user']);
		}
		if (isset($user['signa'])) {
			$user['signa'] = $safe->text($user['signa']);
		}
		if (isset($user['site'])) {
			$user['site'] = $safe->text($user['site']);
		}
		return $user;
	}

	private function user_check($user, $type)
	{
		if ($user['user'] == "") return "用户名不能为空";
		if (strlen($user['user']) < 4) return "用户名过短，至少4位";
		if (is_numeric($user['user'])) return "用户名不能为纯数字";
		if (strpos($user['user'], "@") !== false) return "不能使用@作为用户名";
		if ($user['email'] == "") return "不存在邮箱";
		if ($type != 'edit' &&  $type != 'self') {
			if ($user['password'] === false) return "密码未提交";
			if ($user['password'] !== $user['confirm']) return "两次密码不一致";
			if (strlen($user['password']) < 6) return "密码过短，至少6位";
		}
		if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) return "非法邮件地址";
		if (isset($user['site']) && $user['site'] != "") {
			if (!filter_var($user['site'], FILTER_VALIDATE_URL)) {
				return "非法主页地址";
			}
		}
		if ($type != 'reg' && $type != 'self') {
			if ($user['active'] !== 'true' && $user['active'] !== 'false') return "激活状态错误";
			if (in_array($user['power'], $this->power_list($user)) == false) return "未知用户权限";
		}
		return true;
	}
	public function user_self_edit($info){
		$info = $this->user_to_text($info);
		if(($err = $this->user_check($info,"self"))!==true){
			return $err;
		}
		return $this->edit_sql($info);
	}
	public function user_self_password($o,$n,$c){
		if(strlen($o) < 6)return "原始密码不合法";
		if(strlen($n) < 6)return "新密码不合法";
		if(strlen($c) < 6)return "确认密码不合法";
		if($n != $c)return "两次密码不一致";
		if($n == $o)return "新旧密码一样，无需修改";
		if($this->user['password']!=password($o))return "原始密码错误";
		if(!$this->sql->update("user",array('password'=>password($n)),array('id'=>get_user_id()))){
			return "更新密码失败";
		}else{
			return true;
		}
	}
	private function delete_check($id)
	{
		$id = 0 + $id;
		if ($id === get_user_id()) return "不能删除自己";
		if (is_int($id) && $id > 0) {
			if ($this->sql->count("user", array("id" => $id)) !== 1) {
				return "用户不存在，或异常";
			}
			$list = $this->sql->select("album",array("id"),array("user"=>$id));
			foreach($list as $v){
				if(($err = get_lib("LibAlbum")->album_del($v['id'],true)) !== true){
					return $err;
				}
			}
		} else {
			return "非正常用户";
		}
		return true;
	}

	private function delete_sql($id)
	{
		if ($this->sql->delete("user", array("id" => $id))) {
			return true;
		} else {
			return $this->sql->error()[2];
		}
	}

	private function edit_sql($user)
	{
		$id = $user['id'];
		unset($user['id']);
		if (isset($user['password'])) unset($user['password']);
		if (isset($user['active'])) $user['active'] = ($user['active'] === "true") ? true : false;
		if ($this->sql->update("user", $user, array('id' => $id))) {
			return true;
		} else {
			return $this->sql->error()[2];
		}
	}

	public function ajax_user_edit()
	{
		$rt = array("message" => '', 'status' => false);
		$user = $this->user_to_text(get_core("LyPost")->get());
		if (($err = $this->user_check($user, 'edit')) !== true) {
			$rt['message'] = $err;
		} else {
			if (($err = $this->edit_sql($user)) === true) {
				$rt['message'] = "成功修改账户信息";
				$rt['status'] = true;
			} else {
				$rt['message'] = "数据库出错：" . $err;
			}
		}
		return json_encode($rt);
	}

	public function ajax_user_list()
	{
		$list = $this->sql->select("user", array('id', 'user', 'email', 'signa', 'site', 'active', 'power'));
		return json_encode($list);
	}

	public function ajax_user_add()
	{
		$post = get_core("LyPost");
		$rt = array('message' => '', 'status' => false);
		if ($post->is_post()) {
			$user = $this->user_to_text(array(
				'user' => $post->get('user'),
				'password' => $post->get('password'),
				'confirm' => $post->get('confirm'),
				'email' => $post->get('email'),
				'active' => $post->get("active"),
				'power' => $post->get("power")
			));
			if (($err = $this->user_check($user, 'add')) !== true) {
				$rt['message'] = "参数检查错误:" . $err;
			} else {
				if (!is_numeric($err = $this->register_sql($user)) || $err <= 0) {
					$rt['message'] = "数据库错误:" . $err;
				} else {
					$rt['status'] = true;
					$rt['message'] = $err;
				}
			}
		} else {
			$rt['message'] = '非法请求';
		}
		return json_encode($rt);
	}

	public function ajax_user_del()
	{
		$post = get_core("LyPost");
		$rt = array("message" => '', 'status' => false);
		if ($post->is_post()) {
			$id = $post->get('id');
			if (($err = $this->delete_check($id)) !== true) {
				$rt['message'] = "参数检查错误:" . $err;
			} else {
				if (($err = $this->delete_sql($id)) == true) {
					$rt['message'] = "用户ID为：" . $id;
					$rt['status'] = true;
				} else {
					$rt['message'] = "数据库出错：" . $err;
				}
			}
		} else {
			$rt['message'] = "非法请求";
		}
		return json_encode($rt);
	}

	public function ajax_user_password()
	{
		$rt = array('message' => '', 'status' => false);
		$id = 0 + get_core("LyPost")->get('id');
		$password = trim("" . get_core("LyPost")->get('password'));
		if ($id <= 0 || strlen($password) < 6) {
			$rt['message'] = "传递的参数有误";
		} else {
			if ($this->sql->update("user", array('password' => password($password)), array('id' => $id))) {
				$rt['status'] = true;
			}
		}
		return json_encode($rt);
	}
}

?>