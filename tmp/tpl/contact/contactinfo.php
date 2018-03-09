<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/contact/contactinfo.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/jquery-tags-input/jquery.tagsinput.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/typeahead/typeahead.css">
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
<div class="col-md-12">
<form class="form-horizontal form-row-seperated" action="" enctype="multipart/form-data" id="form_contactinfo" class="form-horizontal" method="POST">
<div class="portlet">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-shopping-cart"></i><?php echo lang('breadcrumb_contact');?>
</div>
<div class="actions btn-set">
<button class="btn green continue" data-continue="contactlist"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<input type="hidden" name="action" value="addContactInfo">
<input type="hidden" name="lang" value="">
<input type="hidden" name="continue" value="">
<input type="hidden" name="issetLangDefault" <?php if(!empty($contactlist['id'])) { ?>value="exist"<?php } ?>>
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
<li <?php if($k_lang==$_GET['lang']) { ?>class="active"<?php } ?> >
<a href="<?=$_B['home']?>/contact-contactlist-lang-<?=$k_lang?>" class="select_lang" data-lang="<?=$k_lang?>"><?php echo lang('lang_'.$k_lang);?> </a>
</li>
<?php } } ?>
</ul>
<div class="tab-content no-space">
<div class="tab-pane active">
<div class="form-body">
<div class="note note-warning">
<p class="block"><?php echo lang('select_lang','lang_'.$_GET['lang']);?></p>
</div>
<div class="portlet light bordered">
<div class="portlet-title">
<div class="caption">
<i class="icon-equalizer font-red-sunglo"></i>
<span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('breadcrumb_contact');?></span>
<span class="caption-helper"></span>
</div>
<div class="tools">
<a href="javascript:;" class="expand"></a>
<a href="#portlet-config" data-toggle="modal" class="config"></a>
<a href="javascript:;" class="reload"></a>
<a href="javascript:;" class="remove"></a>
</div>
</div>
<div class="portlet-body form" >


<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('addinfo');?><span class="required">
* </span> 
</label>
<div class="col-md-10">
<textarea class="span12 ckeditor m-wrap" name="info" rows="6" data-error-container="#editor2_error"><?php if(isset($info_data['info'])) { ?><?=$info_data['info']?><?php } ?></textarea>
</div>
</div>

<div class="form-group">
                                                <label class="control-label col-md-2 label-img">Ảnh</label>
                                                <div class="col-md-8">
                                                    <div class="fileinput <?php if(!empty($info_data['img'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
                                                        <p class="label2"><?php echo lang('title_img');?></p>
                                                        <?php if(!empty($info_data['img'])) { ?>
                                                        <input type="hidden" value="1" name="img_cat"/>
                                                        <?php } ?>
                                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                            <img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                                            <img src="<?php if(isset($info_data['img'])) { ?><?=$_B['upload_path']?><?=$info_data['img']?><?php } ?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" />
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
                                                    
                        
                                                    <div class="fileinput <?php if(!empty($info_data['icon'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
                                                        <p class="label2"><?php echo lang('bieutuong');?></p>
                                                        <?php if(!empty($info_data['icon'])) { ?>
                                                        <input type="hidden" value="1" name="icon_cat"/>
                                                        <?php } ?>
                                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                            <img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                                            <img src="<?php if(isset($info_data['icon'])) { ?><?=$_B['upload_path']?><?=$info_data['icon']?><?php } ?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" />
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
                                                    
                                                    <div class="fileinput <?php if(!empty($info_data['bg'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
                                                        <p class="label2"><?php echo lang('anhnen');?></p>
                                                        <?php if(!empty($info_data['bg'])) { ?>
                                                        <input type="hidden" value="1" name="bg_cat"/>
                                                        <?php } ?>
                                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                            <img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                                            <img src="<?php if(isset($info_data['bg'])) { ?><?=$_B['upload_path']?><?=$info_data['bg']?><?php } ?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" />
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
<label class="col-md-2 control-label"><?php echo lang('manhungbando');?><span class="required">
* </span> 
</label>
<div class="col-md-10">
<textarea class="form-control" name="maps" rows="6" ><?php if(isset($info_data['maps'])) { ?><?=$info_data['maps']?><?php } ?></textarea>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('active');?> <span class="required">
* </span>
</label>
<div class="col-md-3">
<select class="form-control" name="status" data-error="<?php echo lang('contactinfo_error');?>">
<option value="1" <?php if($info_data['status']==1) { ?>selected="selected"<?php } ?>><?php echo lang('active');?></option>
<option value="0"  <?php if($info_data['status']==0) { ?>selected="selected"<?php } ?>><?php echo lang('non_active');?></option>
</select>
</div>
</div>


                                    <div class="form-group">
                                        <label class="control-label col-md-2">Email <span class="required">
                                            * </span>
                                        </label>
                                        <div class="col-md-3">
                                            <input class="form-control" name="email" value="<?php if(isset($info_data['email'])) { ?><?=$info_data['email']?><?php } ?>" data-error="<?php echo lang('contactinfo_error');?>">
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
<button class="btn green continue" data-continue="contactlist"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<input type="hidden" name="action" value="addContactInfo">
<input type="hidden" name="lang" value="">
<input type="hidden" name="continue" value="">
<input type="hidden" name="issetLangDefault" <?php if(!empty($contactlist['id'])) { ?>value="exist"<?php } ?>>
</div>
</div>
</div>
</form>
</div>
</div>
<!-- END PAGE CONTENT-->

<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/ckeditor/ckeditor.js"></script>
<script src="<?=$_B['mod_theme']?>js/contactlist.js"></script>




