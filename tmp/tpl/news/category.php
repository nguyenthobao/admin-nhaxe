<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/news/category.php 
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
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
<div class="col-md-12">
<form class="form-horizontal form-row-seperated" action="" id="form_category" class="form-horizontal" enctype="multipart/form-data" method="POST">
<div class="portlet">
<div class="portlet-title">
<div class="caption col-md-4">
<?php if(isset($cat['title'])) { ?>
<i class="icon-note"></i><?php echo lang('breadcrumb_edit_category');?>
<?php } else { ?>
<i class="icon-note"></i><?php echo lang('breadcrumb_add_category');?>
<?php } ?>						
</div>
<div class="actions btn-set">
<a href="<?=$_B['home']?>/news-categorylist-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('reset');?></button>
<button class="btn green continue" data-continue="categorylist"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<button class="btn green continue" data-continue="category"><i class="fa fa-check-circle"></i> <?php echo lang('submit_cont_');?></button>
<button class="btn green continue" data-continue="category_lang"><i class="fa fa-flag"></i> <?php echo lang('submit_cont_lang');?></button>
<input type="hidden" name="action" value="addCategoryNews">
<input type="hidden" name="lang" value="vi">
<input type="hidden" name="continue" value="">
<input type="hidden" name="issetLangDefault" <?php if(!empty($cat['id'])) { ?>value="exist"<?php } ?>>
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
<label class="col-md-2 control-label"><?php echo lang('title');?> <span class="required">
* </span>
</label>
<div class="col-md-8 row_input_title">
<input type="text" class="form-control maxlength-handler" id="seo_url" onkeyup="trim_name(this);" name="title" maxlength="100" value="<?=$cat['title']?>" placeholder="" data-error="<?php echo lang('title_error');?>">
<span class="help-block"><?php echo lang('maxlength','100');?></span>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label">SEO URL </label>
<div class="col-md-8">
<input class="form-control maxlength-handler" maxlength="225" <?php if(isset($cat['alias'])) { ?> value="<?=$cat['alias']?>" <?php } else { ?> value="" <?php } ?> name="alias" value="" id="seo_keyword" >
<span class="help-block"><?php echo lang('maxlength','225');?></span>													
<script type="text/javascript">
 function trim_name(input_name){
  var txtname_trim=erase($("#seo_url").val());
  $("#seo_keyword").val(nbh_seo_write(txtname_trim));
 }
</script>
</div>
</div>
<?php if(isset($cat['title'])) { ?>
<div class="form-group">
<label class="col-md-2 control-label"></label>
<div class="col-md-8">
<label>
<input type="checkbox" name="is_save" >
<?php echo lang('noti_change');?>
</label>
<input type="hidden" name="title_alias" value="<?=$cat['alias']?>">
</div>
</div>
<?php } ?>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('description');?></label>
<div class="col-md-8">
<div class="text_aria">
<textarea class="form-control " minlength="5" rows="6" name="description"  id="description" data-error="<?php echo lang('description_error');?>"><?=$cat['description']?></textarea>
</div>
</div>
</div>
<?php if(isset($category)) { ?>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('category');?></label>
<div class="col-md-8">
<input type="hidden" id="cat_select" name_id="<?=$cat['id']?>" value="<?=$cat['id']?>">
<select class="form-control" id="cat_parent" name="cat_id" data-error="">
<option value="0"><?php echo lang('category_default');?></option>
<?php if(is_array($category)) { foreach($category as $k => $v) { ?>
<option value="<?=$v['id']?>" <?php if($v['id']==$cat['parent_id']) { ?>selected="selected"<?php } ?> ><?=$v['space']?> <?=$v['title']?></option>
<?php if(sizeof($v['sub'])>0 ) { ?>
<?php if(is_array($v['sub'])) { foreach($v['sub'] as $k => $v) { ?>
<?php include $_B['temp']->load('category_cat_list') ?>
<?php } } ?>		
<?php } ?>
<?php } } ?>
</select>
<div class="warning" id="selectError"  style="display:none" ><span style="color: red;"><?php echo lang('selectError');?></span></div>
</div>
</div>
<?php } ?>
<div class="form-group">
<label class="control-label col-md-2 label-img"><?php echo lang('image');?></label>
<div class="col-md-8">
<div class="fileinput <?php if(!empty($cat['img'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
<p class="label2"><?php echo lang('title_img');?></p>
<?php if(!empty($cat['img'])) { ?>
<input type="hidden" value="1" name="img_cat"/>
<?php } ?>
<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
<img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
<img src="<?php if(isset($cat['img'])) { ?><?=$_B['upload_path']?><?=$cat['img']?><?php } ?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" />
</div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new">
<?php echo lang('select_img');?> </span>
<span class="fileinput-exists">
<?php echo lang('change_img');?> </span>
<input type="file" name="img_cat" id="img_cat">
</span>
<a href="#" class="btn default fileinput-exists" data-dismiss="fileinput">
<?php echo lang('delete');?> </a>
</div>
</div>


