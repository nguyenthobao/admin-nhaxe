<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/news/setting.php 
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
<input type="hidden" name="getLang" value="vi"/>
<div class="row row_setting">
<div class="tabbable">
<ul class="nav nav-tabs">
<?php if(is_array($url_lang)) { foreach($url_lang as $k_lang => $v_lang) { ?>
<li <?php if($k_lang==$_GET['lang']) { ?>class="active"<?php } ?>>
<a class="select_lang" href="<?=$v_lang['url']?>">
<?php echo lang('lang_'.$k_lang);?>
</a>
</li>
<?php } } ?>			
<input type="hidden" name="popup" data-title="<?php echo lang('pop_title');?>" data-yes="<?php echo lang('pop_yes');?>" data-cancel="<?php echo lang('pop_cancel');?>" data-message="<?php echo lang('pop_message');?>" data-close="<?php echo lang('pop_close');?>">
<input type="hidden" name="popup_df" data-title="<?php echo lang('pop_df_title');?>" data-yes="<?php echo lang('pop_yes');?>" data-cancel="<?php echo lang('pop_cancel');?>" data-message="<?php echo lang('pop_df_message');?>" data-close="<?php echo lang('pop_close');?>">		
<input type="hidden" value="" name="idlogo" id="idlogo"/>
</ul>
<div class="tab-content no-space">
<div class="tab-pane active" id="lang_<?=$v_lang?>">
<div class="form-body">
<div class="note note-warning">
<p class="block"><?php echo lang('select_lang','lang_'.$_GET['lang']);?></p>
</div>
<!-- <a class="btn btn-sm blue continue reset_setting"><i class="fa fa-reply"></i> <?php echo lang('back_default_setting');?></a> -->	
<form id="saveSettingNewsPage"  class="form-horizontal form-row-seperated" class="form-horizontal" enctype="multipart/form-data" method="POST">
<input type="hidden" class="view_lang" name="view_lang" value="<?=$_GET['lang']?>">
<div class="portlet">
<div class="portlet-body">
<div class="form-body">
<div class="portlet light bordered">
<div class="portlet-title">
<div class="caption">
<i class="icon-equalizer font-red-sunglo"></i>
<span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('setting_page_news');?></span>
<span class="caption-helper"><?php echo lang('noti_setting_page_news');?></span>
</div>
<div class="tools">
<a href="javascript:;" class="collapse"></a>
</div>
<div class="actions btn-save">
<button class="btn green continue" data-continue="saveSettingNewsPage"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<input type="hidden" name="action" value="saveSettingNewsPage">
<input type="hidden" name="lang" value="vi">
<input type="hidden" name="continue" value="">
</div>
</div>
<div class="portlet-body form">
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('title');?>: <span class="required">
* </span>
</label>
<div class="col-md-8 row_input_title">
<input type="text" class="form-control maxlength-handler" name="title" maxlength="225" value="<?php if(isset($settings['setting_page']['title'])) { ?><?=$settings['setting_page']['title']?><?php } ?>" placeholder="" data-error="<?php echo lang('title_error');?>">
<span class="help-block"><?php echo lang('maxlength','225');?></span>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('description');?></label>
<div class="col-md-8">
<textarea class="form-control " minlength="5" rows="6" name="description"><?php if(isset($settings['setting_page']['description'])) { ?><?=$settings['setting_page']['description']?><?php } ?></textarea>
</div>
</div>
<div class="form-group">
<div class="col-md-2">
<label class="control-label"><?php echo lang('setting_img');?></label>	
</div>
<div class="col-md-3">
<label class="control-label" style="margin-bottom: 5px;"><?php echo lang('title_img');?></label>
<div class="fileinput <?php if(!empty($settings['setting_page']['img'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
<?php if(isset($settings['setting_page']['img'])) { ?>
<input type="hidden" value="<?=$settings['setting_page']['img']?>" name="val_img_page"/>
<?php } ?>
<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
<img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
<img src="<?php if(isset($settings['setting_page']['img'])) { ?><?=$_B['upload_path']?><?=$settings['setting_page']['img']?><?php } ?>" alt="" />
</div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new">
<?php echo lang('select_img');?> </span>
<span class="fileinput-exists">
<?php echo lang('change_img');?> </span>
<input type="file" name="img_page_news">
</span>
<a href="#" class="del_img btn default fileinput-exists" data-dismiss="fileinput">
Remove </a>
</div>
</div>
</div>									
<div class="col-md-3">
<label class="control-label" style="margin-bottom: 5px;"><?php echo lang('icon_img');?></label>	
<div class="fileinput <?php if(!empty($settings['setting_page']['icon'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
<?php if(isset($settings['setting_page']['icon'])) { ?>
<input type="hidden" value="<?=$settings['setting_page']['icon']?>" name="val_icon_page"/>
<?php } ?>
<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
<img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
<img src="<?php if(isset($settings['setting_page']['icon'])) { ?><?=$_B['upload_path']?><?=$settings['setting_page']['icon']?><?php } ?>" alt="" />
</div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new">
<?php echo lang('select_img');?> </span>
<span class="fileinput-exists">
<?php echo lang('change_img');?> </span>
<input type="file" name="icon_page_news">
</span>
<a href="#" class="del_icon btn default fileinput-exists" data-dismiss="fileinput">
Remove </a>
</div>
</div>
</div>
<div class="col-md-3">
<label class="control-label" style="margin-bottom: 5px;"><?php echo lang('bg_img');?></label>
<div class="fileinput <?php if(!empty($settings['setting_page']['bg'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
<?php if(isset($settings['setting_page']['bg'])) { ?>
<input type="hidden" value="<?=$settings['setting_page']['bg']?>" name="val_bg_page"/>
<?php } ?>
<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
<img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
<img src="<?php if(isset($settings['setting_page']['bg'])) { ?><?=$_B['upload_path']?><?=$settings['setting_page']['bg']?><?php } ?>" alt="" />
</div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new">
<?php echo lang('select_img');?> </span>
<span class="fileinput-exists">
<?php echo lang('change_img');?> </span>
<input type="file" name="bg_page_news">
</span>
<a href="#" class="del_bg btn default fileinput-exists" data-dismiss="fileinput">
Remove </a>
</div>
</div>
</div>
</div>

