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
$x =array();

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

/*接收商品规格选择变化,显示对应商品信息显示*/
if(isset($_POST['specData'])){
//    $specDataJson = $_POST['specData'];
//    $specData = json_decode($_POST['specData']);
//    $result = doMysql($specData);

    //转换成json格式输出
//    $resultJson = json_encode($result);
//    echo $resultJson;
    $testDate = json_encode(array('goodsName'=>'test'));
    echo $testDate;
}

/*数据库操作函数*/
function doMysql($specData){
    //连接数据库
    $dataBaseURL = "localhost";
    $dataBaseUser = "root";
    $dataBasePWD = "root";
    $mysqli = new mysqli($dataBaseURL,$dataBaseUser,$dataBasePWD);

    //选择数据库
    $dataBaseName = "p9Demo";
    $mysqli->select_db($dataBaseName);

    //设置客户端编码字符集
    $mysqli->set_charset('utf8');

    //执行数据库语句
//    $queryStr = "select * from goods_record where (spec0=$specData=>specNetwork and spec1=$specData=>specStorage and spec2=specData=>specColor and spec3=specData=>specPackage)";


    //得到结果集
    $resultQuery = $mysqli->query($queryStr);

    //用关联数组输出查询到的结果
    $result = $resultQuery->fetch_assoc();

    //关闭数据库连接
    $mysqli->close();

    //返回结果
    return $result;
}