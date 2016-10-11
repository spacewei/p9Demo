<?php
/**
 * Created by PhpStorm.
 * User: SPACEY
 * Date: 2016/10/11
 * Time: 21:08
 */
header("Content-Type:application/json;charset=utf-8");

///*接收商品规格选择变化,显示对应商品信息显示*/
////if(isset($_POST['specData'])){
////    $specDataJson = $_POST['specData'];
////    $specData = json_decode($_POST['specData']);
////    $result = doMysql($specData);
//
//    //转换成json格式输出
////    $resultJson = json_encode($result);
////    echo $resultJson;
////    $testDate = array('goodsName'=>'test');
////    $testDateJson = json_encode($testDate);
//
//    $testDateJson = $_POST['specData'];
//    echo $testDateJson;
////}

//连接数据库
$dataBaseURL = "localhost";
$dataBaseUser = "root";
$dataBasePWD = "root";
$mysqli = new mysqli($dataBaseURL,$dataBaseUser,$dataBasePWD);

$xxx = "全网通";
$test = "'$xxx '";
//$test = "'全网通'";



$POSTspecNetwork = "全网通";

$specNetwork = "'".$POSTspecNetwork."'";
//$specColor = "'".$POSTspecColor."'";
//$specPackage = "'".$POSTspecPackage."'";
//$specStorage = "'".$POSTspecStorage."'";

//选择数据库
$dataBaseName = "p9Demo";
$mysqli->select_db($dataBaseName);

//设置客户端编码字符集
$mysqli->set_charset('utf8');

//执行数据库语句
//$queryStr = "select * from goods_record where (spec0=".$specNetwork." and spec1='128GB' and spec2='琥珀金' and spec3='官方标配')";
$queryStr = "select * from goods_record where (spec0=".$test." and spec1='128GB' and spec2='琥珀金' and spec3='官方标配')";
//$queryStr = "select * from goods_record where (spec0='全网通' and spec1='128GB' and spec2='琥珀金' and spec3='官方标配')";
//$queryStr = "select * from goods_record where (spec0="."'".$test."'"." and spec1='128GB' and spec2='琥珀金' and spec3='官方标配')";
//$queryStr = "select * from goods_record where (spec0="."$specNetwork"." and spec1="."$specColor"." and spec2="."$specPackage"." and spec3="."$specStorage)";

//得到结果集
$resultQuery = $mysqli->query($queryStr);

//用关联数组输出查询到的结果
$result = $resultQuery->fetch_assoc();

//关闭数据库连接
$mysqli->close();

//返回结果
//return $result;

var_dump($result);