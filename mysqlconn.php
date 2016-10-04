<?php
/**
 * Created by PhpStorm.
 * User: SPACEY
 * Date: 2016/10/4
 * Time: 17:48
 */
//连接数据库
$dataBaseURL = "localhost";
$dataBaseUser = "root";
$dataBasePWD = "root";
//$con = mysql_connect($dataBaseURL,$dataBaseUser,$dataBasePWD);
//if($con){
//    echo "数据库连接成功<br>";
//}else{
//    echo "数据库连接失败<br>";
//}
$mysqli = new mysqli($dataBaseURL,$dataBaseUser,$dataBasePWD);

//选择数据库
$dataBaseName = "p9Demo";
//$seleceDataBase = mysql_select_db($dataBaseName);
//if($seleceDataBase){
//    echo "数据库选择成功<br>";
//}else{
//    echo "数据库选择失败<br>";
//}
$mysqli->select_db($dataBaseName);

//设置客户端编码字符集
//mysql_query("set names utf8");
$mysqli->set_charset('utf8');

//执行数据库语句
$searchFieldStr = "*";
$fieldStr = "user_name";
$x = "'admin'";
$whereStr = $fieldStr . " = " . $x;

/* 改成接收的用户名!!!*/

$queryStr = "select "." $searchFieldStr "." from user_record WHERE " . $whereStr;
//$resultQuery = mysql_query($queryStr);
//if($resultQuery){
//    echo "执行语句成功<br>";
//}else{
//    echo "执行语句失败<br>";
//}
$resultQuery = $mysqli->query($queryStr);
print_r($resultQuery);
echo "<br>";
//print_r($resultQuery->fetch_all(MYSQLI_ASSOC));
//echo "<br>";

//选择输出查询到的结果
$result = $resultQuery->fetch_assoc();
print_r($result);
echo "<br>";
//while($result = mysql_fetch_assoc($resultQuery)){
//    //echo $result['password'];
//    echo $result['password'] . "<br>";
//}

echo $result['password'];
$mysqli->close();