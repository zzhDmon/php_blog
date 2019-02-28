<?php 
/**
*catup.php 栏目编辑页面
*
*@since 2019年2月28 1.1
*@copyright GPL
*/

//获取地址栏上的参数
$id = $_GET['cat_id'];
//连接数据库
$link = mysqli_connect('localhost','root','','blog');
mysqli_query($link,'set names utf8');

//检测是否有数据提交
if(empty($_POST)){
	//取出该行数据,作为默认值放在前台html上
	$sql = "select * from cat where cat_id=$id";
	$res = mysqli_query($link,$sql);
	$row = mysqli_fetch_assoc($res);//?一维数组
	//展示前台页面
	require './view/admin/catup.html';
	exit();
}

//检测栏目是否为空
$catname = trim($_POST['catname']);
if(empty($catname)){
	echo '栏目名不能为空';
	exit();
}

//检测栏目是否已经存在
//连接数据库
$link = mysqli_connect('localhost','root','','blog');
mysqli_query($link,'set names utf8');
//执行查询语句
$sql = "select count(*) from cat where catname='$catname'";
$res = mysqli_query($link,$sql);
if(!$res){
	echo mysqli_error($link);
	exit();
}
$count = mysqli_fetch_row($res)[0];
if($count>=1){
	echo '该栏目名已存在,请重新输入';
	exit();
}

//执行修改操作
$sql = "update cat set catname='$catname' where cat_id=$id";
$res = mysqli_query($link,$sql);
if(!$res){
	echo mysqli_error($link);
	exit();
}

header('location:catlist.php');

?>