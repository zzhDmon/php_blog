<?php 
/**
*artup.php 文章编辑页面
*
*@since 2019年2月28 1.1
*@copyright GPL
*/

//引入初始化文件
require './lib/init.php';
//获取地址栏上id
$id = $_GET['art_id'];
//检测文章id是否合法
if(!is_numeric($id)){
	error('文章ID不合法');
}
//检测文章id是否存在
$sql = "select count(*) from art where art_id='$id'";
$count = mGetOne($sql);
if($count<=0){
	error('文章ID不存在');
}

//取出所有栏目
$sql = 'select * from cat';
$cats = mGetAll($sql);

//检测是否有数据提交
if(empty($_POST)){
	//取出该行数据
	$sql = "select * from art where art_id=$id";
	$art = mGetRow($sql);
	require PATH.'/view/admin/artup.html';
	exit();
}

//检测标题是否为空
$data['title'] = trim($_POST['title']);
if(empty($data['title'])){
	error('文章标题不能为空');
}

//检测栏目id是否存在
$data['cat_id'] = trim($_POST['cat_id']);
$sql = "select count(*) from cat where cat_id='$data[cat_id]'";
$count = mGetOne($sql);
if($count<=0){
	error('栏目ID不存在');
}

//检测内容是否为空
$data['content'] = trim($_POST['content']);
if(empty($data['content'])){
	error('文章内容不能为空');
}

//执行修改操作
$res = mExec('art',$data,'update','art_id='.$id);
if(!$res){
	error('文章修改失败');
}else{
	header('location:artlist.php');
}

?>