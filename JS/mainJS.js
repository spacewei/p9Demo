/**
 * Created by SPACEY on 2016/9/28.
 */
/**/
var index = (function() {
    /*加载后初始化动态页面*/
    var viewInit = function () {
        //初始化图片切换
        switchImg();
        //初始化显示默认选择的商品信息
        specInit();
    };
    /*初始化控制事件*/
    var controllerInit = function () {
        //绑定打开购物车事件
        $('.shop-cart').on('click', function () {
            window.open('shopCart.html')
        });
        //绑定商品规格选择事件
        $('.spec-radio').on('click', function (event) {
            specChock(event);
        });
        //绑定加入购物车事件
        $('#shop-cart-btn').on('click', function () {
            var goodsNumber = $('#number-input').val();
            $.post('shopCart.php', {shopCartFlag: "pushShopCart", goodsNumber: goodsNumber}, function (data) {
                if (data.result == 'fail') {
                    alert('请登录');
                }
            })
        })
    };
    /*分立函数*/
    /*图片切换函数*/
    var switchImg = function () {
        var bigGoodsImg = $('.big-img img');
        var x;
        for (var i = 0; i < 5; i++) {
            (function (i) {
                $('.small-img' + i).on('mouseover', function () {
                    bigGoodsImg.attr({src: 'IMG/goods_430x430_' + i + '.jpg'})
                })
            })(i);
        }
    };
    /*初始化页面后,显示默认选择的商品信息*/
    var specInit = function () {
        //初始化变色默认选择商品,并显示该商品信息
        $('.spec-radio:checked').parent().addClass('selected');
        var specData = getSpec();
        $.extend(specData, {"ready": "ok"});
        $.post('goodsShow.php', specData, function (data) {
            showSpec(data);
        }, 'json')
    };
    /*商品规格选择后发送规格挑选显示商品信息的函数*/
    var specChock = function (event) {
        //先判断是否点击label之前是否有选过,选过就不要发送ajax
        if ($(event.target).parent().hasClass('selected')) {
            return;
        }
        $('.spec-radio').parent().removeClass('selected');
        $('.spec-radio:checked').parent().addClass('selected');
        var specData = getSpec();
        $.extend(specData, {"specFlag": "ok"});
        $.post('goodsShow.php', specData, function (data) {
            showSpec(data);
        }, 'json')
    };
    /*取得选择的商品规格函数*/
    var getSpec = function () {
        var getSpecData = {
            specNetwork: $('.spec-network:checked').val(),
            specColor: $('.spec-color:checked').val(),
            specPackage: $('.spec-package:checked').val(),
            specStorage: $('.spec-storage:checked').val()
        };
        return getSpecData;
    };
    /*由得到的MySQL数据显示在html上*/
    var showSpec = function (data) {
        $('.goods-price').text(data.price);
        $('.sales-show').text(data.monthlySales);
        $('.evaluation-show').text(data.evaluate);
        $('.stock-show').text(data.stock);
    };
    //return {showSpec:function(){return showSpec();}};

    $(document).ready(function () {
        viewInit();
        controllerInit();
    });
    /*如果想暴露变量,则return {showSpec:showSpec()};或再加上闭包return {showSpec:function(){return showSpec();}};*/
})();
//如果在index命名空间外调用则如下:
//index.showSpec();