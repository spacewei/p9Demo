<?php
session_start();
ob_clean();
header("Content-Type:application/json;charset=utf-8");
include 'mysqlconn.php';
$userName = $_POST['userName'];
//加密输入的密码
$userPWD = md5($_POST['userPWD']);
$validate = $_POST['validate'];

//执行数据库查询
$result = userMysql($userName);

//定义返回的字符串
$x =array();

//先判断验证码是否正确
if($validate == $_SESSION['validate']){
    //再判断是否有此用户
    if($result != null){
        //最后判断密码是否匹配
        if(md5($result['password']) != false && $userPWD != false && md5($result['password']) == $userPWD){
            $result['password'] = md5($result['password']);
            $x = array_merge($result,array('flag'=>'true'));
            $_SESSION['loginUser'] = $result['userName'];
            //假如选择了保持登录3600s
            if($_POST['saveLogin'] == 'true'){
                session_set_cookie_params(3600);
                $_SESSION['loginUser'] = $result['userName'];
            }
        }else{
            $x = array_merge($result,array('flag'=>'false','password'=>$result['password']));
            unset($_SESSION['loginUser']);
        }
    }else{
        $result['user_name'] = "无此用户";
        $result['password'] = "无意义";
        $x = array_merge($result, (array('flag' => 'none')));
        unset($_SESSION['loginUser']);
    }
}else{
    $x = array('flag'=>'validateFalse','validate'=>$_SESSION['validate']);
    unset($_SESSION['loginUser']);
}

//转换成json格式输出
$xJson = json_encode($x);
echo $xJson;

?>
