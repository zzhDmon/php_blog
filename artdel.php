<?php 
/**
*artdel.php 文章删除页面
*
*@since 2019年2月28 1.1
*@copyright GPL
*/

//引入初始化文件
require './lib/init.php';
//获取地址栏上的参数
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
//执行删除操作
$sql = "delete from art where art_id='$id'";
$res = mQuery($sql);
if(!$res){
	error('文章删除失败');
}else{
	header('location:artlist.php');
}


?>