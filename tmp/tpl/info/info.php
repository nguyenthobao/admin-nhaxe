<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/info/info.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/jquery-tags-input/jquery.tagsinput.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/typeahead/typeahead.css">
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-datetimepicker/css/datetimepicker.css"/>

<link href="<?=$_B['mod_theme']?>css/style.css" rel="stylesheet" type="text/css" />

<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
<div class="col-md-12">
<form class="form-horizontal form-row-seperated" action="" id="form_info" class="form-horizontal" enctype="multipart/form-data" method="POST">
<div class="portlet">
<div class="portlet-title">
<div class="caption">
<?php if(isset($info_edit['title'])) { ?>
<i class="icon-note"></i><?php echo lang('breadcrumb_edit_info');?>
<?php } else { ?>
<i class="icon-note"></i><?php echo lang('breadcrumb_add_info');?>
<?php } ?>
</div>
<div class="actions btn-set">
<a href="<?=$_B['home']?>/info-infolist-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('reset');?></button>
<button class="btn green continue" data-continue="infolist"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<button class="btn green continue" data-continue="info"><i class="fa fa-check-circle"></i> <?php echo lang('submit_cont_');?></button>
<button class="btn green continue" data-continue="info_lang"><i class="fa fa-flag"></i> <?php echo lang('submit_cont_lang');?></button>
<input type="hidden" name="action" value="addInfo">
<input type="hidden" name="lang" value="vi">
<input type="hidden" name="continue" value="">
<input type="hidden" name="issetLangDefault" <?php if(!empty($info['id'])) { ?>value="exist"<?php } ?>>
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
<a class="select_lang" href="<?=$v_lang['url']?>" data-exist="<?=$v_lang['exist']?>">
<?php echo lang('lang_'.$k_lang);?>  
</a>
</li>
<?php } } ?>
<input type="hidden" name="popup" data-title="<?php echo lang('pop_title');?>" data-yes="<?php echo lang('pop_yes');?>" data-cancel="<?php echo lang('pop_cancel');?>" data-message="<?php echo lang('pop_message');?>" data-close="<?php echo lang('pop_close');?>">
<input type="hidden" name="popup_df" data-title="<?php echo lang('pop_df_title');?>" data-yes="<?php echo lang('pop_yes');?>" data-cancel="<?php echo lang('pop_cancel');?>" data-message="<?php echo lang('pop_df_message');?>" data-close="<?php echo lang('pop_close');?>">
<input type="hidden" value="<?=$_GET['id']?>" name="idinfo" id="idinfo"/>
<input type="hidden" value="<?php if(isset($info_edit['title'])) { ?><?=$info_edit['title']?><?php } ?>" name="title_check" id="title_check"/>
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
<label class="col-md-2 control-label"><?php echo lang('title');?>: <span class="required">
* </span>
</label>
<div class="col-md-8 row_input_title">
<input type="text" class="form-control maxlength-handler" id="seo_url" onkeyup="trim_name(this);" name="title" maxlength="225" value="<?php if(isset($info_edit['title'])) { ?><?=$info_edit['title']?><?php } ?>" placeholder="" data-error="<?php echo lang('title_error');?>">
<span class="help-block"><?php echo lang('maxlength','225');?></span>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label">SEO URL </label>
<div class="col-md-8">
<input class="form-control maxlength-handler" maxlength="225" <?php if(isset($info_edit['alias'])) { ?> value="<?=$info_edit['alias']?>" <?php } else { ?> value="" <?php } ?> name="alias" value="" id="seo_keyword" >
<span class="help-block"><?php echo lang('maxlength','225');?></span>													
<script type="text/javascript">
 function trim_name(input_name){
  var txtname_trim=erase($("#seo_url").val());
  $("#seo_keyword").val(nbh_seo_write(txtname_trim));
 }
</script>
</div>
</div>
<?php if(isset($info_edit['title'])) { ?>
<div class="form-group">
<label class="col-md-2 control-label"></label>
<div class="col-md-8">
<label>
<input type="checkbox" name="is_save" >
<?php echo lang('noti_change');?>
</label>
<input type="hidden" name="title_alias" value="<?=$info_edit['alias']?>">
</div>
</div>
<?php } ?>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('description');?></label>
<div class="col-md-10">
<textarea class="form-control ckeditor m-wrap" minlength="5" rows="6" name="description">
<?php if(isset($info_edit['short'])) { ?><?=$info_edit['short']?><?php } ?>
</textarea>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('content');?></label>
<div class="col-md-10">
<textarea class="span12 ckeditor m-wrap" name="content" rows="6">
<?php if(isset($info_edit['details'])) { ?><?=$info_edit['details']?><?php } ?>
</textarea>

</div>
</div>									
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('tags');?> </label>
<div class="col-md-8">
<input id="tags" name="tags" type="text" class="form-control tags" value="<?php if(isset($info_edit['tags'])) { ?><?=$info_edit['tags']?><?php } ?>"/>
</div>
</div>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('title_img');?> </label>
<div class="col-md-8">
<div class="fileinput <?php if(!empty($info_edit['img'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
<?php if(!empty($info_edit['img'])) { ?>
<input type="hidden" value="1" name="img_info"/>
<input type="hidden" value="<?=$info_edit['img']?>" name="src_img_info"/>
<?php } ?>
<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
<img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
<img src="<?php if(isset($info_edit['img'])) { ?><?=$_B['upload_path']?><?=$info_edit['img']?><?php } ?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" />
</div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new">
<?php echo lang('select_img');?> </span>
<span class="fileinput-exists">
<?php echo lang('change_img');?> </span>
<input type="file" name="img_info" id="img_info">
</span>
<a href="#" class="btn default fileinput-exists" data-dismiss="fileinput">
<?php echo lang('delete');?> </a>
</div>
</div>	
</div>
</div>

