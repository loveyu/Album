var album_list;
function load_album_page(id) {
	$.getJSON(URL + "User/get_ajax", {id:id}, function (data) {
		if (!data['status']) {
			alert("错误提示：" + data['message']);
			window.location.href = URL + "User/album";
		} else {
			album_list = data['message'];
			set_album_value();
		}
	});
}
function album_ajax_update(data) {
	if (data['status']) {
		alert("更新成功");
	} else {
		alert("更新失败：" + data['message']);
	}
}
function set_album_value() {
	$("#album_edit input[name='name']").val(album_list['album']['name']);
	$("#album_edit select[name='public']").val(album_list['album']['public']);
	$("#album_edit select[name='show']").val(album_list['album']['status']);
	$.each(album_list['picture'], function (id, data) {
		$("#album_edit .picture").append(album_list_make(data));
	});
}
function album_list_make(data) {
	return "<div id='picture_id_" + data['id'] + "' class='list clearfix'><form onsubmit='return picture_edit(" + data['id'] + ");' action='" + URL + "User/picture_edit/" + data['id'] + "' method='POST'>" +
		"<div class='img float_left'><img src='" + data['file'] + "' width=\"400\" /></div> " +
		"<div class='form float_left'><p><label>标题:<input name=\"title\" value=\"" + data['title'] + "\" type=\"text\" /></label></p>" +
		"<p><label>标签:<input name=\"tags\" value=\"" + data['tag'] + "\" type=\"text\" /></label></p>" +
		"<p>描述：</p><textarea name=\"description\" rows=\"5\" cols=\"30\">" + data['description'] + "</textarea>" +
		"<p><button type=\"submit\">修改</button></p>" +
		"<p><a href='#' onclick='return picture_list_delete(" + data['id'] + ");'>删除</a></p>" +
		"</form></div>";
}
function picture_edit(id) {
	$("#picture_id_" + id + " form").ajaxSubmit(function (data) {
		if (data['status']) {
			alert("更新成功：" + data['message']);
		} else {
			alert("更新失败：" + data['message']);
		}
	});
	return false;
}
function album_add_picture() {
	if ($("#album_add_form input[name='file']").val() == "" ||
		$("#album_add_form input[name='title']").val() == "" ||
		$("#album_add_form input[name='tags']").val() == "" ||
		$("#album_add_form input[name='description']").val() == "" ||
		$("#album_add_form input[name='album']").val() != ALBUM_ID) {
		alert("表单不能存在空值");
		return false;
	}
	$("#album_add_form").ajaxSubmit(function (data) {
		if (data['status']) {
			$("#album_edit .picture").append(album_list_make(data['message']));
			$("#album_add_form")[0].reset();
		} else {
			alert("添加失败:" + data['message']);
		}
	});
	return false;
}
function album_manager_click() {
	var s = this.href.match(/#[\s\S]+/);
	s = s[0].split("_");
	switch (s[0]) {
		case "#del":
			if (confirm("你确定删除??")) {
				$.post(URL + "User/album_del", {id:s[1]}, function (data) {
					if (data['status']) {
						alert("删除成功");
						window.location.assign(window.location.href);
					} else {
						alert("删除失败:" + data['message']);
					}
				});
			}
			return false;
			break;
		case "#status":
			if (confirm("那你确定修改该状态？")) {
				$.post(URL + "User/album_status", {id:s[1], new:(s[2] == 0 ? 1 : 0)}, function (data) {
					if (data['status']) {
						alert("修改成功");
						window.location.assign(window.location.href);
					} else {
						alert("修改失败:" + data['message']);
					}
				});
			}
			return false;
			break;
	}
	return true;
}

function picture_list_delete(id) {
	if (id <= 0) {
		alert("图片ID不正确");
	} else if (confirm("确定删除该图片?")) {
		$.post(URL + "User/picture_del", {id:id}, function (data) {
			if (data['status']) {
				alert('删除成功:' + data['message']);
				$("#picture_id_" + id).remove();
			} else {
				alert("删除失败:" + data['message']);
			}
		});
	}
	return false;
}

function profile_change_password() {
	old = $("#profile_password form input[name='password']").val();
	new_p = $("#profile_password form input[name='new_password']").val();
	confirm_p = $("#profile_password form input[name='confirm_password']").val();
	if (old.length < 6) {
		alert("原始密码不合法");
		return false;
	} else if (new_p.length < 6) {
		alert("新密码不合法");
		return false;
	} else if (confirm_p != new_p) {
		alert("新密码不一致");
		return false;
	} else if (old == new_p) {
		alert("密码不能一致");
		return false;
	}
	$("#profile_password form").ajaxSubmit(function (data) {
		if (data['status'] == undefined) {
			window.location.assign(window.location.href);
		}
		if (data['status']) {
			alert('修改成功:' + data['message']);
			window.location.assign(window.location.href);
		} else {
			alert("修改失败:" + data['message']);
		}
		return false;
	});
	return false;
}