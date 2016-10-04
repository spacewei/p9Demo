<?php
	header("Content-Type:text/plain;charset=utf-8");
	header("Access-Control-Allow-Origin:*");
	header("Access-Control-Allow-Methods:POST,GET");
	$userName = $_POST['userName'];
	$x = array("userName"=>$userName);
	$xJson = json_encode($x);
	echo $xJson;
?>
