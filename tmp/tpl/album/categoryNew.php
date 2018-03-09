<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/album/categoryNew.php 
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
<div class="caption">
<i class="fa icon-note"></i><?php echo lang('breadcrumb_category_new');?>
</div>
<div class="actions btn-set">
<a href="<?=$_B['home']?>/album-category" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('reset');?></button>
<button class="btn green continue" data-continue="category"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<button class="btn green continue" data-continue="categoryNew"><i class="fa fa-check-circle"></i> <?php echo lang('submit_cont_');?></button>
<button class="btn green continue" data-continue="categoryUpdate"><i class="fa fa-flag"></i> <?php echo lang('submit_cont_lang');?></button>
<input type="hidden" name="action" value="addCategory">
<input type="hidden" name="lang" value="<?=$dfLang?>">
<input type="hidden" name="continue" value="">
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
<li <?php if($k_lang==$get_lang) { ?>class="active"<?php } ?>>
<a class="select_lang" href="<?=$v_lang['url']?>" data-exist="<?=$v_lang['exist']?>"> <?php echo lang('lang_'.$k_lang);?> </a>
</li>
<?php } } ?>
<input type="hidden" name="popup" data-title="<?php echo lang('pop_title');?>" data-yes="<?php echo lang('pop_yes');?>" data-cancel="<?php echo lang('pop_cancel');?>" data-message="<?php echo lang('pop_message');?>" data-close="<?php echo lang('pop_close');?>">
<input type="hidden" name="popup_df" data-title="<?php echo lang('pop_df_title');?>" data-yes="<?php echo lang('pop_yes');?>" data-cancel="<?php echo lang('pop_cancel');?>" data-message="<?php echo lang('pop_df_message');?>" data-close="<?php echo lang('pop_close');?>">
</ul>
<div class="tab-content no-space">
<div class="tab-pane active" id="lang_<?=$get_lang?>">
<div class="form-body">
<div class="note note-warning">
<p class="block">
<?php echo lang('select_lang','lang_'.$get_lang);?>
</p>
</div>
<!--category param-->
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
<label class="col-md-2 control-label"><?php echo lang('title');?>: <span class="required"> * </span> </label>
<div class="col-md-8">
<input type="text" id="seo_url" onkeyup="trim_name(this);"class="form-control maxlength-handler" name="title" maxlength="255" value="" placeholder="" data-error="<?php echo lang('title_error');?>">
<span class="help-block"><?php echo lang('maxlength','255');?></span>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label">SEO URL </label>
<div class="col-md-8">
<input class="form-control maxlength-handler" maxlength="225" name="alias" value="" id="seo_keyword" >
<span class="help-block"><?php echo lang('maxlength','225');?></span>
<script type="text/javascript" src="<?=$_B['mod_theme']?>js/nbh_seo_rewrite.js"></script>
<script type="text/javascript">
function trim_name(input_name){
var txtname_trim=erase($("#seo_url").val());
$("#seo_keyword").val(nbh_seo_write(txtname_trim));
}
</script>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('description');?></label>
<div class="col-md-8">
<textarea class="form-control " minlength="5" rows="6" name="contents_description"  data-error="<?php echo lang('contents_description_error');?>"></textarea>
</div>
</div>
<?php if($categoryMenu) { ?>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('category');?> <span class="required"> * </span> </label>
<div class="col-md-8">
<select class="form-control" name="parent_id" data-error="">
<option value="0"><?php echo lang('main_category');?></option>
<?php if(is_array($categoryMenu)) { foreach($categoryMenu as $k => $v) { ?>
<option value="<?=$v['id']?>"><?=$v['space']?> <?=$v['title']?></option>
<?php if(sizeof($v['sub'])>0 ) { ?>
        <?php if(is_array($v['sub'])) { foreach($v['sub'] as $k => $v) { ?>
        <?php include $_B['temp']->load('category_select_list') ?>
        <?php } } ?>      
<?php } ?>
<?php } } ?>
</select>
</div>
</div>
<?php } ?>
<div class="form-group">
<label class="control-label col-md-2" style="padding-top:0px; margin-top:0px"><?php echo lang('image_group');?></label>
<div class="col-md-8">
<div class="fileinput fileinput-new" data-provides="fileinput">
<p class="label2"><?php echo lang('title_img');?></p>
<div class="fileinput-new thumbnail" style="width:200px; height:150px;">
<img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="" />
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="width:200px; height:150px;"></div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new"><?php echo lang('select_img');?></span>
<span class="fileinput-exists"><?php echo lang('change_img');?></span>
<input type="file" name="avatar" />
</span>
<a href="javascript:void(0)" class="btn default fileinput-exists" data-dismiss="fileinput"><?php echo lang('remove_image');?></a>
</div>
</div>
<div class="fileinput fileinput-new" data-provides="fileinput">
<p class="label2"><?php echo lang('icon_img');?></p>
<div class="fileinput-new thumbnail" style="width:200px; height:150px;">
<img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="" />
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="width:200px; height:150px;"></div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new"><?php echo lang('select_img');?></span>
<span class="fileinput-exists"><?php echo lang('change_img');?></span>
<input type="file" name="icon" />
</span>
<a href="javascript:void(0)" class="btn default fileinput-exists" data-dismiss="fileinput"><?php echo lang('remove_image');?></a>
</div>
</div>
<div class="fileinput fileinput-new" data-provides="fileinput">
<p class="label2"><?php echo lang('bg_img');?></p>
<div class="fileinput-new thumbnail" style="width:200px; height:150px;">
<img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="" />
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="width:200px; height:150px;"></div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new"><?php echo lang('select_img');?></span>
<span class="fileinput-exists"><?php echo lang('change_img');?></span>
<input type="file" name="bg_image" />
</span>
<a href="javascript:void(0)" class="btn default fileinput-exists" data-dismiss="fileinput"><?php echo lang('remove_image');?></a>
</div>
</div>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('sort');?>:</label>
<div class="col-md-3">
<input type="text" data-title="<?php echo lang('sort_tooltips');?>" class="form-control tooltips" name="order_by" data-error="<?php echo lang('number_error');?>" placeholder="<?php echo lang('error_number_only');?>" value="" >
</div>
</div>

