/**
 * Created by SPACEY on 2016/10/9.
 */
/*显示动态加载购物车中的物品,显示在页面*/
function initShopCart(){
    $.post('shopCart.php',{initShopCartFlag:true},function(data){
        var dataObj = JSON.parse(data);
        for(var i=0;i<dataObj.goodsID.length;i++){
            var rowTotal;
            var x = parseFloat(dataObj.price[i]);
            var y = parseFloat(dataObj.goodsNumber[i]);
            rowTotal = x*y;
            rowTotal.toFixed(2);
            $('#test').get(0).innerHTML +=
                "<div class='cart-tr table-title'>"+
                    "<span class='cart-td is-check table-cell-title'>选择</span>"+
                    "<span class='cart-td goods-img table-cell-title'>图片</span>"+
                    "<span class='cart-td goods-detail table-cell-title'>"+dataObj.goodsName[i]+"</span>"+
                    "<span class='cart-td price table-cell-title'>"+dataObj.price[i]+"</span>"+
                    "<span class='cart-td number table-cell-title'>"+dataObj.goodsNumber[i]+"</span>"+
                    "<span class='cart-td total-class table-cell-title'>"+rowTotal+"</span>"+
                    "<span class='cart-td handle table-cell-title'><button class='delete-this-goods'>删除商品</span>"+
                "</div>";
        }
        $('.delete-this-goods').on('click',function(){
            alert('绑定成功');
            //deleteThisGoods(event);
        })
    })
}

//function deleteThisGoods(event){
//    $(event.target)
//}

$(document).ready(function(){
    //var goodsID;
    initShopCart();
});
