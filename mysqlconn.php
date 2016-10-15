<?php
/**
 * Created by PhpStorm.
 * User: SPACEY
 * Date: 2016/10/4
 * Time: 17:48
 */
function initMysql(){
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

    return $mysqli;
}

/*查找商品的数据库操作函数*/
function goodsMysql($specNetwork,$specColor,$specPackage,$specStorage){
    $mysqli = initMysql();

    //执行数据库语句
    $queryStr = "select * from goods_record where (spec0=".$specNetwork." and spec1=".$specStorage." and spec2=".$specColor." and spec3=".$specPackage.")";

    //得到结果集
    $resultQuery = $mysqli->query($queryStr);

    //用关联数组输出查询到的结果
    $result = $resultQuery->fetch_assoc();

    //关闭数据库连接
    $mysqli->close();

    //返回结果
    return $result;
}
/*查找用户的数据库操作函数*/
function userMysql($userName){
    $mysqli = initMysql();

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

/*讲选中的商品信息从商品数据库复制到购物车数据库*/
function shopCartMysql($goodsID,$goodsNumber,$userName){
    $mysqli = initMysql();

    //执行数据库语句
    //注意,要先插入,再update,不能一起拼成字符串同时运行!!!
    $queryStr0 = "insert into shop_cart_record(goodsID,goodsName,price,stock,monthlySales,evaluate,img0,img1,img2,img3,img4,spec0,spec1,spec2,spec3,specialPrice) select * from goods_record where goodsID =".$goodsID.";";
    $mysqli->query($queryStr0);
    $queryStr1 = "update shop_cart_record set goodsNumber =".$goodsNumber.",userName ='".$userName."' where goodsID =".$goodsID.";";
    $result = $mysqli->query($queryStr1);

    //关闭数据库连接
    $mysqli->close();

    //返回结果
    return $result;
}

/*购物车页面初始化(显示其中商品信息)函数*/
function initShopCart(){
    $mysqli = initMysql();

    $queryStr ="select * from shop_cart_record;";

    $resultQuery = $mysqli->query($queryStr);

    $array =array();

    while($resultArray=$resultQuery->fetch_assoc()){
        $resultJson = json_encode($resultArray);
        array_push($array,$resultJson);
    }
    $arrayJson = json_encode($array);
    return $arrayJson;
}

/*点击删除,删除一项商品*/
function deleteThisGoods($thisGoodsID,$loginUser){
    $mysqli = initMysql();

    $queryStr ="delete from shop_cart_record where goodsID =".$thisGoodsID." and userName ='".$loginUser."';";

    $mysqli->query($queryStr);
}

?>