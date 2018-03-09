<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/template/template.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/inputs-ext/address/address.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css"/>

<!-- BEGIN PAGE CONTENT-->
<div class="row">
<div class="col-md-12">

<div class="portlet">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-navicon"></i><?php echo lang('title_setting_basic');?>
</div>					
</div>
<div class="portlet box box-template">					
<div class="portlet-title">
<ul class="nav nav-tabs tabs-template">					
<li class="active">
<a href="#tab_2" data-toggle="tab"><?php echo lang('logo');?></a>
</li>
<li class="">
<a href="#tab_3" data-toggle="tab"><?php echo lang('background_page');?></a>
</li>							
<li class="">
<a href="#tab_4" data-toggle="tab"><?php echo lang('sound_page');?></a>
</li>						
<li class="">
<a href="#tab_5" data-toggle="tab">Giao diện</a>
</li>
 
</ul>
</div>
<div class="portlet-body util-btn-margin-bottom-5">
<div class="tab-content">

<div class="tab-pane active" id="tab_2">
<div class="clearfix">
<form class="form-horizontal form-row-seperated" action="" id="form_logo" class="form-horizontal" enctype="multipart/form-data" method="POST" data-lang="<?=$_GET['lang']?>">
<div class="tabbable">
<ul class="nav nav-tabs">
 		
<input type="hidden" name="popup" data-title="<?php echo lang('pop_title');?>" data-yes="<?php echo lang('pop_yes');?>" data-cancel="<?php echo lang('pop_cancel');?>" data-message="<?php echo lang('pop_message');?>" data-close="<?php echo lang('pop_close');?>">
<input type="hidden" name="popup_df" data-title="<?php echo lang('pop_df_title');?>" data-yes="<?php echo lang('pop_yes');?>" data-cancel="<?php echo lang('pop_cancel');?>" data-message="<?php echo lang('pop_df_message');?>" data-close="<?php echo lang('pop_close');?>">		
<input type="hidden" value="<?php if(isset($logo_edit['id'])) { ?><?=$logo_edit['id']?><?php } ?>" name="idlogo" id="idlogo"/>
</ul>
<div class="tab-content no-space">
<div class="tab-pane active" id="lang_<?=$v_lang?>">
<div class="form-body">
 
<div class="form-group row-title-check">
<label class="col-md-2 control-label"><?php echo lang('display_logo');?> </label>
<div class="col-md-8">
<input type="checkbox" name="display_logo" <?php if(isset($logo_edit['status'])&&($logo_edit['status'] == 1)) { ?> checked <?php } ?> />
</div>
</div>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('logo');?> </label>							
<div class="col-md-8">
<div class="fileinput <?php if(!empty($logo_edit['img'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
<?php if(!empty($logo_edit['img'])) { ?>
<input type="hidden" value="1" name="img_logo"/>
<input type="hidden" value="<?php if(isset($logo_edit['img'])) { ?><?=$_B['upload_path']?><?=$logo_edit['img']?><?php } ?>" name="type_logo" id="type_logo" />
<div class="flash-preview">
<object width="<?php if(!empty($logo_edit['width'])) { ?><?=$logo_edit['width']?><?php } ?>" height="<?php if(!empty($logo_edit['height'])) { ?><?=$logo_edit['height']?><?php } ?>">
<param value="transparent" name="wmode">
<param value="<?=$_B['upload_path']?><?=$logo_edit['img']?>" name="movie">
<embed width="<?php if(!empty($logo_edit['width'])) { ?><?=$logo_edit['width']?><?php } ?>" height="<?php if(!empty($logo_edit['height'])) { ?><?=$logo_edit['height']?><?php } ?>" wmode="transparent" src="<?=$_B['upload_path']?><?=$logo_edit['img']?>">
                    	</object>
                	</div>
<?php } ?>
<div class="fileinput-new thumbnail" style="width: <?php if(!empty($logo_edit['width'])) { ?><?=$logo_edit['width']?><?php } ?>px; height: <?php if(!empty($logo_edit['height'])) { ?><?=$logo_edit['height']?><?php } ?>px;">
<img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="width: <?php if(!empty($logo_edit['width'])) { ?><?=$logo_edit['width']?><?php } ?>px; height: <?php if(!empty($logo_edit['height'])) { ?><?=$logo_edit['height']?><?php } ?>px;">
<img src="<?php if(!empty($logo_edit['img'])) { ?><?=$_B['upload_path']?><?=$logo_edit['img']?><?php } ?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'"  style="width: <?php if(!empty($logo_edit['width'])) { ?><?=$logo_edit['width']?><?php } ?>px; height: <?php if(!empty($logo_edit['height'])) { ?><?=$logo_edit['height']?><?php } ?>px;" alt="" />
</div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new">
<?php echo lang('select_logo');?> </span>
<span class="fileinput-exists">
<?php echo lang('change_logo');?> </span>
<input type="file" name="img_logo" id="img_logo">
</span>

</div>
</div>