<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('meta_title');?></label>
<div class="col-md-8">
<input type="text" class="form-control maxlength-handler" name="meta_title" maxlength="170" value="<?php if(isset($settings['setting_page']['meta_title'])) { ?><?=$settings['setting_page']['meta_title']?><?php } ?>" placeholder="" data-error="">
<span class="help-block">
<?php echo lang('maxlength','170');?></span>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('meta_keyword');?></label>
<div class="col-md-8">
<input id="meta_keyword" name="meta_keyword" type="text" class="form-control tags" value="<?php if(isset($settings['setting_page']['meta_keyword'])) { ?><?=$settings['setting_page']['meta_keyword']?><?php } ?>"/>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('meta_description');?></label>
<div class="col-md-8">
<textarea class="form-control maxlength-handler" rows="4" name="meta_description" maxlength="500"><?php if(isset($settings['setting_page']['meta_description'])) { ?><?=$settings['setting_page']['meta_description']?><?php } ?></textarea>
<span class="help-block">
<?php echo lang('maxlength','500');?> </span>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label">Số lượng hiển thị</label>
<div class="col-md-2">
<input type="text" class="form-control" name="quantity_news" value="<?php if(isset($settings['setting_page']['quantity_news'])) { ?><?=$settings['setting_page']['quantity_news']?><?php } ?>" placeholder="" data-error="">
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</form>
<form id="saveSettingNewsHome"  class="form-horizontal form-row-seperated" class="form-horizontal" enctype="multipart/form-data" method="POST">
<div class="portlet">
<div class="portlet-body">
<div class="form-body">
<div class="portlet light bordered">
<div class="portlet-title">
<div class="caption">
<i class="icon-equalizer font-red-sunglo"></i>
<span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('setting_tab_home');?></span>

