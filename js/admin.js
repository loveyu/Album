function user_manger_load(func) {
	$.getJSON(URL + "Admin/ajax/user_list", function (data) {
		$.each(data, function (id, arr) {
			var str = "<tr class='tr_" + (id % 2) + "'><td>" + arr["id"] + "</td><td>" + arr["user"] + "</td><td>" + arr["email"] +
				"</td><td>" + arr["signa"] + "</td><td>" + arr["site"] + "</td><td>" + (arr["active"] == 1 ? "已激活" : "待激活") + "</td><td>" + arr['power'] +
				"</td><td>" + user_manager_action(arr["id"]) + "</td></tr>";
			$("#tabs_user_manger tbody").append(str);
		});
		$("#tabs_user_manger tbody a").click(user_change);
		if (func != undefined) {
			func();
		}
	});
}
function user_manager_action(id) {
	return '<a href="#edit_' + id + '">编辑</a>&nbsp;<a href="#del_' + id + '">删除</a>&nbsp;<a href="#pwd_' + id + '">密码</a>'
}
function user_manger_reload(func) {
	$("#tabs_user_manger tbody").html("");
	user_manger_load(func);
}
function user_add(data) {
	if (data['status']) {
		$("#tabs_user_add form").resetForm();
		user_manger_reload();
		alert("添加成功");
	} else {
		alert("失败: " + data['message']);
	}
	return false;
}
function user_change() {
	var s = this.href.match(/#[\s\S]+/);
	s = s[0].split("_");
	switch (s[0]) {
		case "#edit":
			user_edit(s[1]);
			break;
		case "#del":
			user_del(s[1]);
			break;
		case "#pwd":
			user_pwd(s[1]);
			break;
	}
	return false;
}
function user_edit(id) {
	$.get(URL + "Admin/user_edit?id=" + id, function (data) {
		$("#user_edit").html(data);
		$("#user_edit").dialog({
			width:400,
			modal:true
		});
		$("#user_edit_form").submit(user_edit_ajax);
	});
}
function user_edit_ajax(data) {
	$.post(URL + "Admin/ajax/user_edit", $('#user_edit_form').serialize(), function (data) {
		if (data['status']) {
			user_manger_reload(function () {
				alert("编辑信息成功:" + data['message']);
				$("#user_edit").dialog('close');
			});
		} else {
			alert("操作失败:" + data['message']);
		}
	});
	return false;
}
function user_del(id) {
	if (confirm("你确定删除ID为` " + id + " `的账户?")) {
		$.post(URL + "Admin/ajax/user_del", {id:id}, function (data) {
			if (data['status']) {
				user_manger_reload(function () {
					alert("删除成功:" + data['message']);
				});
			} else {
				alert("删除失败:" + data['message']);
			}
		});
	}
}
function user_pwd(id) {
	$("#user_password").html("<div><form><p>修改ID为" + id + "的密码</p>" +
		"<p><label>输入新密码:<input name='pw1' type='password' /></label></p>" +
		"<p><label>确认密码:<input name='pw2' type='password' /></label></p>" +
		"<p><button type='submit'>确认</button></p></form></div>");
	$("#user_password form").submit(function () {
		user_pwd_action(id);
		return false;
	});
	$("#user_password").dialog({
		width:400,
		modal:true
	});
}
function user_pwd_action(id) {
	pw1 = $("#user_password input[name='pw1']").val();
	pw2 = $("#user_password input[name='pw2']").val();
	if (pw1 != pw2) {
		alert("密码不等");
		return;
	}
	if (pw1.length < 6) {
		alert("密码过短");
		return;
	}
	$.post(URL + 'Admin/ajax/user_password', { id:id, password:pw1 }, function (data) {
		if (data['status']) {
			alert("修改密码成功");
			if (id == USER.id) {
				window.location.assign(window.location.href);
			}
			$("#user_password").dialog('close');
		} else {
			alert("修改密码失败:" + data['message']);
		}
	});
}

function setting_post(data){
	if(data['status']){
		alert("更新成功");
		window.location.assign(location.href);
	}else{
		alert("更新失败:"+data['message']);
	}
}