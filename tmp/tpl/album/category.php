<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/album/category.php 
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

<!-- BEGIN PAGE CONTENT deleteMultiID -->
<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal form-row-seperated" action="" id="formList" class="form-horizontal" enctype="multipart/form-data" method="POST">
            <input type="hidden" value="" name="action">
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list"></i><?php echo lang('title_manager_category');?>
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
                                <li <?php if($k_lang==$get_lang) { ?>class="active"<?php } ?> >
                                    <a href="<?=$_B['home']?>/album-category-lang-<?=$k_lang?>" class="select_lang" data-lang="<?=$k_lang?>"><?php echo lang('lang_'.$k_lang);?> </a>
                                </li>
                            <?php } } ?>
                        </ul>
                    </div>
<!--search-->
<div class="form-group row-search">
<div class="col-md-3 col-padding-10">
<input type="text" id="form-filter" class="form-control form-filter input-sm" name="title" placeholder="<?php echo lang('search_title');?>" <?php if(isset($value['title']) && $value['title']!='') { ?>value="<?=$value['title']?>"<?php } ?>>
</div>

<div class="col-md-2 col-padding-10">
<select name="status" class="form-filter table-group-action-input form-control input-inline input-sm width-100">
<option selected value=""><?php echo lang('status');?></option>
<option value="0" <?php if(isset($value['status']) && $value['status']=='0') { ?>selected<?php } ?>><?php echo lang('hiding');?></option>
<option value="1" <?php if(isset($value['status']) && $value['status']==1) { ?>selected<?php } ?>><?php echo lang('showing');?></option>

</select>
</div>
<div class="col-md-2 col-padding-10">
<button id="bnt_search" class="btn btn-sm green table-group-action-submit" data-continue="category"><i class="fa fa-search"></i> <?php echo lang('search');?></button>
</div>
<div class="col-md- col-padding-10" style="padding-right: 15px">
<div class="actions btn-set btn-del">
<a  class="btn btn-sm red continue delete_category_select disabled" data-continue="delete_category_select"><i class="fa fa-trash-o"></i> <?php echo lang('delete');?></a>
</div>
<div class="actions btn-set copy_category_lang" style="margin-left:10px;">
                                    <a class="btn btn-sm blue continue copyCatsLang"><i class="fa fa-copy"></i> Sao chép ngôn ngữ</a>
</div>
<div class="actions btn-set">
<a href="<?=$_B['home']?>/album-categoryNew-lang-<?=$get_lang?>" class="btn btn-sm green continue"><i class="fa fa-plus"></i> <?php echo lang('add');?></a>
</div>
</div>

