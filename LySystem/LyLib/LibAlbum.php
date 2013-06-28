<?php
class LibAlbum
{
	private $sql;

	public function __construct()
	{
		$this->sql = get_core()->load_c_lib("CLibSql");
	}

	public function album_add($title, $public)
	{
		$id = $this->sql->insert("album", array("name" => $title, 'public' => $public, 'user' => get_user_id()));
		if (!is_numeric($id) || $id <= 0) {
			return $this->sql->error()[2];
		}
		return $id + 0;
	}

	public function album_del($id,$is_admin = false)
	{
		if (($is_admin && is_admin()) || $this->sql->has("album", array("AND" => array("id" => $id, "user" => get_user_id())))) {
			$list = $this->sql->select("picture", array('file', 'id'), array('album' => $id));
			if (is_array($list) && count($list) >= 1) {
				foreach ($list as $v) {
					$this->picture_delete($v['file']);
				}
				if (!$this->sql->delete("picture", array('album' => $id))) {
					return "图片删除失败";
				}
			}
			if ($this->sql->delete("album", array("AND" => array("id" => $id)))) {
				return true;
			} else {
				return $this->sql->error()[2] . "";
			}
		} else {
			return "你无法访问或没有权限操作该画集";
		}
	}

	public function album_status($id, $show)
	{
		if ($this->sql->has("album", array("AND" => array("id" => $id, "user" => get_user_id())))) {
			if ($this->sql->update("album", array('status' => $show), array("AND" => array("id" => $id, "user" => get_user_id())))) {
				return true;
			} else {
				return $this->sql->error()[2] . "";
			}
		} else {
			return "你无法访问或没有权限操作该画集";
		}
	}

	public function album_list()
	{
		return $this->sql->select("album", "*", array("user" => get_user_id()));
	}

	public function album_get($id)
	{
		$album = $this->sql->get("album", "*", array("AND" => array('id' => $id, 'user' => get_user_id())));
		if (!is_array($album)) return false;
		$list = $this->sql->select("picture", "*", array("album" => $id));
		foreach(array_keys($list) as $v){
			$list[$v]['file'] = get_pic_middle($list[$v]['file']);
		}
		return array(
			'album' => $album,
			'picture' => $list
		);
	}

	public function album_edit($id, $name, $public, $show)
	{
		if ($this->sql->has("album", array("AND" => array("id" => $id, "user" => get_user_id())))) {
			if ($this->sql->update("album", array("name" => $name, "public" => $public, "status" => $show), array("id" => $id))) {
				return true;
			} else {
				return "数据库更新失败";
			}
		} else {
			return "当前画集你没有访问权限";
		}
	}

	public function picture_upload($info, $file)
	{
		if (($up_path = get_upload_path()) == false) {
			return "上传目录获取失败";
		}
		if ($file['size'] > get_pic_max_size()) {
			return "文件过大,最大" . (get_pic_max_size() / 1024) . "KB";
		}
		$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
		if (!in_array($ext, array('gif', 'jpg', 'bmp', 'jpeg', 'png'))) {
			return "不允许该类图片上传";
		}
		$name = get_user_id() . "_" . time() . "." . $ext;
		if (is_file(get_upload_path() . $name)) {
			return "目标文件出现冲突,请重试";
		}
		if (!move_uploaded_file($file['tmp_name'], get_upload_path() . $name)) {
			return "文件移动失败";
		}
		$info['file'] = $name;
		if (($id = $this->sql->insert('picture', $info) + 0) <= 0) {
			return "数据库错误:" . $this->sql->error()[2];
		} else {
			$this->picture_thumbnails($name);
			$rt = $this->sql->get("picture", "*", array('id' => $id));
			if(isset($rt['file']))$rt['file'] = get_pic_middle($rt['file']);
			return $rt;
		}
	}

