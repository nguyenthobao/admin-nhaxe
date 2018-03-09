<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/category/categorylist.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><!-- <link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/> -->
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>

<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/inputs-ext/address/address.css"/>
<link href="<?=$_B['mod_theme']?>css/style.css" rel="stylesheet" type="text/css" />

<!-- BEGIN PAGE CONTENT-->
<div class="row">
<form class="form-horizontal form-row-seperated" action="" id="form_categorylist" class="form-horizontal" enctype="multipart/form-data" method="POST">
<input type="hidden" value="" name="action">
<div class="col-md-12">
<div class="portlet">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-navicon"></i><?=$_L['breadcrumb_manager_categolist']?>
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
<input type="text" class="form-control form-filter input-sm" name="cat_title" placeholder="<?php echo lang('search_title');?>" <?php if($value['cat_title']!='') { ?>value="<?=$value['cat_title']?>"<?php } ?>>
</div>
<div class="col-md-2 col-padding-10">
<select name="status_cat" class="table-group-action-input form-control input-inline input-sm width-100">
<option <?php if($value['status_cat']=='default') { ?>selected<?php } ?> value="default"><?php echo lang('status');?></option>
<option <?php if($value['status_cat']==1) { ?>selected<?php } ?> value="1"> <?php echo lang('show');?></option>

<option <?php if($value['status_cat']=='0') { ?>selected<?php } ?> value="0"><?php echo lang('hide');?></option>

</select>
</div>
<div class="col-md-1 col-padding-10">
<button id="bnt_search" class="btn btn-sm green table-group-action-submit" data-continue="categorylist"><i class="fa fa-search"></i> <?php echo lang('search');?></button>
</div>
<div class="actions btn-set btn-del rightwidth">
<a class="btn red continue delete_category_select rightwidtha disabled"><i class="fa fa-trash-o"></i> <?php echo lang('delete');?></a>
</div> 
<div class="actions btn-set rightwidth">
<a href="<?=$addcategory?>" class="btn green continue rightwidtha"><i class="fa fa-plus"></i> <?php echo lang('add');?></a>
</div>
</div>
<div class="table-scrollable">
<table id="categorylist" data-lang="<?=$_GET['lang']?>" class="table table-striped table-bordered table-advance table-hover">
<thead>
<tr >
<th width="20">
<input type="checkbox" id="checkboxAll" value="">
</th>
<th>
<?php echo lang('Catego_title');?>
</th>
<th width="80" class="hidden-xs">
<?php echo lang('status');?>
</th>
<th width="110">
<?php echo lang('action');?>
</th>
</tr>
</thead>
<tbody>
<?php if($cat) { ?>
<?php if(is_array($cat['data'])) { foreach($cat['data'] as $k => $v) { ?>
<tr id="tr_<?=$v['id']?>" data-key="<?=$v['id']?>" data-lang="<?=$_GET['lang']?>">
<td class="highlight">
<input type="checkbox" name="nameid[]" class="checkboxes delete_multi_category"  value="<?php if(!empty($v['id'])) { ?><?=$v['id']?><?php } ?>">
</td>

<td >
 <span><?php if(!empty($v['space'])) { ?><?=$v['space']?><?php } ?></span><span data-pk="<?php if(!empty($v['id'])) { ?><?=$v['id']?><?php } ?>"  data-type="text" data-lang="<?=$_GET['lang']?>" data-original-title="<?php echo lang('edittitle');?>" class="editable editable-click nonebottom catItem tooltips"><?php if(!empty($v['title'])) { ?><?=$v['title']?><?php } ?></span>
</td>

<td class="hidden-xs">
<?php if($v['status']==1) { ?>
<a class="btn default btn-xs green-stripe active_status" data-status="<?=$v['status']?>" style="width:73px"><?php echo lang('show');?></a>
<?php } else { ?>
<a class="btn default btn-xs red-stripe active_status" data-status="<?=$v['status']?>" style="width:73px"><?php echo lang('hide');?></a>
<?php } ?>
</td>
<td>
<a href="<?=$v['link']?>" target="_blank" class="btn default btn-xs green tooltips" data-placement="top" data-original-title="<?php echo lang('view');?>"><i class="fa fa-eye"></i></a>
<!-- <a href="#" class="btn default btn-xs grey-cascade tooltips fast-edit" data-placement="top" data-original-title="Sửa nhanh"><i class="fa fa-send"></i></a> -->
<a href="category-category-<?=$v['id']?>-<?=$_GET['lang']?>" class="btn default btn-xs yellow tooltips" data-placement="top" data-original-title="<?php echo lang('edit');?>"><i class="fa fa-edit"></i></a>
<a  class="btn default btn-xs red tooltips delete_category"  data-placement="top" data-original-title="<?php echo lang('delete');?>"><i class="fa fa-trash-o"></i></a>
</td>
</tr>

<?php } } ?>
<?php } ?>
</tbody>
</table>
</div>
<?php if(isset($cat['pagination'])) { ?>
<?=$cat['pagination']?>
<?php } else { ?>
<?php if(empty($cat['data'])) { ?>
<div class="alert alert-warning">
<center> <?php echo lang('notfound');?> </center>
</div>
<?php } ?>
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
<!-- END X-EDITABLE PLUGIN -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?=$_B['mod_theme']?>js/categorylist.js"></script>
<script>
jQuery(document).ready(function() {    
CategoList.init();
$(document).keydown(function(e) {
if (e.keyCode == 13) {// mã của phím enter				
$('input[name="action"]').val("searchCategory");
            $('#form_categorylist').submit();    //submit form có id là: "form"
        }
    });
});
</script>
<!-- END JAVASCRIPTS -->

