<?php 
/**
*artadd.php 文章添加页面
*@since 2019年2月28 1.1
*@copyright GPL
*/
//引入初始化文件
require './lib/init.php';

//检测是否有数据提交
if(empty($_POST)){
	//取出所有栏目
	$sql = "select * from cat";
	$cats = mGetAll($sql);//二维数组
	//引入前台html页面
	include PATH.'/view/admin/artadd.html';
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



$data['pubtime'] = time();


//print_r($_FILES);exit();
//检测是否有文件要上传
if(($_FILES['pic']['name']!= '') && ($_FILES['pic']['error'] == 0)){
	$path = createDir().'/'.randStr().getExt($_FILES['pic']['name']);
	$realpath = PATH.$path;
	$res = move_uploaded_file($_FILES['pic']['tmp_name'], $realpath);
	if($res){
		$data['pic'] = $path;
		$suodir = makeThumb($path);
		if($suodir){
			$data['suo'] = $suodir;
		}
	}
}


$res = mExec('art',$data);
if(!$res){
	error('文章添加失败');
}else{
	succ('文章添加成功');
}

?>