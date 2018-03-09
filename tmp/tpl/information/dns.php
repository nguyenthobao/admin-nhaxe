<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/information/dns.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><style>
.tabs-left > .nav-tabs{
float: left;
margin-right:0px;
border-right: 1px solid #ddd;
padding-right: 0px;
}
.table-scrollable{
margin-top:0px !important;
}
.col-md-9-fix{
padding-right: 0px;
}

</style>
<div class="row">
<div class="col-md-12">
<form class="form-horizontal form-row-seperated" action="" id="form_categorylist" class="form-horizontal" enctype="multipart/form-data" method="POST">
<input type="hidden" value="deleteMultiID" name="action">
<div class="portlet">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-th-list"></i><?php echo lang('manager_dns');?>
</div>
<div class="actions btn-set">
<a href="/information-settingdomain-lang-vi" class="btn green">
<i class="fa fa-indent"></i> <?php echo lang('setting_domain');?></a>

</div>
</div>
<div class="portlet-body">
<div class="tabbable tabs-left">
<?php if(isset($dns)) { ?>
<ul class="nav nav-tabs col-md-3 col-sm-3 col-lg-3">
<?php if(is_array($dns['domain'])) { foreach($dns['domain'] as $k => $v) { ?>
<li <?php if($k==0) { ?>class="active"<?php } ?>>
<a href="#tab_6_<?=$k?>" data-toggle="tab">
<?=$v?> </a>
</li>
<?php } } ?>
</ul>

<div class="tab-content col-md-9 col-sm-9 col-lg-9 col-md-9-fix">
<?php if(isset($dns['dns'])) { ?>
<?php $i=0 ?>
<?php if(is_array($dns['dns'])) { foreach($dns['dns'] as $k => $v) { ?>
<div class="tab-pane <?php if($i!=0) { ?>fade<?php } ?> <?php if($i==1) { ?>active in<?php } ?>" id="tab_6_<?=$i?>" 
<?php if($i==0) { ?>style="display:block !important"<?php } ?>>
<div class="table-scrollable ">
<table class="table table-striped table-bordered table-advance table-hover">
<thead>
<tr >
<th><?php echo lang('stt');?></th>
<th><?php echo lang('name');?></th>
<th><?php echo lang('loai_record');?></th>
<th><?php echo lang('diachi_ip');?></th>
</tr>
</thead>
<tbody>
<?php if(is_array($v)) { foreach($v as $k1 => $v1) { ?>
<tr>
<td>
<?php $k1+1 ?>
</td>
<td>
<?=$v1['name']?>
</td>
<td>
<?=$v1['type']?>
</td>
<td>
<?=$v1['content']?>
</td>
</tr>
<?php } } ?>
</tbody>
</table>
</div>
</div>
<?php $i++ ?>
<?php } } ?>
<?php } else { ?>
<div id="tab_6_<?=$i?>">
<div class="table-scrollable ">
<table class="table table-striped table-bordered table-advance table-hover">
<thead>
<tr >
<th><?php echo lang('stt');?></th>
<th><?php echo lang('name');?></th>
<th><?php echo lang('loai_record');?></th>
<th><?php echo lang('diachi_ip');?></th>
</tr>
</thead>
<tbody>
<tr>
<td>1</td>
<td>homanhhung.com</td>
<td>A</td>
<td>123.30.212.168</td>
<!-- <td colspan="4" align="center">
Không tồn tại bản ghi domain này.
</td> -->
</tr>
<tr>
<td>2</td>
<td>homanhhung.com</td>
<td>A</td>
<td>123.30.212.168</td>
</tr>
<tr>
<td>3</td>
<td>homanhhung.com</td>
<td>MX</td>
<td>aspmx2.googlemail.com</td>
</tr>
</tbody>
</table>
</div>
</div>
<?php } ?>
</div>
<?php } ?>	
</div>
</div>
</div>
</form>
</div>
</div>


