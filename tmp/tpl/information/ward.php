<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/information/ward.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?> 	<select class="form-control" name="wardid" data-error="<?php echo lang('contactinfo_error');?>" id="wardid">

<option value=""><?php echo lang('choose_wardid');?></option>

<?php if(isset($information)) { ?>
<?php if(is_array($information)) { foreach($information as $k => $v) { ?>
<option value="<?=$v['name']?>-<?=$v['wardid']?>" data-id="<?=$v['wardid']?>"><?=$v['name']?></option>
<?php } } ?>
<?php } ?>
</select>