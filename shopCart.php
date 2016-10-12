<?php
/**
 * Created by PhpStorm.
 * User: SPACEY
 * Date: 2016/10/12
 * Time: 21:43
 */
session_start();
ob_clean();
include 'mysqlconn.php';

if(isset($_POST['pushShopCart'])){
    $goodsID = $_SESSION['currentGoodsID'];
    $goodsNumber = $_POST['goodsNumber'];

    //执行数据库复制函数
    shopCartMysql($goodsID,$goodsNumber);
//    echo $goodsNumber;
//    echo $result;
}