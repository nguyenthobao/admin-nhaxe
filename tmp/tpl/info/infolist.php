<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/info/infolist.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/inputs-ext/address/address.css"/>

<!-- BEGIN PAGE CONTENT-->
<div class="row">
<div class="col-md-12">
<form class="form-horizontal form-row-seperated" action="" id="form_infolist" class="form-horizontal" enctype="multipart/form-data" method="POST">
<input type="hidden" value="deleteMultiID" name="action">
<div class="portlet">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-navicon"></i><?php echo lang('title_manager_mod');?>
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
 
<div class="form-group row-search">
<div class="col-md-3 col-padding-10">
<input type="text" class="form-control form-filter input-sm" name="info_title" placeholder="<?php echo lang('search_title');?>" value="<?php if(isset($info['keySearch'])) { ?><?=$info['keySearch']['info_title']?><?php } ?>">
</div>
<div class="col-md-2 col-padding-10">
<select name="status_info" class="table-group-action-input form-control input-inline input-sm width-100 form-filter">
<option value="all"<?php if(isset($info['keySearch']['status_info']) && ($info['keySearch']['status_info'] == "all")) { ?>selected<?php } ?>><?php echo lang('status');?></option>
<option value="show"<?php if(isset($info['keySearch']['status_info'])&&($info['keySearch']['status_info'] == 'show')) { ?>selected<?php } ?>><?php echo lang('show');?></option>
<option value="hide"<?php if(isset($info['keySearch']['status_info'])&&($info['keySearch']['status_info'] == 'hide')) { ?>selected<?php } ?>><?php echo lang('hide');?></option>
<option value="time"<?php if(isset($info['keySearch']['status_info'])&&($info['keySearch']['status_info'] == 'time')) { ?>selected<?php } ?>><?php echo lang('time_up');?></option>
</select>
</div>
<div class="col-md-1 col-padding-10">
<button id="btn_search" class="btn btn-sm green table-group-action-submit" data-continue="infolist"><i class="fa fa-search"></i> <?php echo lang('search');?></button>
</div>
<div class="col-md-3 col-padding-10">
</div>
<div class="col-md-3 col-padding-10">
<div class="actions btn-set btn-del">
<a  class="btn btn-sm red continue delete_info_select disabled"><i class="fa fa-trash-o"></i> <?php echo lang('delete');?></a>
</div>
<div class="actions btn-set">
<a href="<?=$addInfo?>" class="btn btn-sm green continue"><i class="fa fa-plus"></i> <?php echo lang('add');?></a>
</div>

</div>
</div>
<?php if(!empty($info['data'])) { ?>
<div class="table-scrollable">
<table id="infolist" data-lang="<?=$_GET['lang']?>" class="table table-striped table-bordered table-advance table-hover ">
<thead>
<tr>
<th width="20">
<input type="checkbox" id="checkboxAll">
</th>
<th width="120">
<?php echo lang('ava');?>
</th>
<th class="highlight">
<?php echo lang('info_title');?>
</th>
<th class="hidden-xs" width="20">
<?php echo lang('sort');?>
</th>
<th width="95">
<?php echo lang('status');?>
</th>
<th width="150">
<?php echo lang('active');?>
</th>
</tr>
</thead>
<tbody>								
<?php if(is_array($info['data'])) { foreach($info['data'] as $k => $v) { ?>
<tr id="tr_<?=$v['id']?>" data-key="<?=$v['id']?>" data-lang="<?=$_GET['lang']?>">
<td class="highlight">
<input type="checkbox" name="name_id[]" class="checkboxes"  value="<?=$v['id']?>">
</td>
<td>
<div class="list-cat-img">
<div class="<?php if(!empty($v['img'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
<div class="fileinput-new thumbnail" style="width: 160px; height: 100px;">
<img class="img-responsive" src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 160px; max-height: 100px;">
<img class="img-responsive" src="<?php if(isset($v['img'])) { ?><?=$_B['upload_path']?><?=$v['img']?> <?php } ?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" />
</div>
<div class="btn-all">
<span class="btn btn-xs default btn-file btn-change" style="display:none">
<span class="fileinput-new">
<?php echo lang('select_img');?> </span>
<span class="fileinput-exists">
<?php echo lang('change_img');?> </span>
<input type="file" name="img_info_<?=$v['id']?>">
</span>
</div>
</div>	
</div>
</td>
<td >
<span data-pk="<?=$v['id']?>"  data-type="text" data-lang="<?=$_GET['lang']?>" class="editable editable-click tooltips infoItem" data-original-title="<?php echo lang('click_edit');?>"><?=$v['title']?></span>

</td>
<td class="hidden-xs">		
<a href="#" data-type="select" data-pk="<?=$v['id']?>" data-value="<?=$v['sort']?>" data-original-title="<?php echo lang('sort');?>" class="editable editable-click tooltips sortItem">
<?php if(isset($v['sort'])) { ?><?=$v['sort']?> <?php } ?>
</a>
</td>
<td>
<?php if($v['status']==2) { ?>
<a class="btn default btn-xs yellow-stripe tooltips post_info" data-status="<?=$v['status']?>" style="width:73px" data-title="<?php echo lang('click_up_now');?>"><?php echo lang('time_up');?></a>
<?php } else { ?>
<?php if($v['status']==1) { ?>
<a class="btn default btn-xs green-stripe active_status" data-status="<?=$v['status']?>" style="width:73px"><?php echo lang('show');?></a>
<?php } else { ?>
<a class="btn default btn-xs red-stripe active_status" data-status="<?=$v['status']?>" style="width:73px"><?php echo lang('hide');?></a>
<?php } ?>
<?php } ?>
</td>
<td class="icon_btn">
<a class="btn default btn-xs blue tooltips refesh_info" data-placement="top" data-original-title="<?php echo lang('go_new');?>"><i class="fa fa-history"></i></a>
<a href="#" class="btn default btn-xs green tooltips" data-placement="top" data-original-title="Xem chi tiết"><i class="fa fa-eye"></i></a>
<a href="info-info-<?=$v['id']?>-<?=$_GET['lang']?>" class="btn default btn-xs yellow tooltips" data-placement="top" data-original-title="<?php echo lang('edit');?>"><i class="fa fa-edit"></i></a>
<a  class="btn default btn-xs red tooltips delete_info"  data-placement="top" data-original-title="<?php echo lang('delete');?>"><i class="fa fa-trash-o"></i></a>
</td>
</tr>

<?php } } ?>
</tbody>
</table>
</div>
<?php } else { ?>
<div class="alert alert-warning">
<center> <?php echo lang('notfound');?> </center>
</div>
<?php } ?>
<?php if(isset($info['pagination'])) { ?>
<?=$info['pagination']?>
<?php } ?>

</div>				
</div>
</form>
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

<link href="<?=$_B['mod_theme']?>css/style.css" rel="stylesheet" type="text/css" />
<!-- END X-EDITABLE PLUGIN -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?=$_B['mod_theme']?>js/infolist.js"></script>
<script type="text/javascript" laguage="javascript">
    jQuery(document).ready(function() {    
       InfoList.init();
       $('.form-filter').keydown(function(e) {
if (e.keyCode == 13) {// mã của phím enter				
   	$('input[name="action"]').val("searchInfo");
            $('#form_infolist').submit();    //submit form có id là: "form"
   }
});
    });
</script>
<!-- END JAVASCRIPTS -->