<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('show_home');?> </label>
<div class="col-md-3">
<select class="form-control" name="is_home" data-error="">
<option value="1" selected="selected"><?php echo lang('publuc');?></option>
<option value="0"><?php echo lang('private');?></option>
</select>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('so_luong_hien_thi');?> </label>
<div class="col-md-3">
<input type="text" class="form-control" name="limit" value="10">
</div>
</div>

<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('status');?><span class="required"> * </span> </label>
<div class="col-md-3">
<select class="form-control" name="status" data-error="">
<option value="1" selected="selected"><?php echo lang('publuc');?></option>
<option value="0"><?php echo lang('private');?></option>
</select>
</div>
</div>
<div class="clearfix"></div>
</div>
</div>
<!--category param end-->
<!--meta information-->
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
<label class="col-md-2 control-label"><?php echo lang('meta_title');?></label>
<div class="col-md-8">
<input type="text" class="form-control maxlength-handler" name="meta_title" maxlength="170" value="" placeholder="" data-error="<?php echo lang('meta_title');?>">
<span class="help-block"><?php echo lang('maxlength','170');?> </span>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('meta_keywords');?></label>
<div class="col-md-8">
<input id="meta_keywords" name="meta_keywords" maxlength="170" type="text" class="form-control tags" value=""/>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('meta_description');?></label>
<div class="col-md-8">
<textarea class="form-control maxlength-handler" rows="4" name="meta_description" maxlength="170"></textarea>
<span class="help-block"><?php echo lang('maxlength','170');?></span>
</div>
</div>
<div class="clearfix"></div>
</div>
</div>
<!--meta information end-->
</div>
</div>
</div>
</div>
</div>
<div class="portlet-title topline">
<div class="actions btn-set">
<a href="<?=$_B['home']?>/album-category" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('reset');?></button>
<button class="btn green continue" data-continue="category"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<button class="btn green continue" data-continue="categoryNew"><i class="fa fa-check-circle"></i> <?php echo lang('submit_cont_');?></button>
<button class="btn green continue" data-continue="categoryUpdate"><i class="fa fa-flag"></i> <?php echo lang('submit_cont_lang');?></button>
<input type="hidden" name="action" value="addCategory">
<input type="hidden" name="lang" value="<?=$dfLang?>">
<input type="hidden" name="continue" value="">
</div>
</div>
</div>
</form>
</div>
</div>
<!-- END PAGE CONTENT-->
<link href="<?=$_B['mod_theme']?>css/addCategory.css?rs=<?=$reload?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript"></script>
<script src="<?=$_B['mod_theme']?>js/album.js?rs=<?=$reload?>" type="text/javascript"></script>
<script src="<?=$_B['mod_theme']?>js/addCategory.js?rs=<?=$reload?>" type="text/javascript"></script>
<script>
jQuery(document).ready(function() {
addCategory.init();
});
</script>