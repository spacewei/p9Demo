/**
 * Created by SPACEY on 2016/10/9.
 */
var shopCart = {
    /*显示动态加载购物车中的物品,显示在页面*/
    initShopCart:function(){
        var numberAll = 0;
        var total = 0;
        $.post('shopCart.php',{shopCartFlag:"initShopCart"},function(data){
            if(data.result == "fail"){
                alert("请登录");
                return;
            }
            for(var key in data){
                //转换数组中每个json字符串为js object
                var dataObj = JSON.parse(data[key]);
                //先限制成浮点数,再计算每件商品的价格
                var x = parseFloat(dataObj.price);
                var y = parseInt(dataObj.goodsNumber);
                var rowTotal = x * y;
                //累加商品金额
                total += rowTotal;
                //累加商品数量
                numberAll = parseInt(numberAll) + parseInt(dataObj.goodsNumber);
                $('#table-all').get(0).innerHTML +=
                    "<div class='cart-tr table-title' id='" + dataObj.goodsID + "-goodsID" + "'>" +
                        "<span class='cart-td is-check table-cell-title'><input class='check-this' type='checkbox'></span>" +
                        "<span class='cart-td goods-img table-cell-title'>图片</span>" +
                        "<span class='cart-td goods-detail table-cell-title'>" + dataObj.goodsName + "</span>" +
                        "<span class='cart-td price table-cell-title'>" + dataObj.price + "</span>" +
                        "<span class='cart-td number table-cell-title'>" + dataObj.goodsNumber + "</span>" +
                        "<span class='cart-td total-class table-cell-title'>" + rowTotal.toFixed(2) + "</span>" +
                        "<span class='cart-td handle table-cell-title'><button class='delete-this-goods'>删除商品</span>" +
                    "</div>";
            }
            //显示商品总数
            $('.goods-total').get(0).innerHTML += numberAll;
            //显示购物车所有商品的总金额
            $('.total-class').get(0).innerHTML += ":" + total;
            //绑定删除此项商品的函数
            shopCart.deleteThisGoods();
            //绑定是否选取商品的函数,全选和单一选择
            shopCart.checkFunction();
        },"json");
        //绑定显示提交购买的商品
        $('#buy-btn').on('click',function(){
            var x = $('.check-this:checked');
            for(var i=0;i< x.length;i++){
                alert(x.eq(i).parent().parent().attr('id'));
                $('#test').get(0).innerHTML += x.eq(i).parent().parent().attr('id')+";";
            }
        });
        //绑定回退按键
        $('.back-index').on('click',function(){
            alert('ok');
        });
        //绑定登录后刷新页面
        $('#login-btn').on('click',function(){
            window.location.reload();
        });
        //绑定退出后刷新页面
        $('.login-off').on('click',function(){
            window.location.reload();
        })
    },
    /*删除一项商品函数*/
    deleteThisGoods:function(){
        $('.delete-this-goods').on('click', function (event){
            var thisGoodsID = parseInt($(event.target).parent().parent().attr('id'));
            $.post('shopCart.php',{shopCartFlag:"deleteGoodsClass",thisGoodsID:thisGoodsID});
            $(event.target).parent().parent().remove();
        });
    },
    /*选择和全选实现函数*/
    checkFunction:function(){
        //绑定每项商品的选择事件
        $('.check-this').on('click',function(event){
            //若一项商品不选,全选取消
            if(!$(event.target).prop('checked')){
                $('#check-all').prop('checked',false);
            }
            //遍历所有商品项的选择,若全部是勾选则全选变为选择
            var flag = true;
            $('.check-this').each(function(){
                if(!$(this).prop('checked')){
                    flag = false;
                    return false;
                }
            });
            if(flag){
                $('#check-all').prop('checked',true);
            }else {
                $('#check-all').prop('checked',false);
            }
        });
        //若全选勾选,则全选
        $('#check-all').on('click',function(){
            if($('#check-all').prop('checked')){
                $('.check-this').prop('checked',true);
            }else {
                $('.check-this').prop('checked',false);
            }
        })
    },
    /*判断使用的浏览器*/
    queryBrowser: function () {
        //alert(navigator.userAgent.indexOf('Firefox'));
    }
};

$(document).ready(function(){
    shopCart.initShopCart();
    shopCart.queryBrowser();
});
