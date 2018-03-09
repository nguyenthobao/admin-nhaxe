<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/information/settingdomain.php 
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

<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
<div class="col-md-12">
<form class="form-horizontal form-row-seperated" action="" id="form_contactinfo" class="form-horizontal" method="POST">
<div class="portlet">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-th-list"></i><?php echo lang('breadcrumb_domain');?>
</div>
<div class="actions btn-set">
<a href="/information-dns-lang-vi" class="btn green">
<i class="fa fa-indent"></i> <?php echo lang('manager_dns');?></a>

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

<strong><?php echo lang('address_id_of_you');?> :</strong><span style="font-weight: bold; color: red"><?=$getIP?></span><br><br>

<span><?php echo lang('note_setting_domain');?></span><br><br>

<span class="badge badge-danger">1</span> <span> <?php echo lang('note_setting_domain_2');?></span> <br><br><br>
<span class="badge badge-danger">2</span> <span> <?php echo lang('note_setting_domain_3');?></span> <br><br>


<p>
<?php echo lang('note_setting_domain_4');?>
</p>
    							</div>
</div>
﻿<div class="portlet light bordered">
<div class="portlet-title">
<div class="caption">
<i class="icon-equalizer font-red-sunglo"></i>
<span class="caption-subject font-red-sunglo bold uppercase"><?php echo lang('breadcrumb_domain_add');?></span>
<span class="caption-helper"></span>
</div>
<div class="tools"></div>
</div>
<div class="portlet-body form" >
<div id="BNC_body_add_domain">
<?php if(!empty($_DATA['list_domain_exist'])) { ?>
<?php if(is_array($_DATA['list_domain_exist'])) { foreach($_DATA['list_domain_exist'] as $k => $v) { ?>
<div class="form-group" id="domain-<?=$v['no_dot']?>">
<label class="control-label col-md-2"><?php echo lang('domain');?></label>
<div class="col-md-3">
<span class="form-control"><?=$v['domain']?></span>
</div>
 
<div class="col-md-1" style="padding:0px">
<button href="javascript:void(0)" type="button" class="btn red BNC_remove_domain tooltips" data-original-title="Xóa" data-domain="<?=$v['domain']?>" style="border-radius:3px !important"><i class="fa fa-trash-o"></i></button>
</div> 
</div>
<?php } } ?>
<?php } else { ?>
<div class="text-center text-danger"><?php echo lang('no_domain');?></div>
<?php } ?>
<hr/>
<div class="form-group">
<label class="control-label col-md-2"><?php echo lang('domain');?></label>
<div class="col-md-3">
<input type="text" class="form-control BNC_infomation_domain" name="info_domain[]" placeholder="Nhập domain..." />
<span class="text-danger BNC_error" style="display:none;"><?php echo lang('please_domain');?>.</span>
<span class="text-danger BNC_exist" style="display:none;"><?php echo lang('exist_domain');?>.</span>
<span class="text-danger BNC_not_dns" style="display:none;"><?php echo lang('not_dns');?>.</span>
<span class="text-danger BNC_exist_in_web" style="display:none;"><?php echo lang('domain_exist_in_web');?>.</span>
</div>
 
<div class="col-md-1" style="padding:0px">
<button href="javascript:void(0)" type="button" class="btn green add_info" style="border-radius:3px !important"><i class="fa fa-plus"></i></button>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript" src="<?=$_B['mod_theme']?>js/dns.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {    
       FormDns.init();
    });        
</script>

</div>
</div>
</div>
</div>
</div>
<div class="portlet-title topline">
<div class="actions btn-set">
<a href="<?=$_B['home']?>/information-settingdomain-lang-vi" class="btn default"><i class="fa fa-angle-left"></i> <?php echo lang('cancel');?></a>
<button class="btn green continue" disabled="disabled" data-continue="settingdomain"><i class="fa fa-check"></i> <?php echo lang('submit');?></button>
<!--<input type="hidden" name="action" value="addInformationBasic">
<input type="hidden" name="lang" value="">
<input type="hidden" name="continue" value="">-->
</div>
</div>
</div>
</form>
</div>

<!-- Modal -->
<div class="modal fade" id="BNC_remove_domain_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('delete_domain');?></h4>
      </div>
      <div class="modal-body">
        <?php echo lang('delete_domain_how');?> <span class="text-danger" id="BNC_remove_domain_modal_body"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close');?></button>
        <button type="button" class="btn btn-primary" id="BNC_remove_domain_button_modal" data-domain=""><?php echo lang('delete');?></button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="BNC_domain_exist_web_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('domain_exist_in_web');?></h4>
      </div>
      <div class="modal-body">
        	<?php echo lang('domain_exist_in_web_modal');?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close');?></button>
      </div>
    </div>
  </div>
</div>

</div>
<!-- END PAGE CONTENT-->
<script type="text/javascript">
var domainlist="<?=$_DATA['domainlist']?>";
var domainlist_array=domainlist.split(',');
</script>

<script src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>

<script src="<?=$_B['mod_theme']?>js/domain.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
Domain.init();
});
</script>



