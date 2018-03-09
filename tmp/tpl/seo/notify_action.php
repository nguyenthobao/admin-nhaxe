<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/seo/notify_action.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><?php if(isset($_SESSION['error_submit'])) { ?>
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