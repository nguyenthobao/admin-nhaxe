<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/template/image.php 
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
<form class="form-horizontal form-row-seperated" action="" id="form_image" class="form-horizontal" enctype="multipart/form-data" method="POST">
<div class="portlet">
<div class="portlet-title">
<div class="caption">
<?php if(isset($image_edit['slide_id'])) { ?>
<i class="icon-note"></i><?php echo lang('breadcrumb_edit_image');?>
<?php } else { ?>
<i class="icon-note"></i><?php echo lang('breadcrumb_add_image');?>
<?php } ?>
</div>
<div class="actions btn-set">
<a href="<?=$_B['home']?>/template-imagelist-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('reset');?></button>
<button class="btn green continue" data-continue="imagelist"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<button class="btn green continue" data-continue="image"><i class="fa fa-check-circle"></i> <?php echo lang('submit_cont_');?></button>
<button class="btn green continue" data-continue="image_lang"><i class="fa fa-flag"></i> <?php echo lang('submit_cont_lang');?></button>
<input type="hidden" name="action" value="addImage">
<input type="hidden" name="lang" value="vi">
<input type="hidden" name="continue" value="">
<input type="hidden" name="issetLangDefault" <?php if(!empty($image['id'])) { ?>value="exist"<?php } ?>>
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
<input type="hidden" value="<?=$_GET['id']?>" name="idimage" id="idimage"/>
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
<label class="control-label col-md-2"><?php echo lang('img_slide');?><span class="required">
* </span></label>
<div class="col-md-8">
<div class="fileinput <?php if(!empty($image_edit['src_link'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
<?php if(!empty($image_edit['src_link'])) { ?>
<input type="hidden" value="1" name="img_slide"/>
<input type="hidden" value="<?=$image_edit['img']?>" name="src_img_slide"/>
<?php } ?>
<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
<img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
<img src="<?php if(isset($image_edit['src_link'])) { ?><?=$_B['upload_path']?><?=$image_edit['src_link']?><?php } ?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" />
</div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new">
<?php echo lang('select_img');?> </span>
<span class="fileinput-exists">
<?php echo lang('change_img');?> </span>
<input type="file" name="img_slide" id="img_slide">
</span>
<a href="#" class="btn default fileinput-exists" data-dismiss="fileinput">
<?php echo lang('delete');?> </a>
<span class="image_slide" data-error="<?php echo lang('image_error');?>"></span>
</div>
</div>	
</div>
</div>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('slide');?><span class="required">
* </span></label>
<div class="col-md-3">
<?php if(isset($slide)) { ?>
<select class="form-control" name="slide_id" id="slide_id" data-error="<?php echo lang('slide_error');?>">
<option value=""><?php echo lang('select_slide');?></option>
<?php if(is_array($slide)) { foreach($slide as $k => $v) { ?>
<option value="<?php if(!empty($v['id'])) { ?><?=$v['id']?><?php } ?>" <?php if(($v['id'] == $image_edit['slide_id'])) { ?> selected="selected" <?php } ?>><?php if(!empty($v['title'])) { ?><?=$v['title']?><?php } ?></option>


<?php } } ?>
</select>
<?php } ?>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('title');?></label>
<div class="col-md-8 row_input_title">
<input type="text" class="form-control" name="title" value="<?php if(isset($image_edit['title'])) { ?><?=$image_edit['title']?><?php } ?>" placeholder="">													
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('description');?></label>
<div class="col-md-8">
<textarea class="form-control " minlength="5" id="description" rows="6" name="description">
<?php if(isset($image_edit['description'])) { ?><?=$image_edit['description']?><?php } ?>
</textarea>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('link');?></label>
<div class="col-md-8">
<input type="text" class="form-control" name="link" data-error="<?php echo lang('number_error');?>" value="<?php if(isset($image_edit['link'])) { ?><?=$image_edit['link']?><?php } ?>" />
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('width');?></label>
<div class="col-md-2">
<input type="text" class="form-control" name="width" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?php if(isset($image_edit['width'])) { ?><?=$image_edit['width']?><?php } ?>" />
</div>
<label class="col-md-1 control-label">(pixels)</label>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('height');?></label>
<div class="col-md-2">
<input type="text" class="form-control" name="height" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?php if(isset($image_edit['height'])) { ?><?=$image_edit['height']?><?php } ?>" />
</div>
<label class="col-md-1 control-label">(pixels)</label>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('sort');?></label>
<div class="col-md-2">
<input type="text" class="form-control" name="sort" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?php if(isset($image_edit['sort'])) { ?><?=$image_edit['sort']?><?php } ?>" />
</div>
</div>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('status');?></label>
<div class="col-md-2">
<select class="form-control" name="status" data-error="<?php echo lang('news_error');?>">
<option value="1" <?php if((isset($image_edit['status'])&& $image_edit['status']==1)||empty($_GET['id'])) { ?>selected="selected"<?php } ?> ><?php echo lang('is_show');?></option>
<option value="0" <?php if(isset($image_edit['status']) && $image_edit['status']==0) { ?>selected="selected"<?php } ?>><?php echo lang('is_hide');?></option>
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
<a href="<?=$_B['home']?>/template-imagelist-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('reset');?></button>
<button class="btn green continue" data-continue="imagelist"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<button class="btn green continue" data-continue="image"><i class="fa fa-check-circle"></i> <?php echo lang('submit_cont_');?></button>
<button class="btn green continue" data-continue="image_lang"><i class="fa fa-flag"></i> <?php echo lang('submit_cont_lang');?></button>
<input type="hidden" name="action" value="addImage">
<input type="hidden" name="lang" value="vi">
<input type="hidden" name="continue" value="">
<input type="hidden" name="issetLangDefault" <?php if(!empty($image['id'])) { ?>value="exist"<?php } ?>>
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

<script type="text/javascript" src="<?=$_B['mod_theme']?>js/image.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
       FormImage.init();
       CKEDITOR.replace('description');
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
