<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/header.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><!DOCTYPE html>
<!--
 * @Project BNC v2 -> Adminuser 
 * @Author Quang Chau Tran (quangchauvn@gmail.com), Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 08/15/2014, 10:40 AM
 -->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title><?php if(isset($_S['title_header'])) { ?><?=$_S['title_header']?><?php } else { ?><?php echo lang('login');?><?php } ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<base href="<?=$_B['home']?>" lang = "<?=$_B['lang']?>"/>
<link rel="shortcut icon" href="<?=$_B['home_theme']?>favicon.png" />
<link rel="icon" href="<?=$_B['home_theme']?>favicon.png" />
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<!-- <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/> -->
<link href="http://adminweb.anvui.vn/themes/default/assets/global/plugins/fonts/css.css" rel="stylesheet" type="text/css"/>

<!-- <link href="<?=$_B['home_theme']?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/> -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<!-- <link href="<?=$_B['home_theme']?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/> -->
<link href="http://adminweb.anvui.vn/themes/default/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['home_theme']?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link href="<?=$_B['home_theme']?>assets/global/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['home_theme']?>assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['home_theme']?>assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL PLUGIN STYLES -->
<!-- BEGIN PAGE STYLES -->
<link href="<?=$_B['home_theme']?>assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="<?=$_B['home_theme']?>assets/global/css/components.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['home_theme']?>assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['home_theme']?>assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['home_theme']?>assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?=$_B['home_theme']?>assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->

<link href="<?=$_B['home_theme']?>assets/global/plugins/toastr/build/toastr.min.css" rel="stylesheet" type="text/css"/>


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
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery.countdown-2.0.4/jquery.countdown.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?=$_B['home_theme']?>assets/global/plugins/countdown/plugin/jquery.countdown.css">

<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/countdown/plugin/jquery.countdown.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/countdown/plugin/jquery.countdown-vi.js"></script>

<link href="<?=$_B['home_theme']?>dist/bootstrap-fileinput/css/fileinput.min.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['home_theme']?>dist/myStyle.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript">
$(function () {
var austDay = new Date();
austDay = new Date(<?=$dates['2']?>, <?=$dates['1']?> - 1, <?=$dates['0']?>,<?=$times['0']?>,<?=$times['1']?>,<?=$times['2']?>);
$('#website-endtime').countdown({until: austDay,format: 'YMDHMS'});
//$('#year').text(austDay.getFullYear());
});
</script>
<script type="text/javascript">
var baseUrl='<?=$_B['home']?>';
var lang='<?=$_B['lang']?>';
var popup_df_lang='<?php echo lang('pop_df_message');?>';
var pop_close='<?php echo lang('pop_close');?>';
var pop_df_title='<?php echo lang('pop_df_title');?>';
</script>
<!-- END CORE PLUGINS -->
<style type="text/css">
.page-header.navbar {
    background-color: #19448a;
}
.page-header.navbar .page-logo .logo-default {
    margin: 5px 0 0 0;
    width: 86px;
}
.page-header.navbar .top-menu {
    margin: 0;
    padding: 0;
    float: right;
    background: #efefef;
}
.page-footer {
    padding: 8px 20px 5px 20px;
    font-size: 12px;
    height: 33px;
    background: #19448a;
}
.page-footer .page-footer-inner {
    color: #ffffff;
}
body {
    background-color: #565d6b;
}
</style>
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
<body class="page-header-fixed page-quick-sidebar-over-content <?php if(isset($_GET['page']) && ($_GET['page']=='cart'||$_GET['page']=='Synchronous')) { ?>page-sidebar-closed<?php } ?>">
<!-- BEGIN HEADER -->


<div class="page-header navbar navbar-fixed-top">
<!-- BEGIN HEADER INNER -->
<div class="page-header-inner">
<!-- BEGIN LOGO -->
<div class="page-logo">
<a href="index.php">
<img src="http://adminweb.anvui.vn/themes/default//anvui/imgs/logo.png" alt="logo" class="logo-default"/>
</a>
<div class="menu-toggler sidebar-toggler hide">
<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
</div>
</div>
<!-- END LOGO -->
<!-- BEGIN RESPONSIVE MENU TOGGLER -->
<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
</a>
<!-- END RESPONSIVE MENU TOGGLER -->
<!-- BEGIN TOP NAVIGATION MENU -->
<div class="top-menu">
<ul class="nav navbar-nav pull-right">
<li>
<div id="website-endtime" class="pull-right tooltips btn btn-fit-height " data-placement="top" data-original-title="Thời hạn sử dụng website"></div>
</li>
 

 
<li class="dropdown dropdown-user">

<a  class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
 
<span class="username username-hide-on-mobile"><?=$_B['uweb']['email']?></span>
<i class="fa fa-angle-down"></i>
</a>
<ul class="dropdown-menu">

 
<li> 
<a href="/webuser-logout"> 
<i class="icon-key"></i> <?=$_L['logout']?></a>
</li>
</ul>
</li>

 
 
<li class="dropdown dropdown-quick-sidebar-toggler">
<a href="<?=$_B['webhome']?>" target="_blank"class="dropdown-toggle">
<i class="fa fa-home"></i>
</a>
</li> 
</ul>
</div>
<!-- END TOP NAVIGATION MENU -->
</div>
<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->