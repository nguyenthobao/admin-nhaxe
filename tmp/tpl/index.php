<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/index.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><?php include_once $_B['temp_ad']->load('header');  ?>

<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
<!-- BEGIN MENU LEFT -->
<?php include_once $_B['temp_ad']->load('menu_left');  ?>
<!-- END MENU LEFT --> 
<!-- BEGIN CONTENT -->
<?php $nm=rand(1,2) ?>
<div class="page-content-wrapper" id="pjax-content"> 
<div class="page-content">
 
<!-- BEGIN PAGE HEADER-->
<?php if($web['query_string']['page']!='mkt') { ?>
 
<div class="page-bar">
<ul class="page-breadcrumb">
<li>
<i class="fa fa-home"></i>
<a href="/"><?=$_L['home']?></a>
</li>
<?php if(isset($_S['breadcrumb_mod'])) { ?>
<li>
<i class="fa fa-angle-right"></i>
<a href="/<?=$mod?>"><?=$_S['breadcrumb_mod']?></a>
</li>
<?php } ?>
<?php if(isset($_S['breadcrumb_page'])) { ?>
<li>
<i class="fa fa-angle-right"></i>
 <?=$_S['breadcrumb_page']?> 
</li>
<?php } ?>
</ul>
 <div class="page-toolbar">
 	
<!-- <div id="dashboard-report-range" class="pull-right tooltips btn btn-fit-height grey-salt" data-placement="top" data-original-title="Thời hạn sử dụng website">
<i class="icon-calendar"></i>&nbsp; <span class="thin uppercase visible-lg-inline-block">December 8, 2014 - January 6, 2015</span>
</div> -->

</div>
</div>
<?php } ?>
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS -->

<?php include_once $content_module; ?>
 
<!-- END DASHBOARD STATS -->

</div>
</div>
<!-- END CONTENT -->

</div>
<!-- END CONTAINER -->

<?php include_once $_B['temp_ad']->load('footer');  ?>