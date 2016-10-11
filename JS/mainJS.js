/**
 * Created by SPACEY on 2016/9/28.
 */
/*加载后初始化动态页面*/
function viewInit(){
    //初始化图片切换
    switchImg();
    //绘制登录框的退出按键
    myCanvas();
    //初始化显示默认选择的商品信息
    specInit();
}
/*初始化控制事件*/
function controllerInit() {
    //加载页面后,提交检查是否维持了登录
    loginUserReady();
    /*绑定弹出登录框(表格)事件,后"请登录"消失*/
    $('.pleaseLogin').on('click',function(){
        $('.login-div').show().css({'display':'table'});
        $('.pleaseLogin').hide();
        var urlValidate = 'validate.php';
        $('.validate-show').attr({'src':urlValidate+"?"+Math.random()});
    });
    /*绑定取消登录事件,清空登录情况界面,"退出登录"消失,"请登录"再现*/
    $('.login-off').on('click',function(){
        $.post('loginStore.php',{loginOff:'off'},function(data){
            $('.login-show').text('');
            $('.login-off').hide();
            $('.pleaseLogin').show();
        },'json');
    });
    /*绑定验证码刷新按钮事件*/
    $('#validate-refresh').on('click',function(){
        var urlValidate = 'validate.php';
        $('.validate-show').attr({'src':urlValidate+"?"+Math.random()});
    });
    /*绑定登录框的关闭事件*/
    $('.closeSymbol').on('click',function(){
        $('.login-div').hide();
        $('.pleaseLogin').show();
    });
    /*绑定提交登录信息事件*/
    $('#login-btn').on('click',function(){
        loginSubmit();
    });
    /*绑定商品规格选择事件*/
    $('.spec-radio').on('click',function(event){
        specChock();
    });
}
/*用canvas画出登录框的关闭按键函数*/
function myCanvas(){
    var closeSymbolDOM = $('.closeSymbol').get(0);
    closeSymbolDOM.width = '30';
    closeSymbolDOM.height = '30';
    var closeSymbol = closeSymbolDOM.getContext('2d');

    closeSymbol.fillStyle = 'white';
    closeSymbol.fillRect(0,0,30,30);

    closeSymbol.beginPath();
    closeSymbol.moveTo(0,0);
    closeSymbol.lineTo(30,30);
    closeSymbol.strokeStyle = 'red';
    closeSymbol.stroke();
    closeSymbol.closePath();

    closeSymbol.beginPath();
    closeSymbol.moveTo(0,30);
    closeSymbol.lineTo(30,0);
    closeSymbol.strokeStyle = 'red';
    closeSymbol.stroke();
    closeSymbol.closePath();
}
/*图片切换函数*/
function switchImg(){
    var bigGoodsImg = $('.big-img img');
    var x;
    for(var i=0;i<5;i++){
        //x = $('.small-img' + i).get(0);
        (function(i){
            $('.small-img'+i).on('mouseover',function () {
                bigGoodsImg.attr({src: 'IMG/goods_430x430_' + i + '.jpg'})
            })
        })(i);
    }
}
/*提交登录信息函数*/
function loginSubmit(){
    var userName = $('#user-name').val();
    var userPassword = $('#user-password').val();
    var validate = $('#validate-number').val();
    var saveLogin = $('#save-login').get(0).checked;
    var urlLogin = "login.php";
    $.post(urlLogin,{userName:userName,userPWD:userPassword,validate:validate,saveLogin:saveLogin},function(data){
        switch (data.flag) {
            case 'none' :
                $('.login-show').text('无此用户');
                break;
            case 'false' :
                $('.login-show').text('密码错误');
                alert(data.password);
                break;
            case 'true' :
                $('.login-show').text('欢迎' + data.user_name);
                //alert(data.validate);
                $('.login-div').hide();
                $('.pleaseLogin').hide();
                $('.login-off').show();
                break;
            case 'validateFalse' :
                $('.login-show').text('验证码错误');
                alert(data.validate);
                break;
        }
    },"json");
}
/*加载页面后,检查是否维持登录函数*/
function loginUserReady(){
    //加载页面后,提交检查是否维持登录函数
    $.post('loginStore.php',{ready:'ok'},function(data){
        if(data.flag == 'keepUser'){
            $('.login-show').text('继续欢迎' + data.user_name);
            $('.login-off').show();
            $('.pleaseLogin').hide();
            alert(data.user_name);
        }
        if(data.flag == 'keepNone'){
            alert(data.flag);
        }
    },'json');
}
/*初始化页面后,显示默认选择的商品信息*/
function specInit(){
    //初始化变色默认选择商品,并显示该商品信息
    $('.spec-radio:checked').parent().addClass('selected');
    var specData = getSpec();
    $.extend(specData,{"ready":"ok"});
        $.post('goodsShow.php',specData,function(data){
            showSpec(data);
        },'json')
}
/*商品规格选择后发送规格挑选显示商品信息的函数*/
function specChock(){
    $('.spec-radio').parent().removeClass('selected');
    $('.spec-radio:checked').parent().addClass('selected');
    var specData = getSpec();
    $.extend(specData,{"specFlag":"ok"});
    $.post('goodsShow.php',specData,function(data){
        showSpec(data);
    },'json')
}
/*取得选择的商品规格函数*/
function getSpec(){
    var getSpecData = {
        specNetwork: $('.spec-network:checked').val(),
        specColor : $('.spec-color:checked').val(),
        specPackage : $('.spec-package:checked').val(),
        specStorage : $('.spec-storage:checked').val()
    };
    return getSpecData;
}
/*由得到的MySQL数据显示在html上*/
function showSpec(data){
    $('.goods-price').text(data.price);
    $('.sales-show').text(data.monthlySales);
    $('.evaluation-show').text(data.evaluate);
    $('.stock-show').text(data.stock);
}

$(document).ready(function(){
    viewInit();
    controllerInit();

});