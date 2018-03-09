<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/video/videolist.php 
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
<form class="form-horizontal form-row-seperated" action="" id="form_videolist" class="form-horizontal" enctype="multipart/form-data" method="POST">
<input type="hidden" value="" name="action">
<div class="col-md-12">
<div class="portlet">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-navicon"></i><?=$_L['title_manager_mod']?>
</div>

<div class="actions btn-set btn-del col-md-1 rightwidth">
<a class="btn red continue delete_video_select btn-sm disabled"><i class="fa fa-trash-o"></i> <?php echo lang('delete');?></a>
</div>
 
 		
<div class="actions btn-set col-md-1 rightwidth">
<a href="<?=$addVideo?>" class="btn green continue btn-sm"><i class="fa fa-plus"></i> <?php echo lang('add');?></a>
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
<div class="col-md-2 col-padding-10">
<input type="text" class="form-control form-filter input-sm" name="video_title" placeholder="<?php echo lang('search_title');?>" value="<?php if($value['video_title']!='') { ?><?=$value['video_title']?><?php } ?>">
</div>
<div class="col-md-2 col-padding-10">							
<select name="cat_id" class="table-group-action-input form-control input-inline input-sm width-100">
<option value="default"><?php echo lang('video_select_cat');?></option>
<?php if(isset($category)) { ?>
<?php if(is_array($category)) { foreach($category as $k => $v) { ?>
<option value="<?=$v['id']?>" <?php if($value['cat_id']==$v['id']) { ?>selected<?php } ?>> <?=$v['title']?></option>
<?php if(sizeof($v['sub'])>0 ) { ?>
<?php if(is_array($v['sub'])) { foreach($v['sub'] as $k => $v) { ?>
<?php include $_B['temp']->load('category_list_search') ?>
<?php } } ?>		
<?php } ?>
<?php } } ?>
<?php } ?>
</select>
</div>

<div class="col-md-2 col-padding-10">
<select name="is_vip" class="table-group-action-input form-control input-inline input-sm width-100">
<option <?php if($value['is_vip']=='default') { ?>selected<?php } ?> value="default"><?php echo lang('statusvip');?></option>
<option <?php if($value['is_vip']==1) { ?>selected<?php } ?> value="1"> <?php echo lang('vip');?></option>

<option value="0"><?php echo lang('thuong');?></option>

</select>
</div>
<div class="col-md-3 col-padding-10">
<select name="is_hot" class="table-group-action-input form-control input-inline input-sm width-100">
<option <?php if($value['is_hot']=='default') { ?>selected<?php } ?> value="default"><?php echo lang('statushot');?></option>
<option <?php if($value['is_hot']==1) { ?>selected<?php } ?> value="1"> <?php echo lang('hot');?></option>

<option value="0"><?php echo lang('thuong');?></option>

</select>
</div>
<div class="col-md-2 col-padding-10">
<?php if($_B['user_perm']!='boss') { ?>
Không có quyền
<?php } else { ?>
<select name="status_video" class="table-group-action-input form-control input-inline input-sm width-100">
<option <?php if($value['status_video']=='default') { ?>selected<?php } ?> value="default"><?php echo lang('status');?></option>
<option <?php if($value['status_video']==1) { ?>selected<?php } ?> value="1"> <?php echo lang('show');?></option>

<option value="0"><?php echo lang('hide');?></option>
<option <?php if($value['status_video']==2) { ?>selected<?php } ?>  value="2"> <?php echo lang('status_clock');?> </option>
</select>
<?php } ?> 	
</div>
<div class="col-md-1 col-padding-10">
<button id="bnt_search" class="btn btn-sm green table-group-action-submit" data-continue="videolist"><i class="fa fa-search"></i> <?php echo lang('search');?></button>
</div>




</div>



