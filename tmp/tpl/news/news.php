<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/news/news.php 
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
<form class="form-horizontal form-row-seperated" action="" id="form_news" class="form-horizontal" enctype="multipart/form-data" method="POST">
<div class="portlet">
<div class="portlet-title">
<div class="caption col-md-4">
<?php if(isset($news_edit['title'])) { ?>
<i class="icon-note"></i><?php echo lang('breadcrumb_edit_news');?>
<?php } else { ?>
<i class="icon-note"></i><?php echo lang('breadcrumb_add_news');?>
<?php } ?>
</div>
<div class="actions btn-set">
<a href="<?=$_B['home']?>/news-newslist-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('reset');?></button>
<button class="btn green continue" data-continue="newslist"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<button class="btn green continue" data-continue="news"><i class="fa fa-check-circle"></i> <?php echo lang('submit_cont_');?></button>
<button class="btn green continue" data-continue="news_lang"><i class="fa fa-flag"></i> <?php echo lang('submit_cont_lang');?></button>
<input type="hidden" name="action" value="addNews">
<input type="hidden" name="lang" value="vi">
<input type="hidden" name="continue" value="">
<input type="hidden" name="issetLangDefault" <?php if(!empty($news['id'])) { ?>value="exist"<?php } ?>>
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
<input type="hidden" value="<?=$_GET['id']?>" name="idnews" id="idnews"/>
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
<input type="text" class="form-control maxlength-handler" id="seo_url" onkeyup="trim_name(this);" name="title" maxlength="225" value="<?php if(isset($news_edit['title'])) { ?><?=$news_edit['title']?><?php } ?>" placeholder="" data-error="<?php echo lang('title_error');?>">
<span class="help-block"><?php echo lang('maxlength','225');?></span>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label">SEO URL </label>
<div class="col-md-8">
<input class="form-control maxlength-handler" maxlength="225" <?php if(isset($news_edit['alias'])) { ?> value="<?=$news_edit['alias']?>" <?php } else { ?> value="" <?php } ?> name="alias" value="" id="seo_keyword" >
<span class="help-block"><?php echo lang('maxlength','225');?></span>

<script type="text/javascript">
 function trim_name(input_name){
  var txtname_trim=erase($("#seo_url").val());
  $("#seo_keyword").val(nbh_seo_write(txtname_trim));
 }
</script>
</div>
</div>
<?php if(isset($news_edit['title'])) { ?>
<div class="form-group">
<label class="col-md-2 control-label"></label>
<div class="col-md-8">
<label>
<input type="checkbox" name="is_save" >
<?php echo lang('noti_change');?>
</label>
<input type="hidden" name="title_alias" value="<?=$news_edit['alias']?>">
</div>
</div>
<?php } ?>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('description');?></label>
<div class="col-md-10">
<textarea class="form-control ckeditor span12" rows="6" name="description"><?php if(isset($news_edit['short'])) { ?><?=$news_edit['short']?><?php } ?></textarea>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('new_content');?></label>
<div class="col-md-10">
<textarea class="span12 ckeditor m-wrap" name="content" rows="6"><?php if(isset($news_edit['details'])) { ?><?=$news_edit['details']?><?php } ?></textarea>

</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('tags');?> </label>
<div class="col-md-8">
<input id="tags" name="tags" type="text" class="form-control tags" value="<?php if(isset($news_edit['tags'])) { ?><?=$news_edit['tags']?><?php } ?>"/>
</div>
</div>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('category');?> <span class="required">
* </span>
</label>										
<div class="col-md-8">
<div class="form-control height-auto">
<div class="scrollbar" id="style-scroll">
<div class="force-overflow">
<ul class="list-unstyled" id="list_category">
<li class="row_check_all">
<label><input id="checkboxAll" type="checkbox" value=""> <?php echo lang('check_all');?> </label>
</li>
<?php if(is_array($category)) { foreach($category as $k => $v) { ?>
<?php $v['line'] = str_replace('-', '&nbsp;&nbsp;&nbsp;', $v['line']) ?>
<?php $str_id = '|'.$v['str_id'].$v['id'].'|' ?>
<li>
<label><?=$v['line']?><input class="checkboxes select_category" data-error-container="#editor2_error" type="checkbox" name="cat_name[]" value="<?php if(!empty($v['id'])) { ?> <?=$v['id']?> <?php } ?>" data-id="<?=$str_id?>" value="<?=$v['id']?>" <?php if(in_array($v['id'] , $news_edit['cat_id'])) { ?> checked <?php } ?>> -- <?=$v['title']?> </label> 

</li>

<?php } } ?>
</ul>

