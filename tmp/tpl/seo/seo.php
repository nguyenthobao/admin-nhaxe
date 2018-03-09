<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/seo/seo.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/select2/select2.css"/>

<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/inputs-ext/address/address.css"/>
<link href="<?=$_B['mod_theme']?>css/style.css" rel="stylesheet" type="text/css" />
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/jquery-tags-input/jquery.tagsinput.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/typeahead/typeahead.css">
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN PAGE CONTENT-->

<!-- BEGIN PAGE CONTENT-->
<div class="row">
<div class="col-md-12">

<div class="portlet">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-navicon"></i><?php echo lang('title_manager_mod');?>
</div>					
</div>
<?php include $_B['temp']->load('notify_action') ?>
<div class="portlet box box-template">					
<div class="portlet-title" style="border-bottom:none !important">
<ul class="nav nav-tabs tabs-template">
 
<li class="active">
<a href="#tab_3" data-toggle="tab"><?php echo lang('google_authorship');?></a>
</li>
<li class="">
<a href="#tab_4" data-toggle="tab"><?php echo lang('manager_robots');?></a>
</li>							
<li class="">
<a href="#tab_5" data-toggle="tab"><?php echo lang('google_analytics');?></a>
</li>
 
 

</ul>
</div>
<div class="portlet-body util-btn-margin-bottom-5">
<div class="tab-content">
 
 
<div class="tab-pane active" id="tab_3">
<div class="clearfix">
<div class="row">
<div class="col-md-12">
<form class="form-horizontal form-row-seperated" action="" id="form_google" class="form-horizontal" method="POST">
<div class="portlet">
<!-- <div class="portlet-title">
<div class="caption">
<i class="fa fa-list-ul"></i><?php echo lang('breadcrumb_footer');?>
</div>
{temp footer_toolbar}
</div> -->
<div class="portlet-body">
<div class="tabbable">

<div class="tab-content no-space">
<div class="tab-pane active">
<div class="form-body">
<?php include $_B['temp']->load('notify_action') ?>
<div class="note note-warning" style="text-align: jutsify;">
<?php echo lang('google_analytics_note');?>

    							</div>
    							<div class = "alert-sucess"></div>
    							<div class="portlet light bordered ">

<div class="portlet-body form" >

<div class="form-group">
<label class="col-md-2 control-label col-hd-1" style = "width:200px;">	<?php echo lang('id_gg');?></label>
<div class="col-md-3">
<input type="text" class="form-control" name="id_google" id = "id_google" value="" data-error="<?php echo lang('id_error');?>">
<a class="giue-video" style="color: blue;" href="javascript:;"><?php echo lang('hd_lay_id');?></a>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label" style = "width:200px;"><?php echo lang('name_tac_gia');?></label>
<div class="col-md-3">
<input type="text" class="form-control" name="name" id="costomer" value="" data-error="<?php echo lang('name_business_error');?>">
</div>
</div>
</div>
</div>
<div style = "display:none" class ="load_img" data-img ="<img src="http://static1.webbnc.vn:8080/upload/web/12/123/test/2014/03/31/04/09/139621378451.jpg">"></div>
<div class="actions btn-set btn-google" style="padding-right: 10px !important;
float: right !important;
margin-top: 10px !important;" data-success-mail="<?php echo lang('success_mail');?>">
<a class="btn green deletegoogle" style="background-color: #d9534f;"><i class="fa fa-check"></i><?php echo lang('cancel_kh');?></a>
<button class="btn green continue" ><i class="fa fa-check"></i><?php echo lang('kich_hoat');?></button>
<input type="hidden" name="action" value="addGoogle">
<input type="hidden" name="lang" value="vi">
<input type="hidden" name="delete" value="deleteGoogle">
<input type="hidden" name="issetLangDefault" <?php if(!empty($contactlist['id'])) { ?>value="exist"<?php } ?>>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="portlet-title topline">
</div>
</div>
</form>
</div>
</div>
<!-- END PAGE CONTENT-->

<script src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script src="<?=$_B['mod_theme']?>js/google.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
Google.init();
});
</script>




</div>
</div>
<div class="tab-pane" id="tab_4">
<div class="clearfix">

<div class="row">
<div class="col-md-12">
<form class="form-horizontal form-row-seperated" action="" id="form_contactinfo" class="form-horizontal" method="POST">
<div class="portlet">

<div class="portlet-body">
<div class="tabbable">
<div class="tab-content no-space">
<div class="tab-pane active">
<div class="form-body">

<div class="portlet light bordered">

<div class="portlet-body form" >
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('noidungfile');?></label>
<div class="col-md-10">
<textarea class="form-control " rows="10" name="robots" ><?=$getRobots['robots']?></textarea>
</div>
<?php include $_B['temp']->load('robots_toolbar') ?>
</div>

</div>
</div>

</div>
</div>
</div>
</div>
</div>
<div class="portlet-title topline">
</div>
</div>
</form>
</div>
</div>
<!-- END PAGE CONTENT-->






</div>
</div>
<div class="tab-pane" id="tab_5">
<div class="clearfix">
<div class="row">
<div class="col-md-12">
<form class="form-horizontal form-row-seperated" action="" id="form_contactinfo" class="form-horizontal" method="POST">
<div class="portlet">

<div class="portlet-body">
<div class="tabbable">
<div class="tab-content no-space">
<div class="tab-pane active">
<div class="form-body">

<div class="portlet light bordered">

<div class="portlet-body form" >
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('ma_gg_analytic');?></label>
<div class="col-md-10">
<textarea class="form-control " rows="10" name="analytics" ><?php if(isset($getGA)) { ?><?=$getGA['ga']?><?php } ?></textarea>
</div>
<?php include $_B['temp']->load('ga_toolbar') ?>
</div>

</div>

</div>

</div>
</div>
</div>
</div>
</div>
<div class="portlet-title topline">
</div>
</div>
</form>
</div>
</div>
</div>
</div>
<div class="tab-pane" id="tab_6">
<div class="clearfix">

</div>
</div>
</div>
</div>
</div>

</div>

</div>
</div>