</div>
</div>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('size_logo');?> </label>
<div class="col-md-9">											
<label class="col-md-2 padding-label control-label"><?php echo lang('width_logo');?></label>
<label class="col-md-55 col-vide-text">X</label>
<label class="col-md-22 padding-label control-label"><?php echo lang('height_logo');?></label>
<div class="col-md-2 padding-label">
<input type="text" class="form-control width_logo form-filter" name="width_logo" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?php if(isset($logo_edit['width'])) { ?><?=$logo_edit['width']?><?php } ?>">
</div>
<label class="col-md-55 col-vide-text">X</label>
<div class="col-md-2 padding-col-height">
<input type="text" class="form-control height_logo form-filter" name="height_logo" onkeypress='validate(event)' data-error="<?php echo lang('number_error');?>" value="<?php if(isset($logo_edit['height'])) { ?><?=$logo_edit['height']?><?php } ?>">
</div>
<label class="col-md-3 margin-bt-10 control-label">(<?php echo lang('label_size');?>)</label>
</div>
</div>					
<div class="btn_topline">
<a class="btn btn-sm red continue delete_logo_select"><i class="fa fa-trash-o"></i> <?php echo lang('del_logo');?></a>
<div class="btn_actions">
<button class="btn green continue" data-continue="template"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
</div>
<input type="hidden" name="action" value="addLogo">

<input type="hidden" name="continue" value="">
<input type="hidden" name="issetLangDefault" <?php if(!empty($logo['id'])) { ?>value="exist"<?php } ?>>
</div>
</div>
</div>
</div>
</div>
</form>
<script type="text/javascript">
jQuery(document).ready(function() {
$('.form-filter').keydown(function(e) {
if (e.keyCode == 13) {// mã của phím enter				
    $('#form_logo').submit();    //submit form có id là: "form"
   	}
});
});
</script>
</div>
</div>
<div class="tab-pane" id="tab_3">
<div class="clearfix">
<form class="form-horizontal form-row-seperated" action="" id="form_background" class="form-horizontal" enctype="multipart/form-data" method="POST">
<input type="hidden" value="<?php if(isset($bg_edit['id'])) { ?><?=$bg_edit['id']?><?php } ?>" name="idbg" id="idbg"/>
<div class="tabbable">
<div class="tab-content no-space">
<div class="tab-pane active">
<div class="form-body">
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('color_page');?> </label>
<div class="col-md-2">
<div class="input-group color colorpicker-default" data-color="<?php if(isset($bg_edit['color'])) { ?><?=$bg_edit['color']?><?php } ?>" data-color-format="rgba">
<input type="text" name="color_background" class="form-control" value="<?php if(isset($bg_edit['color'])) { ?><?=$bg_edit['color']?><?php } ?>">
<span class="input-group-btn">
<button class="btn default" type="button"><i style="background-color: <?php if(isset($bg_edit['color'])) { ?><?=$bg_edit['color']?><?php } ?>;"></i>&nbsp;</button>
</span>
</div>							
</div>
</div>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('img_background');?> </label>
<div class="col-md-8">
<div class="fileinput <?php if(!empty($bg_edit['img'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
<?php if(!empty($bg_edit['img'])) { ?>
<input type="hidden" value="1" name="img_bg"/>
<?php } ?>
<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
<img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
<img src="<?php if(isset($bg_edit['img'])) { ?><?=$_B['upload_path']?><?=$bg_edit['img']?><?php } ?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" />
</div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new">
<?php echo lang('select_img');?> </span>
<span class="fileinput-exists">
<?php echo lang('change_img');?> </span>
<input type="file" name="img_bg" id="img_bg">
</span>
<a href="#" class="btn default fileinput-exists" data-dismiss="fileinput"><?php echo lang('delete');?> </a>
</div>
</div>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('repeat_background');?></label>
<div class="col-md-3 margin-bt-10">
<select class="form-control" name="repeat" data-error="">
<option value="1" <?php if(isset($bg_edit['repeat']) && $bg_edit['repeat']==1) { ?>selected="selected"<?php } ?>><?php echo lang('bg_repeat_1');?></option>
<option value="2" <?php if(isset($bg_edit['repeat']) && $bg_edit['repeat']==2) { ?>selected="selected"<?php } ?>><?php echo lang('bg_repeat_2');?></option>
<option value="3" <?php if(isset($bg_edit['repeat']) && $bg_edit['repeat']==3) { ?>selected="selected"<?php } ?>><?php echo lang('bg_repeat_3');?></option>
<option value="4" <?php if(isset($bg_edit['repeat']) && $bg_edit['repeat']==4) { ?>selected="selected"<?php } ?>><?php echo lang('bg_repeat_4');?></option>
<option value="5" <?php if(isset($bg_edit['repeat']) && $bg_edit['repeat']==5) { ?>selected="selected"<?php } ?>><?php echo lang('bg_repeat_5');?></option>
</select>
</div>
</div>
<div class="btn_topline">
<a class="btn btn-sm blue continue set_default"><i class="fa fa-reply"></i> <?php echo lang('default_now');?></a>
<div class="btn_actions">
<button class="btn green continue" data-continue="template"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
</div>
<input type="hidden" name="action" value="addBackground">
<input type="hidden" name="lang" value="vi">
<input type="hidden" name="continue" value="">
</div>
</div>
</div>
</div>
</div>
</form>
</div>
</div>
<div class="tab-pane" id="tab_4">
<div class="clearfix">
<form class="form-horizontal form-row-seperated" action="" id="form_audio" class="form-horizontal" enctype="multipart/form-data" method="POST">
<input type="hidden" value="<?php if(isset($audio_edit['id'])) { ?><?=$audio_edit['id']?><?php } ?>" name="idaudio" id="idaudio"/>
<div class="tabbable">
<div class="tab-content no-space">
<div class="tab-pane active">
<div class="form-body">					
<div class="form-group row-title-check">
<label class="control-label col-md-3"><?php echo lang('choose_file');?> </label>						
<div class="col-md-8">							
<input type="file" name="file_audio" id="file_audio" class="bg_audio" value="<?php if(isset($audio_edit['audio'])) { ?><?=$_B['upload_path']?><?=$audio_edit['audio']?><?php } ?>" />
<?php if(!empty($audio_edit['audio'])) { ?>
<input type="hidden" value="1" name="file_exists"/>
<audio controls class="play_file">
  	<source src="<?=$_B['upload_path']?><?=$audio_edit['audio']?>" type="audio/mpeg">	
</audio>
<?php } ?>
</div>
</div>
<div class="form-group row-title-check">
<label class="control-label col-md-3"><?php echo lang('play_home');?></label>
<div class="col-md-8">
<input type="checkbox" name="play_home" <?php if(isset($audio_edit['is_home'])&&($audio_edit['is_home'] == 1)) { ?> checked <?php } ?> />
</div>
</div>
<div class="form-group row-title-check">
<label class="control-label col-md-3"><?php echo lang('play_page');?></label>
<div class="col-md-8">
<input type="checkbox" name="play_page" <?php if(isset($audio_edit['is_page'])&&($audio_edit['is_page'] == 1)) { ?> checked <?php } ?> />
</div>
</div>
<div class="form-group row-title-check">
<label class="control-label col-md-3"><?php echo lang('on_audio');?></label>
<div class="col-md-8">
<input type="checkbox" name="on_audio" <?php if(isset($audio_edit['status'])&&($audio_edit['status'] == 1)) { ?> checked <?php } ?> />
</div>
</div>
<div class="form-group row-title-check">
<label class="control-label col-md-3"><?php echo lang('play_again');?></label>
<div class="col-md-8">
<input type="checkbox" name="play_again" <?php if(isset($audio_edit['play_again'])&&($audio_edit['play_again'] == 1)) { ?> checked <?php } ?> />
</div>
</div>
<div class="btn_topline">						
<div class="btn_actions">
<button class="btn green continue" data-continue="template"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
</div>
<input type="hidden" name="action" value="addAudio">
<input type="hidden" name="lang" value="vi">
<input type="hidden" name="continue" value="">
</div>
</div>
</div>
</div>
</div>
</form>
</div>
</div> 
<div class="tab-pane" id="tab_5">
<div class="clearfix"> 
<form class="form-horizontal form-row-seperated" action="" id="form_logo" class="form-horizontal" enctype="multipart/form-data" method="POST" data-lang="<?=$_GET['lang']?>">
<div class="tabbable">
 