</div>													
</div>
</div>											
</div>										
</div>									
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('title_img');?> </label>
<div class="col-md-8">
<div class="fileinput <?php if(!empty($news_edit['img'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
<?php if(!empty($news_edit['img'])) { ?>
<input type="hidden" value="1" name="img_news"/>
<?php } ?>
<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
<img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
<img src="<?php if(isset($news_edit['img'])) { ?><?=$_B['upload_path']?><?=$news_edit['img']?><?php } ?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" />
</div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new">
<?php echo lang('select_img');?> </span>
<span class="fileinput-exists">
<?php echo lang('change_img');?> </span>
<input type="file" name="img_news" id="img_news">
</span>
<a href="#" class="btn default fileinput-exists" data-dismiss="fileinput">
<?php echo lang('delete');?> </a>
</div>
</div>	
</div>
</div>
<div class="form-group row-title-check">
<label class="col-md-2 control-label"><?php echo lang('news_vip');?> </label>
<div class="col-md-8">
<input type="checkbox" name="news_vip" <?php if(isset($news_edit['is_vip'])&&($news_edit['is_vip'] == 1)) { ?> checked <?php } ?>>
</div>
</div>
<div class="form-group row-title-check">
<label class="col-md-2 control-label"><?php echo lang('news_hot');?> </label>
<div class="col-md-8">
<input type="checkbox" name="news_hot" <?php if(isset($news_edit['is_hot'])&&($news_edit['is_hot'] == 1)) { ?> checked <?php } ?>>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('source');?></label>
<div class="col-md-3">
<input type="text" class="form-control" name="news_source" data-error="<?php echo lang('number_error');?>" value="<?php if(isset($news_edit['news_source'])) { ?><?=$news_edit['news_source']?><?php } ?>" >
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('author');?></label>
<div class="col-md-3">
<input type="text" class="form-control" name="author" data-error="<?php echo lang('number_error');?>" value="<?php if(isset($news_edit['author'])) { ?><?=$news_edit['author']?><?php } ?>" >
</div>
</div>											
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('sort');?></label>
<div class="col-md-2">
<input type="text" class="form-control" name="sort" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?php if(isset($news_edit['sort'])) { ?><?=$news_edit['sort']?><?php } ?>" >
</div>
</div>


<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('status');?></label>
<div class="col-md-2">
<?php if($_B['user_perm']!='boss' && $_B['web']['idw']==4298) { ?>
<select class="form-control" name="status" data-error="<?php echo lang('news_error');?>">

<option value="0" <?php if(isset($news_edit['status']) && $news_edit['status']==0) { ?>selected="selected"<?php } ?>><?php echo lang('is_hide');?></option>

</select>
<?php } else { ?>
<select class="form-control" name="status" data-error="<?php echo lang('news_error');?>">
<option value="1" <?php if((isset($news_edit['status'])&& $news_edit['status']==1)||empty($_GET['id'])) { ?>selected="selected"<?php } ?> ><?php echo lang('is_show');?></option>
<option value="0" <?php if(isset($news_edit['status']) && $news_edit['status']==0) { ?>selected="selected"<?php } ?>><?php echo lang('is_hide');?></option>
<option value="" <?php if(isset($news_edit['status']) && $news_edit['status']==2) { ?>selected="selected"<?php } ?>><?php echo lang('time_up');?></option>
</select>
<?php } ?>
</div>
</div>

</div>
</div>

