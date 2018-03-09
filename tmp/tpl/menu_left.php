<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/menu_left.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?> 
<div class="page-sidebar-wrapper">
<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
<div class="page-sidebar navbar-collapse collapse">
<!-- BEGIN SIDEBAR MENU -->
<ul class="page-sidebar-menu page-sidebar-menu-hover-submenu <?php if(isset($_GET['page']) && ($_GET['page']=='cart' || $_GET['page']=='Synchronous')) { ?>page-sidebar-menu-closed<?php } ?>" data-auto-scroll="true" data-slide-speed="200">
<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
<li class="sidebar-toggler-wrapper">
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
</li>
<!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
 <li class="sidebar-search-wrapper">
 
<form class="sidebar-search " action="extra_search.html" method="POST">
<a href="javascript:;" class="remove">
<i class="icon-close"></i>
</a>
<!-- <div class="input-group">
<input type="text" class="form-control" placeholder="Search...">
<span class="input-group-btn">
<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
</span>
</div> -->
</form> 
</li>  
<li class="start">
<a href="/home">
<i class="icon-home"></i>
<span class="title">Trang chủ</span> 
</a> 
</li>
<li class="start">
<a target="_blank" href="http://admin.anvui.vn">
<i class="fa fa-bus"></i>
<span class="title">Quản lý đặt xe</span> 
</a> 
</li>


<?php if(is_array($_B['menu'])) { foreach($_B['menu'] as $v) { ?>

<li class="start<?php if($mod==$v['mod'] ) { ?> active open<?php } ?>">
<a href="<?=$v['link']?>">
<i class="<?=$v['icon']?>"></i>
<?php if($v['mod']=='marketing') { ?>
<span class="title"><?=$_L[$v['title']]?> <img src="/themes/default/icon-hot.gif"></span>
<?php } else { ?>
<span class="title"><?=$_L[$v['title']]?></span>
<?php } ?>
<span class="selected"></span>
<span class="arrow open"></span>
</a>
<?php if(isset($v['submenu']) && count($v['submenu']) > 0) { ?>
<ul class="sub-menu">


<?php if(isset($v['submenu']['0']) && is_array($v['submenu']['0'])) { ?>
<?php if(is_array($v['submenu'])) { foreach($v['submenu'] as $vs) { ?>
<li>
<a href="<?=$vs['link']?>">
<i class="<?=$vs['icon']?>"></i>
<?=$_L[$vs['title']]?></a>
<?php if(isset($vs['submenu']) && ($c = count($vs['submenu']) > 0)) { ?>
<ul class="sub-menu">
<?php if(isset($vs['submenu']['0']) && is_array($vs['submenu']['0'])) { ?>
<?php if(is_array($vs['submenu'])) { foreach($vs['submenu'] as $vss) { ?>
<li>
<a href="<?=$vss['link']?>">
<i class="<?=$vss['icon']?>"></i>
<?=$_L[$vss['title']]?></a>
</li> 
<?php } } ?>
<?php } else { ?>
<li>
<a href="<?=$vs['submenu']['link']?>">
<i class="<?=$vs['submenu']['icon']?>"></i>
<?=$_L[$vs['submenu']['title']]?></a>
</li> 
<?php } ?>

</ul>
<?php } ?>
</li> 
<?php } } ?>
<?php } else { ?>
<li>
<a href="<?=$v['submenu']['link']?>">
<i class="<?=$v['submenu']['icon']?>"></i>
<?=$_L[$v['submenu']['title']]?></a>
<?php if(isset($vs['submenu']) && ($c = count($v['submenu']['submenu']) > 0)) { ?>
<ul class="sub-menu">
<?php if(is_array($v['submenu']['submenu']['0'])) { ?>
<?php if(is_array($v['submenu']['submenu'])) { foreach($v['submenu']['submenu'] as $vss) { ?>
<li>
<a href="<?=$vss['link']?>">
<i class="<?=$vss['icon']?>"></i>
<?=$_L[$vss['title']]?></a>
</li> 
<?php } } ?>
<?php } else { ?>
<li>
<a href="<?=$v['submenu']['submenu']['link']?>">
<i class="<?=$v['submenu']['submenu']['icon']?>"></i>
<?=$_L[$v['submenu']['submenu']['title']]?></a>
</li> 
<?php } ?>

</ul>
<?php } ?>
</li> 
<?php } ?>
</ul>
<?php } ?>
</li>
<?php } } ?>
 
</ul>
<!-- END SIDEBAR MENU -->
</div>
</div>
<!-- END SIDEBAR