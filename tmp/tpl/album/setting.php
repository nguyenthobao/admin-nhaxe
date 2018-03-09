<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/album/setting.php 
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
                        <i class="fa fa-gear"></i><?php echo lang('breadcrumb_setting');?>
                    </div>
                    <div class="actions btn-set">
<button class="btn default continue" data-continue="reset_default"><i class="fa fa-refresh"></i> <?php echo lang('reset_default');?></button>
<button class="btn green continue" data-continue="setting"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<input type="hidden" name="action" value="setting">
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
                            <a class="select_lang" href="<?=$v_lang['url']?>" data-exist="<?=$v_lang['exist']?>"><?php echo lang('lang_'.$k_lang);?></a>
                        </li>
                        <?php } } ?>
                    </ul>
                    <div class="tab-content no-space">
                        <div class="tab-pane active" id="lang_<?=$get_lang?>">
                            <div class="form-body">
                                <div class="note note-warning">
                                    <p class="block">
                                        <?php echo lang('select_lang','lang_'.$get_lang);?>
                                    </p>
                                </div>
                                <!--meta information-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-equalizer font-red-sunglo"></i>
                                            <span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('setting_information');?></span>
                                            <span class="caption-helper"><?php echo lang('setting_define');?></span>
                                        </div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse"></a>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label"><?php echo lang('title');?></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control maxlength-handler" name="title" maxlength="170" data-title="<?php echo lang('maxlength','170');?>" value="<?php if(!empty($cf['title'])) { ?><?=$cf['title']?><?php } ?>" />
                                                <span class="help-block"><?php echo lang('maxlength','170');?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label"><?php echo lang('description');?></label>
                                            <div class="col-md-8">
                                                <textarea class="form-control maxlength-handler" rows="5" name="description" maxlength="500" data-title="<?php echo lang('maxlength','500');?>"><?php if(!empty($cf['description'])) { ?><?=$cf['description']?><?php } ?></textarea>
                                                <span class="help-block"><?php echo lang('maxlength','500');?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-2" style="padding-top:0px; margin-top:0px"><?php echo lang('image_group');?></label>
                                            <div class="col-md-8">
                                                <div class="fileinput <?php if(!empty($cf['avatar'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
                                                <p class="label2"><?php echo lang('title_img');?></p>
                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                    <img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                                    <img src="<?php if(isset($cf['avatar'])) { ?><?=$_B['upload_path']?><?=$cf['avatar']?><?php } ?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" />
                                                </div>
                                                <div>
                                                    <span class="btn default btn-file">
                                                        <span class="fileinput-new"><?php echo lang('select_img');?></span>
                                                        <span class="fileinput-exists"><?php echo lang('change_img');?></span>
                                                        <input type="hidden" name="avatar" value="<?php if(isset($cf['avatar'])) { ?><?=$cf['avatar']?><?php } ?>" />
                                                        <input type="file" name="avatar" />
                                                    </span>
                                                    <a href="javascript:void(0)" class="btn default fileinput-exists" data-dismiss="fileinput"><?php echo lang('remove_image');?></a>
                                                </div>
                                            </div>
                                            <div class="fileinput <?php if(!empty($cf['icon'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
                                            <p class="label2"><?php echo lang('icon_img');?></p>
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                <img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                                <img src="<?php if(isset($cf['icon'])) { ?><?=$_B['upload_path']?><?=$cf['icon']?><?php } ?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" />
                                            </div>
                                            <div>
                                                <span class="btn default btn-file">
                                                    <span class="fileinput-new"><?php echo lang('select_img');?></span>
                                                    <span class="fileinput-exists"><?php echo lang('change_img');?></span>
                                                    <input type="hidden" name="icon" value="<?php if(isset($cf['icon'])) { ?><?=$cf['icon']?><?php } ?>" />
                                                    <input type="file" name="icon" />
                                                </span>
                                                <a href="javascript:void(0)" class="btn default fileinput-exists" data-dismiss="fileinput"><?php echo lang('remove_image');?></a>
                                            </div>
                                        </div>
                                        <div class="fileinput <?php if(!empty($cf['bg_image'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
                                        <p class="label2"><?php echo lang('bg_img');?></p>
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                            <img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                            <img src="<?php if(isset($cf['bg_image'])) { ?><?=$_B['upload_path']?><?=$cf['bg_image']?><?php } ?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" />
                                        </div>
                                        <div>
                                            <span class="btn default btn-file">
                                                <span class="fileinput-new"><?php echo lang('select_img');?></span>
                                                <span class="fileinput-exists"><?php echo lang('change_img');?></span>
                                                <input type="hidden" name="bg_image" value="<?php if(isset($cf['bg_image'])) { ?><?=$cf['bg_image']?><?php } ?>" />
                                                <input type="file" name="bg_image" />
                                            </span>
                                            <a href="javascript:void(0)" class="btn default fileinput-exists" data-dismiss="fileinput"><?php echo lang('remove_image');?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label"><?php echo lang('meta_title');?></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control maxlength-handler" name="meta_title" maxlength="170" value="<?php if(!empty($cf['meta_title'])) { ?><?=$cf['meta_title']?><?php } ?>" placeholder="" data-error="<?php echo lang('meta_title');?>">
                                    <span class="help-block"><?php echo lang('maxlength','170');?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label"><?php echo lang('meta_keywords');?></label>
                                <div class="col-md-8">
                                    <input id="meta_keywords" name="meta_keywords" maxlength="170" type="text" class="form-control tags" value="<?php if(!empty($cf['meta_keywords'])) { ?><?=$cf['meta_keywords']?><?php } ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label"><?php echo lang('meta_description');?></label>
                                <div class="col-md-8">
                                    <textarea class="form-control maxlength-handler" rows="4" name="meta_description" maxlength="170"><?php if(!empty($cf['meta_description'])) { ?><?=$cf['meta_description']?><?php } ?></textarea>
                                    <span class="help-block"> <?php echo lang('maxlength','170');?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label"><?php echo lang('kieu_sap_xep');?></label>
                                <div class="col-md-3">
                                    <?php $sort = array('new', 'hot', 'az') ?>
                                    <select class="form-control" name="display_sort">
                                        <?php if(is_array($sort)) { foreach($sort as $k => $v) { ?>
                                        <option value="<?=$v?>" <?php if(isset($cf) && $cf['display_sort']==$v) { ?>selected<?php } ?>><?php echo lang($v);?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label"><?php echo lang('so_luong_hien_thi');?></label>
                                <div class="col-md-3">
                                    
                                    <input type="number" class="form-control" name="display_number" value="<?php if(isset($cf)) { ?><?=$cf['display_number']?><?php } ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label"><?php echo lang('kieu_hien_thi');?></label>
                                <div class="col-md-2">
                                    <select class="form-control" name="display_type">
                                        <option value="grid" <!--<?php if(isset($cf) && $cf['display_type']=='grid') { ?>selected<?php } ?>><?php echo lang('dang_luoi');?></option>
                                        <option value="list" <?php if(isset($cf) && $cf['display_type']=='list') { ?>selected<?php } ?>><?php echo lang('danh_sach');?></option>
                                    </select>
                                </div>
                            </div>
                            
                            
                                <div class="form-group">
                                    <label class="col-md-2 control-label spanbold">
                                        <?php echo lang('hien_album_cung_danh_muc');?>
                                    </label>
                                    <div class="col-md-10">
                                        <div class="col-md-1" style="margin-top: 10px;">
                                            <input type="checkbox" value="1" class="form-control" <?php if(isset($cf['related']['album_cate']['status']) && $cf['related']['album_cate']['status']==1) { ?>checked<?php } ?> name="album_cate[status]">
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label class="col-md-6 margin-bt-10 control-label"><?php echo lang('so_luong_hien_thi');?></label>
                                            <div class="col-md-6 margin-bt-10">
                                                <select class="form-control" name="album_cate[quantity]" data-error="">
                                                    <?php for($i=5 ; $i<=30 ; $i++) { ?>
                                                        <option value="<?=$i?>" <?php if(isset($cf['related']['album_cate']['quantity']) && $cf['related']['album_cate']['quantity']==$i) { ?>selected<?php } ?>><?=$i?></option>
                                                    <?php }  ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-5">
                                            <label class="col-md-6 margin-bt-10 control-label"><?php echo lang('sap_xep_tin');?></label>
                                            <div class="col-md-6 margin-bt-10">
                                                <select class="form-control" name="album_cate[order]" data-error="">
                                                    <option value="1" <?php if(isset($cf['related']['album_cate']['order']) && $cf['related']['album_cate']['order']==1) { ?>selected<?php } ?>><?php echo lang('album_new_sort');?></option>
                                                    <option value="2" <?php if(isset($cf['related']['album_cate']['order']) && $cf['related']['album_cate']['order']==2) { ?>selected<?php } ?>><?php echo lang('album_hot');?></option>
                                                    <option value="3" <?php if(isset($cf['related']['album_cate']['order']) && $cf['related']['album_cate']['order']==3) { ?>selected<?php } ?>><?php echo lang('album_random');?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label class="col-md-2 control-label spanbold">
                                       <?php echo lang('show_album');?>
                                    </label>
                                    <div class="col-md-10">
                                        <div class="col-md-1" style="margin-top: 10px;">
                                            <input type="checkbox" value="1" <?php if(isset($cf['related']['album_related']['status']) && $cf['related']['album_related']['status']==1) { ?>checked<?php } ?> class="form-control" name="album_related[status]">
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label class="col-md-6 margin-bt-10 control-label"><?php echo lang('so_luong_hien_thi');?></label>
                                            <div class="col-md-6 margin-bt-10">
                                                <select class="form-control" name="album_related[quantity]" data-error="">
                                                    <?php for($i=5 ; $i<=30 ; $i++) { ?>
                                                        <option value="<?=$i?>" <?php if(isset($cf['related']['album_related']['quantity']) && $cf['related']['album_related']['quantity']==$i) { ?>selected<?php } ?>><?=$i?></option>
                                                    <?php }  ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-5">
                                            <label class="col-md-6 margin-bt-10 control-label"><?php echo lang('sap_xep_tin');?></label>
                                            <div class="col-md-6 margin-bt-10">
                                                <select class="form-control" name="album_related[order]" data-error="">
                                                    <option value="1" <?php if(isset($cf['related']['album_related']['order']) && $cf['related']['album_related']['order']==1) { ?>selected<?php } ?>><?php echo lang('album_new_sort');?></option>
                                                    <option value="2" <?php if(isset($cf['related']['album_related']['order']) && $cf['related']['album_related']['order']==2) { ?>selected<?php } ?>><?php echo lang('album_hot');?></option>
                                                    <option value="3" <?php if(isset($cf['related']['album_related']['order']) && $cf['related']['album_related']['order']==3) { ?>selected<?php } ?>><?php echo lang('album_random');?></option>
                                                </select>
                                            </div>
                                        </div>
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
<button class="btn default continue" data-continue="reset_default"><i class="fa fa-refresh"></i> <?php echo lang('reset_default');?></button>
<button class="btn green continue" data-continue="setting"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<input type="hidden" name="action" value="setting">
<input type="hidden" name="lang" value="<?=$dfLang?>">
<input type="hidden" name="continue" value="">
</div>
</div>
</div>
</form>
</div>
</div>
<!-- END PAGE CONTENT-->
<link href="<?=$_B['mod_theme']?>css/addCategory.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript"></script>
<script src="<?=$_B['mod_theme']?>js/setting.js" type="text/javascript"></script>
<script>
jQuery(document).ready(function() {
var person = new Array()
person["ok"] = "<?php echo lang('ok');?>";
person["cancel"] = "<?php echo lang('cancel');?>";
person["hiding"] = "<?php echo lang('hiding');?>";
person["showing"] = "<?php echo lang('showing');?>";
person["alert"] = "<?php echo lang('alert');?>";
person['do_you_really_want_to_reset'] = "<?php echo lang('do_you_really_want_to_reset');?>"
setting.init(person);
});
</script>