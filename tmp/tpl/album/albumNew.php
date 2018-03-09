<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/album/albumNew.php 
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
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal form-row-seperated" action="" id="form_album" class="form-horizontal" enctype="multipart/form-data" method="POST">
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa icon-note"></i><?php echo lang('breadcrumb_album_new');?>
                    </div>
                    <div class="actions btn-set">
    <a href="<?=$_B['home']?>/album" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
    <button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('reset');?></button>
    <button class="btn green continue" data-continue="album"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
    <button class="btn green continue" data-continue="albumNew"><i class="fa fa-check-circle"></i> <?php echo lang('submit_cont_');?></button>
    <button class="btn green continue" data-continue="albumUpdate"><i class="fa fa-flag"></i> <?php echo lang('submit_cont_lang');?></button>
    <input type="hidden" name="action" value="addAlbum">
    <input type="hidden" name="lang" value="<?=$dfLang?>">
    <input type="hidden" name="tmp_id" value="<?=$tmpIdAlbum?>">
    <input type="hidden" name="avatar_id" value="">
    <input type="hidden" name="avatar" value="">
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
                            <a class="select_lang" href="<?=$v_lang['url']?>" data-exist="<?=$v_lang['exist']?>"> <?php echo lang('lang_'.$k_lang);?> </a>
                        </li>
                        <?php } } ?>
                        <input type="hidden" name="popup" data-title="<?php echo lang('pop_title');?>" data-yes="<?php echo lang('pop_yes');?>" data-cancel="<?php echo lang('pop_cancel');?>" data-message="<?php echo lang('pop_message');?>" data-close="<?php echo lang('pop_close');?>">
                        <input type="hidden" name="popup_df" data-title="<?php echo lang('pop_df_title');?>" data-yes="<?php echo lang('pop_yes');?>" data-cancel="<?php echo lang('pop_cancel');?>" data-message="<?php echo lang('pop_df_message');?>" data-close="<?php echo lang('pop_close');?>">
                    </ul>
                    <div class="tab-content no-space">
                        <div class="tab-pane active" id="lang_<?=$get_lang?>">
                            <div class="form-body">
                                <div class="note note-warning">
                                    <p class="block">
                                        <?php echo lang('select_lang','lang_'.$get_lang);?>
                                    </p>
                                </div>
                                <!--album param-->
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
                                        <div class="form-group param1">
                                            <label class="col-md-2 control-label"><?php echo lang('title');?>: <span class="required"> * </span> </label>
                                            <div class="col-md-8">
                                                <input type="text" id="seo_url" onkeyup="trim_name(this);" class="form-control maxlength-handler" name="title" maxlength="255" value="" placeholder="" data-error="<?php echo lang('title_error');?>">
                                                <span class="help-block"><?php echo lang('maxlength','255');?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">SEO URL </label>
                                            <div class="col-md-8">
                                                <input class="form-control maxlength-handler" maxlength="225" name="alias" value="" id="seo_keyword" >
                                                <span class="help-block"><?php echo lang('maxlength','225');?></span>
                                                <script type="text/javascript" src="<?=$_B['mod_theme']?>js/nbh_seo_rewrite.js"></script>
                                                <script type="text/javascript">
                                                function trim_name(input_name){
                                                var txtname_trim=erase($("#seo_url").val());
                                                $("#seo_keyword").val(nbh_seo_write(txtname_trim));
                                                }
                                                </script>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label"><?php echo lang('description');?></label>
                                            <div class="col-md-8">
                                                <textarea class="form-control " minlength="5" rows="6" name="contents_description" id="contents_description" data-error="<?php echo lang('contents_description_error');?>"></textarea>
                                            </div>
                                        </div>
                                        <?php if($categoryMenu) { ?>
                                        <div class="form-group param2">
                                            <label class="control-label col-md-2"><?php echo lang('category');?> <span class="required"> * </span></label>
                                            <div class="col-md-8">
                                                <div class="form-control height-auto">
                                                    <div class="scrollbar" id="style-scroll">
                                                        <div class="force-overflow">
                                                            <ul class="list-unstyled">
                                                                <li class="row_check_all">
                                                                    <label><input id="checkboxAll" type="checkbox" value=""> <?php echo lang('check_all');?> </label>
                                                                </li>
                                                                <?php if(is_array($categoryMenu)) { foreach($categoryMenu as $k => $v) { ?>
                                                                <li>
    <label><input class="checkboxes chil" data-error-container="" type="checkbox" name="category_id[]" value="<?=$v['id']?>"><?=$v['title']?></label>
<?php if(sizeof($v['sub'])>0 ) { ?>
<ul class="list-unstyled">
    <?php if(is_array($v['sub'])) { foreach($v['sub'] as $k => $v) { ?>
    <?php include $_B['temp']->load('category_album_list') ?>
    <?php } } ?>
</ul>
<?php } ?>
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
                                            <label class="col-md-2 control-label"><?php echo lang('tags');?>:</label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="tags" placeholder="" value="" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label"><?php echo lang('sort');?>:</label>
                                            <div class="col-md-4">
                                                <input type="text" data-title="<?php echo lang('sort_tooltips');?>" class="form-control tooltips" name="order_by" data-error="<?php echo lang('number_error');?>" placeholder="<?php echo lang('error_number_only');?>" value="" >
                                            </div>
                                        </div>
                                        <div class="form-group row-title-check">
                                            <label class="col-md-2 control-label"><?php echo lang('album_vip');?> </label>
                                            <div class="col-md-8">
                                                <input type="checkbox" name="album_vip" value="1">
                                            </div>
                                        </div>
                                        <div class="form-group row-title-check">
                                            <label class="col-md-2 control-label"><?php echo lang('album_hot');?> </label>
                                            <div class="col-md-8">
                                                <input type="checkbox" name="album_hot" value="1">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-2"><?php echo lang('status');?><span class="required"> * </span> </label>
                                            <div class="col-md-4">
                                                <select class="form-control" name="status" data-error="">
                                            <?php if($_B['user_perm']!='boss') { ?>
                                            <?php } else { ?>
                                             <option value="1" selected="selected"><?php echo lang('publuc');?></option>
                                            <?php } ?>
                                                    <option value="0"><?php echo lang('private');?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <!--album param end-->
                                <!--images-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-equalizer font-red-sunglo"></i>
                                            <span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('images');?></span>
                                            <span class="caption-helper"><?php echo lang('images_noti');?></span>
                                        </div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse"></a>
                                        </div>
                                    </div>
                                    <div class="portlet-body form album-images overlay_">
                                        <div class="form-group param3 upload-ft">
                                            <div style="max-width: 1034px; margin: 0 auto; position: relative; padding-bottom: 69px;" class="form-control-img" id="sortB_">
                                                <p class="none_avatar" style="color: #E02222; display: none"><?php echo lang('none_avatar');?></p>
                                                <div id="albumImagesUpload"><?php echo lang('add_image');?></div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--images end-->
                                <!--related-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-equalizer font-red-sunglo"></i>
                                            <span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('album_related');?></span>
                                            <span class="caption-helper"><?php echo lang('related_noti');?></span>
                                        </div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse"></a>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label spanbold">
                                                <?php echo lang('hien_album_cung_danh_muc');?>
                                                <span class="required"></span>
                                            </label>
                                            <div class="col-md-10">
                                                <div class="form-control height-auto">
                                                    <div class="force-over">
                                                        <ul class="list-unstyled">
                                                            <li class="row_check_all">
                                                                <label>
                                                                    <input type="checkbox" <?php if(isset($configNXT['related']['album_cate']) && $configNXT['related']['album_cate']['status']==1) { ?>checked<?php } ?> name="chk_cat_related" value="1">
                                                                </label>
                                                            </li>
                                                        </ul>
                                                        <label class="col-md-3 margin-bt-10 control-label"><?php echo lang('so_luong_hien_thi');?></label>
                                                        <div class="col-md-3 margin-bt-10">
                                                            <select class="form-control" name="show_quantity" data-error="">
                                                                <?php for($i=5 ; $i<=30 ; $i++) { ?>
                                                                    <option value="<?=$i?>" <?php if(isset($configNXT['related']['album_cate']['quantity']) && $configNXT['related']['album_cate']['quantity']==$i) { ?>selected<?php } ?>><?=$i?></option>
                                                                <?php }  ?>
                                                            </select>
                                                        </div>
                                                        <label class="col-md-3 margin-bt-10 control-label"><?php echo lang('sap_xep_tin');?></label>
                                                        <div class="col-md-3 margin-bt-10">
                                                            <select class="form-control" name="related_order" data-error="">
                                                                    <option value="1" <?php if(isset($configNXT['related']['album_cate']['order']) && $configNXT['related']['album_cate']['order']==1) { ?>selected<?php } ?>><?php echo lang('album_new_sort');?></option>
                                                                    <option value="2" <?php if(isset($configNXT['related']['album_cate']['order']) && $configNXT['related']['album_cate']['order']==2) { ?>selected<?php } ?>><?php echo lang('album_hot');?></option>
                                                                    <option value="3" <?php if(isset($configNXT['related']['album_cate']['order']) && $configNXT['related']['album_cate']['order']==3) { ?>selected<?php } ?>><?php echo lang('album_random');?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label spanbold">
                                                <?php echo lang('hien_album_tu_chon');?>
                                                <span class="required"></span>
                                            </label>
                                            <div class="col-md-10">
                                                <div class="form-control height-auto">
                                                    <div class="force-over">
                                                        <ul class="list-unstyled">
                                                            <li class="row_check_all">
                                                                <label>
                                                                    <input type="checkbox" name="chk_related" value="1" <?php if(isset($configNXT['related']['album_related']) && $configNXT['related']['album_related']['status']==1) { ?>checked<?php } ?>>
                                                                </label>
                                                            </li>
                                                        </ul>
                                                        <label class="col-md-3 margin-bt-10 control-label"><?php echo lang('so_luong_hien_thi');?></label>
                                                        <div class="col-md-3 margin-bt-10">
                                                            <select class="form-control" name="show_quantity_" data-error="">
                                                                <?php for($i=5 ; $i<=30 ; $i++) { ?>
                                                                    <option value="<?=$i?>" <?php if(isset($configNXT['related']['album_related']['quantity']) && $configNXT['related']['album_related']['quantity']==$i) { ?>selected<?php } ?>><?=$i?></option>
                                                                <?php }  ?>
                                                            </select>
                                                        </div>
                                                        <label class="col-md-3 margin-bt-10 control-label"><?php echo lang('sap_xep_tin');?></label>
                                                        <div class="col-md-3 margin-bt-10">
                                                            <select class="form-control" name="related_order_" data-error="">
                                                                <option value="1" <?php if(isset($configNXT['related']['album_related']['order']) && $configNXT['related']['album_related']['order']==1) { ?>selected<?php } ?>><?php echo lang('album_new_sort');?></option>
                                                                    <option value="2" <?php if(isset($configNXT['related']['album_related']['order']) && $configNXT['related']['album_related']['order']==2) { ?>selected<?php } ?>><?php echo lang('album_hot');?></option>
                                                                    <option value="3" <?php if(isset($configNXT['related']['album_related']['order']) && $configNXT['related']['album_related']['order']==3) { ?>selected<?php } ?>><?php echo lang('album_random');?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-2" style="padding-right: 10px"><?php echo lang('related');?></label>
                                            <div class="col-md-10">
                                                <div class="related_form height-auto">
                                                    <div class="col-md-48 col_left">
                                                        <div class="cotsearch">
                                                            <input type="text" class="form-control inputsearch" id="search" name="search" value="" placeholder="<?php echo lang('search_title');?>" >
                                                            <input type="hidden" name="langsearch" id="langsearch" value="<?=$get_lang?>">
                                                            <input type="hidden" id="idsearch" value="<?=$get_lang?>">
                                                            <!--<a class="btn green btn_search" id="btn_search"><i class="fa fa-search" data-lang="<?=$get_lang?>"></i> <?php echo lang('search');?></a>-->
                                                        </div>
                                                        <div>
                                                            <div class="scrollbar_1" id="style-scroll-1">
                                                                <div class="force-overflow-1">
                                                                    <ul id="news_left">
                                                                        <?php if(isset($related)) { ?>
                                                                        <?php if(is_array($related)) { foreach($related as $k => $v) { ?>
                                                                        <?php if(isset($v)) { ?>
                                                                        <li id="<?=$v['id']?>" style="display: none"></li>
                                                                        <li data-id="<?=$v['id']?>" class="l<?=$v['id']?>">
                                                                            <span><img src="<?=$_B['upload_path']?><?=$v['avatar']?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" /></span>
                                                                            <a href="javascript:;"><?php if(isset($v['title'])) { ?><?=$v['title']?><?php } ?></a>
                                                                        </li>
                                                                        <?php } ?>
                                                                        <?php } } ?>
                                                                        <?php } ?>
                                                                    </ul>
                                                                </div>
                                                                <?php if(isset($related) && count($related) >= 10) { ?>
                                                                <div id="more"><?php echo lang('load_more');?></div>
                                                                <?php } else { ?>
                                                                <div id="more" style="display: none"><?php echo lang('load_more');?></div>
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
                                                                    <ul id="news_right">
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
                                <!--related end-->
                                <!--meta information-->
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
                                            <label class="col-md-2 control-label"><?php echo lang('meta_title');?></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control maxlength-handler" name="meta_title" maxlength="170" value="" placeholder="" data-error="<?php echo lang('meta_title');?>">
                                                <span class="help-block"><?php echo lang('maxlength','170');?> </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label"><?php echo lang('meta_keywords');?></label>
                                            <div class="col-md-8">
                                                <input id="meta_keywords" name="meta_keywords" maxlength="170" type="text" class="form-control tags" value=""/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label"><?php echo lang('meta_description');?></label>
                                            <div class="col-md-8">
                                                <textarea class="form-control maxlength-handler" rows="4" name="meta_description" maxlength="170"></textarea>
                                                <span class="help-block"><?php echo lang('maxlength','170');?></span>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <!--meta information end-->
                                <!--time post-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-equalizer font-red-sunglo"></i>
                                            <span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('option_post');?></span>
                                            <span class="caption-helper"></span>
                                        </div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse"></a>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label"><?php echo lang('post_time');?></label>
                                            <div class="col-md-4">
                                                <div class="input-group date form_datetime">
                                                    <input type="text" size="16" readonly class="form-control" name="post_time" value="">
                                                    <span class="input-group-btn">
                                                        <button class="btn default date-reset" type="button"><i class="fa fa-times"></i></button>
                                                    </span>
                                                    <span class="input-group-btn">
                                                        <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--time post end-->
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet-title topline">
                <div class="actions btn-set">
    <a href="<?=$_B['home']?>/album" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
    <button class="btn default" id="btn_reset" type="reset"><i class="fa fa-reply"></i> <?php echo lang('reset');?></button>
    <button class="btn green continue" data-continue="album"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
    <button class="btn green continue" data-continue="albumNew"><i class="fa fa-check-circle"></i> <?php echo lang('submit_cont_');?></button>
    <button class="btn green continue" data-continue="albumUpdate"><i class="fa fa-flag"></i> <?php echo lang('submit_cont_lang');?></button>
    <input type="hidden" name="action" value="addAlbum">
    <input type="hidden" name="lang" value="<?=$dfLang?>">
    <input type="hidden" name="tmp_id" value="<?=$tmpIdAlbum?>">
    <input type="hidden" name="avatar_id" value="">
    <input type="hidden" name="avatar" value="">
    <input type="hidden" name="continue" value="">
</div>
            </div>
        </div>
    </form>
</div>
</div>
<!-- END PAGE CONTENT-->
<link href="<?=$_B['mod_theme']?>css/addAlbum.css?rs=<?=$reload?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?=$_B['mod_theme']?>js/album.js" type="text/javascript"></script>
<script src="<?=$_B['mod_theme']?>js/jquery.form.js"></script>
<script src="<?=$_B['mod_theme']?>js/Ft.uploadfile.js?rs=<?=$reload?>"></script>
<script src="<?=$_B['mod_theme']?>js/addAlbum.js?rs=<?=$reload?>" type="text/javascript"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>/assets/global/plugins/ckeditor/ckeditor.js"></script>

<script>
jQuery(document).ready(function() {
    CKEDITOR.replace('contents_description');
var person = new Array()
person["url"] = "<?=$_B['home']?>/album-ajax-lang-<?=$get_lang?>";
person["reset"] = "<?php echo lang('reset');?>";
addAlbum.init(person);
var settings = {
url: "<?=$_B['home']?>/album-uploads-lang-<?=$get_lang?>",
method: "POST",
allowedTypes:"jpg,jpeg,png,gif",
fileName: "Lfile",
formData:{tmp_id: <?=$tmpIdAlbum?>},
multiple: true,
showDelete: true,
dragDropStr: '<span><b><?php echo lang('dragDropStr');?></b></span>',
chooseStr: '<?php echo lang('chooseStr');?>',
abortStr: '<?php echo lang('abortStr');?>',
deletelStr: '<?php echo lang('delete');?>',
loadingStr: '<?php echo lang('loadingStr');?>',
placeholderTextStr: '<?php echo lang('placeholderTextStr');?>',
placeholderTextAreaStr: '<?php echo lang('placeholderTextAreaStr');?>',
onSuccess:function(files,data,xhr)
{
$('.upload-ft').removeClass('has-error');
},
onError: function(files,status,errMsg)
{
alert('<?php echo lang('error_just_not_idea');?>');
},
deleteCallback: function (e) {
var this_ = $(this);
var obj = $.parseJSON(e);
bootbox.dialog({
message : '<li class="list-group-item list-group-item-warning"><?php echo lang('do_you_really_want_to_delete_pic');?></li>',
title : "<?php echo lang('alert');?>",
buttons : {
success : {
label : "<?php echo lang('ok');?>",
className : "green",
callback : function() {
$.post("<?=$_B['home']?>/album-ajax-lang-<?=$get_lang?>", { id: obj.id, name: 'pic-delete' }, function( data ) {
if(data.success){
this_.parent().fadeOut(500, function(){
$(this).remove();
});
}
if(data.error){
alert(data.error);
}
}, "json");
}
},
danger : {
label : "<?php echo lang('cancel');?>",
className : "red",
callback : function() {
return;
}
}
}
});
},
inputCallback: function (e,val) {
var obj = $.parseJSON(e);
$.post("<?=$_B['home']?>/album-ajax-lang-<?=$get_lang?>", { id: obj.id, title: val, name: 'pic-update' }, function( data ) {
if(data.error){
alert(data.error);
}
}, "json");

},
textareaCallback: function (e,val) {
var obj = $.parseJSON(e);
$.post("<?=$_B['home']?>/album-ajax-lang-<?=$get_lang?>", { id: obj.id, description: val, name: 'pic-update' }, function( data ) {
if(data.error){
alert(data.error);
}
}, "json");
},
chooseCallback: function (e) {
$('.none_avatar').hide();
$('.param3').removeClass('has-error');
$('.ajax-file-upload-del').css("top", "");
$('.ajax-file-upload-statusbar').css("border-color", "");
$(this).parents().css("border-color", "#0DA3E2");
$(this).prev().css("top", "-100px");
var obj = $.parseJSON(e);
$('input[name="avatar_id"]').val(obj.id);
$('input[name="avatar"]').val(obj.path);

}
}
$("#albumImagesUpload").uploadFile(settings);

});
</script>