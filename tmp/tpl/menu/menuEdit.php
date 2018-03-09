<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/menu/menuEdit.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<link href="<?=$_B['mod_theme']?>css/style.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
<div class="col-md-12">
<form class="form-horizontal form-row-seperated" action="/menu-menu-editToDb-lang-<?=$_DATA['lang']?>" id="form_menuabove" class="form-horizontal" method="POST" enctype="multipart/form-data">
<div class="portlet">
<div class="portlet-title">
<div class="caption">
<?php if(isset($info_data['id'])) { ?>
<i class="icon-note"></i><?php echo lang('breadcrumb_edit_menu');?>
<?php } else { ?>
<i class="icon-note"></i><?php echo lang('breadcrumb_new_menu');?> 
<?php } ?>
</div>
<div class="actions btn-set">
<a href="<?=$_DATA['link_back']?>" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn green continue-next chage-link" data-continue="menulisttop"><i class="fa fa-save"></i> Lưu và tiếp tục</button>
<button class="btn green continue chage-link" data-continue="menulisttop"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>

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
<?php if(is_array($_DATA['lang_tab'])) { foreach($_DATA['lang_tab'] as $k => $v) { ?>
<li <?php if($k==$_DATA['lang']) { ?>class="active"<?php } ?> >
<a href="/menu-menu-add-lang-<?=$k?>"  data-lang="<?=$k?>" data-exists="<?=$v['exist']?>"> <?php echo lang('lang_'.$k);?></a>
</li>
<?php } } ?>
</ul>
<div class="tab-content no-space" id="menutop">
<div class="tab-pane active">
<div class="form-body">
<div class="note note-warning">
<p class="block"><?php echo lang('select_lang','lang_'.$_DATA['lang']);?></p>
</div>
<div class="portlet light bordered">
<div class="portlet-title">
<div class="caption">
<i class="icon-equalizer font-red-sunglo"></i>
<span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('breadcrumb_information_base');?></span>
<span class="caption-helper"></span>
</div>

</div>
<div class="portlet-body form" >


<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('name');?>: <span class="required">* </span></label>
<div class="col-md-5">
<input type="text" class="form-control maxlength-handler" name="namemenu" maxlength="255" value="<?=$_DATA['content']['namemenu']?>" data-error="<?php echo lang('title_error_name');?>">
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label">SEO URL: <span class="required">* </span></label>
<div class="col-md-5">
<input type="text" class="form-control maxlength-handler" name="alias" maxlength="255" value="<?=$_DATA['content']['alias']?>" data-error="<?php echo lang('title_error_name');?>">
</div>
<?php if(isset($_DATA['id'])) { ?>
<div class="col-md-2">
<input type="checkbox" id="changeSEO" name="changeSEO" value="1">
<label for="changeSEO">Thay đổi SEO URL </label>
</div>
<?php } ?>
</div>


<div class="form-group">
<label class="col-md-2 control-label">Kiểu menu: <span class="required">* </span></label>
<div class="col-md-5">
<input type="radio" name="type" value="1" <?php if($_DATA['content']['type']==1) { ?>checked="checked"<?php } ?>> Menu trên
<input type="radio" name="type" value="2" <?php if($_DATA['content']['type']==2) { ?>checked="checked"<?php } ?>> Menu dưới
</div>
</div>

<div class="form-group">
<label class="col-md-2 control-label">Kiểu nội dung: <span class="required">* </span></label>
<div class="col-md-5">
<input type="radio" name="op" value="1" <?php if($_DATA['content']['direct_link']!='') { ?>checked="checked"<?php } ?>> Trang nội dung
<input type="radio" name="op" value="2" <?php if($_DATA['content']['link']!='') { ?>checked="checked"<?php } ?>> Link
</div>
</div>



