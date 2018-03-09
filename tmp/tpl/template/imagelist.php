<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/template/imagelist.php 
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
<form class="form-horizontal form-row-seperated" action="" id="form_imagelist" class="form-horizontal" enctype="multipart/form-data" method="POST">
<input type="hidden" value="deleteMultiID" name="action">
<div class="portlet">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-navicon"></i><?php echo lang('title_manager_image');?>
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
<a href="<?=$_B['home']?>/template-imagelist-lang-<?=$k_lang?>" class="select_lang" data-lang="<?=$k_lang?>"><?php echo lang('lang_'.$k_lang);?> </a>
</li>
<?php } } ?>
</ul>
</div>
<div class="form-group row-search">
<div class="col-md-3 col-padding-10">

<?php if(isset($slide)) { ?>
<select class="table-group-action-input form-control input-inline input-sm width-100 form-filter" name="slide_id" id="slide_id" data-error="<?php echo lang('slide_error');?>">
<option value=""><?php echo lang('select_slide');?></option>
<?php if(is_array($slide)) { foreach($slide as $k => $v) { ?>
<option value="<?=$v['id']?>" <?php if(isset($image['keySearch']['slide_id'])&&($image['keySearch']['slide_id'] == $v['id'])) { ?>selected<?php } ?>><?=$v['title']?></option>
<?php } } ?>
</select>
<?php } ?>
</div>

<div class="col-md-1 col-padding-10">
<button id="btn_search" class="btn btn-sm green table-group-action-submit" data-continue="imagelist"><i class="fa fa-search"></i> <?php echo lang('search');?></button>
</div>
<div class="col-md-8 col-padding-10">							

<div class="actions btn-set btn-del">
<a  class="btn btn-sm red continue delete_image_select disabled"><i class="fa fa-trash-o"></i> <?php echo lang('delete');?></a>
</div>
<div class="actions btn-set">
<a href="<?=$addImage?>" class="btn btn-sm green continue"><i class="fa fa-plus"></i> <?php echo lang('add');?></a>
</div>
</div>
</div>
<?php if(!empty($image['data'])) { ?>
<div class="table-scrollable">
<table id="imagelist" data-lang="<?=$_GET['lang']?>" class="table table-striped table-bordered table-advance table-hover ">
<thead>
<tr>
<th width="20">
<input type="checkbox" id="checkboxAll">
</th>
<th width="206">
<?php echo lang('image');?>
</th>
<th class="highlight">
<?php echo lang('image_title');?>
</th>
<th class="hidden-xs" width="20">
<?php echo lang('sort');?>
</th>								
<th width="95">
<?php echo lang('status');?>
</th>
<th width="90">
<?php echo lang('action');?>
</th>
</tr>
</thead>
<tbody>								
<?php if(is_array($image['data'])) { foreach($image['data'] as $k => $v) { ?>
<tr id="tr_<?=$v['id']?>" data-key="<?=$v['id']?>" data-lang="<?=$_GET['lang']?>">
<td class="highlight">
<input type="checkbox" name="name_id[]" class="checkboxes"  value="<?=$v['id']?>">
</td>
<td>
<div class="list-cat-img">
<div class="<?php if(!empty($v['src_link'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
<div class="fileinput-new thumbnail" style="width: 190px; height: 120px;">
<img class="img-responsive" src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar"/>
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 190px; max-height: 120px;">
<img class="img-responsive" src="<?php if(isset($v['src_link'])) { ?><?=$_B['upload_path']?><?=$v['src_link']?> <?php } ?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" />
</div>
<div class="btn-all">
<span class="btn btn-xs default btn-file btn-change" style="display:none">
<span class="fileinput-new">
<?php echo lang('select_img');?> </span>
<span class="fileinput-exists">
<?php echo lang('change_img');?> </span>
<input type="file" name="img_slide_<?=$v['id']?>">
</span>
</div>
</div>
</div>
</td>
<td>
<span data-pk="<?=$v['id']?>"  data-type="text" data-lang="<?=$_GET['lang']?>" class="editable editable-click tooltips imageItem" data-original-title="<?php echo lang('click_edit');?>"><?=$v['title']?></span>		
</td>

<td class="hidden-xs">		
<a href="#" data-type="select" data-pk="<?=$v['id']?>" data-value="<?=$v['sort']?>" data-original-title="<?php echo lang('sort');?>" class="editable editable-click tooltips sortImage">
<?php if(isset($v['sort'])) { ?><?=$v['sort']?> <?php } ?>
</a>
</td>
<td>		
<?php if($v['status']==1) { ?>
<a class="btn default btn-xs green-stripe active_status_image" data-status="<?=$v['status']?>" style="width:73px"><?php echo lang('showing');?></a>
<?php } else { ?>
<a class="btn default btn-xs red-stripe active_status_image" data-status="<?=$v['status']?>" style="width:73px"><?php echo lang('hiding');?></a>
<?php } ?>
</td>
<td class="icon_btn">		
<a href="template-image-<?=$v['id']?>-<?=$_GET['lang']?>" class="btn default btn-xs yellow tooltips" data-placement="top" data-original-title="<?php echo lang('edit');?>"><i class="fa fa-edit"></i></a>
<a  class="btn default btn-xs red tooltips delete_image"  data-placement="top" data-original-title="<?php echo lang('delete');?>"><i class="fa fa-trash-o"></i></a>
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
<?php if(isset($image['pagination'])) { ?>
<?=$image['pagination']?>
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
<script src="<?=$_B['mod_theme']?>js/imagelist.js"></script>
<script type="text/javascript" laguage="javascript">
    jQuery(document).ready(function() {    
       ImageList.init();
       $('.form-filter').keydown(function(e) {
if (e.keyCode == 13) {// mã của phím enter				
   	$('input[name="action"]').val("searchImage");
            $('#form_imagelist').submit();    //submit form có id là: "form"
   }
});
    });
</script>
<!-- END JAVASCRIPTS -->