	private function picture_thumbnails($name)
	{
		$c = get_config('picture');
		$big = $c['big'];
		$middle = $c['middle'];
		$small = $c['small'];
		unset($c);
		$src = get_upload_path($name);
		list(, , $type) = getimagesize($src);
		if ($type) {
			foreach (array($big => get_pic_big_path($name),$middle => get_pic_middle_path($name),$small => get_pic_small_path($name)) as $width => $path) {
				if(!$this->image_copy($out,$src,$width)){
					@copy($src,$path);
				}
				switch ($type) {
					case IMAGETYPE_JPEG:
						$b = imagejpeg($out,$path);
						break;
					case IMAGETYPE_GIF:
						$b = imagegif($out,$path);
						break;
					case IMAGETYPE_PNG:
						$b = imagepng($out,$path);
						break;
					case IMAGETYPE_BMP:
						$b = imagewbmp($out,$path);
						break;
					case IMAGETYPE_WBMP:
						$b = imagewbmp($out,$path);
						break;
					default:
						$b = false;
						break;
				}
				if(!$b){
					@copy($src,$path);
				}else{
					imagedestroy($out);
				}
			}
		}else{
			@copy($src,get_pic_big_path($name));
			@copy($src,get_pic_small_path($name));
			@copy($src,get_pic_middle_path($name));
		}

	}

	private function image_copy(&$out, $src_file, $new_width, $new_height = 0, $max_flag = false)
	{
		$new_width += 0;
		$new_height += 0;
		if ($new_width <= 0 && $new_height <= 0) {
			return false;
		}
		list($width, $height, $type) = getimagesize($src_file);
		if ($width <= 0 || $height <= 0) return false;
		if ($new_height > 0 && $new_width == 0) {
			if ($new_height > $height && $max_flag) return false;
			$new_width = $new_height / $height * $width;
		} else if ($new_width > 0 && $new_height == 0) {
			if ($new_width > $width && $max_flag) return false;
			$new_height = $new_width / $width * $height;
		} else if (($new_height > $height || $new_width > $width) && $max_flag) {
			return false;
		}
		switch ($type) {
			case IMAGETYPE_JPEG:
				$in = imagecreatefromjpeg($src_file);
				break;
			case IMAGETYPE_GIF:
				$in = imagecreatefromgif($src_file);
				break;
			case IMAGETYPE_PNG:
				$in = imagecreatefrompng($src_file);
				break;
			case IMAGETYPE_BMP:
				$in = imagecreatefromwbmp($src_file);
				break;
			case IMAGETYPE_WBMP:
				$in = imagecreatefromwbmp($src_file);
				break;
			default:
				return false;
				break;
		}
		$out = imagecreatetruecolor($new_width, $new_height);
		return imagecopyresampled($out, $in, 0, 0, 0, 0, $new_width, $new_height, $width, $height) && imagedestroy($in);
	}

	private function picture_delete($name)
	{
		@unlink(get_pic_path($name));
		@unlink(get_pic_big_path($name));
		@unlink(get_pic_middle_path($name));
		@unlink(get_pic_small_path($name));
	}

	public function picture_edit($id, $info)
	{
		if ($this->sql->update("picture", $info, array('id' => $id))) {
			return true;
		} else {
			return $this->sql->error()[2];
		}
	}

	public function picture_del($id)
	{
		$pic = $this->sql->get("picture", array("file", "album"), array('id' => $id));
		if (!is_array($pic) || !isset($pic['album'])) {
			return "该图片不存在";
		} else {
			$album = $this->sql->get("album", array("user"), array("id" => $pic['album']));
			if (!is_array($album) || !isset($album['user'])) {
				return "图片所属专辑不存在";
			} else {
				if ($album['user'] != get_user_id()) {
					return "你没有访问该图片的操作权限";
				} else {
					if (!$this->sql->delete("picture", array("id" => $id))) {
						return "图片删除失败";
					} else {
						$this->picture_delete($pic['file']);
					}
				}
			}
		}
		return true;
	}
}

?>