</div>
<div class="tools">
<a href="javascript:;" class="collapse"></a>
</div>
<div class="actions btn-save">
<button class="btn green continue" data-continue="saveSettingNewsHome"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<input type="hidden" name="action" value="saveSettingNewsHome">
<input type="hidden" name="lang" value="vi">
<input type="hidden" name="continue" value="">
</div>
</div>
<div class="portlet-body form">
<div id="sortable">
<div class="form-group ui-state-default">
<label class="col-md-2 control-label" style="cursor:move"><?php echo lang('tintinmoi');?></label>
<div class="col-md-4">
<input type="text" class="form-control" name="title_new" value="<?php if(isset($settings['setting_home']['title_new'])) { ?><?=$settings['setting_home']['title_new']?><?php } ?>" placeholder="<?php echo lang('title_tab');?>" />
</div>
<div class="col-md-2">
<select class="form-control" name="status_new">
<option value="9" <?php if(isset($settings['setting_home']['status_new']) && $settings['setting_home']['status_new']==9) { ?>selected<?php } ?>><?php echo lang('status');?></option>
<option value="1" <?php if(isset($settings['setting_home']['status_new']) && $settings['setting_home']['status_new']==1) { ?>selected<?php } ?>><?php echo lang('is_show');?></option>
<option value="0" <?php if(isset($settings['setting_home']['status_new']) && $settings['setting_home']['status_new']==0) { ?>selected<?php } ?>><?php echo lang('is_hide');?></option>
</select>
</div>
<div class="col-md-2">
<input type="text" class="form-control" name="quantity_new"  value="<?php if(isset($settings['setting_home']['quantity_new'])) { ?><?=$settings['setting_home']['quantity_new']?><?php } ?>" placeholder="số lượng" />
</div>
</div>
<div class="form-group ui-state-default">
<label class="col-md-2 control-label" style="cursor:move"><?php echo lang('tintinnoibat');?></label>
<div class="col-md-4">
<input type="text" class="form-control" name="title_hot" value="<?php if(isset($settings['setting_home']['title_hot'])) { ?><?=$settings['setting_home']['title_hot']?><?php } ?>" placeholder="<?php echo lang('title_tab');?>" />
</div>
<div class="col-md-2">
<select class="form-control" name="status_hot">
<option value="9" <?php if(isset($settings['setting_home']['status_hot']) && $settings['setting_home']['status_hot']==9) { ?>selected<?php } ?>><?php echo lang('status');?></option>
<option value="1" <?php if(isset($settings['setting_home']['status_hot']) && $settings['setting_home']['status_hot']==1) { ?>selected<?php } ?>><?php echo lang('is_show');?></option>
<option value="0" <?php if(isset($settings['setting_home']['status_hot']) && $settings['setting_home']['status_hot']==0) { ?>selected<?php } ?>><?php echo lang('is_hide');?></option>
</select>
</div>
<div class="col-md-2">
<input type="text" class="form-control" name="quantity_hot" value="<?php if(isset($settings['setting_home']['quantity_hot'])) { ?><?=$settings['setting_home']['quantity_hot']?><?php } ?>" placeholder="số lượng" />
</div>
</div>
<div class="form-group ui-state-default">
<label class="col-md-2 control-label" style="cursor:move">Tin tức Vip</label>
<div class="col-md-4">
<input type="text" class="form-control" name="title_vip" value="<?php if(isset($settings['setting_home']['title_vip'])) { ?><?=$settings['setting_home']['title_vip']?><?php } ?>" placeholder="<?php echo lang('title_tab');?>" />
</div>
<div class="col-md-2">
<select class="form-control" name="status_vip">
<option value="9" <?php if(isset($settings['setting_home']['status_vip']) && $settings['setting_home']['status_vip']==9) { ?>selected<?php } ?>><?php echo lang('status');?></option>
<option value="1" <?php if(isset($settings['setting_home']['status_vip']) && $settings['setting_home']['status_vip']==1) { ?>selected<?php } ?>><?php echo lang('is_show');?></option>
<option value="0" <?php if(isset($settings['setting_home']['status_vip']) && $settings['setting_home']['status_vip']==0) { ?>selected<?php } ?>><?php echo lang('is_hide');?></option>
</select>
</div>
<div class="col-md-2">
<input type="text" class="form-control" name="quantity_vip" value="<?php if(isset($settings['setting_home']['quantity_vip'])) { ?><?=$settings['setting_home']['quantity_vip']?><?php } ?>" placeholder="số lượng" />
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</form>

<!--CAI DAT HIEN THI TIN TUC LIEN QUAN-->

