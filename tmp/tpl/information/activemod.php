<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/information/activemod.php 
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
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-toastr/toastr.min.css">
<style type="text/css">
.boderRight{
border-right: #F0F8FF solid 1px;
    min-height: 300px;
}
.ulborder{
   border: #E1E1E1 1px dotted;
   margin-bottom: -2px;
}
.ulborder > li{
  list-style: none;
  margin-left: -32px;
  line-height: 29px;
}

.listborder2{
    -webkit-columns: 300px 2;
   -moz-columns: 300px 2;
        columns: 300px 2;
}
.listborder2 > li{
    list-style: none;
  line-height: 29px;
  cursor: pointer;
  padding: 1px;
  border: #E1E1E1 1px dotted;
  margin: 7px;
  margin-left: 0px;
}
</style>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
<div class="col-md-12">
<form class="form-horizontal form-row-seperated" action="/information-settinglang-edit-lang-vi" id="nxt_form" class="form-horizontal" method="POST">
<div class="portlet">
<div class="portlet-title"> 
<div class="caption">
<i class="fa fa-th-list"></i><?php echo lang('settingActiveModule');?>
</div>
<div class="actions btn-set">
<a href="<?=$_B['home']?>/information-settingdomain-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn green continue" data-continue="settingdomain"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
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
<div class="tab-content no-space">
<div class="tab-pane active">
<div class="form-body">
<div class="tab-pane active fontawesome-demo" id="tab_1_1">
<div class="note note-warning" style="text-align: jutsify;">
<?php echo lang('setting_module');?>
<br/>
<span class="text-danger"><strong>Lưu ý:</strong></span> <?php echo lang('note_can_nhac');?>
</div>
</div>
<div class="portlet light bordered">
<div class="portlet-title">
<div class="caption">
<i class="icon-equalizer font-red-sunglo"></i>
<span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('settingActiveModule');?></span>
<span class="caption-helper"></span>
</div>
<div class="tools"></div>
</div>
<div class="portlet-body form" >

<div class="row">
<div class="col-md-12 boderRight">
<ul class="listborder2" id="areaLeft">
<?php if(is_array($_DATA['active_mod'])) { foreach($_DATA['active_mod'] as $k => $v) { ?>
<li class="mod">
<input type="checkbox" name="mod_active[]" value="<?=$v?>" class="form-control" <?php if($v=='information') { ?>readonly checked<?php } elseif(in_array($v,$_DATA['customs_mod'])) { ?>checked<?php } ?> > <?php echo lang($v);?>
</li>
<?php } } ?>
</ul>
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
<a href="<?=$_B['home']?>/information-settingdomain-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn green continue" data-continue="settingdomain"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
</div>
</div>
</div>
</form>
</div>

</div>
<!-- END PAGE CONTENT-->


<script src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
<script src="<?=$_B['mod_theme']?>js/drag/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?=$_B['mod_theme']?>js/activemod.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
activemod.init();
});
</script>


