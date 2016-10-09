<?php
session_start();
ob_clean();
header("Content-Type:application/json;charset=utf-8");
$userName = $_POST['userName'];
$userPWD = $_POST['userPWD'];
$formData = array("userName"=>$userName,"userPWD"=>$userPWD);
$validate = $_POST['validate'];

//数据库操作函数
function doMysql($userName){
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

//得到结果集
    $resultQuery = $mysqli->query($queryStr);

//用关联数组输出查询到的结果
    $result = $resultQuery->fetch_assoc();

//关闭数据库连接
    $mysqli->close();

//返回结果
    return $result;
}

//执行数据库查询
$result = doMysql($userName);

//定义返回的字符串
$x =array();

//接收是否要保持登录状态
if($_POST['saveLogin'] == 'true'){
    $_SESSION['saveLogin'] = 'true';
}else{
    unset($_SESSION['saveLogin']);
    unset($_SESSION['loginUser']);
}

    //首先查找数据库中是否有此用户
    if($result != null){
        //取出数据库的password,和输入的密码对比
        $CorrectPWD = $result['password'];
        if($CorrectPWD == $formData['userPWD']){
            if($validate == $_SESSION['validate']){
                $x = array_merge($result,array('flag'=>'true','validate'=>$_SESSION['validate']));
                //假如选择了保持登录
                if($_POST['saveLogin'] == 'true'){
                    $_SESSION['saveLogin'] = 'true';
                    $_SESSION['loginUser'] = $result['user_name'];
                }
            }else{
                $x = array_merge($result,array('flag'=>'validateFalse','validate'=>$_SESSION['validate']));
                unset($_SESSION['loginUser']);
            }
        }else{
            $x = array_merge($result,array('flag'=>'false','password'=>$result['password']));
            unset($_SESSION['loginUser']);
        }
    }else {
        $result['user_name'] = "无此用户";
        $result['password'] = "无意义";
        $x = array_merge($result, (array('flag' => 'none')));
        unset($_SESSION['loginUser']);
    }

//session_destroy();

//转换成json格式输出
$xJson = json_encode($x);
echo $xJson;


?>
