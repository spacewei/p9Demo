/**
 * Created by SPACEY on 2016/9/28.
 */
function init() {
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
    $('.login').on('click',function(){
        $('.login-div').show().css({'display':'table'});
    })
    $('#login-btn').on('click',function(){
        var userName = $('#user-name').val();
        var userPassword = $('#user-password').val();
        //var dataAjax = {
        //    userName:$('#user-name').val(),
        //    userPassword:$('#user-password').val()
        //}
        var urlLogin = "login.php";
        $.post(urlLogin,{userName:userName,userPWD:userPassword},function(data){
            $(".login-show").text(data.user_name + ";" + data.password);
            alert(data.user_name + ";" + data.password);
        },"json")
    })
}
function test(){
    alert('!');
}

$(document).ready(function(){
    init();

});