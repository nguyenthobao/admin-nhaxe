<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/information/footer.php 
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
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">



<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
<div class="col-md-12">
<form class="form-horizontal form-row-seperated" action="" id="form_contactinfo" class="form-horizontal" method="POST">
<div class="portlet">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-list-ul"></i><?php echo lang('breadcrumb_footer');?>
</div>
<div class="actions btn-set pull-right">
<a href="<?=$_B['home']?>/information-footer-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn green continue" data-continue="informationbasic"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<input type="hidden" name="action" value="addFooter">
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
<div class="portlet-title">
    <ul class="nav nav-tabs tabs-template">
        <li class="active"> <a href="#tab_1" data-toggle="tab"><?php echo lang('footer');?></a> </li>
        <li class=""> <a href="#tab_2" data-toggle="tab"><?php echo lang('qc_chantrang');?></a> </li>
    </ul>
</div>
<div class="tab-content">
<div class="tab-pane active" id="tab_1">
<ul class="nav nav-tabs">
<?php if(is_array($url_lang)) { foreach($url_lang as $k_lang => $v_lang) { ?>
<li <?php if($k_lang==$_GET['lang']) { ?>class="active"<?php } ?> >
<a href="<?=$_B['home']?>/information-footer-lang-<?=$k_lang?>" class="select_lang" data-lang="<?=$k_lang?>"><?php echo lang('lang_'.$k_lang);?> </a>
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
<span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('breadcrumb_footer_add');?></span>
<span class="caption-helper"></span>
</div>
<div class="tools">

</div>
</div>

<div class="portlet-body form" >

<div class="form-group">

<div class="col-md-12">
<textarea class="span12 m-wrap" id="editorFooter" name="footer" rows="6" data-error-container="#editor2_error"><?php if(isset($info_data['footer'])) { ?><?=$info_data['footer']?><?php } ?></textarea>
</div>
</div>



</div>

</div>
</div>
</div>
</div>
<div class="portlet-title topline">
<div class="actions btn-set pull-right">
<a href="<?=$_B['home']?>/information-footer-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn green continue" data-continue="informationbasic"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<input type="hidden" name="action" value="addFooter">
<input type="hidden" name="lang" value="">
<input type="hidden" name="continue" value="">

</div>
</div>
</div>

<div class="tab-pane" id="tab_2">
<div class="form-body">
    <div class="note note-info">
        <p class="block"><?php echo lang('tt_qc_chantrang');?> <a class="btn btn-xs red status_ads_footer"> <?php if(isset($data['ads_footer']) && $data['ads_footer']!=0) { ?>Bật<?php } else { ?>Tắt<?php } ?></a></p>
    </div>
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption"> <i class="icon-equalizer font-red-sunglo"></i> <span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('cs_qc_chantrang');?></span> <span class="caption-helper"></span> </div>
            <div class="tools"> </div>
        </div>
        <div class="portlet-body form">
            <div class="form-group">
                <div class="col-md-12">
                    <input <?php if(isset($data['ads_footer']) && $data['ads_footer']!=0) { ?>checked<?php } else { ?><?php } ?> type="checkbox" value="1" name="on_off_ads_footer"  class="make-switch" data-on="success" data-off="warning">
                    Bật tắt <?php echo lang('qc_chantrang');?> 
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
</div>
</div>
<!-- END PAGE CONTENT-->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?=$_B['mod_theme']?>editor/editor.js" type="text/javascript"></script>
<script src="<?=$_B['mod_theme']?>js/footer.js" type="text/javascript"></script> 

<script type="text/javascript">
jQuery(document).ready(function() {
Footer.init();
});
</script>