<div class="form-group row-title-check">
<label class="col-md-2 control-label"><?php echo lang('info_hot');?> </label>
<div class="col-md-8">
<input type="checkbox" name="info_hot" <?php if(isset($info_edit['is_hot'])&&($info_edit['is_hot'] == 1)) { ?> checked <?php } ?> />
</div>
</div>

<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('sort');?></label>
<div class="col-md-2">
<input type="text" class="form-control" name="sort" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?php if(isset($info_edit['sort'])) { ?><?=$info_edit['sort']?><?php } ?>" />
</div>
</div>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('status');?></label>
<div class="col-md-2">
<select class="form-control" name="status" data-error="<?php echo lang('news_error');?>">
<option value=""><?php echo lang('status');?></option>
<option value="1" <?php if((isset($info_edit['status'])&& $info_edit['status']==1)||empty($_GET['id'])) { ?>selected="selected"<?php } ?> ><?php echo lang('is_show');?></option>
<option value="0" <?php if(isset($info_edit['status']) && $info_edit['status']==0) { ?>selected="selected"<?php } ?>><?php echo lang('is_hide');?></option>
</select>
</div>
</div>

</div>
</div>									

<div class="portlet light bordered">
<div class="portlet-title">
<div class="caption">
<i class="icon-equalizer font-red-sunglo"></i>
<span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('meta_information');?></span>
<span class="caption-helper"><?php echo lang('meta_define');?></span>
</div>
<div class="tools">
<a href="javascript:;" class="collapse"></a>
</div>
</div>
<div class="portlet-body form">
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('meta_title');?> </label>
<div class="col-md-8">
<input type="text" class="form-control maxlength-handler" name="meta_title" maxlength="170" value="<?php if(isset($info_edit['meta_title'])) { ?><?=$info_edit['meta_title']?><?php } ?>" placeholder="" data-error="<?php echo lang('meta_title');?>">
<span class="help-block">
<?php echo lang('maxlength','170');?> </span>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('meta_keyword');?>  </label>
<div class="col-md-8">
<input id="meta_keyword" name="meta_keyword" type="text" class="form-control tags" value="<?php if(isset($info_edit['meta_keyword'])) { ?><?=$info_edit['meta_keyword']?><?php } ?>"/>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('meta_description');?> </label>
<div class="col-md-8">
<textarea class="form-control maxlength-handler" rows="4" name="meta_description" maxlength="500"><?php if(isset($info_edit['meta_description'])) { ?><?=$info_edit['meta_description']?><?php } ?></textarea>
<span class="help-block">
<?php echo lang('maxlength','500');?> </span>
</div>
</div>
</div>
</div>									
<div class="portlet light bordered">
<div class="portlet-title">
<div class="caption">
<i class="icon-equalizer font-red-sunglo"></i>
<span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('option_post');?></span>												
</div>
<div class="tools">
<a href="javascript:;" class="collapse"></a>
</div>
</div>
<div class="portlet-body form">
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('time_post');?></label>
<div class="col-md-4">
<div class="input-group input-medium date form_datetime" data-date-format="dd-mm-yyyy" data-date-start-date="+0d">
<input type="text" class="form-control" readonly name="time_up" value="<?php if(isset($info_edit['time_up'])) { ?><?=$info_edit['time_up']?><?php } ?>">
<span class="input-group-btn">
<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
</span>
</div>

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
<a href="<?=$_B['home']?>/info-infolist-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('reset');?></button>
<button class="btn green continue" data-continue="infolist"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<button class="btn green continue" data-continue="info"><i class="fa fa-check-circle"></i> <?php echo lang('submit_cont_');?></button>
<button class="btn green continue" data-continue="info_lang"><i class="fa fa-flag"></i> <?php echo lang('submit_cont_lang');?></button>
<input type="hidden" name="action" value="addInfo">
<input type="hidden" name="lang" value="vi">
<input type="hidden" name="continue" value="">
<input type="hidden" name="issetLangDefault" <?php if(!empty($info['id'])) { ?>value="exist"<?php } ?>>
</div>
</div>
</div>
</form>
</div>
</div>
<!-- END PAGE CONTENT-->
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/scripts/metronic.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript" src="<?=$_B['mod_theme']?>js/info.js"></script>
<script type="text/javascript" src="<?=$_B['mod_theme']?>js/nbh_seo_rewrite.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
       FormInfo.init();
    });        
</script>
<script type="text/javascript">
function validate(evt) {
  	var theEvent = evt || window.event;
  	var key = theEvent.keyCode || theEvent.which;
  	key = String.fromCharCode( key );
  	var regex = /[0-9]|\./;
  	if( !regex.test(key) ) {
    	theEvent.returnValue = false;
    	if(theEvent.preventDefault) theEvent.preventDefault();
  	}
}
</script>
