<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/template/addSocial.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?=$_B['mod_theme']?>css/style.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
<div class="col-md-12">
<form class="form-horizontal form-row-seperated" action="" id="form_slide" enctype="multipart/form-data" method="POST" novalidate="novalidate">
<div class="portlet">
<div class="portlet-title">
<div class="caption">
<i class="icon-note"></i><?php echo lang('block_mang_xh');?></div> 
<div class="actions btn-set">
<a href="/template-addLayout-listLayout-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> Hủy</a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> Làm mới</button>
<button class="btn green continue" data-continue="slidelist"><i class="fa fa-check"></i> Lưu</button>
</div> 
</div>
<div class="portlet-body">
<?php if(isset($_SESSION['error_submit'])) { ?>
<div class="alert alert-danger">
<button class="close" data-close="alert"></button>
<?php echo show_ss('error_submit');?>
</div>
<?php } ?> 
<?php if(isset($_SESSION['success'])) { ?>
<div class="alert alert-success">
<button class="close" data-close="alert"></button>
<?php echo show_ss('success');?>
</div>
<?php } ?> 

<div class="alert alert-danger display-hide">
<button class="close" data-close="alert"></button>
<?php echo lang('notify_error');?>
</div>

<div class="alert alert-success display-hide">
<button class="close" data-close="alert"></button>
<?php echo lang('notify_success');?>
</div>
<div class="tabbable">
<ul class="nav nav-tabs">
<?php if(is_array($_DATA['lang_tab'])) { foreach($_DATA['lang_tab'] as $k_lang => $v_lang) { ?>
<li <?php if($k_lang==$_DATA['lang']) { ?>class="active"<?php } ?> >
<a href="<?=$v_lang['url']?>" data-lang="<?=$k_lang?>"><?php echo lang('lang_'.$k_lang);?> </a>
</li>
<?php } } ?>
</ul>
</div>
<div class="tabbable">
<div class="tab-content no-space">
<div class="tab-pane active">
<div class="form-body">
<div class="note note-warning">
<p class="block"><?php echo lang('haytruycap');?><a href="https://developers.facebook.com/docs/plugins?locale=vi_VN">Link</a> <?php echo lang('laymacode');?></p>
</div>
<div class="portlet light bordered">
<div class="portlet-title">
<div class="caption">
<i class="icon-equalizer font-red-sunglo"></i>
<span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('block_mang_xh');?></span>

</div>
<div class="tools">
<a href="javascript:;" class="collapse"></a>
</div>
</div>
<div class="portlet-body form">

<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('name_block');?> <span class="required" aria-required="true">* </span></label>
<div class="col-md-4">
<input type="text" class="form-control" name="title" value="<?php if(isset($_DATA['item'])) { ?><?=$_DATA['item']['title']?><?php } ?>" data-error="Vui lòng nhập trường này" placeholder="Facebook">
</div>
</div>

<div class="form-group">
<label class="col-md-2 control-label">Fan Page <span class="required" aria-required="true">* </span></label>

<div class="col-md-4">
<input type="text" class="form-control" name="url" value="<?php if(isset($_DATA['item'])) { ?><?=$_DATA['item']['data_custome']?><?php } else { ?>webbnc.net<?php } ?>"  data-error="Vui lòng nhập trường này">
<small>Ví dụ:https://www.facebook.com/<strong>facebook</strong></small>
</div>
</div>

<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('position');?> <span class="required" aria-required="true">* </span></label>
<div class="col-md-4">
<select name="position" class="form-control">
<?php if(is_array($_DATA['position'])) { foreach($_DATA['position'] as $k => $v) { ?>
<option value="<?=$k?>" <?php if(isset($_DATA['item']) && $k==$_DATA['item']['position']) { ?>selected<?php } ?>><?=$v?></option>
<?php } } ?>
</select>
</div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="portlet-title topline">
<input type="hidden" name="id" value="<?php if(isset($_DATA['item'])) { ?><?=$_DATA['item']['id']?><?php } ?>">
<div class="actions btn-set">
<a href="/template-social-index-lang-<?=$_DATA['lang']?>" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('lammoi');?></button>
<button class="btn green continue" data-continue="slidelist"><i class="fa fa-check"></i> <?php echo lang('luu');?></button>
</div>  
</div>
</div>
</form>
</div>
</div>
<script type="text/javascript" src="<?=$_B['mod_theme']?>js/addsocial.js"></script> 
