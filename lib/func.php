<?php 
/**
*提示成功函数
*/
function succ($str='成功'){
	$sign = 'succ';
	require PATH.'/view/admin/info.html';
	exit();
}
/**
*提示失败函数
*/
function error($str='失败'){
	$sign = 'error';
	require PATH.'/view/admin/info.html';
	exit();
}

/**
*获取用户ip
*
*@return $ip 获取到的用户ip
*/

function getIp(){
	if(getenv('REMOTE_ADDR')){
		return $ip = getenv('REMOTE_ADDR');
	}else if (getenv('HTTP_CLIENT_IP')){
		return $ip = getenv('HTTP_CLIENT_IP');
	}else if (getenv('HTTP_X_FORWARDED_FOR')){
		return $ip = getenv('HTTP_X_FORWARDED_FOR');
	}else{
		return false;
	}
}

/**
*获取页码数,固定显示5个页码数
*
*@param $num 总文章数
*@param $cnt 每页显示几篇文章
*@param $curr  当前页面的页码数
*@return array $pages  获取到的页码数
*/

function getPage($num,$curr,$cnt=2){
	//总页码数
	$pagenum = ceil($num/$cnt);
	//最左边的页码数
	$left = max($curr-2,1);
	//最右边的页码数
	$right = min($left+4,$pagenum);
	//最左边的页码数
	$left = max($right-4,1);
	
	for ($i=$left; $i<=$right ; $i++) { 
		//$page[] = $i;
		$_GET['page'] = $i;
		$page[$i] = http_build_query($_GET);
		//$page = array(1=>'page=1')
	}
	return $page;
}

/**
*生成随机字符串
*
*@param  $length 随机字符串的长度
*@return $str 生成的随机字符串
*/

function randStr($length=6){
	$str = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789';
	$str = str_shuffle($str);
	return substr($str, 0,$length);
}


/**
*获取文件后缀(带点的)
*
*@param $filename 待截取的文件名
*@return $ext 获取到的文件后缀
*/

function getExt($filename){
	return $ext = strrchr($filename,'.');
}

/**
*按日期创建存储目录
*
*@return $path 创建好的存储目录
*/

function createDir(){
	$path = '/upload/'.date('Y/md');
	$abspath = PATH.$path;
	if(is_dir($abspath)||mkdir($abspath,0777,true)){
		return $path;
	}else{
		return false;
	}
}


/**
*生成缩略图
*
*@param $opath 原图的路径
*@param $swidth 缩略图的宽
*@param $sheight 缩略图的高
*@return $spath  缩略图的路径(相对)
*/

function makeThumb($opath,$swidth=200,$sheight=200){
	//缩略图的路径(相对)
	$spath = dirname($opath).'/'.randStr().getExt($opath);

	//获取原图的有效路径(绝对路径)
	$oabs = PATH.$opath;
	//获取目标图的有效路径(绝对路径)
	$dabs = PATH.$spath;

	//获取原图信息
	if(!list($owidth,$oheight,$otype) = getimagesize($oabs)){
		return 1 ;
	}
	$type = array(
		1=>'imagecreatefromgif',
		2=>'imagecreatefromjpeg',
		3=>'imagecreatefrompng',
		);
	if(!$func = $type[$otype]){
		return 2;
	}
	//获取大图资源
	$big = $func($oabs);
	//创建空白画布
	$bu = imagecreatetruecolor($swidth, $sheight);
	//创建画布底色
	$white = imagecolorallocate($bu, 255, 255, 255);
	//底色填充
	imagefill($bu, 1, 1, $white);

	//计算缩略比
	$rate = min($swidth/$owidth,$sheight/$oheight);

	//真正粘贴在小花布上的宽和高
	$rwidth = $owidth*$rate;
	$rheight = $oheight*$rate;

	imagecopyresampled($bu, $big, ($swidth-$rwidth)/2, ($sheight-$rheight)/2, 0, 0, 
		$rwidth, $rheight, $owidth, $oheight);

	//保存缩略图
	imagepng($bu,$dabs);

	//销毁画布资源
	imagedestroy($bu);
	imagedestroy($big);

	//返回缩略图的相对路径
	return $spath;

}


/**
*检测是否登录成功
*
*@return bool 成功返回true,失败false
*/

function checkCookie(){
	//return isset($_COOKIE['name']);
	//检测两个cookie是否都存在
	if(!isset($_COOKIE['name']) || !isset($_COOKIE['ccode'])){
		return false;
	}

	return ccode($_COOKIE['name']) === $_COOKIE['ccode']?true:false;
}


/**
*过滤非法字符
*
*@param $arr 要转义的数组
*@return $arr 转义之后的数组
*/

function _addslashes($arr){
	foreach ($arr as $k => $v) {
		if(is_string($v)){
			$arr[$k] = addslashes($v);
		}else if(is_array($v)){
			$arr[$k] = _addslashes($v);
		}
	}
	return $arr;
}


/**
*加密字符
*
*@param $str 要加密的字符
*@return $str 加密过后的字符
*/

function ccode($str){
	$cfg = require PATH.'/lib/config.php';
	return $str = md5($cfg['salt'].$str);
}



?>
<!-- (1[2]345)6789
12(34[5]67)89
1234 (567[8]9) -->