<div class="portlet light bordered">
<div class="portlet-title">
<div class="caption">
<i class="icon-equalizer font-red-sunglo"></i>
<span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('related_define');?></span>												
</div>
<div class="tools">
<a href="javascript:;" class="collapse"></a>
</div>
</div>
<div class="portlet-body form">
<div class="form-group">
<label class="col-md-2 control-label spanbold">
<?php echo lang('category_related');?>
<span class="required"></span>
</label>
<div class="col-md-8">
<div class="form-control height-auto">
<div class="force-over">
<ul class="list-unstyled">
<li class="row_check_all">
<label>
<input type="checkbox" name="chk_cat_related" <?php if(isset($news_edit['config_news_cat']['status'])&&($news_edit['config_news_cat']['status'] == 'on')) { ?> checked <?php } ?>>																
</label>
</li>												
</ul>
<div class="col-md-6">
<label class="col-md-6 margin-bt-10 control-label"><?php echo lang('show_quantity');?></label>
<div class="col-md-6 margin-bt-10">
<input type="text" class="form-control show_quantity" name="show_quantity" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?php if(isset($news_edit['config_news_cat']['show_quantity'])) { ?><?=$news_edit['config_news_cat']['show_quantity']?><?php } ?>">
</div>
<label class="col-md-6 margin-bt-10 control-label"><?php echo lang('show_type');?></label>
<div class="col-md-6 margin-bt-10">
<select class="form-control" name="show_type" data-error="">
<option value="list" <?php if((isset($news_edit['config_news_cat']['show_type'])&& $news_edit['config_news_cat']['show_type']=='list')||empty($_GET['id'])) { ?>selected="selected"<?php } ?> ><?php echo lang('show_list');?></option>
<option value="slide" <?php if(isset($news_edit['config_news_cat']['show_type']) && $news_edit['config_news_cat']['show_type']=='slide') { ?>selected="selected"<?php } ?>><?php echo lang('show_slide');?></option>
</select>
</div>
</div>
<div class="col-md-6">
<label class="col-md-6 margin-bt-10 control-label"><?php echo lang('sort');?></label>
<div class="col-md-6 margin-bt-10">
<select class="form-control" name="show_sort" data-error="">
<option value="1" <?php if((isset($news_edit['config_news_cat']['show_sort'])&& $news_edit['config_news_cat']['show_sort']==1)||empty($_GET['id'])) { ?>selected="selected"<?php } ?> >1</option>
<option value="2" <?php if(isset($news_edit['config_news_cat']['show_sort']) && $news_edit['config_news_cat']['show_sort']==2) { ?>selected="selected"<?php } ?>>2</option>

