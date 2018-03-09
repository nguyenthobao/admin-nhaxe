<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/template/blockcustomadd.php 
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
<form class="form-horizontal form-row-seperated" action="" id="blockcustom_form" class="form-horizontal" enctype="multipart/form-data" method="POST">
<div class="portlet">
<div class="portlet-title">
<div class="caption">
<i class="icon-note"></i><?php echo lang('breadcrumb_custom_block');?>
</div>
<div class="actions btn-set">
<a href="<?=$_B['home']?>/template-blockcustom-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('reset');?></button>
<button class="btn green continue" data-continue="blockcustom"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<button class="btn green continue" data-continue="blockcustomadd"><i class="fa fa-check-circle"></i> <?php echo lang('submit_cont_');?></button>
<button class="btn green continue" data-continue="blockcustom_lang"><i class="fa fa-flag"></i> <?php echo lang('submit_cont_lang');?></button>
<input type="hidden" name="action" value="addBlockcustom">
<input type="hidden" name="lang" value="<?=$_GET['lang']?>">
<input type="hidden" name="continue" value="">
<input type="hidden" name="issetLangDefault" <?php if(!empty($content['id'])) { ?>value="exist"<?php } ?>>
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
<?php if(is_array($url_lang)) { foreach($url_lang as $k_lang => $v_lang) { ?>
<li <?php if($k_lang==$_GET['lang']) { ?>class="active"<?php } ?>>
<a href="<?=$v_lang['url']?>">
<?php echo lang('lang_'.$k_lang);?>
</a>

</li>
<?php } } ?>
<input type="hidden" name="popup" data-title="<?php echo lang('pop_title');?>" data-yes="<?php echo lang('pop_yes');?>" data-cancel="<?php echo lang('pop_cancel');?>" data-message="<?php echo lang('pop_message');?>" data-close="<?php echo lang('pop_close');?>">
<input type="hidden" name="popup_df" data-title="<?php echo lang('pop_df_title');?>" data-yes="<?php echo lang('pop_yes');?>" data-cancel="<?php echo lang('pop_cancel');?>" data-message="<?php echo lang('pop_df_message');?>" data-close="<?php echo lang('pop_close');?>">
<input type="hidden" value="<?=$_GET['id']?>" name="id" id="id"/>
</ul>
<div class="tab-content no-space">
<div class="tab-pane active" id="lang_<?=$v_lang?>">
<div class="form-body">
<div class="note note-warning">
<p class="block"><?php echo lang('select_lang','lang_'.$_GET['lang']);?></p>
</div>
<div class="portlet light bordered">
<div class="portlet-title">
<div class="caption">
<i class="icon-equalizer font-red-sunglo"></i>
<span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('basic_information');?></span>
<span class="caption-helper"><?php echo lang('noti_information');?></span>
</div>
<div class="tools">
<a href="javascript:;" class="collapse"></a>
</div>
</div>
<div class="portlet-body form">

<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('label_title_block');?><span class="required">* </span>
</label>
<div class="col-md-10 row_input_title">
<input type="text" class="form-control maxlength-handler" autocomplete="off" name="title" id="title" maxlength="225" value="<?php if(isset($content['title'])) { ?><?=$content['title']?><?php } ?>" placeholder="" data-error="<?php echo lang('error_input_title');?>">
<span class="help-block"><?php echo lang('maxlength','225');?></span>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label">HTML</label>
<div class="col-md-5">
<textarea class="form-control" style="min-height:300px;max-width: 380px;"  name="html" data-error="<?php echo lang('error_input');?>"><?php if(isset($content['html'])) { ?><?=$content['html']?><?php } ?></textarea>
</div>
<label class="col-md-1 control-label">CSS</label>
<div class="col-md-4">
<textarea class="form-control" style="min-height:300px;max-width: 298px;" name="css" data-error="<?php echo lang('error_input');?>"><?php if(isset($content['css'])) { ?><?=$content['css']?><?php } ?></textarea>
</div>
</div>

