<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/notify/ajaxShowNotify.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
<i class="icon-bell"></i>
<span class="badge badge-default">
<?=$_DATA['count']?> </span>
</a>
<ul class="dropdown-menu">

<li>
<p id="countNewNotify">
 <?php echo lang('ban_co');?> <?=$_DATA['count']?> <?php echo lang('new_thongbao');?> 
</p>
</li>


<li>
<ul class="dropdown-menu-list scroller" id="liNotify" style="height: 250px;">

<?php if(is_array($_DATA['notify'])) { foreach($_DATA['notify'] as $k => $v) { ?>
<li>
<a href="<?=$v['link']?>">
<?php if($v['type']==1) { ?>
<span class="label label-sm label-icon label-success">
<i class="fa fa-plus"></i>
</span>
<?php } elseif(($v['type']==2)) { ?>
<span class="label label-sm label-icon label-info">
<i class="fa fa-bolt"></i>
</span>
<?php } elseif(($v['type']==3)) { ?>
<span class="label label-sm label-icon label-danger">
<i class="fa fa-ban"></i>
</span>
<?php } ?>
<?=$v['title']?>
<br/>
<small style="margin-left: 26px;"><i class="fa fa-clock-o"></i> <?=$v['time']?></small>
</a>
</li>
<?php } } ?>
</ul>
</li>

<li class="external" id="allExternalMessage">
<a href="/notify-notify-index-lang-vi">
 <?php echo lang('view_all_noti');?> <i class="m-icon-swapright"></i>
</a>
</li>
</ul>
<input type="hidden" value="<?=$_DATA['count']?>" id="isNotifyNew"> 
<input type="hidden" value="<?=$_DATA['sound']?>" id="isNotifyNewSound"> 
