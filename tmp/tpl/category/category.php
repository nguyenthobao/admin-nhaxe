<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/category/category.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/jquery-tags-input/jquery.tagsinput.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/typeahead/typeahead.css">
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/components.css" />
<link href="<?=$_B['mod_theme']?>css/style.css" rel="stylesheet" type="text/css" />
<!-- BEGIN PAGE CONTENT-->
<div class="row">
<div class="col-md-12">
<form class="form-horizontal form-row-seperated" action="" id="form_catego" class="form-horizontal" enctype="multipart/form-data" method="POST">
<div class="portlet">
<div class="portlet-title">
<div class="caption">
<i class="fa icon-note"></i><?=$_S['breadcrumb_page_cat']?>
</div>
<div class="actions btn-set">
<a href="<?=$_B['home']?>/category-categorylist-lang-<?=$_GET['lang']?>" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('reset');?></button>
<button class="btn green continue" data-continue="categorylist"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<button class="btn green continue" data-continue="category"><i class="fa fa-check-circle"></i> <?php echo lang('submit_cont_');?></button>
<button class="btn green continue" data-continue="category_lang"><i class="fa fa-flag"></i> <?php echo lang('submit_cont_lang');?></button>
<input type="hidden" name="action" value="addcategory">
<input type="hidden" name="lang" value="vi">
<input type="hidden" name="continue" value="">
<input type="hidden" name="issetLangDefault" <?php if(!empty($cat['id'])) { ?>value="exist"<?php } ?>>
</div>
</div>
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
<div class="portlet-body">
<div class="tabbable">
<ul class="nav nav-tabs">					
<?php if(is_array($url_lang)) { foreach($url_lang as $k_lang => $v_lang) { ?>
<li <?php if($k_lang==$_GET['lang']) { ?>class="active"<?php } ?>>
<a class="select_lang" href="<?=$v_lang['url']?>" 
data-close="Đóng" data-exist="<?=$v_lang['exist']?>" data-message="<?=$v_lang['mes']?>">
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
<label class="col-md-2 control-label">
<?=$_L['Catego_title']?><span class="required">
* </span>
</label>
<div class="col-md-8">
<input type="text" class="form-control maxlength-handler" id="seo_url" onkeyup="trim_name(this);" name="title" maxlength="60" value="<?php if(!empty($cat['title'])) { ?><?=$cat['title']?><?php } ?>" placeholder="" data-error="<?php echo lang('error_title');?>">
<span class="help-block"><?php echo lang('maxlength','60');?></span>
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
<label class="col-md-2 control-label"><?=$_L['Catego_des']?> 
</label>
<div class="col-md-8">
<textarea class="form-control " rows="6" name="short"><?php if(!empty($cat['short'])) { ?><?=$cat['short']?><?php } ?></textarea>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('catego_content');?>: 
</label>
<div class="col-md-10">
<textarea class="span12 ckeditor m-wrap" name="content" rows="6" data-error-container="#editor2_error"><?php if(!empty($cat['details'])) { ?><?=$cat['details']?><?php } ?></textarea>
<div id="editor2_error"></div>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-2 label-img">Ảnh</label>
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

<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('status');?> 
</label>
<div class="col-md-3">
<select class="form-control" name="status" data-error="<?php echo lang('category_error');?>">
<?php if(empty($cat['id']) ) { ?>
<option value="1" selected="selected"><?php echo lang('active');?></option>
<option value="0"><?php echo lang('non_active');?></option>
<?php } else { ?>
<option value="1" <?php if((isset($_POST['status'])&& $_POST['status']==1)||empty($_GET['id'])) { ?>selected="selected"<?php } ?> ><?php echo lang('active');?></option>
<option value="0" <?php if(isset($_POST['status']) && $_POST['status']==0) { ?>selected="selected"<?php } ?>><?php echo lang('non_active');?></option>
<?php } ?>
</select>
</div>
</div>	
</div>
</div>
<div class="portlet light bordered">
<div class="portlet-title">
<div class="caption">
<i class="icon-equalizer font-red-sunglo"></i>
<span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('metainformation');?></span>
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
<input type="text" class="form-control maxlength-handler" name="meta_title" maxlength="100" value="<?php if(!empty($cat['meta_title'])) { ?><?=$cat['meta_title']?><?php } ?>" placeholder="" data-error="<?php echo lang('meta_title');?>">
<span class="help-block">
<?php echo lang('maxlength','100');?> </span>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('meta_keyword');?>  </label>
<div class="col-md-8">
<input id="meta_keyword" name="meta_keyword" type="text" class="form-control tags" value="<?php if(!empty($cat['meta_keyword'])) { ?><?=$cat['meta_keyword']?><?php } ?>"/>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('meta_description');?> </label>
<div class="col-md-8">
<textarea class="form-control maxlength-handler" rows="4" name="meta_description" maxlength="500"><?php if(!empty($cat['meta_description'])) { ?><?=$cat['meta_description']?><?php } ?></textarea>
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
<a href="<?=$_B['home']?>/category-categorylist-lang-<?=$_GET['lang']?>" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('reset');?></button>
<button class="btn green continue" data-continue="categorylist"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<button class="btn green continue" data-continue="category"><i class="fa fa-check-circle"></i> <?php echo lang('submit_cont_');?></button>
<button class="btn green continue" data-continue="category_lang"><i class="fa fa-flag"></i> <?php echo lang('submit_cont_lang');?></button>
<input type="hidden" name="action" value="addcategory">
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
<script src="<?=$_B['mod_theme']?>js/category.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/ckeditor/ckeditor.js"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$_B['mod_theme']?>js/nbh_seo_rewrite.js"></script>
<script>
jQuery(document).ready(function() {
catego.init();
});
</script>