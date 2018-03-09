<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/menu/menulistfix.php 
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
<form class="form-horizontal form-row-seperated" action="" id="form_menulistabove" class="form-horizontal" enctype="multipart/form-data" method="POST">

<input type="hidden" value="deleteMultiID" name="action">
<div class="portlet">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-navicon"></i><?=$_DATA['menu_br']?>
</div>
<div class="actions btn-set btn-del">
<a  class="btn red continue delete_contactview_select disabled"><i class="fa fa-trash-o"></i> <?php echo lang('delete');?></a>
</div>
<div class="actions btn-set copy_category">
<a class="btn blue continue disabled copyCats"><i class="fa fa-copy"></i> <?php echo lang('copy');?></a>
</div>
<div class="actions btn-set copy_category_product" style="margin-left: 10px">
<a class="btn blue continue copyCatsProduct"><i class="fa fa-copy"></i> Sao chép danh mục sản phẩm</a>
</div>
<div class="actions btn-set btn-add">
<a href="<?=$_DATA['link_add']?>" class="btn green continue"><i class="fa fa-plus"></i> <?php echo lang('add');?></a>
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
<?php if(is_array($_DATA['lang_tab'])) { foreach($_DATA['lang_tab'] as $k_lang => $v_lang) { ?>
<li <?php if($k_lang==$_DATA['lang']) { ?>class="active"<?php } ?> >
<a href="<?=$v_lang['url']?>" data-lang="<?=$k_lang?>"><?php echo lang('lang_'.$k_lang);?> </a>
</li>
<?php } } ?>
</ul>
</div>
<?php if(!empty($_DATA['data'])) { ?>
<div class="table-scrollable">
<table id="menulist" data-lang="<?=$_DATA['lang']?>" class="table table-striped table-bordered table-advance table-hover" data-lang-j='<?php echo lang('delete_feedback_add');?>' data-lang-a='<?php echo lang('delete_feedback');?>'data-lang-title="<?php echo lang('delete_js_title');?>">
<thead>
<tr >
<th width="20">
<input type="checkbox" id="checkboxAll">
</th>
<th >
<?php echo lang('name');?>
</th>
<th width="250" style="display:none;">
<?php echo lang('linktoct');?>
</th>

<th width="60">
<?php echo lang('sort');?>
</th>
<th width="60" style="text-align:center">
Nofollow
</th>
<th width="95" style="text-align:center">
<?php echo lang('status');?>
</th>
<th width="110" style="text-align:center">
<?php echo lang('action');?>
</th>
<th width="10" style="display:none">
</th>
<th width="10" style="display:none">
</th>
</tr>
</thead>
<tbody>
<?php if(!empty($_DATA['data'])) { ?>
<?php if(is_array($_DATA['data'])) { foreach($_DATA['data'] as $k => $v) { ?>

<tr data-parent="tr_<?=$v['parent_id']?>" id="tr_<?=$v['id']?>" data-key="<?=$v['id']?>"  >
<td class="highlight">
<input type="checkbox" name="name_id[]" class="checkboxes"  value="<?=$v['id']?>">
</td>

<td class="ct_name" width="350">
<span><?=$v['space']?></span><span class="nameItem editable editable-click nonebottom tooltips btn" data-pk="<?php if(!empty($v['id'])) { ?><?=$v['id']?><?php } ?>" data-params="{'type': '<?=$_DATA['type']?>'}" data-type="text" data-original-title="<?php echo lang('editsortname');?>" ><?=$v['namemenu']?></span>
</td> 

<td class="hidden-xs" style ="text-align:center">		
<a href="#" data-type="select" data-pk="<?=$v['id']?>" data-value="<?=$v['sort']?>" data-original-title="<?php echo lang('sort');?> (<?php echo lang('number_error');?>)" class="editable editable-click nonebottom tooltips btn sortItem">
<?php if(isset($v['sort'])) { ?><?=$v['sort']?> <?php } ?>
</a>
</td> 
<td style="text-align:center">
<?php if($v['nofollow']==1) { ?>
<a class="btn default btn-xs green-stripe active_nofollow" data-nofollow="<?=$v['nofollow']?>"><?php echo lang('yes');?></a>
<?php } else { ?>
<a class="btn default btn-xs red-stripe active_nofollow" data-nofollow="<?=$v['nofollow']?>"><?php echo lang('no');?></a>
<?php } ?>
</td>

<td style="text-align:center">
<?php if($v['status']==1) { ?>
<a class="btn default btn-xs green-stripe active_status" data-status="<?=$v['status']?>" style="width:73px"><?php echo lang('show');?></a>
<?php } else { ?>
<a class="btn default btn-xs red-stripe active_status" data-status="<?=$v['status']?>" style="width:73px"><?php echo lang('hide');?></a>
<?php } ?>
</td>
<td style="text-align:center" >
<a href="menu-menu-edit-<?=$v['id']?>-lang-<?=$_DATA['lang']?>" class="btn default btn-xs yellow tooltips" data-placement="top" data-original-title="<?php echo lang('edit');?>"><i class="fa fa-edit"></i></a>
<a  class="btn default btn-xs red tooltips delete_menu"  data-placement="top" data-original-title="<?php echo lang('delete');?>"><i class="fa fa-trash-o"></i></a>
</td>
 
</tr>
<?php if(count($v['sub'])>0 ) { ?>
<?php if(is_array($v['sub'])) { foreach($v['sub'] as $k => $v) { ?>
<?php include $_B['temp']->load('menulist_listfix') ?>
<?php } } ?>		
<?php } ?>


<?php } } ?>
<?php } else { ?>
<?php } ?>
</tbody>
</table>
</div>
<?php } else { ?>
<div class="alert alert-warning">
<center><?php echo lang('notfound');?></center>
</div>
<?php } ?>

</div>

</div>
</form>
</div>
</div>

<!-- BEGIN PLUGINS USED BY X-EDITABLE -->
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js"></script>
<link href="<?=$_B['mod_theme']?>css/style.css" rel="stylesheet" type="text/css" />
<!-- END X-EDITABLE PLUGIN -->
<script src="<?=$_B['mod_theme']?>js/menulisttopfix.js"></script>


