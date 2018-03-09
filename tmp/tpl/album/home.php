<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/album/home.php 
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
<link href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>

<link href="<?=$_B['mod_theme']?>css/category.css?rs=<?=$reload?>" rel="stylesheet" type="text/css" />
<link href="<?=$_B['mod_theme']?>css/album.css?rs=<?=$reload?>" rel="stylesheet" type="text/css" />
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal form-row-seperated" action="" id="formList" class="form-horizontal" enctype="multipart/form-data" method="POST">
            <input type="hidden" value="" name="action">
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list"></i><?php echo lang('title_manager_album');?>
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
                    
<!--search-->
<div class="form-group row-search">
<div class="col-md-2 col-padding-10">
<input type="text" id="form-filter" class="form-control form-filter input-sm" name="title" placeholder="<?php echo lang('search_title');?>" <?php if(!empty($value['title'])) { ?>value="<?=$value['title']?>"<?php } ?>>
</div>

<div class="col-md-2 col-padding-10">                           
<select name="category" class="form-filter table-group-action-input form-control input-inline input-sm width-100">
<option value="" ><?php echo lang('tim_theo_danh_muc');?></option>
<?php if(isset($categoryMenu)) { ?>
<?php if(is_array($categoryMenu)) { foreach($categoryMenu as $k => $v) { ?>
<option value="<?=$v['id']?>" <?php if(isset($value['category']) && $value['category']==$v['id']) { ?>selected<?php } ?>><?=$v['space']?> <?=$v['title']?></option>
<?php if(sizeof($v['sub'])>0 ) { ?>
        <?php if(is_array($v['sub'])) { foreach($v['sub'] as $k => $v) { ?>
        <?php include $_B['temp']->load('category_album_list_search') ?>
        <?php } } ?>
<?php } ?>
<?php } } ?>
<?php } ?>
</select>
</div>

<div class="col-md-2 col-padding-10">
<select name="status" class="form-filter table-group-action-input form-control input-inline input-sm width-100">
<option selected value=""><?php echo lang('status');?></option>
<option value="0" <?php if(isset($value['status']) && $value['status']=='0') { ?>selected<?php } ?>><?php echo lang('hiding');?></option>
<option value="1" <?php if(isset($value['status']) && $value['status']==1) { ?>selected<?php } ?>><?php echo lang('showing');?></option>
<option value="2" <?php if(isset($value['status']) && $value['status']==2) { ?>selected<?php } ?>><?php echo lang('hen_dang');?></option>

</select>
</div>
<div class="col-md-1 col-padding-10">
<button id="bnt_search" class="btn btn-sm green table-group-action-submit" data-continue="category"><i class="fa fa-search"></i> <?php echo lang('search');?></button>
</div>
<div class="col-md-5 col-padding-10" style="padding-right: 15px">
<div class="actions btn-set btn-del">
<a class="btn btn-sm red continue delete_album_select disabled" data-continue="delete_album_select"><i class="fa fa-trash-o"></i> <?php echo lang('delete');?></a>
</div>
 
<div class="actions btn-set">
<a href="<?=$_B['home']?>/album-albumNew-lang-vi" class="btn btn-sm green continue"><i class="fa fa-plus"></i> <?php echo lang('add');?></a>
</div>
</div>

