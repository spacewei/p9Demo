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

if(isset($_SESSION['loginUser'])){
    switch ($_POST['shopCartFlag']) {
        case 'pushShopCart' :
            $goodsID = addslashes($_SESSION['currentGoodsID']);
            $goodsNumber = addslashes($_POST['goodsNumber']);
            $userName = addslashes($_SESSION['loginUser']);

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