</select>
</div>														
<label class="col-md-6 margin-bt-10 control-label"><?php echo lang('show_news');?></label>
<div class="col-md-6 margin-bt-10">
<select class="form-control" name="show_news" data-error="">
<option value="tin_moi" <?php if((isset($news_edit['config_news_cat']['show_news'])&& $news_edit['config_news_cat']['show_news']=='tin_moi')||empty($_GET['id'])) { ?>selected="selected"<?php } ?> ><?php echo lang('news_new');?></option>
<option value="tin_noibat" <?php if(isset($news_edit['config_news_cat']['show_news']) && $news_edit['config_news_cat']['show_news']=='tin_noibat') { ?>selected="selected"<?php } ?>><?php echo lang('news_hot');?></option>
<option value="tin_ngaunhien" <?php if(isset($news_edit['config_news_cat']['show_news']) && $news_edit['config_news_cat']['show_news']=='tin_ngaunhien') { ?>selected="selected"<?php } ?>><?php echo lang('news_random');?></option>
</select>
</div>
</div>
</div>			
</div>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label spanbold">
<?php echo lang('option_related');?>
<span class="required"></span>
</label>
<div class="col-md-8">
<div class="form-control height-auto">
<div class="force-over">
<ul class="list-unstyled">
<li class="row_check_all">
<label>
<input type="checkbox" name="chk_news_related" <?php if(isset($news_edit['config_news_related']['status'])&&($news_edit['config_news_related']['status'] == 'on')) { ?> checked <?php } ?>>
</label>
</li>												
</ul>
<div class="col-md-6">
<label class="col-md-6 margin-bt-10 control-label"><?php echo lang('show_quantity');?></label>
<div class="col-md-6 margin-bt-10">
<input type="text" class="form-control show_quantity_1" name="show_quantity_1" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?php if(isset($news_edit['config_news_related']['show_quantity'])) { ?><?=$news_edit['config_news_related']['show_quantity']?><?php } ?>">
</div>
<label class="col-md-6 margin-bt-10 control-label"><?php echo lang('show_type');?></label>
<div class="col-md-6 margin-bt-10">
<select class="form-control" name="show_type_1" data-error="">
<option value="list" <?php if((isset($news_edit['config_news_related']['show_type'])&& $news_edit['config_news_related']['show_type']=='list')||empty($_GET['id'])) { ?>selected="selected"<?php } ?> ><?php echo lang('show_list');?></option>
<option value="slide" <?php if(isset($news_edit['config_news_related']['show_type']) && $news_edit['config_news_related']['show_type']=='slide') { ?>selected="selected"<?php } ?>><?php echo lang('show_slide');?></option>
</select>
</div>
</div>
<div class="col-md-6">
<label class="col-md-6 margin-bt-10 control-label"><?php echo lang('sort');?></label>
<div class="col-md-6 margin-bt-10">
<select class="form-control" name="show_sort_1" data-error="">
<option value="1" <?php if((isset($news_edit['config_news_related']['show_sort'])&& $news_edit['config_news_related']['show_sort']==1)||empty($_GET['id'])) { ?>selected="selected"<?php } ?> >1</option>
<option value="2" <?php if(isset($news_edit['config_news_related']['show_sort']) && $news_edit['config_news_related']['show_sort']==2) { ?>selected="selected"<?php } ?>>2</option>
</select>
</div>
<label class="col-md-6 margin-bt-10 control-label"><?php echo lang('show_news');?></label>
<div class="col-md-6 margin-bt-10">
<select class="form-control" name="show_news_1" data-error="">
<option value="tin_moi" <?php if((isset($news_edit['config_news_related']['show_news'])&& $news_edit['config_news_related']['show_news']=='tin_moi')||empty($_GET['id'])) { ?>selected="selected"<?php } ?> ><?php echo lang('news_new');?></option>
<option value="tin_noibat" <?php if(isset($news_edit['config_news_related']['show_news']) && $news_edit['config_news_related']['show_news']=='tin_noibat') { ?>selected="selected"<?php } ?>><?php echo lang('news_hot');?></option>
<option value="tin_ngaunhien" <?php if(isset($news_edit['config_news_related']['show_news']) && $news_edit['config_news_related']['show_news']=='tin_ngaunhien') { ?>selected="selected"<?php } ?>><?php echo lang('news_random');?></option>
</select>
</div>
</div>
</div>			
</div>
</div>
</div>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('related');?></label>
<div class="col-md-10">
<div class="related_form height-auto">
<div class="col-md-48 col_left">
<div class="cotsearch">
<input type="text" class="form-control inputsearch" id="search" name="search" value="" placeholder="<?php echo lang('search_title');?>" >
<input type="hidden" name="langsearch" id="langsearch" value="<?=$_GET['lang']?>">
<input type="hidden" id="idsearch" value="<?=$_GET['id']?>">
<a class="btn green btn_search" id="btn_search"><i class="fa fa-search" data-lang="<?=$_GET['lang']?>"></i> <?php echo lang('search');?></a>
</div>
<div>
<div class="scrollbar_1" id="style-scroll-1">
<div class="force-overflow-1">
<ul id="news_left">
<?php if(isset($related_news)) { ?>
<?php if(is_array($related_news['data'])) { foreach($related_news['data'] as $k => $v) { ?>
<?php if(isset($v)) { ?>
<li data-id=<?=$v['id']?> >
<span><img src="<?php if(isset($v['img'])) { ?><?=$_B['upload_path']?><?=$v['img']?><?php } ?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" /></span>
<a href="javascript:void()"><?php if(isset($v['title'])) { ?><?php echo cutString($v['title'],0,80); ?><?php } ?></a>
</li>
<?php } ?>
<?php } } ?>
<?php } ?>
</ul>
<?php if(!empty($related_news['data'])) { ?>
<div id="more">
<span class="btn btn-xs grey-cascade"><?php echo lang('load_more');?> <i class="glyphicon glyphicon-refresh"></i></span>
</div>
<?php } else { ?>
<div class="alert alert-warning">
<center> <?php echo lang('notData');?> </center>
</div>
<?php } ?>
</div>

