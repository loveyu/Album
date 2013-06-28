<?php
function header_html(){
	header("Content-Type: text/html; charset=utf-8");
}
function header_plain(){
	header("Content-Type: text/plain; charset=utf-8");
}
function header_404(){
	header('HTTP/1.1 404 Not Found');
}
function header_json(){
	header("content-Type: application/json; charset=utf-8");
}
?>