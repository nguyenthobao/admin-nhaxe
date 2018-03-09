<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/menu/menu_cat_listfix.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><select class="form-control" name="parent_id" data-error="">
<option value="0" <?php if(isset($_DATA['content']) && $_DATA['content']['parent_id']==0) { ?>selected<?php } ?>>Không chọn</option>
<?php if(is_array($_DATA['menu'])) { foreach($_DATA['menu'] as $k => $v) { ?>
<option value="<?=$v['id']?>" <?php if(isset($_DATA['content']) && $_DATA['content']['parent_id']==$v['id']) { ?>selected<?php } ?>><?=$v['line']?> <?=$v['namemenu']?></option>
<?php } } ?>
</select>