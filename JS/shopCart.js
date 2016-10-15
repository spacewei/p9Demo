/**
 * Created by SPACEY on 2016/10/9.
 */
/*显示动态加载购物车中的物品,显示在页面*/
function initShopCart(){
    var numberAll = 0;
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
            //累加商品数量
            numberAll = parseInt(numberAll) + parseInt(dataObj.goodsNumber);
            var xx =
                "<div class='cart-tr table-title' id='" + dataObj.goodsID + "-goodsID" + "'>" +
                "<span class='cart-td is-check table-cell-title'><input class='check-this' type='checkbox'></span>" +
                "<span class='cart-td goods-img table-cell-title'>图片</span>" +
                "<span class='cart-td goods-detail table-cell-title'>" + dataObj.goodsName + "</span>" +
                "<span class='cart-td price table-cell-title'>" + dataObj.price + "</span>" +
                "<span class='cart-td number table-cell-title'>" + dataObj.goodsNumber + "</span>" +
                "<span class='cart-td total-class table-cell-title'>" + rowTotal.toFixed(2) + "</span>" +
                "<span class='cart-td handle table-cell-title'><button class='delete-this-goods'>删除商品</span>" +
                "</div>";
            $('#table-all').get(0).innerHTML += xx;
        }
        $('.goods-total').get(0).innerHTML += numberAll;
        $('.delete-this-goods').on('click', function (event) {
            deleteThisGoods(event);
        })
    },"json");
    $('#buy-btn').on('click',function(){
        var x = $('.check-this:checked');
        for(var i=0;i< x.length;i++){
            alert(x.eq(i).parent().parent().attr('id'));
            $('#test').get(0).innerHTML += x.eq(i).parent().parent().attr('id')+";";
        }
    });
    $('.back-index').on('click',function(){
        alert('ok');
    });
    //问题:用了innerHTML后不能绑定!!!
    //$('#check-all').on('click',function(){
    //    $('.check-this').attr({'checked':'checked'})
    //});
}

function deleteThisGoods(event){
    var thisGoodsID = parseInt($(event.target).parent().parent().attr('id'));
    $.post('shopCart.php',{shopCartFlag:"deleteGoodsClass",thisGoodsID:thisGoodsID});
    $(event.target).parent().parent().remove();
}

$(document).ready(function(){
    initShopCart();
    setTimeout(function(){
        $('#check-all').on('click',function(){
            dof();
        })
    },2000);
    function dof(){
        if($('#check-all').prop('checked')){
            $('.check-this').attr('checked','true');
            //alert($('#check-all').attr("checked"));
        }else {
            $('.check-this').removeAttr('checked');
            //alert($('#check-all').prop("checked"));
        }
    }
});
//$('#all-checked').on('click',function(){
//    alert('ok');
//});
