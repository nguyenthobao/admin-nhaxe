<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/template/addSupport.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?=$_B['mod_theme']?>css/style.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
<div class="col-md-12"> 
<form class="form-horizontal form-row-seperated" action="" id="form_slide" enctype="multipart/form-data" method="POST" novalidate="novalidate">
<div class="portlet">
<div class="portlet-title">
<div class="caption">
<i class="icon-note"></i><?php echo lang('hotrotructuyen');?></div> 
<div class="actions btn-set">
<a href="/template-support-index-lang-<?=$_DATA['lang']?>" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('lammoi');?></button>
<button class="btn green continue" data-continue="slidelist"><i class="fa fa-check"></i> <?php echo lang('luu');?></button>
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
<?php if(is_array($_DATA['lang_tab'])) { foreach($_DATA['lang_tab'] as $k_lang => $v_lang) { ?>
<li <?php if($k_lang==$_DATA['lang']) { ?>class="active"<?php } ?> >
<a href="<?=$v_lang['url']?>" data-lang="<?=$k_lang?>"><?php echo lang('lang_'.$k_lang);?> </a>
</li>
<?php } } ?>
</ul>
</div>
<div class="tabbable">
<div class="tab-content no-space">
<div class="tab-pane active">
<div class="form-body">
<div class="portlet light bordered">
<div class="portlet-title">
<div class="caption">
<i class="icon-equalizer font-red-sunglo"></i>
<span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('hotrotructuyen');?></span>

</div>
<div class="tools">
<a href="javascript:;" class="collapse"></a>
</div>
</div>
<div class="portlet-body form form_support">

<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('name_block');?> <span class="required" aria-required="true">* </span></label>
<div class="col-md-4">
<input type="text" class="form-control" name="title" value="<?php if(isset($_DATA['item'])) { ?><?=$_DATA['item']['title']?><?php } ?>" data-error="Vui lòng nhập trường này" placeholder="Facebook">
</div>
</div>
<div class="divNick">
<?php if(isset($_DATA['item'])) { ?>
<?php if(is_array($_DATA['item']['data_custome'])) { foreach($_DATA['item']['data_custome'] as $k => $v) { ?>
<div class="form-group nick">
<label class="col-md-2 control-label"><?php if($k==0) { ?><?php echo lang('taikhoan');?><?php } ?><span class="required" aria-required="true">* </span></label>
<div class="col-md-3">
<input type="text" class="form-control" name="name" value="<?=$v['name']?>"  data-error="Vui lòng nhập trường này">
<small>* <?php echo lang('ten_nv');?></small>
</div>
<div class="col-md-3">
<input type="text" class="form-control" name="nick" value="<?=$v['nick']?>"  data-error="Vui lòng nhập trường này">
<small>* <?php echo lang('thongtin');?></small>
</div>
<div class="col-md-2">
<select name="type" class="form-control">
<option value="1" >Skype</option>
<option value="2" <?php if($v['type']==2) { ?>selected="selected"<?php } ?> >Yahoo</option>
<option value="3" <?php if($v['type']==3) { ?>selected="selected"<?php } ?>><?php echo lang('sdt');?></option>
</select>
<small>* <?php echo lang('thuoctinh');?></small>
</div>
<?php if(count($_DATA['item']['data_custome'])==1) { ?>
<a href="javascript:void(0)" class="btn green addNew">
      <span class="glyphicon glyphicon-plus"></span>
    </a>
    <?php } else { ?>
    	<?php if($k==count($_DATA['item']['data_custome'])-1) { ?>
    	<a href="javascript:void(0)" class="btn green addNew">
      <span class="glyphicon glyphicon-plus"></span>
    </a>
    <?php } else { ?>
    	<a href="javascript:void(0)" class="btn green removeNew">
      <span class="glyphicon glyphicon-minus"></span>
    </a>
    <?php } ?>
    <?php } ?>
</div>
<?php } } ?>
<?php } else { ?>
<div class="form-group nick">
<label class="col-md-2 control-label"><?php echo lang('taikhoan');?> <span class="required" aria-required="true">* </span></label>
<div class="col-md-3">
<input type="text" class="form-control" name="name" value=""  data-error="Vui lòng nhập trường này">
<small>* <?php echo lang('ten_nv');?></small>
</div>
<div class="col-md-3">
<input type="text" class="form-control" name="nick" value=""  data-error="Vui lòng nhập trường này">
<small>* <?php echo lang('thongtin');?></small>
</div>
<div class="col-md-2">
<select name="type" class="form-control">
<option value="1" selected="selected">Skype</option>
<!-- <option value="2">Yahoo</option> -->
<option value="3"><?php echo lang('sdt');?></option>
</select>
<small>* <?php echo lang('thuoctinh');?></small>
</div>
<a href="javascript:void(0)" class="btn green addNew">
      <span class="glyphicon glyphicon-plus"></span>
    </a>
</div>
<?php } ?>
</div>
<div class="form-group">
<label class="col-md-2 control-label">Vị trí <span class="required" aria-required="true">* </span></label>
<div class="col-md-4">
<select name="position" class="form-control">
<?php if(is_array($_DATA['position'])) { foreach($_DATA['position'] as $k => $v) { ?>
<option value="<?=$k?>" <?php if(isset($_DATA['item']) && $k==$_DATA['item']['position']) { ?>selected<?php } ?>><?=$v?></option>
<?php } } ?>
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
<input type="hidden" name="id" value="<?php if(isset($_DATA['item'])) { ?><?=$_DATA['item']['id']?><?php } ?>">
<div class="actions btn-set">
<a href="/template-support-index-lang-<?=$_DATA['lang']?>" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('lammoi');?></button>
<button class="btn green continue" data-continue="slidelist"><i class="fa fa-check"></i> <?php echo lang('luu');?></button>
</div>   
</div>
</div>
</form>
</div>
</div>
<script type="text/javascript" src="<?=$_B['mod_theme']?>js/addsupport.js"></script> 

