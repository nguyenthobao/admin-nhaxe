<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/contact/contactview.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/inputs-ext/address/address.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/css/components.css"/>
<link href="<?=$_B['mod_theme']?>css/style1.css" rel="stylesheet" type="text/css" />
<!-- BEGIN PAGE CONTENT-->
<div class="row">
<div class="col-md-12">
<form class="form-horizontal form-row-seperated" action="" id="form_contactview" class="form-horizontal" enctype="multipart/form-data" method="POST">
<input type="hidden" value="deleteMultiID" name="action">

<div class="portlet">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-navicon"></i><?php echo lang('title_manager_mod');?>
</div>
<div>
<div class="actions btn-set btn-del  ">
<div class="actions btn-set btn-del">
<a  class=" col-b-del btn btn-sm red continue delete_contactview_select disabled"><i class="fa fa-trash-o"></i> <?php echo lang('delete');?></a>
</div>

</div>
<div class="actions btn-set btn-add ">
<div class="actions btn-set btn-del">
<a class=" col-b-del btn btn-sm green continue btn_feedback_add  disabled"><i class="fa fa-mail-reply"></i> <?php echo lang('ctfeedback');?></a>
</div>

</div>
</div>


</div>
<div class="portlet-body">
<?php if(isset($_SESSION['error_submit'])) { ?>
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
<div class="tabbable">
<ul class="nav nav-tabs">
<?php if(is_array($url_lang)) { foreach($url_lang as $k_lang => $v_lang) { ?>
<li <?php if($k_lang==$_GET['lang']) { ?>class="active"<?php } ?> >
<a href="<?=$_B['home']?>/contact-contactview-lang-<?=$k_lang?>" class="select_lang" data-lang="<?=$k_lang?>"><?php echo lang('lang_'.$k_lang);?> </a>
</li>
<?php } } ?>
</ul>
</div>
<div class="form-group row-search">
<div class="  col-md-2 col-padding-10">
<input class="form_datetime form-control form-filter input-sm" type="text" placeholder="<?php echo lang('search_date');?>" data-date="12-02-2012" data-date-format="dd-mm-yyyy" data-date-viewmode="years" value="<?=$value['create_time']?>" name="create_time" id="datetime">
</div>
<div class="col-md-2 col-padding-10">
<input type="text" class="form-control form-filter input-sm" name="search_customers" value="<?=$value['search_customers']?>" placeholder="<?php echo lang('search_customers');?>" id="customers">
</div>
<div class="col-md-2 col-padding-10">
<input type="text" class="form-control form-filter input-sm" name="search_phone" placeholder="<?php echo lang('search_phone');?>" value="<?=$value['search_phone']?>" id="phone">
</div>
<div class="col-md-2 col-padding-10">
<input type="text" class="form-control form-filter input-sm" name="search_email" placeholder="<?php echo lang('search_mail');?>" value="<?=$value['search_email']?>" id='email'>
</div>

<div class="col-md-2 col-padding-10 col-width-1">
<select name="status_news" class="table-group-action-input form-control input-inline input-sm width-100">
<option value="all" <?php if($value['status_news']=='all') { ?>selected<?php } ?>><?php echo lang('status');?></option>
<option value="1" <?php if($value['status_news']=='1') { ?>selected<?php } ?>><?php echo lang('view');?></option>
<option value="0" <?php if($value['status_news']=='0') { ?>selected<?php } ?>><?php echo lang('not_view');?></option>
</select>
</div>
<div class="col-md-1 col-padding-10">
<button id="bnt_search" class="btn btn-sm green table-group-action-submit search_contact" ><i class="fa fa-search"></i> <?php echo lang('search');?></button>
</div>
</div>
<?php if(!empty($contact['data'])) { ?>
<div class="table-scrollable">
<table id="contactview" data-lang="<?=$_GET['lang']?>"data-viewf="<?php echo lang('feedbackmail');?>"data-title ="<?php echo lang('title_mail');?>" data-content="<?php echo lang('content');?>"data-viewbb="<?php echo lang('contentmail');?>" class="table table-striped table-bordered table-advance table-hover"data-lang-a="<?php echo lang('delete_contact_add');?>" data-lang-j="<?php echo lang('delete_contact');?>" data-error-mail="<?php echo lang('error_mail');?>" data-success-mail="<?php echo lang('success_mail');?>">
<thead id="result">
<tr >
<th width="20">
<input type="checkbox" id="checkboxAll">
</th>
<th  width="200" >
<?php echo lang('customers');?>
</th>
<th  width="100" >
<?php echo lang('phone');?>
</th>
<th  width="200">
<?php echo lang('gmail');?>
</th>
<th width="150">
<?php echo lang('datetime');?>
</th>
<th width="80">
<?php echo lang('status');?>
</th>
<th width="120" >
<?php echo lang('action');?>
</th>
</tr>
</thead>
<tbody>	
<?php if(!empty($contact['data'])) { ?>
<?php if(is_array($contact['data'])) { foreach($contact['data'] as $k => $v) { ?>


<div id="contactshow">
<tr   id="tr_<?=$v['id']?>" data-key="<?=$v['id']?>" data-lang="<?=$_GET['lang']?>" data-error="{lang error-delete}"data-error-mail="<?php echo lang('error_mail');?>" data-success-mail="<?php echo lang('success_mail');?>" data-view="<?php echo lang('readed');?>"data-viewa="<?php echo lang('customers');?>"data-viewb="<?php echo lang('email');?>"data-viewc="<?php echo lang('phone');?>"data-viewd="<?php echo lang('address');?>"data-viewe="<?php echo lang('content');?>" data-content="<?=$v['content_base64']?>"data-answer="<?=$v['content_answer_base64']?>" data-address="<?=$v['address']?>"data-viewf="<?php echo lang('feedbackmail');?>"data-title ="<?php echo lang('title_mail');?>" data-viewcontact="<?php echo lang('contactfrom');?>" datetime="<?=$v['update_time']?>">
<td style="text-align:center" >
<input type="checkbox" name="name_id[]" class="checkboxes"  value="<?=$v['id']?>">
</td>
<td class="ct_customers">
<?=$v['customers']?>
</td>
<td class="ct_phone">
<?=$v['phone']?>
</td>
<td class="ct_email">
 <?=$v['email']?>
</td>

<td class="ct_datetime">
<?=$v['create_time']?>
</td>
<td style="text-align:center">
<?php if($v['status']==1) { ?>
<span class="btn default btn-xs green-stripe active_status" data-status="<?=$v['status']?>" style="width:73px"><?php echo lang('view');?></span>
<?php } else { ?>
<span class="btn default btn-xs red-stripe active_status" data-status="<?=$v['status']?>" style="width:73px"><?php echo lang('not_view');?></span>
<?php } ?>
</td>
<td style="text-align:center" >
<a class="btn default btn-xs blue tooltips refesh_news" data-placement="top" data-original-title="<?php echo lang('view_feedback');?>"><i class="fa fa-envelope-o"></i></a>
<a  class="btn default btn-xs yellow tooltips btn_feedback" data-placement="top" data-original-title="<?php echo lang('ctfeedback');?>"><i class="fa fa-mail-reply"></i></a>
<a class="btn default btn-xs green tooltips btn_view view_contact" data-original-title="<?php echo lang('viewdl');?>"><i class="fa fa-eye" class="btn default"></i></a>
<a  class="btn default btn-xs red tooltips delete_contact"  data-placement="top" data-original-title="<?php echo lang('delete');?>"><i class="fa fa-trash-o"></i></a>
</td>
</tr>
</div>

<?php } } ?>							
<?php } else { ?>				
<?php } ?>						
</tbody>
</table>
</div>
<?php } else { ?>
<div class="alert alert-warning">
<center><?php echo lang('notfound');?></center>
</div>
<?php } ?>
<?php if(isset($contact['pagination'])) { ?>
<?=$contact['pagination']?>
<?php } ?>
</div>	
</div>
</form>
</div>
</div>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/moment.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery.mockjax.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/inputs-ext/address/address.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-editable/inputs-ext/wysihtml5/wysihtml5.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script src="<?=$_B['mod_theme']?>js/contactview.js"></script>

<script>
    jQuery(document).ready(function() {    
       ContactView.init();
         $('.form-filter').keydown(function(e) {
if (e.keyCode == 13) {// mã của phím enter				
   	$('input[name="action"]').val("searchContact");
            $('#form_contactview').submit();    //submit form có id là: "form"
   }
});
    });
</script>
<!-- END JAVASCRIPTS -->