<form class="form-horizontal form-row-seperated" action="" id="form_setting" class="form-horizontal" enctype="multipart/form-data" method="POST">
<div class="portlet">
<div class="portlet-body">
<div class="form-body">
<div class="portlet light bordered">
<div class="portlet-title">
<div class="caption">
<i class="icon-equalizer font-red-sunglo"></i>
<span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('setting_news');?></span>
</div>
<div class="tools">
<a href="javascript:;" class="collapse"></a>
</div>
<div class="actions btn-save">
<button class="btn green continue" data-continue="setting"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>								
<input type="hidden" name="action" value="addSetting">
<input type="hidden" name="lang" value="vi">
<input type="hidden" name="continue" value="">
</div>
</div>
<div class="portlet-body form">
<div class="form-group">
<div class="form-control height-auto row-setting">
<div class="force-over">
<ul class="list-unstyled">
<li class="row_check_all">
<label class="lbl_active">
<input type="checkbox" name="setting[news_related][status]" <?php if(isset($settings['news_relateds']['news_related']['status'])&&($settings['news_relateds']['news_related']['status'] == 'on')) { ?> checked <?php } ?>>
<?php echo lang('news_option_show');?>
</label>
</li>
</ul>
<label class="col-md-label margin-bt-10 control-label"><?php echo lang('show_quantity');?></label>
<div class="col-md-1 margin-bt-10">
<input type="text" class="form-control show_quantity" name="setting[news_related][quantity]" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?php if(isset($settings['news_relateds']['news_related']['quantity'])) { ?><?=$settings['news_relateds']['news_related']['quantity']?><?php } ?>">
</div>	
<label class="col-md-label margin-bt-10 control-label"><?php echo lang('sort');?></label>
<div class="col-md-1 margin-bt-10">												
<input type="text" class="form-control show_quantity" name="setting[news_related][sort]" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?php if(isset($settings['news_relateds']['news_related']['sort'])) { ?><?=$settings['news_relateds']['news_related']['sort']?><?php } ?>">
</div>
<label class="col-md-2 margin-bt-10 control-label"><?php echo lang('show_type');?></label>
<div class="col-md-2 margin-bt-10">
<select class="form-control" name="setting[news_related][show_type]" data-error="">
<option value="list" <?php if((isset($settings['news_relateds']['news_related']['show_type'])&& $settings['news_relateds']['news_related']['show_type']=='list')||empty($_GET['id'])) { ?>selected="selected"<?php } ?> ><?php echo lang('show_list');?></option>
<option value="slide" <?php if(isset($settings['news_relateds']['news_related']['show_type']) && $settings['news_relateds']['news_related']['show_type']=='slide') { ?>selected="selected"<?php } ?>><?php echo lang('show_slide');?></option>
</select>
</div>
<label class="col-md-2 margin-bt-10 control-label"><?php echo lang('show_news');?></label>
<div class="col-md-2 margin-bt-10">
<select class="form-control" name="setting[news_related][show_news]" data-error="">
<option value="tin_moi" <?php if((isset($settings['news_relateds']['news_related']['show_news'])&& $settings['news_relateds']['news_related']['show_news']=='tin_moi')||empty($_GET['id'])) { ?>selected="selected"<?php } ?> ><?php echo lang('news_new');?></option>
<option value="tin_noibat" <?php if(isset($settings['news_relateds']['news_related']['show_news']) && $settings['news_relateds']['news_related']['show_news']=='tin_noibat') { ?>selected="selected"<?php } ?>><?php echo lang('news_hot');?></option>
<option value="tin_ngaunhien" <?php if(isset($settings['news_relateds']['news_related']['show_news']) && $settings['news_relateds']['news_related']['show_news']=='tin_ngaunhien') { ?>selected="selected"<?php } ?>><?php echo lang('news_random');?></option>
</select>
</div>
</div>			
</div>
</div>
<div class="form-group">
<div class="form-control height-auto row-setting">
<div class="force-over">
<ul class="list-unstyled">
<li class="row_check_all">
<label class="lbl_active">
<input type="checkbox" name="setting[news_cate][status]" <?php if(isset($settings['news_relateds']['news_cate']['status'])&&($settings['news_relateds']['news_cate']['status'] == 'on')) { ?> checked <?php } ?>>
<?php echo lang('news_category_show');?>
</label>
</li>												
</ul>
<label class="col-md-label margin-bt-10 control-label"><?php echo lang('show_quantity');?></label>
<div class="col-md-1 margin-bt-10">
<input type="text" class="form-control show_quantity" name="setting[news_cate][quantity]" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?php if(isset($settings['news_relateds']['news_cate']['quantity'])) { ?><?=$settings['news_relateds']['news_cate']['quantity']?><?php } ?>">
</div>
<label class="col-md-label margin-bt-10 control-label"><?php echo lang('sort');?></label>
<div class="col-md-1 margin-bt-10">
<input type="text" class="form-control show_quantity" name="setting[news_cate][sort]" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?php if(isset($settings['news_relateds']['news_cate']['sort'])) { ?><?=$settings['news_relateds']['news_cate']['sort']?><?php } ?>">
</div>
<label class="col-md-2 margin-bt-10 control-label"><?php echo lang('show_type');?></label>
<div class="col-md-2 margin-bt-10">
<select class="form-control" name="setting[news_cate][show_type]" data-error="">
<option value="list" <?php if((isset($settings['news_relateds']['news_cate']['show_type'])&& $settings['news_relateds']['news_cate']['show_type']=='list')||empty($_GET['id'])) { ?>selected="selected"<?php } ?> ><?php echo lang('show_list');?></option>
<option value="slide" <?php if(isset($settings['news_relateds']['news_cate']['show_type']) && $settings['news_relateds']['news_cate']['show_type']=='slide') { ?>selected="selected"<?php } ?>><?php echo lang('show_slide');?></option>
</select>
</div>
<label class="col-md-2 margin-bt-10 control-label"><?php echo lang('show_news');?></label>
<div class="col-md-2 margin-bt-10">
<select class="form-control" name="setting[news_cate][show_news]" data-error="">
<option value="tin_moi" <?php if((isset($settings['news_relateds']['news_cate']['show_news'])&& $settings['news_relateds']['news_cate']['show_news']=='tin_moi')||empty($_GET['id'])) { ?>selected="selected"<?php } ?> ><?php echo lang('news_new');?></option>
<option value="tin_noibat" <?php if(isset($settings['news_relateds']['news_cate']['show_news']) && $settings['news_relateds']['news_cate']['show_news']=='tin_noibat') { ?>selected="selected"<?php } ?>><?php echo lang('news_hot');?></option>
<option value="tin_ngaunhien" <?php if(isset($settings['news_relateds']['news_cate']['show_news']) && $settings['news_relateds']['news_cate']['show_news']=='tin_ngaunhien') { ?>selected="selected"<?php } ?>><?php echo lang('news_random');?></option>
</select>
</div>
</div>			
</div>
</div>
<div class="form-group">
<div class="form-control height-auto row-setting">
<div class="force-over">
<ul class="list-unstyled">
<li class="row_check_all">
<label class="lbl_active">
<input type="checkbox" name="setting[news_latest][status]" <?php if(isset($settings['news_relateds']['news_latest']['status'])&&($settings['news_relateds']['news_latest']['status'] == 'on')) { ?> checked <?php } ?>>
<?php echo lang('news_best_show');?>
</label>
</li>												
</ul>
<label class="col-md-label margin-bt-10 control-label"><?php echo lang('show_quantity');?></label>
<div class="col-md-1 margin-bt-10">
<input type="text" class="form-control show_quantity" name="setting[news_latest][quantity]" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?php if(isset($settings['news_relateds']['news_latest']['quantity'])) { ?><?=$settings['news_relateds']['news_latest']['quantity']?><?php } ?>">
</div>
<label class="col-md-label margin-bt-10 control-label"><?php echo lang('sort');?></label>
<div class="col-md-1 margin-bt-10">
<input type="text" class="form-control show_quantity" name="setting[news_latest][sort]" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?php if(isset($settings['news_relateds']['news_latest']['sort'])) { ?><?=$settings['news_relateds']['news_latest']['sort']?><?php } ?>">
</div>
<label class="col-md-2 margin-bt-10 control-label"><?php echo lang('show_type');?></label>
<div class="col-md-3 margin-bt-10">
<select class="form-control" name="setting[news_latest][show_type]" data-error="">
<option value="list" <?php if((isset($settings['news_relateds']['news_latest']['show_type'])&& $settings['news_relateds']['news_latest']['show_type']=='list')||empty($_GET['id'])) { ?>selected="selected"<?php } ?> ><?php echo lang('show_list');?></option>
<option value="slide" <?php if(isset($settings['news_relateds']['news_latest']['show_type']) && $settings['news_relateds']['news_latest']['show_type']=='slide') { ?>selected="selected"<?php } ?>><?php echo lang('show_slide');?></option>
</select>
</div>
</div>			
</div>
</div>
<div class="form-group">
<div class="form-control height-auto row-setting">
<div class="force-over">
<ul class="list-unstyled">
<li class="row_check_all">
<label class="lbl_active">
<input type="checkbox" name="setting[news_newer][status]" <?php if(isset($settings['news_relateds']['news_newer']['status'])&&($settings['news_relateds']['news_newer']['status'] == 'on')) { ?> checked <?php } ?>>
<?php echo lang('news_new_show');?>
</label>
</li>												
</ul>
<label class="col-md-label margin-bt-10 control-label"><?php echo lang('show_quantity');?></label>
<div class="col-md-1 margin-bt-10">
<input type="text" class="form-control show_quantity" name="setting[news_newer][quantity]" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?php if(isset($settings['news_relateds']['news_newer']['quantity'])) { ?><?=$settings['news_relateds']['news_newer']['quantity']?><?php } ?>">
</div>
<label class="col-md-label margin-bt-10 control-label"><?php echo lang('sort');?></label>
<div class="col-md-1 margin-bt-10">
<input type="text" class="form-control show_quantity" name="setting[news_newer][sort]" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?php if(isset($settings['news_relateds']['news_newer']['sort'])) { ?><?=$settings['news_relateds']['news_newer']['sort']?><?php } ?>">
</div>
<label class="col-md-2 margin-bt-10 control-label"><?php echo lang('show_type');?></label>
<div class="col-md-3 margin-bt-10">
<select class="form-control" name="setting[news_newer][show_type]" data-error="">
<option value="list" <?php if((isset($settings['news_relateds']['news_newer']['show_type'])&& $settings['news_relateds']['news_newer']['show_type']=='list')||empty($_GET['id'])) { ?>selected="selected"<?php } ?> ><?php echo lang('show_list');?></option>
<option value="slide" <?php if(isset($settings['news_relateds']['news_newer']['show_type']) && $settings['news_relateds']['news_newer']['show_type']=='slide') { ?>selected="selected"<?php } ?>><?php echo lang('show_slide');?></option>
</select>
</div>
</div>
</div>
</div>
<div class="form-group">
<div class="form-control height-auto row-setting">
<div class="force-over">
<ul class="list-unstyled">
<li class="row_check_all">
<label class="lbl_active">
<input type="checkbox" name="setting[news_old][status]" <?php if(isset($settings['news_relateds']['news_old']['status'])&&($settings['news_relateds']['news_old']['status'] == 'on')) { ?> checked <?php } ?>>
<?php echo lang('news_old_show');?>
</label>

