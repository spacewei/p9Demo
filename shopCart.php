<?php
/**
 * Created by PhpStorm.
 * User: SPACEY
 * Date: 2016/10/12
 * Time: 21:43
 */
session_start();
ob_clean();
header("Content-Type:application/json;charset=utf-8");
include 'mysqlconn.php';

//处于登录状态下,执行商品主页加入购物车物品及其数量
//if(isset($_POST['shopCartFlag'])) {
//    if (isset($_SESSION['loginUser'])){
//        if ($_POST['shopCartFlag'] == "pushShopCart") {
//            $goodsID = $_SESSION['currentGoodsID'];
//            $goodsNumber = $_POST['goodsNumber'];
//            $userName = $_SESSION['loginUser'];
//
//            //执行数据库复制函数
//            $result = shopCartMysql($goodsID, $goodsNumber, $userName);
//
//            $resultArray = array("result" => "加入成功");
//            echo json_encode($resultArray);
//        }
//    }
//}
//打开购物车,显示购物车中商品到页面上
//if(isset($_POST['shopCartFlag'])){
//    if(isset($_SESSION['loginUser'])){
//        if($_POST['shopCartFlag']=="initShopCart"){
//            $arrayJson = initShopCart();
//            echo $arrayJson;
//        }
//    }
//}

//点击删除,删除购物车数据库和购物车页面上的商品条目
//if(isset($_POST['shopCartFlag'])){
//    if($_POST['shopCartFlag']=="deleteGoodsClass"){
//        deleteThisGoods($_POST['thisGoodsID'],$_SESSION['loginUser']);
//    }
//}

if(isset($_SESSION['loginUser'])){
    switch ($_POST['shopCartFlag']) {
        case 'pushShopCart' :
            $goodsID = $_SESSION['currentGoodsID'];
            $goodsNumber = $_POST['goodsNumber'];
            $userName = $_SESSION['loginUser'];

            //执行数据库复制函数
            $result = shopCartMysql($goodsID, $goodsNumber, $userName);

            $resultArray = array("result" => "加入成功");
            echo json_encode($resultArray);
            break;
        case 'initShopCart' :
            $arrayJson = initShopCart();
            echo $arrayJson;
            break;
        case 'deleteGoodsClass' :
            deleteThisGoods($_POST['thisGoodsID'],$_SESSION['loginUser']);
            break;
    }
}else{
    $resultArray = array("result" => "fail");
    echo json_encode($resultArray);
}