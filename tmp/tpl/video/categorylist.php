<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/video/categorylist.php 
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
<div class="col-md-12">
<form class="form-horizontal form-row-seperated" action="" id="form_categorylist" class="form-horizontal" enctype="multipart/form-data" method="POST">
<div class="portlet">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-navicon"></i><?php echo lang('title_manager_category');?>
</div>
<div class="actions btn-set btn-del">
<a class="btn red continue delete_category_select disabled"><i class="fa fa-trash-o"></i> <?php echo lang('delete');?></a>
</div>
<div class="actions btn-set copy_category">
<a class="btn blue continue disabled copyCats"><i class="fa fa-plus"></i> <?php echo lang('copy');?></a>
</div>
<div class="actions btn-set copy_category_lang" style="margin-left:10px;">
<a class="btn blue continue copyCatsLang"><i class="fa fa-copy"></i> Sao chép ngôn ngữ</a>
</div>
<div class="actions btn-set">
<a href="<?=$addCategory?>" class="btn green continue"><i class="fa fa-plus"></i> <?php echo lang('add');?></a>
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
<li <?php if($k_lang==$_GET['lang']) { ?>class="active"<?php } ?>>
<a class="select_lang" href="<?=$v_lang['url']?>">
<?php echo lang('lang_'.$k_lang);?>  
</a>
</li>
<?php } } ?>
</ul>
</div>
<?php if($cat) { ?>	
<div class="table-scrollable">

<table id="categorylist" data-lang="<?=$_GET['lang']?>" class="table table-striped table-bordered table-advance table-hover">
<thead>
<tr >
<th width="20">
<input type="checkbox" id="checkboxAll" value="">
</th>
<th class="highlight">
<?php echo lang('namecategory');?> 

</th>
<th width="100" class="hidden-xs">
<?php echo lang('sort');?>
</th>
<th width="100" class="hidden-xs">
<?php echo lang('status');?>
</th>
<th width="109"><?php echo lang('active');?>
</th>
</tr>
</thead>
<tbody>

<?php if(is_array($cat)) { foreach($cat as $k => $v) { ?>
<tr id="tr_<?=$v['id']?>" data-key="<?=$v['id']?>" data-lang="<?=$_GET['lang']?>">
<td class="highlight">
<input type="checkbox" name="name_id[]" class="checkboxes delete_multi"  value="<?=$v['id']?>">
</td>
<td >
 <span><?php if(!empty($v['space'])) { ?><?=$v['space']?><?php } ?></span><span class="catItem nonebottom tooltips" data-pk="<?=$v['id']?>"  data-type="text" data-lang="<?=$_GET['lang']?>"   data-original-title="<?php echo lang('editsort');?>"><?php if(!empty($v['title'])) { ?><?=$v['title']?><?php } ?></span>
</td>
<td class="hidden-xs center">
<!-- <span data-pk="<?=$v['id']?>"  data-original-title="<?php echo lang('sort');?> (<?php echo lang('number_error');?>)" data-type="text" data-lang="<?=$_GET['lang']?>" class="editable editable-click sortItem"><?=$v['sort']?></span> -->
<a href="#" data-type="select" data-pk="<?=$v['id']?>" data-value="<?=$v['sort']?>" data-original-title="<?php echo lang('sort');?> (<?php echo lang('number_error');?>)" class="editable editable-click sortItem tooltips">
<?php if(!empty($v['sort'])) { ?><?=$v['sort']?><?php } ?> </a>
</td>
<td class="hidden-xs">
<?php if($v['status']==1) { ?>
<a class="btn default btn-xs green-stripe active_status" data-status="<?=$v['status']?>" style="width:73px"><?php echo lang('show');?></a>
<?php } else { ?>
<a class="btn default btn-xs red-stripe active_status" data-status="<?=$v['status']?>" style="width:73px"><?php echo lang('hide');?></a>
<?php } ?>
</td>
<td>
<a href="#" class="btn default btn-xs green tooltips" data-placement="top" data-original-title="<?php echo lang('view');?>"><i class="fa fa-eye"></i></a>
<!-- <a href="#" class="btn default btn-xs grey-cascade tooltips fast-edit" data-placement="top" data-original-title="Sửa nhanh"><i class="fa fa-send"></i></a> -->
<a href="video-category-<?=$v['id']?>-<?=$_GET['lang']?>" class="btn default btn-xs yellow tooltips" data-placement="top" data-original-title="<?php echo lang('edit');?>"><i class="fa fa-edit"></i></a>
<a  class="btn default btn-xs red tooltips delete_category"  data-placement="top" data-original-title="<?php echo lang('delete');?>"><i class="fa fa-trash-o"></i></a>
</td>
</tr>
<?php if(sizeof($v['sub'])>0 ) { ?>
<?php if(is_array($v['sub'])) { foreach($v['sub'] as $k => $v) { ?>
<?php include $_B['temp']->load('categorylist_cat_list') ?>
<?php } } ?>		
<?php } ?>
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

<div class="modal fade" id="copyCat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
<form role="form" id="formCopy" action="/video-categorylist-ajaxCopyCategory-lang-<?=$_GET['lang']?>">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">Sao chép danh mục video</h4>
      </div>
      <div class="modal-body">
        <div class="note note-warning">
            <p class="block">
                - Bạn có thể sao chép được toàn bộ danh mục video sang ngôn ngữ được định sẵn.<br>
                - Tất cả dữ liệu từ bên ngôn ngữ gốc sẽ được bảo toàn khi chuyển qua ngôn ngữ mới.<br>
            </p>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Chọn ngôn ngữ sao chép sang</label>
                <select name="langData" class="form-control">
                	<?php if(is_array($_DATA['lang_use'])) { foreach($_DATA['lang_use'] as $k => $v) { ?>
                		
                			<option value="<?=$v?>"><?php echo lang('lang_'.$v);?></option>
                		
<?php } } ?>
                </select>
            </div>
            <div class="col-md-6">
                <label>Bạn có muốn xóa tất cả danh mục video ?</label> <br>
                <input class="form-control" value="1" type="checkbox" name="emptyData"> Làm rỗng trước khi sao chép
            </div>
            <input type="hidden" name="currentLang" value="<?=$_GET['lang']?>">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
        <button type="submit" class="btn btn-primary">Đồng ý</button>
      </div>
    </div>
  </div>
  </form>
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
           CategoryList.init();
        });
    </script>
<!-- END JAVASCRIPTS -->

