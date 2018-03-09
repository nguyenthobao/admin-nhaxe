<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/lockweb.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><!DOCTYPE html>
<!-- 
Author: Công ty cổ phần WebBNC Việt Nam
Website: https://webbnc.net
Contact: admin@webbnc.vn
Admin  : nguyenbahuong156@gmail.com
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>WebBNC | Website của bạn đã hết hạn sử dụng</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta content="" name="description"/>
<meta content="huongnb" name="author"/>
<link rel="shortcut icon" href="<?=$_B['home_theme']?>favicon.png" />
<link rel="icon" href="<?=$_B['home_theme']?>favicon.png" />
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['home_theme']?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['home_theme']?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['home_theme']?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?=$_B['home_theme']?>assets/global/plugins/select2/select2.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['home_theme']?>assets/admin/pages/css/login-soft.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="<?=$_B['home_theme']?>assets/global/css/components.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['home_theme']?>assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['home_theme']?>assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link id="style_color" href="<?=$_B['home_theme']?>assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['home_theme']?>assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
<a class="brand" href="https://webbnc.net" target="_blank">
<img src="https://webbnc.net/image/data/logo_bnc.png" alt="Công ty cổ phần Webbnc Việt Nam"/>
</a>
</div>
<!-- END LOGO -->
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGIN -->
<div class="content">
<!-- BEGIN LOGIN FORM -->
<form class="login-form" action="/" method="post">
<h3 class="form-title">Website hết hạn sử dụng</h3>
<div class="form-group" style="text-align:justify">
<p>Hệ thống WebBNC thấy rằng website 
<b><?=$_B['web']['domain']?></b> của quý khách đã hết hạn vào ngày 
<b><?=$enddate?></b>.
<p>Quý khách vui lòng gia hạn để tiếp tục sử dụng dịch vụ. Rất xin lỗi Quý khách vì sự bất tiện này.
<p>Chú ý : Quý khách có thể sử dụng chức năng GIA HẠN TẠM THỜI bên dưới. Chức năng này quý khách sẽ được gia hạn thêm 2 ngày để hoàn tất thủ tục.
<?php if($giahan==0) { ?>

<center>
<button type="submit" class="btn blue ">
Gia hạn tạm thời <i class="m-icon-swapright m-icon-white"></i>
</button>
</center>
<?php } else { ?>
<center>
<button type="submit" class="btn red disabled">
Rất tiếc bạn đã gia hạn <?=$giahan?> lần <i class="m-icon-swapright m-icon-white"></i>
</button>
</center>
<?php } ?>
<br/>
<div class="col-md-6" style="text-align:center;margin-bottom:2px;"><b>Miền Bắc </b></div>
<div class="col-md-6" style="text-align:center;margin-bottom:2px;"><b>Miền Nam </b></div>
<div class="col-md-6 contact-icon" style="text-align:center">

<a href="Tel:0978398756" title="0978398756"><span class="glyphicon glyphicon-phone"></span></a>
<a href="Tel:19006024" title="19006024"><span class="glyphicon glyphicon-phone-alt"></span></a>
<a href="mailto:admin@webbnc.vn" title="admin@webbnc.vn"><span class="glyphicon glyphicon-envelope"></span></a>
</div>
<div class="col-md-6 contact-icon" style="text-align:center">

<a href="Tel:0961255924" title="0961255924"><span class="glyphicon glyphicon-phone"></span></a>
<a href="Tel:0873025588" title="0873025588"><span class="glyphicon glyphicon-phone-alt"></span></a>
<a href="mailto:admin@webbnc.vn" title="admin@webbnc.vn"><span class="glyphicon glyphicon-envelope"></span></a>
</div>


<div class="clearfix"></div>

</div>
<input type="hidden" value="2" name="giahan"/>
</form>
<!-- END LOGIN FORM -->

</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
 2011 &copy; Webbnc Việt Nam.
</div>
<!-- END COPYRIGHT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?=$_B['home_theme']?>assets/global/plugins/respond.min.js"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/select2/select2.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?=$_B['home_theme']?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/admin/pages/scripts/login-soft.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {     
  	Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init() // init quick sidebar
  	Login.init();

       	// init background slide images
       	$.backstretch([
        "<?=$_B['home_theme']?>assets/admin/pages/media/bg/1.jpg",
    		    "<?=$_B['home_theme']?>assets/admin/pages/media/bg/2.jpg",
    		    "<?=$_B['home_theme']?>assets/admin/pages/media/bg/3.jpg",
    		    "<?=$_B['home_theme']?>assets/admin/pages/media/bg/4.jpg"
        ], {
          fade: 1000,
          duration: 8000
    	}
    );
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>