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