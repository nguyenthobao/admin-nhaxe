<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/information/informationbasic.php 
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
<form class="form-horizontal form-row-seperated" action="" id="form_informationbasic" class="form-horizontal" enctype="multipart/form-data" method="POST">
<div class="portlet">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-cog"></i><?php echo lang('breadcrumb_information');?>
</div>
<div class="actions btn-set">
<a href="<?=$_B['home']?>/information-informationbasic-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn green continue" data-continue="informationbasic"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<input type="hidden" name="action" value="addInformationBasic">
<input type="hidden" name="lang" value="">
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
 

<div class="tab-content no-space" id="information" data-lang="<?=$_GET['lang']?>">
<div class="tab-pane active" id="lang_<?=$get_lang?>">
<div class="form-body">
 


<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('name_business');?>: <span class="required">
*</span>
</label>
<div class="col-md-5 row_input_title">
<input type="text" class="form-control maxlength-handler" maxlength="100" name="business" data-error="<?php echo lang('name_business_error');?>" value="<?php if(isset($advertisers_edit['business'])) { ?><?=$advertisers_edit['business']?><?php } ?>">

</div>
</div>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('title_img');?> </label>
<div class="col-md-8">
<div class="fileinput <?php if(!empty($advertisers_edit['img'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
<?php if(!empty($advertisers_edit['img'])) { ?>
<input type="hidden" value="1" name="img_news"/>
<?php } ?>
<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
<img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
<img src="<?=$_B['upload_path']?><?=$advertisers_edit['img']?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" />
</div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new">
<?php echo lang('select_img');?> </span>
<span class="fileinput-exists">
<?php echo lang('change_img');?> </span>
<input type="file" name="img_news">
</span>
<a href="#" class="btn default fileinput-exists" data-dismiss="fileinput">
Xóa </a>
</div>
</div>	
</div>
</div>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('favicon');?> </label>
<div class="col-md-8">
<div class="fileinput <?php if(!empty($advertisers_edit['icon'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
<?php if(!empty($advertisers_edit['icon'])) { ?>
<input type="hidden" value="1" name="favicon_news"/>
<?php } ?>
<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
<img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px;height: 150px;">
<img src="<?php if(isset($advertisers_edit['icon'])) { ?><?=$_B['upload_path']?><?=$advertisers_edit['icon']?><?php } ?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" />
</div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new">
<?php echo lang('select_img');?> </span>
<span class="fileinput-exists">
<?php echo lang('change_img');?> </span>
<input type="file" name="favicon_news">
</span>
<a href="#" class="btn default fileinput-exists" data-dismiss="fileinput">
<?php echo lang('remove');?> </a>
</div>
</div>	
</div>
</div>

<div class="form-group get_id_province"<?php if(!empty($advertisers_edit['provinceid'])) { ?>key="<?=$advertisers_edit['provinceid']?>"<?php } else { ?>key="0"<?php } ?> >
<label class="control-label col-md-2"><?php echo lang('provinces');?><span class="required">*
</span>
</label>
<div class="col-md-3">
<select class="form-control" name="provinces" data-error="<?php echo lang('provinces_error');?>" id="provinces">
<option value="" ><?php echo lang('choose_provinces');?></option>
<?php if(isset($information)) { ?>
<?php if(is_array($information)) { foreach($information as $k => $v) { ?>
<option value="<?=$v['name']?>-<?=$v['provinceid']?>"<?php if($advertisers_edit['provinces'] == $v['name']) { ?>selected<?php } ?> data-id="<?=$v['provinceid']?>"> <?=$v['name']?></option>
<?php } } ?>
<?php } ?>
</select>
</div>
</div>
<div <?php if(empty($advertisers_edit['district'])) { ?>style ="display:none"<?php } else { ?>style =""<?php } ?>class="form-group get_id_district "  id="show_district" <?php if(!empty($advertisers_edit['districtid'])) { ?>key="<?=$advertisers_edit['districtid']?>"<?php } else { ?>key="0"<?php } ?>>
<label class="control-label col-md-2"><?php echo lang('districtid');?><span class="required">*
</span>
</label>
<div class="col-md-3" id="district">
<select class="form-control" name="districtid" data-error="<?php echo lang('contactinfo_error');?>" id="districtid">

