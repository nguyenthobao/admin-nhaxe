<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/video/video.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/jquery-tags-input/jquery.tagsinput.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/typeahead/typeahead.css">
<link href="<?=$_B['mod_theme']?>css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-datetimepicker/css/datetimepicker.css"/>
<!-- BEGIN PAGE CONTENT-->
<div class="row">
<div class="col-md-12">
<form class="form-horizontal form-row-seperated" action="" id="form_category" class="form-horizontal" enctype="multipart/form-data" method="POST">
<div class="portlet">
<div class="portlet-title">
<div class="caption">
<i class="icon-note"></i><?=$_S['breadcrumb_page_vd']?>
</div>
<div class="actions btn-set">
<a href="<?=$_B['home']?>/video-videolist-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('reset');?></button>
<button class="btn green continue" id="btn_save" data-continue="videolist-lang-<?=$_GET['lang']?>"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<button class="btn green continue" data-continue="video"><i class="fa fa-check-circle"></i> <?php echo lang('submit_cont_');?></button>
<button class="btn green continue" data-continue="video_lang"><i class="fa fa-flag"></i> <?php echo lang('submit_cont_lang');?></button>
<input type="hidden" name="action" value="addvideo">
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
<input type="hidden" value="<?=$_GET['id']?>" name="idvideo" id="idvideo"/>
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
<?=$_L['Video_title']?><span class="required">
* </span>
</label>
<div class="col-md-8">
<input type="text" class="form-control maxlength-handler" id="seo_url" onkeyup="trim_name(this);" name="title" id="title" maxlength="60" value="<?php if(isset($cat['title'])) { ?><?=$cat['title']?><?php } ?>" placeholder=""  data-error="<?php echo lang('error_title');?>">
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
<label class="col-md-2 control-label"><?=$_L['Video_des']?>
</label>
<div class="col-md-8">
<textarea class="form-control maxlength-handler" rows="6" name="short" maxlength="500"><?php if(!empty($cat['short'])) { ?><?=$cat['short']?><?php } ?></textarea>
<span class="help-block"><?php echo lang('maxlength','500');?></span>
</div>
</div>

<?php if($category) { ?>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('categoryvd');?> <span class="required">
* </span>
</label>
<div class="col-md-8">
<div class="form-control height-auto">
<div class="scrollbar" id="style-scroll">
<div class="force-overflow">
<ul class="list-unstyled" id="list_category">
<li class="row_check_all">
<label><input id="checkboxAll" type="checkbox" value=""><?php echo lang('check_alldm');?> </label>
</li>
<?php if(is_array($category)) { foreach($category as $k => $v) { ?>

<?php $v['line'] = str_replace('-', '&nbsp;&nbsp;&nbsp;', $v['line']) ?>
<?php $str_id = '|'.$v['str_id'].$v['id'].'|' ?>
<li>
<label><?=$v['line']?><input class="checkboxes select_category" data-error-container="#editor2_error" type="checkbox" name="cat_name[]" value="<?php if(!empty($v['id'])) { ?> <?=$v['id']?> <?php } ?>" data-id="<?=$str_id?>" value="<?=$v['id']?>" <?php if(in_array($v['id'] , $cat['cat_id'])) { ?> checked <?php } ?>> -- <?=$v['title']?> </label> 

</li>

<?php } } ?>
</ul>
</div>
</div>
</div>
</div>
</div>
<?php } ?>

<div class="form-group">
<label class="col-md-2 control-label">
<?=$_L['Video_link']?><span class="required">
* </span>
</label>
<div class="col-md-8">
<input type="text" class="form-control maxlength-handler mrgb10" name="link_video" maxlength="200" value="<?php if(!empty($cat['link_video'])) { ?><?=$cat['link_video']?><?php } ?>" placeholder=""data-error="<?php echo lang('error_link');?>">
<span class="help-block"><?php echo lang('maxlength','200');?></span>
<span class="help-block"><?php echo lang('linkyou');?>: http://youtu.be/xbP7AlubtEo</span>
<a class="linkyou"><?php echo lang('hdclick');?></a>
</div>
</div>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('title_img');?> </label>
<div class="col-md-8">

