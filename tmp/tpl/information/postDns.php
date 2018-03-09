<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/information/postDns.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><?php if(isset($dns)) { ?>
<?php $i = 1 ?>
<div class="tab-pane">
<div class="table-scrollable ">
<table class="table table-striped table-bordered table-advance table-hover">
<thead>
<tr>
<th>STT</th>
<th>Tên</th>
<th>Loại record</th>
<th>Địa chỉ IP</th>
</tr>
</thead>
<tbody>
<?php if(is_array($dns)) { foreach($dns as $k => $v) { ?>
<tr>
<td >
<?=$i?>
</td>
<td>
<?=$v['name']?>
</td>
<td>
<?=$v['type']?>
</td>
<td>
<?=$v['content']?>
</td>
</tr>
<?php $i++ ?>
<?php } } ?>
</tbody>
</table>
</div>
</div>

<?php } else { ?>
<div>
<div class="table-scrollable">
<table class="table table-striped table-bordered table-advance table-hover">
<thead>
<tr>
<th>STT</th>
<th>Tên</th>
<th>Loại record</th>
<th>Địa chỉ IP</th>
</tr>
</thead>
<tbody>
<tr>
<td>1</td>
<td>nguyenbahuong.com</td>
<td>A</td>
<td>123.30.212.168</td>						
</tr>
<tr>
<td>2</td>
<td>nguyenbahuong.com</td>
<td>A</td>
<td>123.30.212.168</td>
</tr>
<tr>
<td>3</td>
<td>nguyenbahuong.com</td>
<td>MX</td>
<td>aspmx2.googlemail.com</td>
</tr>
</tbody>
</table>
</div>
</div>
<?php } ?>