<div class="fileinput <?php if(!empty($cat['icon'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
<p class="label2"><?php echo lang('icon_img');?></p>
<?php if(!empty($cat['icon'])) { ?>
<input type="hidden" value="1" name="icon_cat"/>
<?php } ?>
<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
<img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
<img src="<?php if(isset($cat['icon'])) { ?><?=$_B['upload_path']?><?=$cat['icon']?><?php } ?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" />
</div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new">
<?php echo lang('select_img');?> </span>
<span class="fileinput-exists">
<?php echo lang('change_img');?> </span>
<input type="file" name="icon_cat" id="icon_cat">
</span>
<a href="#" class="btn default fileinput-exists" data-dismiss="fileinput">
<?php echo lang('delete');?> </a>
</div>
</div>

<div class="fileinput <?php if(!empty($cat['bg'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
<p class="label2"><?php echo lang('bg_img');?></p>
<?php if(!empty($cat['bg'])) { ?>
<input type="hidden" value="1" name="bg_cat"/>
<?php } ?>
<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
<img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
<img src="<?php if(isset($cat['bg'])) { ?><?=$_B['upload_path']?><?=$cat['bg']?><?php } ?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" />
</div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new">
<?php echo lang('select_img');?> </span>
<span class="fileinput-exists">
<?php echo lang('change_img');?> </span>
<input type="file" name="bg_cat" id="bg_cat">
</span>
<a href="#" class="btn default fileinput-exists" data-dismiss="fileinput">
<?php echo lang('delete');?> </a>
</div>
</div>
</div>
</div>
<div class="form-group row-title-check">
<label class="col-md-2 control-label"><?php echo lang('is_home');?> </label>
<div class="col-md-8">
<input type="checkbox" name="is_home" <?php if(isset($cat['is_home'])&&($cat['is_home'] == 1)) { ?> checked <?php } ?>>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('number_home');?></label>
<div class="col-md-2">
<input type="text" class="form-control" name="number_home" value="<?=$cat['number_home']?>" >
</div>
<label class="col-md-3 control-label">(<?php echo lang('noti_news_cat');?>)</label>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('sort');?> </label>
<div class="col-md-2">
<input type="text" class="form-control" name="sort" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?=$cat['sort']?>" >
</div>
</div>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('active');?></label>
<div class="col-md-2">
<select class="form-control" name="status" data-error="<?php echo lang('category_error');?>">
<option value="1" <?php if((isset($cat['status'])&& $cat['status']==1)) { ?>selected="selected"<?php } ?> ><?php echo lang('is_show');?></option>
<option value="0" <?php if(isset($cat['status']) && $cat['status']==0) { ?>selected="selected"<?php } ?>><?php echo lang('is_hide');?></option>
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
<input type="text" class="form-control maxlength-handler" name="meta_title" maxlength="100" value="<?=$cat['meta_title']?>" placeholder="" data-error="<?php echo lang('meta_title');?>">
<span class="help-block">
<?php echo lang('maxlength','100');?> </span>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('meta_keyword');?>  </label>
<div class="col-md-8">
<input id="meta_keyword" name="meta_keyword" type="text" class="form-control tags" value="<?=$cat['meta_keyword']?>"/>
</div>

</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('meta_description');?> </label>
<div class="col-md-8">
<textarea class="form-control maxlength-handler" rows="4" name="meta_description" maxlength="500"><?=$cat['meta_description']?></textarea>
<span class="help-block">
<?php echo lang('maxlength','500');?> </span>
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
<a href="<?=$_B['home']?>/news-categorylist-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('reset');?></button>
<button class="btn green continue" data-continue="categorylist"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<button class="btn green continue" data-continue="category"><i class="fa fa-check-circle"></i> <?php echo lang('submit_cont_');?></button>
<button class="btn green continue" data-continue="category_lang"><i class="fa fa-flag"></i> <?php echo lang('submit_cont_lang');?></button>
<input type="hidden" name="action" value="addCategoryNews">
<input type="hidden" name="lang" value="vi">
<input type="hidden" name="continue" value="">
<input type="hidden" name="issetLangDefault" <?php if(!empty($cat['id'])) { ?>value="exist"<?php } ?>>
</div>
</div>
</div>
</form>
</div>
</div>
<!-- END PAGE CONTENT-->

<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript"></script>

<script src="<?=$_B['mod_theme']?>js/category.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$_B['mod_theme']?>js/nbh_seo_rewrite.js"></script>
<link href="<?=$_B['mod_theme']?>css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=$_B['home_theme']?>/assets/global/plugins/ckeditor/ckeditor.js"></script>
<script>
jQuery(document).ready(function() {
   NewsCategory.init();
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