<div class="fileinput <?php if(!empty($cat['img'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
<?php if(!empty($cat['img'])) { ?>
<input type="hidden" value="1" name="img_video"/>
<?php } ?>
<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
<img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
<img src="<?php if(isset($cat['img'])) { ?><?=$_B['upload_path']?><?=$cat['img']?><?php } else { ?><?=$_B['home_theme']?>assets/no_image.gif<?php } ?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" />
</div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new">
<?php echo lang('select_img');?> </span>
<span class="fileinput-exists">
<?php echo lang('change_img');?> </span>
<input type="file" name="img_video">
</span>
<a href="#" class="btn default fileinput-exists" data-dismiss="fileinput">
<?php echo lang('remove');?></a>
</div>
</div>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('video_content');?>:
</label>
<div class="col-md-10">
<textarea class="span12 ckeditor m-wrap" name="content" rows="6" data-error-container="#editor2_error"><?php if(!empty($cat['details'])) { ?><?=$cat['details']?><?php } ?></textarea>
<div id="editor2_error"></div>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('tags');?>  </label>
<div class="col-md-8">
<input id="tags" name="tags" type="text" class="form-control tags" value="<?php if(!empty($cat['tags'])) { ?><?=$cat['tags']?><?php } ?>"/>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('sort');?>:
</label>
<div class="col-md-2">
<input type="text" class="form-control" name="sort" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?php if(!empty($cat['sort'])) { ?><?=$cat['sort']?><?php } ?>" placeholder="<?php echo lang('inint');?>" >
</div>
</div>
<div class="form-group row-title-check">
<label class="col-md-2 control-label"><?php echo lang('video_vip');?> </label>
<div class="col-md-8">
<input type="checkbox" name="video_vip" <?php if(isset($cat['is_vip'])&&($cat['is_vip'] == 1)) { ?> checked <?php } ?>>
</div>
</div>
<div class="form-group row-title-check">
<label class="col-md-2 control-label"><?php echo lang('video_hot');?> </label>
<div class="col-md-8">
<input type="checkbox" name="video_hot" <?php if(isset($cat['is_hot'])&&($cat['is_hot'] == 1)) { ?> checked <?php } ?>>
</div>
</div>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('status');?>
</label>
<div class="col-md-2">
<select class="form-control" name="status" data-error="<?php echo lang('category_error');?>">
<?php if(empty($cat['id']) ) { ?>
<?php if($_B['user_perm']!='boss') { ?>
<?php } else { ?>
<option value="1" selected="selected"><?php echo lang('act');?></option>
<?php } ?>
<option value="0"><?php echo lang('none_act');?></option>
<?php } else { ?>
<?php if($_B['user_perm']!='boss') { ?>
<?php } else { ?>
<option value="1" <?php if((isset($_POST['status'])&& $_POST['status']==1)||empty($_GET['id'])) { ?>selected="selected"<?php } ?> ><?php echo lang('act');?></option>
<option value="0" <?php if(isset($_POST['status']) && $_POST['status']==0) { ?>selected="selected"<?php } ?>><?php echo lang('none_act');?></option>
<?php } ?>
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
<span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('video_lq');?></span>
<span class="caption-helper"><?php echo lang('videolq_information');?></span>
</div>
<div class="tools">
<a href="javascript:;" class="collapse"></a>
</div>
</div>

<div class="portlet-body form">
<div class="form-group">
<label class="col-md-2 control-label spanbold">
<?php echo lang('Video_lqdm');?>
<span class="required"></span>
</label>
<div class="col-md-8">
<div class="form-control height-auto">
<div class="force-over">
<ul class="list-unstyled">
<li class="row_check_all">
<label>

<input type="checkbox" <?php if(isset($cat['video_lqdm']) && $cat['video_lqdm'] == 1) { ?>checked<?php } elseif(isset($configNXT['related_cate']) && $configNXT['related_cate']['status']=='on') { ?>checked<?php } ?> name="video_lqdm">


</label>
</li>

</ul>
<label class="col-md-3 control-label"><?php echo lang('video_show');?></label>
<div class="col-md-3 margin-bt-10">
<select class="form-control" name="slvddm" data-error="">
<?php $temp = array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30') ?>
<option value="0"><?php echo lang('video_default');?></option>
<?php if(!empty($temp)) { ?>
<?php if(is_array($temp)) { foreach($temp as $k => $v) { ?>
<option value="<?=$v?>" <?php if((!empty($_GET['id'])) && $tempid == true) { ?> <?php if($cat['slvddm'] ==$v) { ?> selected="selected" <?php } ?><?php } elseif(isset($configNXT['related_cate']) && $configNXT['related_cate']['quantity']==$v) { ?>selected<?php } ?>><?=$v?></option>
<?php } } ?>
<?php } ?>
</select>
</div>
<label class="col-md-2 control-label"><?php echo lang('sort');?></label>
<div class="col-md-3 margin-bt-10">
<select class="form-control" name="sttvdm" data-error="">
<option value="1">1</option>
<option <?php if((!empty($_GET['id'])) && $tempid == true) { ?><?php if($cat['sttvdm']==2) { ?>selected="selected"<?php } ?> <?php } elseif(isset($configNXT['related_cate']) && $configNXT['related_cate']['order']==2) { ?>selected<?php } ?>value="2">2</option>
</select>
</div>
<label class="clearboth col-md-3 control-label "><?php echo lang('show');?></label>
<div class="col-md-3 margin-bt-10">
<select class="form-control" name="kieuhtdm" data-error="">
<option value="1"><?php echo lang('show_video');?></option>
<option value="2"<?php if((!empty($_GET['id'])) && $tempid == true) { ?> <?php if($cat['kieuhtdm'] ==2) { ?> selected="selected"<?php } ?><?php } elseif(isset($configNXT['related_cate']) && $configNXT['related_cate']['type']==2) { ?>selected<?php } ?>><?php echo lang('show_vd_slide');?></option>
</select>
</div>
<label class="col-md-2 control-label "><?php echo lang('sortvideo');?></label>
<div class="col-md-3 margin-bt-10">
<select class="form-control" name="kieusxdm" data-error="">
<option value="1"><?php echo lang('newvd');?></option>
<option value="2" <?php if((!empty($_GET['id'])) && $tempid == true) { ?><?php if($cat['kieusxdm'] ==2) { ?> selected="selected"<?php } ?><?php } elseif(isset($configNXT['related_cate']) && $configNXT['related_cate']['orderby']==2) { ?>selected<?php } ?>><?php echo lang('hotvd');?></option>
<option value="3" <?php if((!empty($_GET['id'])) && $tempid == true) { ?><?php if($cat['kieusxdm'] ==3) { ?> selected="selected"<?php } ?><?php } elseif(isset($configNXT['related_cate']) && $configNXT['related_cate']['orderby']==3) { ?>selected<?php } ?>><?php echo lang('randomvd');?></option>
</select>
</div>
</div>
</div>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label spanbold">
<?php echo lang('Video_lqtc');?>
<span class="required"></span>
</label>
<div class="col-md-8">
<div class="form-control height-auto">
<div class="force-over">
<ul class="list-unstyled">
<li class="row_check_all">
<label>


<input type="checkbox" <?php if(isset($cat['video_lqtc'])&&($cat['video_lqtc'] == 1)) { ?> checked <?php } elseif(isset($configNXT['related_related']) && $configNXT['related_related']['status']=='on') { ?>checked<?php } ?> name="video_lqtc">
</li>

</ul>
<label class="col-md-3 control-label"><?php echo lang('video_show');?></label>
<div class="col-md-3 margin-bt-10">
<select class="form-control" name="slvdtc" data-error="">
<option value="0"><?php echo lang('video_default');?></option>
<?php for($i=1 ; $i<30 ; $i++) { ?>
<option value="<?=$i?>" <?php if((!empty($_GET['id'])) && $tempid == true) { ?> <?php if($cat['slvdtc']==$i) { ?>selected="selected"<?php } ?> <?php } elseif(isset($configNXT['related_related']) && $configNXT['related_related']['quantity']==$i) { ?>selected<?php } ?>><?=$i?></option>
<?php }  ?>
</select>
</div>
<label class="col-md-2 control-label "><?php echo lang('sort');?></label>
<div class="col-md-3 margin-bt-10">
<select class="form-control" name="sttvtc" data-error="">
<option value="2" >2</option>
<option value="1" <?php if((!empty($_GET['id'])) && $tempid == true) { ?> <?php if($cat['sttvtc'] ==1) { ?> selected="selected"<?php } ?><?php } elseif(isset($configNXT['related_related']) && $configNXT['related_related']['order']==1) { ?>selected<?php } ?>>1</option>
</select>
</div>
<label class="clearboth col-md-3 control-label "><?php echo lang('show');?></label>
<div class="col-md-3 margin-bt-10 ">
<select class="form-control" name="kieuhttc" data-error="">
<option value="1"><?php echo lang('show_video');?></option>
<option value="2"<?php if((!empty($_GET['id'])) && $tempid == true) { ?> <?php if($cat['kieuhttc'] ==2) { ?> selected="selected"<?php } ?><?php } elseif(isset($configNXT['related_related']) && $configNXT['related_related']['type']==2) { ?>selected<?php } ?>><?php echo lang('show_vd_slide');?></option>
</select>
</div>
<label class="col-md-2 control-label "><?php echo lang('sortvideo');?></label>
<div class="col-md-3 margin-bt-10 ">
<select class="form-control" name="kieusxtc" data-error="">
<option value="1"><?php echo lang('newvd');?></option>
<option value="2" <?php if((!empty($_GET['id'])) && $tempid == true) { ?> <?php if($cat['kieusxtc'] ==2) { ?> selected="selected"<?php } ?><?php } elseif(isset($configNXT['related_related']) && $configNXT['related_related']['orderby']==2) { ?>selected<?php } ?>><?php echo lang('hotvd');?></option>
<option value="3" <?php if((!empty($_GET['id'])) && $tempid == true) { ?><?php if($cat['kieusxtc'] ==3) { ?> selected="selected"<?php } ?><?php } elseif(isset($configNXT['related_related']) && $configNXT['related_related']['orderby']==3) { ?>selected<?php } ?>><?php echo lang('randomvd');?></option>
</select>
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
<input type="text" class="form-control inputsearch" id="search" name="search" value="" placeholder="<?php echo lang('search_title');?>">
<input type="hidden" name="langsearch" id="langsearch" value="<?=$_GET['lang']?>">
<input type="hidden" id="idsearch" value="<?=$_GET['id']?>">
<a class="btn green btn_search" id="btn_search"><i class="fa fa-check" data-lang="<?=$_GET['lang']?>"></i> <?php echo lang('search');?></a>

</div>

<div>
<div class="scrollbar_1" id="style-scroll-1">
<div class="force-overflow-1">
<ul id="video_left">
<?php if(isset($related_video)) { ?>
<?php if(is_array($related_video['data'])) { foreach($related_video['data'] as $k => $v) { ?>
<?php if(isset($v)) { ?>
<li data-id=<?=$v['id']?> >
<span><img src="<?=$_B['upload_path']?><?=$v['img']?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" /></span>
<a href="javascript:void()"><?php if(isset($v['title'])) { ?><?=$v['title']?><?php } ?></a>
</li>
<?php } ?>
<?php } } ?>
<?php } ?>
<?php if(empty($related_video['data'])) { ?>
<label class="notvideo">Hiện chưa có video nào</label>
<?php } ?>


</ul>
</div>
<?php if(!empty($related_video['data'])) { ?>
<div id="more">
<span class="btn btn-xs grey-cascade"><?php echo lang('load_more');?> <i class="glyphicon glyphicon-refresh"></i></span>
</div>
<?php } ?>
</div>
</div>
</div>
<div class="col-width-4"><span class="glyphicon glyphicon-arrow-right"></span></div>
<div class="col-md-48 col_right">
<p><?php echo lang('related_list');?></p>
<div>
<div class="scrollbar_1" id="style-scroll-1">
<div class="force-overflow-1">
<ul id="video_right">

<?php if(isset($related_video_exist)) { ?>
<?php if(is_array($related_video_exist)) { foreach($related_video_exist as $k => $v) { ?>
<?php if(isset($v)) { ?>
<li data-id=<?=$v['id']?> >
<span><img src="<?=$_B['upload_path']?><?=$v['img']?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" /></span>
<a href="javascript:void()"><?php if(isset($v['title'])) { ?><?=$v['title']?><?php } ?></a>
<i class="cancel glyphicon glyphicon-trash font-red"></i>
<input class="related_video" type="hidden" name="related_id[]" value="<?=$v['id']?>">
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
<input type="text" class="form-control maxlength-handler" name="meta_title" maxlength="170" value="<?php if(!empty($cat['meta_title'])) { ?><?=$cat['meta_title']?><?php } ?>" placeholder="" data-error="<?php echo lang('meta_title');?>">
<span class="help-block">
<?php echo lang('maxlength','170');?> </span>
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
<div class="portlet light bordered">
<div class="portlet-title">
<div class="caption">
<i class="icon-equalizer font-red-sunglo"></i>
<span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('timeupload');?></span>
<span class="caption-helper"><?php echo lang('timeuploadinfo');?></span>
</div>
<div class="tools">
<a href="javascript:;" class="collapse"></a>
</div>
</div>
<div class="portlet-body form">
<div class="form-group">
<label class="col-md-2 control-label"><?=$_L['Video_clock']?></label>
<div class="col-md-4">
<div class="input-group date form_datetime">
<input type="text" size="16" readonly class="form-control" name="date_up" value="<?php if((!empty($_GET['id'])) && $tempid == true) { ?><?php if($cat['date_up'] != 0) { ?><?=$cat['date_up']?><?php } ?><?php } ?>">
<span class="input-group-btn">
<button class="btn default date-reset" type="button"><i class="fa fa-times"></i></button>
</span>
<span class="input-group-btn">
<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
</span>
</div>
<span class="help-block"><?php echo lang('sub_datetime_up');?></span>
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
<a href="<?=$_B['home']?>/video-videolist-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('reset');?></button>
<button class="btn green continue" id="btn_save" data-continue="videolist-lang-<?=$_GET['lang']?>"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<button class="btn green continue" data-continue="video"><i class="fa fa-check-circle"></i> <?php echo lang('submit_cont_');?></button>
<button class="btn green continue" data-continue="video_lang"><i class="fa fa-flag"></i> <?php echo lang('submit_cont_lang');?></button>
<input type="hidden" name="action" value="addvideo">
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
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script src="<?=$_B['mod_theme']?>js/video.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/ckeditor/ckeditor.js"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="<?=$_B['mod_theme']?>js/nbh_seo_rewrite.js"></script>
<script>
jQuery(document).ready(function() {
Video.init();
});
</script>
<script>
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