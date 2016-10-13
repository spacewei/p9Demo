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

//执行商品主页加入购物车物品及其数量
if(isset($_POST['pushShopCart'])){
    $goodsID = $_SESSION['currentGoodsID'];
    $goodsNumber = $_POST['goodsNumber'];

    //执行数据库复制函数
    shopCartMysql($goodsID,$goodsNumber);
}

if(isset($_POST['initShopCartFlag'])){
    $arrayJson = initShopCart();

    echo $arrayJson;
}