<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('label_preview_block');?></label>
<div class="col-md-10 BNC_preview" style="display:none;min-height: 50px;padding: 10px;border: #FAEBD7 solid 1px;width: 81%;margin-left: 13px;">
<?php if(isset($content['html'])) { ?><?=$content['html']?><?php } ?>
<style type="text/css">
<?php if(isset($content['css'])) { ?><?=$content['css']?><?php } ?>
</style>
</div>

<iframe scrolling="yes" class="col-md-10" id="iframe" style="min-height: 500px;padding: 10px;border: #FAEBD7 solid 1px;width: 81%;margin-left: 13px;">

</iframe>

</div>

</div>
</div>
<div class="portlet light bordered">
<div class="portlet-title">
<div class="caption">
<i class="icon-equalizer font-red-sunglo"></i>
<span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('label_more_infomation');?></span>
</div>
<div class="tools">
<a href="javascript:;" class="collapse"></a>
</div>
</div>


<div class="portlet-body form">
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('sort');?></label>
<div class="col-md-4">
<input type="number" min="0" class="form-control" name="sort" data-error="<?php echo lang('number_error');?>" value="<?php if(isset($content['sort'])) { ?><?=$content['sort']?><?php } else { ?>0<?php } ?>" />
</div>
</div>

<div class="form-group">
<label class="col-md-2 control-label">Module hiển thị </label>
<div class="col-md-8">
<div class="form-control thr-col">
<div class="scrollbar">
<ul class="list-unstyled">
<?php if(is_array($mod_in_home)) { foreach($mod_in_home as $km => $vm) { ?>
<li>
<label><input class="form-control"  <?php if(!isset($active_mod)) { ?>checked<?php } elseif(isset($active_mod) && in_array($vm,$active_mod)) { ?>checked<?php } ?> type="checkbox" name="active_mod[]" value="<?=$vm?>"><?php echo lang($vm);?></label>
</li>
<?php } } ?>
</ul>
</div>
</div>
</div>

</div>

<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('position_block');?></label>
<div class="col-md-4">
<select class="form-control" name="position" data-error="<?php echo lang('position_error');?>">
<?php if(is_array($position)) { foreach($position as $k => $v) { ?>
<option value="<?=$k?>" <?php if(isset($content['position']) && $k==$content['position']) { ?>selected<?php } ?> ><?=$v?></option>
<?php } } ?>
</select>
</div>
</div>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('status');?></label>
<div class="col-md-4">
<select class="form-control" name="status" data-error="<?php echo lang('news_error');?>">
<option value="1" <?php if((isset($content['status'])&& $content['status']==1)||empty($_GET['id'])) { ?>selected="selected"<?php } ?> ><?php echo lang('is_show');?></option>
<option value="0" <?php if(isset($content['status']) && $content['status']==0) { ?>selected="selected"<?php } ?>><?php echo lang('is_hide');?></option>
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
<div class="actions btn-set">
<a href="<?=$_B['home']?>/template-blockcustom-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('reset');?></button>
<button class="btn green continue" data-continue="blockcustom"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<button class="btn green continue" data-continue="blockcustomadd"><i class="fa fa-check-circle"></i> <?php echo lang('submit_cont_');?></button>
<button class="btn green continue" data-continue="blockcustom_lang"><i class="fa fa-flag"></i> <?php echo lang('submit_cont_lang');?></button>
<input type="hidden" name="action" value="addBlockcustom">
<input type="hidden" name="lang" value="<?=$_GET['lang']?>">
<input type="hidden" name="continue" value="">
<input type="hidden" name="issetLangDefault" <?php if(!empty($content['id'])) { ?>value="exist"<?php } ?>>
</div>
</div>
</div>
</form>
</div>
</div>
<!-- END PAGE CONTENT-->
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
<script type="text/javascript" src="<?=$_B['mod_theme']?>js/blockcustom.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
BlockCustom.init();
});
</script>