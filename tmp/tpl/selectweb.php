<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/selectweb.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập quản trị web</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="wrapper">
        <div class="">
            <header id="header">
                <div class="container">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <a class="logo" href="#">
                            <img class="img-responsive" src="<?=$_B['home_theme']?>/anvui/imgs/logo.png">
                        </a>
                    </div>
                    
                </div>
            </header>
            
            <div class="content login">
                <div class="container">
                    <div class="row">
                        <div class="login-box col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="login-inner">
                                <div class="login-box-title"> 
                                    <?php if(isset($error)) { ?>
                                    <div class="alert alert-danger" style="margin-top: 5px;" role="alert"> 
                                       <?=$error?>
                                    </div>
                                    <?php } ?>
                                    <h1><span>Chọn trang web</span></h1>
                                </div>
                                <div class="login-box-body">
                                    <form class="form-horizontal" >
                                        <ul>
                                            <li>
                                                <input type="text" class="form-control" id="wname" placeholder="Nhập tên rút gọn website của bạn">
                                            </li> 
                                        </ul>
                                        <button type="button" class="loginbtn">
Vào quản trị website  </button>
                                    </form> 
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <footer class="">
                <div class="container">
                    <div class="menubotton col-lg-5 col-sm-5 col-xs-12">
                        <ul>
                            <li>
                                <a href="">Điều khoản dịch vụ</a>
                            </li>
                            <li>
                                <a href="">Chính sách riêng tư</a>
                            </li>
                        </ul>
                    </div>
                    <div class="coppyright col-lg-2 col-sm-2 col-xs-12">
                        <span>© Anvui 2017</span>
                    </div>
                    <div class="version col-lg-5 col-sm-5 col-xs-12">
                        <span>v0.16.9</span>
                    </div>
                </div>
                
            </footer>
        </div>
        <!--#header-->
    </div>
    </div>
    <!--CSS-->
    <link href="<?=$_B['home_theme']?>anvui/plugins/owl-carousel/carousel.css" rel="stylesheet" type="text/css">
    <!-- <link href="css/layouts.css" rel="stylesheet" type="text/css"> -->
    <link href="<?=$_B['home_theme']?>anvui/css/common.css" rel="stylesheet" type="text/css">
    <link href="<?=$_B['home_theme']?>anvui/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?=$_B['home_theme']?>anvui/css/mobile.css" rel="stylesheet" type="text/css">
    <!--JS-->
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script type="text/javascript">
$('.loginbtn').click(function(){
var wname = $('#wname').val();
if(wname ==''){
$('#wname').focus();
return false;
}
window.location ="/"+wname+'.admin';

});
$(document).keypress(
    function(event){
     if (event.which == '13') {
        event.preventDefault();
      }


});
</script>
</body>

</html>