</li>												
</ul>
<label class="col-md-label margin-bt-10 control-label"><?php echo lang('show_quantity');?></label>
<div class="col-md-1 margin-bt-10">
<input type="text" class="form-control show_quantity" name="setting[news_old][quantity]" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?php if(isset($settings['news_relateds']['news_old']['quantity'])) { ?><?=$settings['news_relateds']['news_old']['quantity']?><?php } ?>">
</div>
<label class="col-md-label margin-bt-10 control-label"><?php echo lang('sort');?></label>
<div class="col-md-1 margin-bt-10">
<input type="text" class="form-control show_quantity" name="setting[news_old][sort]" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?php if(isset($settings['news_relateds']['news_old']['sort'])) { ?><?=$settings['news_relateds']['news_old']['sort']?><?php } ?>">
</div>
<label class="col-md-2 margin-bt-10 control-label"><?php echo lang('show_type');?></label>
<div class="col-md-3 margin-bt-10">
<select class="form-control" name="setting[news_old][show_type]" data-error="">
<option value="list" <?php if((isset($settings['news_relateds']['news_old']['show_type'])&& $settings['news_relateds']['news_old']['show_type']=='list')||empty($_GET['id'])) { ?>selected="selected"<?php } ?> ><?php echo lang('show_list');?></option>
<option value="slide" <?php if(isset($settings['news_relateds']['news_old']['show_type']) && $settings['news_relateds']['news_old']['show_type']=='slide') { ?>selected="selected"<?php } ?>><?php echo lang('show_slide');?></option>
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
</form>

<!--CAI DAT HIEN THI TIN TUC LIEN QUAN-->

</div>
</div>
</div>
</div>
</div>

<!-- END PAGE CONTENT-->
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/scripts/metronic.js"></script>
<script type="text/javascript" src="<?=$_B['mod_theme']?>js/setting.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
       FormSetting.init();
    });
</script>
