<?php
session_start();
/**
 * Created by PhpStorm.
 * User: SPACEY
 * Date: 2016/10/8
 * Time: 23:26
 */
//header("Content-Type:application/json;charset=utf-8");
//生成验证码数字
$code = "";
for($i=0;$i<4;$i++){
    $code .=rand(0,9);
}
$_SESSION['validateTrue'];