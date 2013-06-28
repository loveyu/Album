<?php
class User
{
	public function __construct()
	{
		if (!is_login()) {
			redirect("Login");
		}
		if(!is_active()){
			redirect("Error/active");
		}
	}

	public function main()
	{
		header_html();
		get_lib("LibTemplate")->set_title("用户中心");
		get_lib("LibTemplate")->add_style(array(
			"css/user.css",
			"css/colorbox.css",
		));
		get_template()->add_js(array(
			'js/jquery-1.8.2.min.js',
			'js/jquery.colorbox.js',
		));
		get_core()->view("user/header");
		get_core()->view("user/user",array('list'=>get_lib('LibGet')->get_rand(9)));
		get_core()->view("user/footer");
	}

	public function add()
	{
		header_html();
		get_lib("LibTemplate")->set_title("添加图集");
		get_lib("LibTemplate")->add_style(array(
			"css/jquery-ui.css",
			"css/user.css"
		));
		get_template()->add_js(array(
			'js/jquery-1.10.1.js',
			"js/jquery-ui.js",
			"js/jquery.form.js"
		));
		get_core()->view("user/header");
		get_core()->view("user/add");
		get_core()->view("user/footer");
	}

	public function album()
	{
		header_html();
		get_lib("LibTemplate")->set_title("图集管理");
		get_lib("LibTemplate")->add_style(array(
			"css/jquery-ui.css",
			"css/user.css"
		));
		get_template()->add_js(array(
			'js/jquery-1.10.1.js',
			"js/jquery-ui.js",
			"js/jquery.form.js",
			'js/user.js'
		));
		get_core()->view("user/header");
		get_core()->view("user/album");
		get_core()->view("user/footer");
	}

	public function profile()
	{
		header_html();
		get_lib("LibTemplate")->set_title("个人信息");
		get_lib("LibTemplate")->add_style(array(
			"css/jquery-ui.css",
			"css/user.css"
		));
		get_template()->add_js(array(
			'js/jquery-1.10.1.js',
			"js/jquery-ui.js",
			"js/jquery.form.js",
			'js/user.js'
		));
		get_core()->view("user/header");
		get_core()->view("user/profile");
		get_core()->view("user/footer");
	}

	public function profile_edit()
	{
		header_json();
		$rt = array('message' => '', 'status' => false);
		$post = get_core("LyPost");
		$info = array(
			'id' => get_user_id(),
			'user' => $post->get('user'),
			'email' => $post->get('email'),
			'signa' => $post->get('signa'),
			'site' => $post->get('site')
		);
		if (($rt['message'] = get_lib("LibUser")->user_self_edit($info)) === true) {
			$rt['status'] = true;
		}
		echo json_encode($rt);
	}
	public function profile_password(){
		header_json();
		$rt = array('message' => '', 'status' => false);
		$pwd = get_core("LyPost")->get('password');
		$n_pwd = get_core("LyPost")->get('new_password');
		$c_pwd = get_core("LyPost")->get('confirm_password');
		if (($rt['message'] = get_lib("LibUser")->user_self_password($pwd,$n_pwd,$c_pwd)) === true) {
			$rt['status'] = true;
		}
		echo json_encode($rt);
	}
	public function album_del()
	{
		header_json();
		$rt = array("message" => "", "status" => false);
		$id = get_core("LyPost")->get('id') + 0;
		if ($id > 0) {
			if (($rt['message'] = get_lib("LibAlbum")->album_del($id)) === true) {
				$rt['status'] = true;
			}
		} else {
			$rt['message'] = "表单有误,ID不正确";
		}
		echo json_encode($rt);
	}

	public function album_status()
	{
		header_json();
		$rt = array("message" => "", "status" => false);
		$id = get_core("LyPost")->get('id') + 0;
		$new = get_core("LyPost")->get('new') + 0;
		if ($id > 0 && ($new === 0 || $new === 1)) {
			if (($rt['message'] = get_lib("LibAlbum")->album_status($id, $new)) === true) {
				$rt['status'] = true;
			}
		} else {
			$rt['message'] = "表单有误,ID不正确";
		}
		echo json_encode($rt);
	}

	public function add_ajax()
	{
		header_json();
		$rt = array("message" => "", "status" => false);
		$title = trim(get_core('LySafe')->text(get_core("LyPost")->get('title')));
		$public = get_core("LyPost")->get('public');
		if ($title == "") {
			$rt['message'] = "标题为空或异常";
		} else {
			if (in_array($public, array("yes", "no"))) {
				if (is_int($rt['message'] = get_lib("LibAlbum")->album_add($title, $public)) && $rt['message'] > 0) {
					$rt['status'] = true;
				} else {
					$rt['message'] = "创建失败";
				}
			} else {
				$rt['message'] = "状态不正确";
			}
		}
		echo json_encode($rt);
	}