<div class="form-group content" style="display:<?php if($_DATA['content']['direct_link']!='') { ?>block<?php } else { ?>none<?php } ?>;">
<label class="col-md-2 control-label">Trang nội dung: <span class="required">* </span>
</label>
<div class="col-md-5">
<select name = "linktoct" id="linktoct" class="form-control">
<?php if(is_array($_DATA['list_cat'])) { foreach($_DATA['list_cat'] as $k => $v) { ?>
<optgroup label="<?=$v['name']?>">
 <?php if($k!='basic') { ?>
<option value="<?=$k?>|||" <?php if(isset($_DATA['content']['direct_link_decode']) && $_DATA['content']['direct_link_decode']['mod']==$k && $_DATA['content']['direct_link_decode']['id']=='') { ?>selected<?php } ?> ><?=$v['name']?></option>
 <?php } ?>
<?php if(is_array($v['content'])) { foreach($v['content'] as $k_2 => $v_2) { ?>
<?php if($k!='basic') { ?>
<option value="<?=$v['mod']?>|<?=$v['page']?>|<?=$v['sub']?>|<?=$v_2['id']?>" <?php if(isset($_DATA['content']['direct_link_decode']) && $_DATA['content']['direct_link_decode']['mod']==$k && $_DATA['content']['direct_link_decode']['id']==$v_2['id']) { ?>selected<?php } ?>><?=$v_2['line']?><?=$v_2['title']?></option>
<?php } else { ?>
<?php $content=explode('|',$v_2['content']); ?>
<option data-basic="1" value="<?=$v_2['content']?>" <?php if(isset($_DATA['content']['direct_link_decode']) && $_DATA['content']['direct_link_decode']['mod']==$content['0'] && $_DATA['content']['direct_link_decode']['page']==$content['1'] && $_DATA['content']['direct_link_decode']['sub']==$content['2'] && $_DATA['content']['direct_link_decode']['id']==$content['3']) { ?>selected<?php } ?>><?=$v_2['title']?></option>
<?php } ?>
<?php } } ?>
</optgroup>
<?php } } ?>
</select>
</div>
</div>


<div class="form-group link" style="display:<?php if($_DATA['content']['link']!='') { ?>block<?php } else { ?>none<?php } ?>;">
<label class="col-md-2 control-label"><?php echo lang('linkto');?>: <span class="required">* </span></label>
<div class="col-md-5">
<input  id="cd-1" type="text" class="form-control" name="linkto" value="<?=$_DATA['content']['link']?>">
</div> 
</div>


<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('parentmenu');?>: <span class="required">
</span>
</label>
<div class="col-md-5 parentmenu">
<select class="form-control" name="parent_id" data-error="">
<option value="0" <?php if(isset($_DATA['content']) && $_DATA['content']['parent_id']==0) { ?>selected<?php } ?>>Không chọn</option>
<?php if(is_array($_DATA['menu'])) { foreach($_DATA['menu'] as $k => $v) { ?>
<option value="<?=$v['id']?>" <?php if(isset($_DATA['content']) && $_DATA['content']['parent_id']==$v['id']) { ?>selected<?php } ?>><?=$v['line']?> <?=$v['namemenu']?></option>
<?php } } ?>
</select>
</div>
</div>

<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('sort');?>: </label>
<div class="col-md-2">
<input type="number" class="form-control " name="sort" value="<?=$_DATA['content']['sort']?>">

</div>
</div>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('status');?></label>
<div class="col-md-2">
<select class="form-control" name="status" data-error="<?php echo lang('contactinfo_error');?>">
<option value="1" <?php if($_DATA['content']['status']==1) { ?>selected="selected"<?php } ?>><?php echo lang('active');?></option>
<option value="0"  <?php if($_DATA['content']['status']==0) { ?>selected="selected"<?php } ?>><?php echo lang('non_active');?></option>
</select>
</div>
</div>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('Nofollow');?> <span class="required">
 </span>
</label>
<div class="col-md-2">
<input type="checkbox" <?php if($_DATA['content']['nofollow']==1) { ?>checked<?php } ?> name="nofollow" value="1">
</div>
</div>


 	</div>
</div>
<div class="portlet light bordered">
<div class="portlet-title">
<div class="caption">
<i class="icon-equalizer font-red-sunglo"></i>
<span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('breadcrumb_img');?></span>
<span class="caption-helper">Phục vụ minh họa menu trên trang web. Chỉ xuất hiện nếu giao diện hỗ trợ.</span>
</div>

</div>
<div class="portlet-body form" >
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('img');?></label>
<div class="col-md-8">
<input id="menu_icon" name="menu_icon" type="file" multiple=false class="file-loading">
</div>
</div>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('img');?></label>
<div class="col-md-8">
<input id="menu_img" name="menu_img" type="file" multiple=false class="file-loading">
</div>
</div>
</div>
</div>

</div>
</div>
</div>
</div>
</div>
<input type="hidden" value="<?=$_DATA['id']?>" name="id_lang_default">
<div class="portlet-title topline">
<div class="actions btn-set">
<a href="<?=$_DATA['link_back']?>" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn green continue-next chage-link" data-continue="menulisttop"><i class="fa fa-save"></i> Lưu và tiếp tục</button>
<button class="btn green continue chage-link" data-continue="menulisttop"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>

</div>
</div>
</div>
</form>
</div>
</div>
<!-- END PAGE CONTENT-->
<script type="text/javascript">
var statics='<?=$_B['upload_path']?>';
var menu_img='<?=$_DATA['content']['img']?>';
var menu_icon='<?=$_DATA['content']['icon']?>';

</script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script src="<?=$_B['mod_theme']?>js/menu_add.js" type="text/javascript"></script>




