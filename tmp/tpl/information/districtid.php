<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/information/districtid.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?>     <select class="form-control" name="districtid" data-error="<?php echo lang('contactinfo_error');?>" id="districtid">

<option value="<?php if(!empty($advertisers_edit['district'])) { ?><?=$advertisers_edit['district']?>-<?=$advertisers_edit['districtid']?><?php } else { ?><?php } ?>"><?php if(!empty($advertisers_edit['district'])) { ?><?=$advertisers_edit['district']?><?php } else { ?><?php echo lang('choose_districtid');?><?php } ?></option>

<?php if(isset($information)) { ?>
<?php if(is_array($information)) { foreach($information as $k => $v) { ?>
<option value="<?=$v['name']?>-<?=$v['districtid']?>" data-id="<?=$v['districtid']?>"><?=$v['name']?></option>
<?php } } ?>
<?php } ?>
</select>

