/**
 * Created by SPACEY on 2016/10/23.
 */
/*公共控制函数*/
function controllerCommon(){
    //加载页面后,提交检查是否维持了登录
    loginUserReady();
    /*绑定弹出登录框(表格)事件,后"请登录"消失*/
    $('.login-please').on('click',function(){
        $('.login-div').show().css({'display':'table'});
        $('.login-please').hide();
        var urlValidate = 'validate.php';
        $('.validate-show').attr({'src':urlValidate+"?"+Math.random()});
    });
    /*绑定取消登录事件,清空登录情况界面,"退出登录"消失,"请登录"再现*/
    $('.login-off').on('click',function(){
        $.post('loginStore.php',{loginOff:'off'},function(data){
            $('.login-show').text('');
            $('.login-off').hide();
            $('.login-please').show();
            $('.shop-cart').hide();
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
        $('.login-please').show();
    });
    /*绑定提交登录信息事件*/
    $('#login-btn').on('click',function(){
        loginSubmit();
    });
}
/*公共视图函数*/
function viewCommon(){
    //绘制登录框的退出按键
    myCanvas();
}
/*用canvas画出登录框的关闭按键函数*/
function myCanvas(){
    //建立canvas对象
    var closeSymbolDOM = $('.closeSymbol').get(0);
    closeSymbolDOM.width = '30';
    closeSymbolDOM.height = '30';
    //canvas的2d绘制
    var closeSymbol = closeSymbolDOM.getContext('2d');
    //用白色填充画布
    closeSymbol.fillStyle = 'white';
    closeSymbol.fillRect(0,0,30,30);
    //绘制从左上到右下的线
    closeSymbol.beginPath();
    closeSymbol.moveTo(0,0);
    closeSymbol.lineTo(30,30);
    closeSymbol.strokeStyle = 'red';
    closeSymbol.stroke();
    closeSymbol.closePath();
    //绘制从左下到右上的线
    closeSymbol.beginPath();
    closeSymbol.moveTo(0,30);
    closeSymbol.lineTo(30,0);
    closeSymbol.strokeStyle = 'red';
    closeSymbol.stroke();
    closeSymbol.closePath();
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
            case 'validateFalse' :
                $('.login-show').text('验证码错误');
                alert(data.validate);
                break;
            case 'true' :
                $('.login-show').text('欢迎' + data.userName);
                $('.login-div').hide();
                $('.login-please').hide();
                $('.login-off').show();
                $('.shop-cart').show();
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
            $('.login-please').hide();
            $('.shop-cart').show();
            alert(data.user_name);
        }
        if(data.flag == 'keepNone'){
            alert(data.flag);
        }
    },'json');
}

$(document).ready(function(){
    controllerCommon();
    viewCommon();
})