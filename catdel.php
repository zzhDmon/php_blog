<?php 
/**
*catdel.php 栏目删除页面
*
*@since 2019年2月28 1.1
*@copyright GPL
*/

//获取地址栏上的参数
$id = $_GET['cat_id'];

//检测栏目id是否合法
if(!is_numeric($id)){
	echo '栏目id不合法';
	exit();
}

//检测栏目id是否存在
//连接数据库
$link = mysqli_connect('localhost','root','1234','blog');
mysqli_query($link,'set names utf8');
$sql = "select count(*) from cat where cat_id=$id";
$res = mysqli_query($link,$sql);
if(!$res){
	echo mysqli_error($link);
	exit();
}
$count = mysqli_fetch_row($res)[0];
if($count<=0){
	echo '栏目id不存在';
	exit();
}


//执行删除操作
$sql = "delete from cat where cat_id=$id";
$res = mysqli_query($link,$sql);
if(!$res){
	echo mysqli_error($link);
	exit();
}
	
header('location:catlist.php');

?>