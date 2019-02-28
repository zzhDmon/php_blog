<?php 
/****
布尔教育 高端PHP培训
培  训: http://www.itbool.com
论  坛: http://www.zixue.it
****/
function randStr($length=6){
	$str = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789';
	$str = str_shuffle($str);
	return substr($str, 0,$length);
}
//创建空白画布
$bu = imagecreatetruecolor(100, 25);

//创建颜色
$yel = imagecolorallocate($bu,255,255,0);
$green = imagecolorallocate($bu, 0, 255, 255);

//填充底色
imagefill($bu,1,1,$green);

//写入字符串
imagestring($bu, 5, 18, 5, randStr(4), $yel);

//输出到浏览器上
header('Content-type:image/png');
imagepng($bu);


?>