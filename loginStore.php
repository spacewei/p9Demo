<?php
session_start();
ob_clean();
header("Content-Type:application/json;charset=utf-8");
/**
 * Created by PhpStorm.
 * User: SPACEY
 * Date: 2016/10/9
 * Time: 17:49
 */

//定义返回的字符串
//$x =array();

//接收ready,判断是否ok,在加载页面时判断可否显示之前登录
if(isset($_POST['ready'])){
    //如果没有之前没有保存用户,显示无保存用户;如果保存了,显示欢迎xx登录
    if(isset($_SESSION['loginUser'])){
        $x = array_merge(array('user_name'=>$_SESSION['loginUser'],'flag'=>'keepUser','loginUser'=>$_SESSION['loginUser']));
    }else{
        $x = array_merge(array('flag'=>'keepNone'));
    }

    //转换成json格式输出
    $xJson = json_encode($x);
    echo $xJson;
}

if(isset($_POST['loginOff'])){
    unset($_SESSION['saveLogin']);
    unset($_SESSION['loginUser']);
    $x = array_merge(array('flag'=>'restore'));

    //转换成json格式输出
    $xJson = json_encode($x);
    echo $xJson;
}