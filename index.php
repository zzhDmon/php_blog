<?php 
/**
*index.php 首页
*
*@since 2019年2月28 1.1
*@copyright GPL
*/


//引入初始化文件
require './lib/init.php';

//取出所有栏目
$sql = 'select * from cat';
$cats = mGetAll($sql);

//检测地址栏上是否有cat_id参数
if(!isset($_GET['cat_id'])){
	$where = 1;
	//$where = '';
}else{
	$where = 'art.cat_id = '.$_GET['cat_id'];
	//$where = 'and cat_id = '.$_GET['cat_id'];
}

//检测地址栏上是否有page参数
if(!isset($_GET['page'])){
	$curr = 1;
}else{
	$curr = $_GET['page'];
}
//获取页码数
$sql = 'select count(*) from art';
$num = mGetOne($sql);
$cnt = 2;
$page = getPage($num,$curr,$cnt);


//取出所有文章
$sql = 'select suo,title,content,pubtime,catname,comm,art_id from art left join cat 
on art.cat_id=cat.cat_id where '. $where . ' order 
by art_id desc limit '.($curr-1)*$cnt.','.$cnt;
$arts = mGetAll($sql);//二维数组





//把数据展示在html页面上
require PATH.'/view/front/index.html';


?>