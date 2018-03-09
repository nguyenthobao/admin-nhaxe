<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/seo/ga_toolbar.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><div class="actions btn-set" style="padding-right: 10px !important;
float: right !important;
margin-top: 10px !important;">

<button class="btn green continue" data-continue="contactlist"><i class="fa fa-check"></i> <?php echo lang('update_content');?></button>
<input type="hidden" name="action" value="addGA">
<input type="hidden" name="lang" value="vi">
<input type="hidden" name="continue" value="addGA">
<input type="hidden" name="issetLangDefault" <?php if(!empty($contactlist['id'])) { ?>value="exist"<?php } ?>>
</div>