<?php if(isset($advertisers_edit['district'])) { ?>
<option value="<?=$advertisers_edit['district']?>" ><?=$advertisers_edit['district']?></option>
<?php } else { ?>
<option value="0"><?php echo lang('districtid');?></option>
<?php } ?>

</select>
</div>
</div>


<div class="form-group wardid" id="show_wardid" <?php if(empty($advertisers_edit['ward'])) { ?>style ="display:none"<?php } else { ?>style =""<?php } ?>>
<label class="control-label col-md-2"><?php echo lang('wardid');?><span class="required">
</span>
</label>
<div class="col-md-3" id="wardid">
<select class="form-control" name="wardid" data-error="<?php echo lang('contactinfo_error');?>" >
<?php if(isset($advertisers_edit['ward'])) { ?>
<option value="<?=$advertisers_edit['ward']?>" ><?=$advertisers_edit['ward']?></option>
<?php } else { ?>
<option value="0"><?php echo lang('wardid');?></option>
<?php } ?>
</select>
</div>
</div>

<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('phone_number');?> <span class="required">*
</span>
</label>
<div class="col-md-3">
<input type="text" value="<?php if(isset($advertisers_edit['phone'])) { ?><?=$advertisers_edit['phone']?><?php } ?>" class="form-control" name="phone" data-error="<?php echo lang('phone_error');?>">

</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('address');?><span class="required">*
</span>
</label>
<div class="col-md-5">
<input type="text" value="<?php if(isset($advertisers_edit['address'])) { ?><?=$advertisers_edit['address']?><?php } ?>" class="form-control" name="address" data-error="<?php echo lang('address_error');?>" >
</div>
</div>

<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('email');?><span class="required">*
</span>
</label>
<div class="col-md-5">
<input type="text" value="<?php if(isset($advertisers_edit['email'])) { ?><?=$advertisers_edit['email']?><?php } ?>" class="form-control" name="email" data-error="<?php echo lang('email_error');?>" >
</div>
</div>	
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('user_name');?><span class="required">
</span>
</label>
<div class="col-md-5">
<input type="text" value="<?php if(isset($advertisers_edit['name'])) { ?><?=$advertisers_edit['name']?><?php } ?>" class="form-control" name="name" data-error="<?php echo lang('user_error');?>" >
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
<input type="text" class="form-control maxlength-handler" name="meta_title" maxlength="170" value="<?php if(isset($advertisers_edit['meta_title'])) { ?><?=$advertisers_edit['meta_title']?><?php } ?>" placeholder="" data-error="<?php echo lang('meta_title');?>">
<span class="help-block">
<?php echo lang('maxlength','170');?> </span>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('meta_keyword');?> </label>
<div class="col-md-8">
<input id="meta_keyword" name="meta_keyword" type="text" class="form-control tags" value="<?php if(isset($advertisers_edit['meta_keyword'])) { ?><?=$advertisers_edit['meta_keyword']?><?php } ?>"/>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('meta_description');?> </label>
<div class="col-md-8">
<textarea class="form-control maxlength-handler" rows="4" name="meta_description" maxlength="500"><?php if(isset($advertisers_edit['meta_description'])) { ?><?=$advertisers_edit['meta_description']?><?php } ?></textarea>
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
<a href="<?=$_B['home']?>/information-informationbasic-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn green continue" data-continue="informationbasic"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<input type="hidden" name="action" value="addInformationBasic">
<input type="hidden" name="lang" value="">
<input type="hidden" name="continue" value="">

</div>
</div>
</div>
</form>
</div>
</div>
<!-- END PAGE CONTENT-->

<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>

<script type="text/javascript" src="<?=$_B['mod_theme']?>js/informationbasic.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {    
       InformationBasic.init();
    });        
</script>

