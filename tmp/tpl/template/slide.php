<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/template/slide.php 
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
<form class="form-horizontal form-row-seperated" action="" id="form_slide" class="form-horizontal" enctype="multipart/form-data" method="POST">
<div class="portlet">
<div class="portlet-title">
<div class="caption">
<?php if(isset($slide_edit['title'])) { ?>
<i class="icon-note"></i><?php echo lang('breadcrumb_edit_slide');?>
<?php } else { ?>
<i class="icon-note"></i><?php echo lang('breadcrumb_add_slide');?>
<?php } ?>
</div>
<div class="actions btn-set">
<a href="<?=$_B['home']?>/template-slidelist-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('reset');?></button>
<button class="btn green continue" data-continue="slidelist"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<button class="btn green continue" data-continue="slide"><i class="fa fa-check-circle"></i> <?php echo lang('submit_cont_');?></button>
<button class="btn green continue" data-continue="slide_lang"><i class="fa fa-flag"></i> <?php echo lang('submit_cont_lang');?></button>
<input type="hidden" name="action" value="addSlide">
<input type="hidden" name="lang" value="vi">
<input type="hidden" name="continue" value="">
<input type="hidden" name="issetLangDefault" <?php if(!empty($slide['id'])) { ?>value="exist"<?php } ?>>
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
<input type="hidden" value="<?=$_GET['id']?>" name="idslide" id="idslide"/>
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
<label class="col-md-2 control-label"><?php echo lang('title');?><span class="required">
* </span>
</label>
<div class="col-md-8 row_input_title">
<input type="text" class="form-control maxlength-handler" name="title" maxlength="225" value="<?php if(isset($slide_edit['title'])) { ?><?=$slide_edit['title']?><?php } ?>" placeholder="" data-error="<?php echo lang('title_error');?>">
<span class="help-block"><?php echo lang('maxlength','225');?></span>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('description');?></label>
<div class="col-md-8">
<textarea class="form-control " id="description" minlength="5" rows="6" name="description">
<?php if(isset($slide_edit['description'])) { ?><?=$slide_edit['description']?><?php } ?>
</textarea>
</div>
</div>

<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('sort');?></label>
<div class="col-md-4">
<input type="text" class="form-control" name="sort" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?php if(isset($slide_edit['sort'])) { ?><?=$slide_edit['sort']?><?php } ?>" />
</div>
</div>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('status');?></label>
<div class="col-md-4">
<select class="form-control" name="status" data-error="<?php echo lang('news_error');?>">
<option value="1" <?php if((isset($slide_edit['status'])&& $slide_edit['status']==1)||empty($_GET['id'])) { ?>selected="selected"<?php } ?> ><?php echo lang('is_show');?></option>
<option value="0" <?php if(isset($slide_edit['status']) && $slide_edit['status']==0) { ?>selected="selected"<?php } ?>><?php echo lang('is_hide');?></option>
</select>
</div>
</div>
<div class="form-group">
                                                <label class="control-label col-md-2"><?php echo lang('position_block');?><span class="required">
* </span></label>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="position" data-error="<?php echo lang('position_error');?>">
                                                    	<?php if(is_array($positions)) { foreach($positions as $k => $v) { ?>
                                                    		<option value="<?=$k?>" <?php if(isset($slide_edit['position']) && $slide_edit['position']==$k) { ?>selected="selected"  <?php } ?>><?=$v?></option>
                                                    	<?php } } ?>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('module_hienthi');?> </label>
<div class="col-md-8">
<div class="form-control height-auto thr-col">
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
<input type="text" class="form-control maxlength-handler" name="meta_title" maxlength="170" value="<?php if(isset($slide_edit['meta_title'])) { ?><?=$slide_edit['meta_title']?><?php } ?>" placeholder="" data-error="<?php echo lang('meta_title');?>">
<span class="help-block">
<?php echo lang('maxlength','170');?> </span>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('meta_keyword');?>  </label>
<div class="col-md-8">
<input id="meta_keywords" name="meta_keywords" type="text" class="form-control tags" value="<?php if(isset($slide_edit['meta_keywords'])) { ?><?=$slide_edit['meta_keywords']?><?php } ?>"/>
</div>												
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('meta_description');?> </label>
<div class="col-md-8">
<textarea class="form-control maxlength-handler" rows="4" name="meta_description" maxlength="500"><?php if(isset($slide_edit['meta_description'])) { ?><?=$slide_edit['meta_description']?><?php } ?></textarea>
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
<a href="<?=$_B['home']?>/template-slidelist-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('reset');?></button>
<button class="btn green continue" data-continue="slidelist"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<button class="btn green continue" data-continue="slide"><i class="fa fa-check-circle"></i> <?php echo lang('submit_cont_');?></button>
<button class="btn green continue" data-continue="slide_lang"><i class="fa fa-flag"></i> <?php echo lang('submit_cont_lang');?></button>
<input type="hidden" name="action" value="addSlide">
<input type="hidden" name="lang" value="vi">
<input type="hidden" name="continue" value="">
<input type="hidden" name="issetLangDefault" <?php if(!empty($slide['id'])) { ?>value="exist"<?php } ?>>
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

<script type="text/javascript" src="<?=$_B['mod_theme']?>js/slide.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
       FormSlide.init();
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
