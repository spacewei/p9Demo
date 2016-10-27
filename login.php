<?php
session_start();
ob_clean();
header("Content-Type:application/json;charset=utf-8");
include 'mysqlconn.php';

/*登录验证函数*/
function login(){
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
}

/*判断是否保存登录*/
function loginSave(){
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

/*退出登录*/
function loginOff(){
        unset($_SESSION['saveLogin']);
        unset($_SESSION['loginUser']);
        $x = array_merge(array('flag'=>'restore'));

        //转换成json格式输出
        $xJson = json_encode($x);
        echo $xJson;
}

/*执行功能的switch判断*/
if(isset($_POST['loginFlag'])){
    switch ($_POST['loginFlag']){
        case "loginIn":
            login();
            break;
        case "loginOff":
            loginOff();
            break;
        case "ready":
            loginSave();
            break;
    }
}

?>
