<?php
class LibGet
{
	private $album_sql = 'SELECT album.id AS album_id, album.name AS album_name, album.user AS user_id,
			user.user AS user_name, picture.file AS pic_file,
			picture.title AS title, picture.tag AS tag
			FROM album
			INNER JOIN picture ON album.id = picture.album
			AND album.public = \'yes\'
			AND album.status =1
			INNER JOIN user ON user.id = album.user
			GROUP BY picture.album
			ORDER BY album.id DESC';
	private $album_count = 'select count(*) from (
		SELECT album FROM album
		INNER JOIN picture ON album.id = picture.album
		AND album.public = \'yes\'
		AND album.status =1
		INNER JOIN user ON user.id = album.user
		GROUP BY picture.album
	) alias';
	private $sql;
	private $page_number;

	public function __construct()
	{
		$this->sql = get_core()->load_c_lib('CLibSql');
		$this->page_number = get_config('album', 'one_page');
		if ($this->page_number == 0) {
			$this->page_number = 5;
		}
	}

	public function get_list($page)
	{
		$pn = $this->get_pagination($page + 0, $this->count($this->album_count), $this->page_number);
		get_lib('LibTemplate')->set_pagination("album_list", $pn['count'], $page);
		return array(
			'list' => $this->select($this->album_sql, "limit " . $pn['begin'] . ", " . $this->page_number),
			'pn' => $pn
		);
	}

	public function get_album($id)
	{
		$id += 0;
		if ($id <= 0) return false;
		$album = $this->sql->get('album', "*", array('AND' => array('id' => $id, 'status' => 1)));
		if ($album == false || !isset($album['id'])) return false;
		if ($album['user'] == get_user_id() || $album['public'] == 'yes') {
			$list = $this->sql->select("picture", "*", array('album' => $album['id']));
			if (!is_array($list) || count($list) <= 0) return false;
			return array('album' => $album, 'list' => $list);
		} else {
			return false;
		}
	}

	public function get_pic($id)
	{
		$id += 0;
		return $this->select('SELECT album.id AS album_id,
album.name AS album_name, album.user AS user_id,
user.user AS user_name, picture.file AS pic_file,
picture.title AS title, picture.tag AS tag, picture.description AS description
FROM album
INNER JOIN picture ON album.id = picture.album
AND (album.public =  \'yes\' OR album.user = '.get_user_id().')
AND album.status =1
INNER JOIN user ON user.id = album.user WHERE picture.id =' . $id);
	}

	public function get_album_count()
	{
		return $this->count($this->album_count);
	}

	public function select($sql, $where = null)
	{
		$query = $this->sql->query($sql . " $where");
		return $query ? $query->fetchAll(PDO::FETCH_ASSOC) : false;
	}
	public function get_rand($n=5){
		$n+=0;
		return $this->sql->select("picture","*",array('ORDER'=>"rand()",'LIMIT'=>$n));
	}
	private function count($sql)
	{
		return $this->sql->query($this->album_count)->fetchColumn() + 0;
	}

	public function get_pagination($page, $count, $num)
	{
		$rt = array('count' => 0, "all" => $count, "begin" => 0, "end" => 0, "num" => 0, "error" => false);
		if ($page <= 0) $page = 1;
		if ($num <= 0) $num = 1;
		$rt['count'] = round($count / $num);
		if ($rt['count'] < $count / $num) {
			$rt['count']++;
		}
		if ($page > $rt['count']) {
			$rt['error'] = true;
		}
		$rt['begin'] = ($page - 1) * $num;
		$rt['end'] = $page * $num - 1;
		if ($rt['end'] >= $count) {
			$rt['end'] = $count - 1;
		}
		$rt['num'] = $num;
		return $rt;
	}
}

?>