	public function edit($id = 0)
	{
		if ($id <= 0) redirect("User");
		header_html();
		get_lib("LibTemplate")->set_title("编辑图集");
		get_lib("LibTemplate")->add_style(array(
			"css/jquery-ui.css",
			"css/user.css"
		));
		get_template()->add_js(array(
			'js/jquery-1.10.1.js',
			"js/jquery-ui.js",
			"js/jquery.form.js",
			"js/user.js"
		));
		get_core()->view("user/header");
		get_core()->view("user/edit", array('id' => $id));
		get_core()->view("user/footer");
	}

	public function get_ajax()
	{
		header_json();
		$id = get_core("LyGet")->get('id') + 0;
		$rt = array(
			'message' => '',
			'status' => false
		);
		if ($id <= 0) {
			$rt['message'] = '错误的ID序号';
		} else {
			$rt['message'] = get_lib("LibAlbum")->album_get($id);
			if (!is_array($rt['message']))
				$rt['message'] = "无法权限或无法访问";
			else
				$rt['status'] = true;
		}
		echo json_encode($rt);
	}

	public function album_edit()
	{
		header_json();
		$rt = array("message" => "", "status" => false);
		$name = trim(get_core('LySafe')->text(get_core("LyPost")->get('name')));
		$public = get_core("LyPost")->get('public');
		$id = get_core("LyPost")->get('id') + 0;
		$show = get_core("LyPost")->get("show") + 0;
		if ($id > 0 && ($show === 0 || $show === 1)) {
			if ($name == "") {
				$rt['message'] = "标题为空或异常";
			} else {
				if (in_array($public, array("yes", "no"))) {
					if (($rt['message'] = get_lib("LibAlbum")->album_edit($id, $name, $public, $show)) == true) {
						$rt['status'] = true;
					}
				} else {
					$rt['message'] = "状态不正确";
				}
			}
		} else {
			$rt['message'] = "ID不正确";
		}
		echo json_encode($rt);
	}

	public function picture_add()
	{
		header_json();
		$rt = array('status' => false, 'message' => '');
		$post = get_core("LyPost");
		$info = array("title" => $post->get('title'), 'tag' => $post->get('tags'), 'description' => $post->get('description'), 'album' => $post->get('album'));
		$info['tag'] = str_replace("、",",",str_replace("，",",",str_replace("、",",",$info['tag'])));
		foreach (array_keys($info) as $n) {
			if ($info[$n] == "") {
				$rt['message'] = $n . ":为空";
				echo json_encode($rt);
				return;
			}
			$info[$n] = get_core("LySafe")->text($info[$n]);
		}
		if (!isset($_FILES['file'])) {
			$rt['message'] = "文件未上传";
		} else if ($_FILES['file']['error'] != 0) {
			$rt['message'] = "文件上传错误";
		} else {
			if (is_array($rt['message'] = get_lib("LibAlbum")->picture_upload($info, $_FILES['file']))) {
				if (!empty($rt['message']))
					$rt['status'] = true;
				else
					$rt['message'] = "添加图片到相册失败";
			}
		}
		echo json_encode($rt);
	}

	public function picture_edit($id = 0)
	{
		header_json();
		$rt = array('message' => '', 'status' => false);
		$id = $id + 0;
		if ($id < 0) {
			$rt['message'] = "ID值有误";
		} else {
			$post = get_core("LyPost");
			$info = array("title" => $post->get('title'), 'tag' => $post->get('tags'), 'description' => $post->get('description'));
			$info['tag'] = str_replace("、",",",str_replace("，",",",str_replace("、",",",$info['tag'])));
			foreach (array_keys($info) as $n) {
				if ($info[$n] == "") {
					$rt['message'] = $n . ":为空";
					echo json_encode($rt);
					return;
				}
				$info[$n] = get_core("LySafe")->text($info[$n]);
			}
			if (($rt['message'] = get_lib("LibAlbum")->picture_edit($id, $info)) === true) {
				$rt['status'] = true;
			}
		}
		echo json_encode($rt);
	}

	public function picture_del()
	{
		header_json();
		$rt = array('message' => '', 'status' => false);
		$id = get_core("LyPost")->get("id") + 0;
		if ($id <= 0) {
			$rt['message'] = "ID值有误";
		} else {
			if (($rt['message'] = get_lib('LibAlbum')->picture_del($id)) === true) {
				$rt['status'] = true;
			}
		}
		echo json_encode($rt);
	}
}

?>