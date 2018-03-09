<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/template/addLayoutList.php 
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
<i class="fa fa-navicon"></i><?php echo lang('ds_layout');?>
</div>
<div class="actions btn-set btn-del">
<a  class="btn red continue delete_slide_select disabled"><i class="fa fa-trash-o"></i> <?php echo lang('delete');?></a>
</div>
<div class="actions btn-set">
<a href="/template-addLayout-index-lang-vi" class="btn green continue"><i class="fa fa-plus"></i> <?php echo lang('add');?></a>
</div>
</div>
<div class="portlet-body">
<?php if(!empty($_DATA['content'])) { ?>
<div class="table-scrollable">
<table id="slidelist" data-lang="<?=$_GET['lang']?>" class="table table-striped table-bordered table-advance table-hover ">
<thead>
<tr>
<th width="20">
<input type="checkbox" id="checkboxAll">
</th>
<th class="highlight">
<?php echo lang('name_layout');?>
</th>
<th class="hidden-xs" width="120">
Layout
</th>
<th width="220">
<?php echo lang('duongdan');?>
</th>
<th width="120">
<?php echo lang('action');?>
</th>
</tr>
</thead>
<tbody>								
<?php if(is_array($_DATA['content'])) { foreach($_DATA['content'] as $k => $v) { ?>
<tr id="tr_<?=$v['id']?>" data-key="<?=$v['id']?>" data-lang="<?=$_GET['lang']?>">
<td class="highlight">
<input type="checkbox" name="name_id[]" class="checkboxes"  value="<?=$v['id']?>">
</td>

<td >
<span data-pk="<?=$v['id']?>"  data-type="text" data-lang="<?=$_GET['lang']?>" class="editable tooltips slideItem" data-original-title="<?php echo lang('click_edit');?>"><?=$v['title']?></span>
 
</td>
<td class="hidden-xs">		
<span data-pk="<?=$v['id']?>"  data-type="text" data-lang="<?=$_GET['lang']?>" class="editable editable-click tooltips aslideItem" data-original-title="<?php echo lang('click_edit');?>"><?=$v['layout_name']?></span>

</td>
<td class="hidden-xs">		
<span data-pk="<?=$v['id']?>"  data-type="text" data-lang="<?=$_GET['lang']?>" class="editable editable-click tooltips bslideItem" data-original-title="<?php echo lang('click_edit');?>"><?=$v['router']?></span>
</td>

<td class="icon_btn">
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
<script src="<?=$_B['mod_theme']?>js/addLayoutList.js"></script>
<script type="text/javascript" laguage="javascript">
    jQuery(document).ready(function() {    
       addLayoutList.init();       
    });
</script>
<!-- END JAVASCRIPTS -->