</div>
</div>
</div>
<div class="col-width-4"><span class="glyphicon glyphicon-arrow-right"></span></div>
<div class="col-md-48 col_right">
<p><?php echo lang('related_list');?></p>
<div>														
<div class="scrollbar_1" id="style-scroll-1">
<div class="force-overflow-1">
<ul id="news_right">
<?php if(isset($related_news_exist)) { ?>
<?php if(is_array($related_news_exist)) { foreach($related_news_exist as $k => $v) { ?>
<?php if(isset($v)) { ?>
<li data-id=<?=$v['id']?> >
<span><img src="<?php if(isset($v['img'])) { ?><?=$_B['upload_path']?><?=$v['img']?><?php } ?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" /></span>
<a href="javascript:void()"><?php if(isset($v['title'])) { ?><?php echo cutString($v['title'],0,80); ?><?php } ?></a>
<i class="cancel glyphicon glyphicon-trash font-red"></i>
<input class="related_news" type="hidden" name="related_id[]" value="<?=$v['id']?>">
</li>
<?php } ?>
<?php } } ?>
<?php } ?>
</ul>
</div>
</div>														
</div>
<input type='hidden' id='related_select' name='related_select' value=''/>
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
<input type="text" class="form-control maxlength-handler" name="meta_title" maxlength="170" value="<?php if(isset($news_edit['meta_title'])) { ?><?=$news_edit['meta_title']?><?php } ?>" placeholder="" data-error="<?php echo lang('meta_title');?>">
<span class="help-block">
<?php echo lang('maxlength','170');?> </span>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('meta_keyword');?> </label>
<div class="col-md-8">
<input id="meta_keyword" name="meta_keyword" type="text" class="form-control tags" value="<?php if(isset($news_edit['meta_keyword'])) { ?><?=$news_edit['meta_keyword']?><?php } ?>"/>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('meta_description');?> </label>
<div class="col-md-8">
<textarea class="form-control maxlength-handler" rows="4" name="meta_description" maxlength="500"><?php if(isset($news_edit['meta_description'])) { ?><?=$news_edit['meta_description']?><?php } ?></textarea>
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
<input type="text" class="form-control" readonly name="time_up" value="<?php if(isset($news_edit['time_up'])) { ?><?=$news_edit['time_up']?><?php } ?>">
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
<a href="<?=$_B['home']?>/news-newslist-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('reset');?></button>
<button class="btn green continue" data-continue="newslist"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<button class="btn green continue" data-continue="news"><i class="fa fa-check-circle"></i> <?php echo lang('submit_cont_');?></button>
<button class="btn green continue" data-continue="news_lang"><i class="fa fa-flag"></i> <?php echo lang('submit_cont_lang');?></button>
<input type="hidden" name="action" value="addNews">
<input type="hidden" name="lang" value="vi">
<input type="hidden" name="continue" value="">
<input type="hidden" name="issetLangDefault" <?php if(!empty($news['id'])) { ?>value="exist"<?php } ?>>
</div>
</div>
</div>
</form>
</div>
</div>
<!-- END PAGE CONTENT-->

<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/scripts/metronic.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?=$_B['mod_theme']?>js/news.js"></script>
<script type="text/javascript" src="<?=$_B['mod_theme']?>js/nbh_seo_rewrite.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
       FormNews.init();
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
