<?php
/**
 * Created by PhpStorm.
 * User: SPACEY
 * Date: 2016/10/11
 * Time: 22:53
 */
header("Content-Type:application/json;charset=utf-8");

include 'mysqlconn.php';

/*页面初始化,调用默认的页面商品信息*/
/*接收商品规格选择变化,显示对应商品信息显示*/
if(isset($_POST['specFlag']) || isset($_POST['ready'])){
    $specNetwork = "'".$_POST['specNetwork']."'";
    $specColor = "'".$_POST['specColor']."'";
    $specPackage = "'".$_POST['specPackage']."'";
    $specStorage = "'".$_POST['specStorage']."'";
    $result = goodsMysql($specNetwork,$specColor,$specPackage,$specStorage);

    //转换成json格式输出
    $resultJson = json_encode($result);
    echo $resultJson;
}