<?php if(!empty($cat['data'])) { ?>	
<div class="table-scrollable">
<table id="videolist" data-lang="<?=$_GET['lang']?>" class="table table-striped table-bordered table-advance table-hover">
<thead>
<tr >
<th width="20">
<input type="checkbox" id="checkboxAll" value="">
</th>
<th width="120" class="hidden-xs">
<?php echo lang('ava');?>

</th>
<th class="highlight">
<?php echo lang('video_title');?> 

</th>

<th class="hidden-xs" width="35">
<?php echo lang('sort');?>
</th>
<th width="95" class="hidden-xs">
<?php echo lang('vip');?> / <?php echo lang('hot');?>
</th>

<th width="95" class="hidden-xs">
<?php echo lang('status');?>
</th>
<th width="140">	<?php echo lang('active');?>
</th>
</tr>
</thead>
<tbody>

<?php if($cat) { ?>
<?php if(is_array($cat['data'])) { foreach($cat['data'] as $k => $v) { ?>
<tr id="tr_<?=$v['id']?>" data-key="<?=$v['id']?>" data-lang="<?=$_GET['lang']?>">
<td class="highlight">
<input type="checkbox" name="nameid[]" class="checkboxes delete_multi_video"  value="<?php if(!empty($v['id'])) { ?><?=$v['id']?><?php } ?>">
</td>
<td class="hidden-xs">
<div class="list-cat-img">
<div class="<?php if(!empty($v['img'])) { ?>fileinput-exists<?php } else { ?>fileinput-new<?php } ?>" data-provides="fileinput">
<div class="fileinput-new thumbnail">
<img src="<?=$_B['home_theme']?>assets/no_image.gif" alt="Avatar" class="imgkhung"/>
</div>
<div class="fileinput-preview fileinput-exists thumbnail">
<img src="<?=$_B['upload_path']?><?=$v['img']?>" onerror="this.onerror=null;this.src='<?=$_B['home_theme']?>assets/no_image.gif'" alt="" class="imgkhung"/>
</div>
<div class="btn-all">
<span class="btn btn-xs default btn-file btn-change" style="display:none">
<span class="fileinput-new">
<?php echo lang('select_img');?> </span>
<span class="fileinput-exists">
<?php echo lang('select_img');?> </span>
<input type="file" name="img_video_<?=$v['id']?>">
</span>
</div>
</div>	
</div>
</td>
</td>
<td >
 <span><?php if(!empty($v['space'])) { ?><?=$v['space']?><?php } ?></span><span class="catItem editable editable-click nonebottom tooltips btn" data-pk="<?php if(!empty($v['id'])) { ?><?=$v['id']?><?php } ?>"  data-type="text" data-lang="<?=$_GET['lang']?>" data-original-title="<?php echo lang('editsort');?>"><?php if(!empty($v['title'])) { ?><?=$v['title']?><?php } ?></span>

</td>
<td class="hidden-xs center">
<!-- <span data-pk="<?=$v['id']?>"  data-original-title="<?php echo lang('sort');?> (<?php echo lang('number_error');?>)" data-type="text" data-lang="<?=$_GET['lang']?>" class="editable editable-click sortItem"><?=$v['sort']?></span> -->
<a href="#" data-type="select" data-pk="<?=$v['id']?>" data-value="<?=$v['sort']?>" data-original-title="<?php echo lang('clickedit');?> (<?php echo lang('number_error');?>)" class="editable editable-click orderItem tooltips">
<?php if(isset($v['sort'])) { ?><?=$v['sort']?> <?php } ?></a>
</td>
<td class="hidden-xs">
<?php if($v['is_vip']==0) { ?>
<a class="btn default btn-xs green-stripe active_vip" data-vip="<?=$v['is_vip']?>" style="width:73px"><?php echo lang('thuong');?></a>
<?php } else { ?>
<a class="btn default btn-xs yellow-stripe active_vip" data-vip="<?=$v['is_vip']?>" style="width:73px"><?php echo lang('vip');?></a>
<?php } ?>
<?php if($v['is_hot']==0) { ?>
<a class="btn default btn-xs green-stripe active_hot" data-hot="<?=$v['is_hot']?>" style="width:73px"><?php echo lang('thuong');?></a>
<?php } else { ?>
<a class="btn default btn-xs yellow-stripe active_hot" data-hot="<?=$v['is_hot']?>" style="width:73px"><?php echo lang('hot');?></a>
<?php } ?>
</td>

<td class="hidden-xs">
<?php if($v['status']==2) { ?>
<a class="btn default btn-xs yellow-stripe active_post tooltips" data-status="<?=$v['status']?>" style="width:73px" data-title="<?php echo lang('postclick');?>"><?php echo lang('status_clock');?></a>
<?php } else { ?>
<?php if($v['status']==1) { ?>
<a class="btn default btn-xs green-stripe active_status" data-status="<?=$v['status']?>" style="width:73px"><?php echo lang('show');?></a>
<?php } else { ?>
<a class="btn default btn-xs red-stripe active_status" data-status="<?=$v['status']?>" style="width:73px"><?php echo lang('hide');?></a>
<?php } ?>
<?php } ?>
</td>
<td>
<a  class="btn default btn-xs blue tooltips refesh_video" data-placement="top" data-original-title="<?php echo lang('refesh');?>"><i class="fa fa-history"></i></a>

<a href="<?=$v['link']?>" target="_blank" class="btn default btn-xs green tooltips" data-placement="top" data-original-title="<?php echo lang('view');?>"><i class="fa fa-eye"></i></a>
<!-- <a href="#" class="btn default btn-xs grey-cascade tooltips fast-edit" data-placement="top" data-original-title="Sửa nhanh"><i class="fa fa-send"></i></a> -->
<a href="video-video-<?=$v['id']?>-<?=$_GET['lang']?>" class="btn default btn-xs yellow tooltips" data-placement="top" data-original-title="<?php echo lang('edit');?>"><i class="fa fa-edit"></i></a>
<a  class="btn default btn-xs red tooltips delete_video"  data-placement="top" data-original-title="<?php echo lang('delete');?>"><i class="fa fa-trash-o"></i></a>
</td>
</tr>

<?php } } ?>	

<?php } ?>		
</tbody>
</table>
</div>
<?php if(isset($cat['pagination'])) { ?>
<?=$cat['pagination']?>
<?php } ?>
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
<form role="form" id="formCopy" action="/video-videolist-ajaxCopyVideo-lang-<?=$_GET['lang']?>">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">Sao chép video</h4>
      </div>
      <div class="modal-body">
        <div class="note note-warning">
            <p class="block">
                - Bạn có thể sao chép được toàn bộ video sang ngôn ngữ được định sẵn.<br>
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
                <label>Bạn có muốn xóa tất cả video ?</label> <br>
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
<script src="<?=$_B['mod_theme']?>js/videolist.js"></script>

<script>
        jQuery(document).ready(function() {    
           VideoList.init();
           $(document).keydown(function(e) {
if (e.keyCode == 13) {// mã của phím enter				
   	$('input[name="action"]').val("searchVideo");
            $('#form_videolist').submit();    //submit form có id là: "form"
   }
});
        });
    </script>
<!-- END JAVASCRIPTS -->