<div class="tab-content no-space">
<div class="tab-pane active" id="lang_<?=$v_lang?>">
<div class="form-body">
 
<div class="form-group row-title-check">
<label class="col-md-2 control-label">Chọn giao diện</label>
<div class="col-md-8">
 <select class="form-control" name="tempid" >
 <option value="1" <?php if($tempId ==1) { ?>selected="selected"<?php } ?>>Giao diện 1</option> 
 <option value="2" <?php if($tempId ==2) { ?>selected="selected"<?php } ?>>Giao diện 2</option>  
</select>
</div>
</div>
 
 					
<div class="btn_topline">
 <div class="btn_actions">
<button class="btn green continue" data-continue="template"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
</div>
<input type="hidden" name="action" value="changeTemp">
<input type="hidden" name="giaodien" value="giaodien">
 
</div>
</div>
</div>
</div>
</div>
</form> 
</div>
</div> 
</div>
</div>
</div>

</div>

</div>
</div>

<!-- BEGIN PLUGINS USED BY X-EDITABLE -->
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/moment.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery.mockjax.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/inputs-ext/address/address.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/inputs-ext/wysihtml5/wysihtml5.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>


<link href="<?=$_B['mod_theme']?>css/style.css" rel="stylesheet" type="text/css" />
<!-- END X-EDITABLE PLUGIN -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?=$_B['mod_theme']?>js/template.js"></script>
<script type="text/javascript" laguage="javascript">
    jQuery(document).ready(function() {
       Template.init();       
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
<!-- END JAVASCRIPTS -->
