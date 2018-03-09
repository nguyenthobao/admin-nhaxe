<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/menu/menulist_listfix.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?>
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

