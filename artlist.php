<?php 
/**
*artlist.php 文章展示页面
*
*@since 2019年2月28 1.1
*@copyright GPL
*/

//引入初始化文件
require './lib/init.php';
//把数据从数据库中取出
$sql = 'select art_id,title,pubtime,catname,comm 
from art left join cat 
on art.cat_id=cat.cat_id';
$arts = mGetAll($sql);
//把数据放在html模板上
require PATH.'/view/admin/artlist.html';
?>