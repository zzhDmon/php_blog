<?php 
require './lib/init.php';

//接收地址栏上的参数
$id = $_GET['art_id'];

//取出所有栏目
$sql = 'select * from cat';
$cats = mGetAll($sql);

//取出该篇文章
$sql = "select art.*,catname from art left join cat on art.cat_id=cat.cat_id where art_id='$id'";
$art = mGetRow($sql);

//取出所有评论
$sql = "select * from comment where art_id=$id";
$comms = mGetAll($sql);


//检测是否有评论提交
if(!empty($_POST)){
	//检测nick是否为空
	$data['nick'] = trim($_POST['nick']);
	if(empty($data['nick'])){
		error('昵称不能为空');
	}
	//检测email是否为空
	$data['email'] = trim($_POST['email']);
	if(empty($data['email'])){
		error('EMAIL不能为空');
	}
	//检测内容是否为空
	$data['content'] = trim($_POST['content']);
	if(empty($data['content'])){
		error('内容不能为空');
	}

	$data['art_id'] = $id;
	$data['pubtime'] = time();
	$data['ip'] = sprintf('%u',ip2long(getIp()));

	//echo sprintf('%u',ip2long('192.168.0.123'));exit();

	$res = mExec('comment',$data);

	if($res){
		$ref = $_SERVER['HTTP_REFERER'];
		header("location:$ref");
	}
}


//引入前台页面
require PATH.'/view/front/art.html';




?>