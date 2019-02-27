<?php 
/**
*catlist.php 栏目展示页面
*
*@since 2019年2月27 1.1
*@copyright GPL
*/

//连接数据库
/*$link = mysqli_connect('localhost','root','1234','blog');
mysqli_query($link,'set names utf8');*/
require './lib/init.php';

//把数据从数据库中取出
$sql = 'select * from cat';
$data = mGetAll($sql);
/*$res = mysqli_query($link,$sql);//大麻袋
$data = array();
while($row = mysqli_fetch_assoc($res)){
	$data[] = $row;//二维数组
}*/

//print_r($data);
//放在前台html页面上
require PATH.'/view/admin/catlist.html';

?>