</div>
<?php if($homeList) { ?>
<div class="table-scrollable">
<table id="categoryList" data-lang="<?=$get_lang?>" class="table table-striped table-bordered table-advance table-hover">
<thead>
<tr >
<th width="20">
<input type="checkbox" id="checkboxAll" value="">
</th>
<th class="highlight" style="width: 173px">
<?php echo lang('album_images');?>
</th>
<th class="highlight max559">
<?php echo lang('album_name');?>
</th>
<th class="hidden-xs" width="20">
<?php echo lang('sort');?>
</th>
<th width="100">
<?php echo lang('status');?>
</th>
<th width="140"><?php echo lang('action');?>
</th>
</tr>
</thead>
<tbody>

<?php if(is_array($homeList)) { foreach($homeList as $k => $v) { ?>
<tr id="tr_<?=$v['id']?>" data-key="<?=$v['id']?>" data-lang="<?=$get_lang?>">
    <td class="highlight">
    <input type="checkbox" name="name_id[]" class="checkboxes"  value="<?=$v['id']?>">
    </td>
    <td><div class="album_avatar">
        <img id="<?=$v['avatar_id']?>" class="pic" src="<?=$_B['upload_path']?><?=$v['avatar']?>" />
        <button data-avatar="<?=$v['avatar_id']?>" data-id="<?=$v['id']?>" data-title="<?=$v['title']?>" class="choose-avatar" type="button" data-toggle="modal"><?php echo lang('chon_anh_dai_dien');?></button>
        </div></td>
    <td class="ovhide"><span data-pk="<?=$v['id']?>"  data-type="text" data-lang="<?=$get_lang?>"  class="ajaxItem editable editable-click tooltips" data-original-title="<?php echo lang('click_to_edit');?>"><?=$v['title']?></span></td>
    <td class="hidden-xs">
        <a href="#" data-type="select" data-pk="<?=$v['id']?>" data-lang="<?=$get_lang?>" (<?php echo lang('number_error');?>)" class="editable editable-click sortItem tooltips" data-original-title="<?php echo lang('click_to_edit_order');?>"> <?=$v['order_by']?> </a>
        </td>
    <td class="sort-wr">
    <?php if($_B['user_perm']!='boss') { ?>
        Không có quyền
    <?php } else { ?>
        <?php if($v['hide_by_cate']) { ?>
            <span class="glyphicon glyphicon-eye-close tooltips" data-original-title="<?php echo lang('alert_hide_by_cate');?>"></span>
        <?php } else { ?>
        <?php if($v['post_time'] > $time_now) { ?>
                 <a class="btn default btn-xs yellow-stripe active_status tooltips" data-title="<?php echo lang('click_to_change_status');?>" data-status="2"><?php echo lang('hen_dang');?></a>
        <?php } else { ?>
            <?php if($v['status']==1) { ?>
            <a class="btn default btn-xs green-stripe active_status tooltips" data-title="<?php echo lang('click_to_change_status');?>" data-status="<?=$v['status']?>"><?php echo lang('showing');?></a>
            <?php } else { ?><a class="btn default btn-xs red-stripe active_status tooltips" data-title="<?php echo lang('click_to_change_status');?>" data-status="<?=$v['status']?>"><?php echo lang('hiding');?></a><?php } ?>
            <?php } ?>
        <?php } ?>
      <?php } ?>   
    </td>
    <td class="atc-wr">
        <a data-id="<?=$v['id']?>" class="btn default btn-xs blue tooltips refesh_new" data-placement="top" data-original-title="<?php echo lang('go_new');?>"><i class="fa fa-history"></i></a>
        <a href="<?=$v['link']?>" target="_blank" class="btn default btn-xs green tooltips" data-placement="top" data-original-title="<?php echo lang('view_details');?>"><i class="fa fa-eye"></i></a>
        <a href="<?=$_B['home']?>/album-albumUpdate-<?=$v['id']?>-<?=$get_lang?>" class="btn default btn-xs yellow tooltips" data-placement="top" data-original-title="<?php echo lang('edit');?>"><i class="fa fa-edit"></i></a>
        <a class="btn default btn-xs red tooltips delete_category" style="margin-right: 0" data-placement="top" data-original-title="<?php echo lang('delete');?>"><i class="fa fa-trash-o"></i></a>
        </td>
</tr>
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
                
            <?php if(isset($paging)) { ?>
            <?=$paging?>
            <?php } ?>
                </div>
                
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="copyCat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <form role="form" id="formCopy" action="/album-home-ajaxCopyAlbum-lang-<?=$_GET['lang']?>">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo lang('copy_album');?></h4>
              </div>
              <div class="modal-body">
                <div class="note note-warning">
                    <p class="block">
                        <?php echo lang('note_copy_album');?><br>
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
                        <label><?php echo lang('delete_all_album');?></label> <br>
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
<div id="ajax-modal" class="modal hide fade" tabindex="-1"></div>
<div id="deleteItemDialog" style="display: none"><li class="list-group-item list-group-item-warning"><?php echo lang('delete_item_album');?></li></div>
<div id="deleteAllDialog" style="display: none"><li class="list-group-item list-group-item-warning"><?php echo lang('delete_all_album');?></li></div>
<!-- BEGIN PLUGINS USED BY X-EDITABLE -->
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/moment.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery.mockjax.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/inputs-ext/address/address.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/inputs-ext/wysihtml5/wysihtml5.js"></script>

<script src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript" ></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript" ></script>
<script src="<?=$_B['mod_theme']?>js/jquery.form.js"></script>
<script src="<?=$_B['mod_theme']?>js/Ft.uploadfile.js?rs=<?=$reload?>"></script>

<!-- END X-EDITABLE PLUGIN -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?=$_B['mod_theme']?>js/home.js?rs=<?=$reload?>"></script>
<script type="text/javascript">
jQuery(document).ready(function() { 
var person = new Array()
    person["url"] = "<?=$_B['home']?>/album-ajax-lang-<?=$get_lang?>";
    person["urlUpload"] = "<?=$_B['home']?>/album-uploads-lang-<?=$get_lang?>";
    person["f5confirm"] = "<?php echo lang('co_chac_muon_lam_moi_ko');?>";
    person["time_post"] = "<?php echo lang('ban_muon_dang_ngay');?>";
    person["ok"] = "<?php echo lang('ok');?>";
    person["cancel"] = "<?php echo lang('cancel');?>";  
    person["hiding"] = "<?php echo lang('hiding');?>"; 
    person["showing"] = "<?php echo lang('showing');?>"; 
    person["alert"] = "<?php echo lang('alert');?>";
    person["dragDropStr"] = "<?php echo lang('dragDropStr');?>";  
    person["chooseStr"] = "<?php echo lang('chooseStr');?>"; 
    person["abortStr"] = "<?php echo lang('abortStr');?>"; 
    person["delete"] = "<?php echo lang('delete');?>"; 
    person["loadingStr"] = "<?php echo lang('loadingStr');?>"; 
    person["placeholderTextStr"] = "<?php echo lang('placeholderTextStr');?>"; 
    person["placeholderTextAreaStr"] = "<?php echo lang('placeholderTextAreaStr');?>";  
    person["error_just_not_idea"] = "<?php echo lang('error_just_not_idea');?>"; 
    person["do_you_really_want_to_delete"] = "<?php echo lang('do_you_really_want_to_delete');?>";  
    person["do_you_really_want_to_delete_pic"] = "<?php echo lang('do_you_really_want_to_delete_pic');?>"; 
    person["save"] = "<?php echo lang('save');?>"; 
    home.init(person);
});
</script>
<!-- END JAVASCRIPTS -->

