<?php
	header("Content-Type:application/json;charset=utf-8");
//	include "mysqlconn.php";
	$userName = $_POST['userName'];
	$userPWD = $_POST['userPWD'];
	$formData = array("userName"=>$userName,"userPWD"=>$userPWD);
//	$xJson = json_encode($x);
//	echo $xJson;

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
$searchFieldStr = "*";
$fieldStr = "user_name";
$y = "'" . $userName . "'";
$whereStr = $fieldStr . " = " . $y;
$queryStr = "select "." $searchFieldStr "." from user_record WHERE " . $whereStr;

$queryUserNameStr = "select user_name from user_record WHERE " . $whereStr;

//得到结果集

/*其次验证密码是否和用户名匹配*/
//$userNameExist = $mysqli->query($queryUserNameStr);
//if($userNameExist == null){
//    $result['user_name'] = "不存在用户名";
//    $result['password'] = "null";
//    $xJson = json_encode($result);
//    echo $xJson;
//}

$resultQuery = $mysqli->query($queryStr);

//用关联数组输出查询到的结果
$result = $resultQuery->fetch_assoc();

/*首先查找数据库中是否有此用户*/
if($result != null){
    //取出数据库的password,和输入的密码对比
    $CorrectPWD = $result['password'];
    if($CorrectPWD == $formData['userPWD']){
        //转换成json格式输出
        $xJson = json_encode($result);
        echo $xJson;
    }else{
        //转换成json格式输出
        $result['password'] = "密码错误";
        $xJson = json_encode($result);
//    $xJson->passwprd = "密码错误";
        echo $xJson;
    }
}else{
    $result['user_name'] = "无此用户";
    $result['password'] = "无意义";
    $xJson = json_encode($result);
    echo $xJson;
}




//关闭数据库连接
$mysqli->close();

?>