</div>
<?php if($cateList) { ?>
<div class="table-scrollable">
<table id="categoryList" data-lang="<?=$get_lang?>" class="table table-striped table-bordered table-advance table-hover">
<thead>
<tr >
<th width="20">
<input type="checkbox" id="checkboxAll" value="">
</th>
<th class="highlight max559">
<?php echo lang('category_name');?>
</th>
<th class="hidden-xs" width="20">
<?php echo lang('sort');?>
</th>
<th width="100">
<?php echo lang('status');?>
</th>
<th width="115"><?php echo lang('action');?>
</th>
</tr>
</thead>
<tbody>

<?php if(is_array($cateList)) { foreach($cateList as $k => $v) { ?>
<tr id="tr_<?=$v['id']?>" data-key="<?=$v['id']?>" data-lang="<?=$get_lang?>">
    <td class="highlight">
    <input type="checkbox" name="name_id[]" class="checkboxes"  value="<?=$v['id']?>">
    </td>
    <td class="ovhide"><span><?=$v['space']?></span><span data-pk="<?=$v['id']?>"  data-type="text" data-lang="<?=$get_lang?>"  class="ajaxItem editable editable-click tooltips" data-original-title="<?php echo lang('click_to_edit');?>"><?=$v['title']?></span></td>
    <td class="hidden-xs">
        <a href="#" data-type="select" data-pk="<?=$v['id']?>" data-lang="<?=$get_lang?>" (<?php echo lang('number_error');?>)" class="editable editable-click sortItem tooltips" data-original-title="<?php echo lang('click_to_edit_order');?>"> <?=$v['order_by']?> </a>
        </td>
    <td class="sort-wr"><?php if($v['status']==1) { ?>
        <a class="btn default btn-xs green-stripe active_status tooltips" data-title="<?php echo lang('click_to_change_status');?>" data-status="<?=$v['status']?>"><?php echo lang('showing');?></a>
        <?php } else { ?><a class="btn default btn-xs red-stripe active_status tooltips" data-title="<?php echo lang('click_to_change_status');?>" data-status="<?=$v['status']?>"><?php echo lang('hiding');?></a><?php } ?>
        </td>
    <td class="atc-wr"><a href="#" class="btn default btn-xs green tooltips" data-placement="top" data-original-title="<?php echo lang('view_details');?>"><i class="fa fa-eye"></i></a>
        <a href="<?=$_B['home']?>/album-categoryUpdate-<?=$v['id']?>-<?=$get_lang?>" class="btn default btn-xs yellow tooltips" data-placement="top" data-original-title="<?php echo lang('edit');?>"><i class="fa fa-edit"></i></a>
        <a class="btn default btn-xs red tooltips delete_category" style="margin-right: 0" data-placement="top" data-original-title="<?php echo lang('delete');?>"><i class="fa fa-trash-o"></i></a>
        </td>
</tr>
<?php if(sizeof($v['sub'])>0 ) { ?>
<?php if(is_array($v['sub'])) { foreach($v['sub'] as $k => $v) { ?>
<?php include $_B['temp']->load('category_list') ?>
<?php } } ?>
<?php } ?>
<?php } } ?>

</tbody>
</table>
</div>
<?php } else { ?>
<div class="alert alert-warning">
<center><?php echo lang('no_data');?></center>
</div>
<?php } ?>
<!--search end-->
                
            <?php if($paging) { ?>
            <?=$paging?>
            <?php } ?>
                </div>
                
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="copyCat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <form role="form" id="formCopy" action="/album-category-ajaxCopyCategory-lang-<?=$_GET['lang']?>">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo lang('copy_cate');?></h4>
              </div>
              <div class="modal-body">
                <div class="note note-warning">
                    <p class="block">
                        <?php echo lang('copy_cate_note');?>.<br>
                    </p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label><?php echo lang('select_lang');?></label>
                        <select name="langData" class="form-control">
                            <?php if(is_array($_DATA['lang_use'])) { foreach($_DATA['lang_use'] as $k => $v) { ?>
                                
                                    <option value="<?=$v?>"><?php echo lang('lang_'.$v);?></option>
                                
                            <?php } } ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label><?php echo lang('delete_all_cate');?></label> <br>
                        <input class="form-control" value="1" type="checkbox" name="emptyData"> <?php echo lang('empty_for_copy');?>
                    </div>
                    <input type="hidden" name="currentLang" value="<?=$_GET['lang']?>">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close');?></button>
                <button type="submit" class="btn btn-primary"><?php echo lang('ok');?></button>
              </div>
            </div>
          </div>
          </form>
</div>
<div id="deleteItemDialog" style="display: none"><li class="list-group-item list-group-item-warning"><?php echo lang('delete_item_dialog');?></li></div>
<div id="deleteAllDialog" style="display: none"><li class="list-group-item list-group-item-warning"><?php echo lang('delete_all_dialog');?></li></div>
<!-- BEGIN PLUGINS USED BY X-EDITABLE -->
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/moment.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery.mockjax.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/inputs-ext/address/address.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/inputs-ext/wysihtml5/wysihtml5.js"></script>
<link href="<?=$_B['mod_theme']?>css/category.css?rs=<?=$reload?>" rel="stylesheet" type="text/css" />
<!-- END X-EDITABLE PLUGIN -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?=$_B['mod_theme']?>js/category.js?rs=<?=$reload?>"></script>
<script type="text/javascript">
jQuery(document).ready(function() { 
var person = new Array()
    person["ok"] = "<?php echo lang('ok');?>";
    person["cancel"] = "<?php echo lang('cancel');?>";  
    person["hiding"] = "<?php echo lang('hiding');?>"; 
    person["showing"] = "<?php echo lang('showing');?>"; 
    person["alert"] = "<?php echo lang('alert');?>"; 
   category.init(person);
});
</script>
<!-- END JAVASCRIPTS -->

