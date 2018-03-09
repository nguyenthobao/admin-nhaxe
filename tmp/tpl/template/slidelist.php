<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/template/slidelist.php 
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
<form class="form-horizontal form-row-seperated" action="" id="form_slidelist" class="form-horizontal" enctype="multipart/form-data" method="POST">
<input type="hidden" value="deleteMultiID" name="action">
<div class="portlet">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-navicon"></i><?php echo lang('title_manager_slide');?>
</div>
<div class="actions btn-set btn-del">
<a  class="btn red continue delete_slide_select disabled"><i class="fa fa-trash-o"></i> <?php echo lang('delete');?></a>
</div>
<div class="actions btn-set">
<a href="<?=$addSlide?>" class="btn green continue"><i class="fa fa-plus"></i> <?php echo lang('add');?></a>
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
<a href="<?=$_B['home']?>/template-slidelist-lang-<?=$k_lang?>" class="select_lang" data-lang="<?=$k_lang?>"><?php echo lang('lang_'.$k_lang);?> </a>
</li>
<?php } } ?>
</ul>
</div>

<?php if(!empty($slide['data'])) { ?>
<div class="table-scrollable">
<table id="slidelist" data-lang="<?=$_GET['lang']?>" class="table table-striped table-bordered table-advance table-hover ">
<thead>
<tr>
<th width="20">
<input type="checkbox" id="checkboxAll">
</th>
<th class="highlight">
<?php echo lang('slide_title');?>
</th>
<th class="hidden-xs" width="20">
<?php echo lang('sort');?>
</th>
<th width="120">
<?php echo lang('position');?>
</th>
<th width="95">
<?php echo lang('status');?>
</th>
<th width="120">
<?php echo lang('action');?>
</th>
</tr>
</thead>
<tbody>								
<?php if(is_array($slide['data'])) { foreach($slide['data'] as $k => $v) { ?>
<tr id="tr_<?=$v['id']?>" data-key="<?=$v['id']?>" data-lang="<?=$_GET['lang']?>">
<td class="highlight">
<input type="checkbox" name="name_id[]" class="checkboxes"  value="<?=$v['id']?>">
</td>

<td >
<span data-pk="<?=$v['id']?>"  data-type="text" data-lang="<?=$_GET['lang']?>" class="editable editable-click tooltips slideItem" data-original-title="<?php echo lang('click_edit');?>"><?=$v['title']?></span>

</td>
<td class="hidden-xs">		
<a href="#" data-type="select" data-pk="<?=$v['id']?>" data-value="<?=$v['sort']?>" data-original-title="<?php echo lang('sort');?>" class="editable editable-click tooltips sortItem">
<?php if(isset($v['sort'])) { ?><?=$v['sort']?> <?php } ?>
</a>
</td>
<td class="hidden-xs">		
<a href="#" data-type="select" data-pk="<?=$v['id']?>" data-value="<?=$v['position']?>" data-original-title="<?php echo lang('position_edit');?>" class="editable editable-click tooltips positionItem">
            <?php if(is_array($positions)) { foreach($positions as $k_2 => $v_2) { ?>
            	<?php if(isset($v_2['position']) && $v_2['position'] == $k_2) { ?><?=$v_2?><?php } ?>
            <?php } } ?>
        </a>
</td>
<td class="hidden-xs">		
<?php if($v['status']==1) { ?>
<a class="btn default btn-xs green-stripe active_status" data-status="<?=$v['status']?>" style="width:73px"><?php echo lang('showing');?></a>
<?php } else { ?>
<a class="btn default btn-xs red-stripe active_status" data-status="<?=$v['status']?>" style="width:73px"><?php echo lang('hiding');?></a>
<?php } ?>
</td>
<td class="icon_btn">
<a href="template-imagelist-<?=$v['id']?>-lang-<?=$_GET['lang']?>" class="btn default btn-xs green tooltips" data-placement="top" data-original-title="Xem ảnh slide"><i class="fa fa-eye"></i></a>
<a href="template-slide-<?=$v['id']?>-<?=$_GET['lang']?>" class="btn default btn-xs yellow tooltips" data-placement="top" data-original-title="<?php echo lang('edit');?>"><i class="fa fa-edit"></i></a>
<a  class="btn default btn-xs red tooltips delete_slide"  data-placement="top" data-original-title="<?php echo lang('delete');?>"><i class="fa fa-trash-o"></i></a>
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
<?php if(isset($slide['pagination'])) { ?>
<?=$slide['pagination']?>
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
<script src="<?=$_B['mod_theme']?>js/slidelist.js"></script>
<script type="text/javascript" laguage="javascript">
var positions_source=[<?php if(is_array($positions)) { foreach($positions as $k => $v) { ?>{value: <?=$k?>,text: "<?=$v?>"},<?php } } ?>];
    jQuery(document).ready(function() {    
       SlideList.init();       
    });
</script>
<!-- END JAVASCRIPTS -->
