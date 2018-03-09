<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/footer.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><!-- BEGIN FOOTER -->
<div class="page-footer">
<div class="page-footer-inner">
  Copyright AnVui @2017
</div>
<div class="page-footer-tools">
<span class="go-top">
<i class="fa fa-angle-up"></i>
</span>
</div>
</div>


 

 

<style type="text/css">
#listFeature > li{
list-style: none;
}
#listFeature > .spFeature{
    color: #c52727;
    font-weight: bold;
    margin-bottom: 15px;
}
#commentButton .icon-pencil
{
line-height: 35px;
color: #fff !important;
}
#commentButton
{
display: block;
width: 35px;
height: 35px;	
-webkit-border-radius: 50% !important;
-moz-border-radius: 50% !important;
border-radius: 50% !important;
line-height: 35px;
position: fixed;
bottom: 100px;
right: 10px;
z-index: 100;
cursor: pointer;
color: #FFF;
background: #35aa47;
white-space: nowrap;
padding: 0px 5px;
/*text-align: center;*/
opacity: 0.8;
box-shadow: 2px 2px 2px #333;
}
#icon_popup
{
display: block;
height: 35px;
width: 150px;
border-radius: 1px !important;
left: 1px;
/*-webkit-border-radius: 50% !important;
-moz-border-radius: 50% !important;*/
/*border-radius: 50% !important;*/
line-height: 35px;
position: fixed;
bottom: 50px;
/*right: 10px;*/
z-index: 100;
cursor: pointer;
color: #FFF;
background: #35aa47;
white-space: nowrap;
padding: 0px 5px;
text-align: center;
opacity: 0.8;
box-shadow: 2px 2px 2px #333;
    -webkit-animation: glowing 1500ms infinite;
    -moz-animation: glowing 1500ms infinite;
    -o-animation: glowing 1500ms infinite;
    animation: glowing 1500ms infinite;
    box-shadow: none !important;
}
.label_size
{
padding-top: 0px !important;
}

</style>

<!-- END FOOTER -->
<!-- BEGIN PAGE LEVEL PLUGINS -->

<script src="<?=$_B['home_theme']?>assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/flot/jquery.flot.pie.min.js"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript">
</script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="<?=$_B['home_theme']?>assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>

<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?=$_B['home_theme']?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/admin/layout/scripts/comment.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/scripts/menu_lang.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/toastr/build/toastr.min.js" type="text/javascript"></script>
<?php if($_GET['mod']=='menu') { ?>
<script src="<?=$_B['home_theme']?>dist/bootstrap-fileinput/js/fileinput.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>dist/bootstrap-fileinput/js/fileinput_locale_LANG.js" type="text/javascript"></script>
<?php } ?>
<script src="<?=$_B['home_theme']?>dist/spin.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>dist/global.js" type="text/javascript"></script>

<div id="spinLoading" style="position: fixed;top: 50%;left:50%;z-index: 10000;"></div>

 

 
 
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {
//
Metronic.init(); // init metronic core componets
Layout.init(); // init layout
QuickSidebar.init(); // init quick sidebar
Index.init();   
MenuTabLang.init();//process menu language

//Index.initCharts();
// Comment.init();
$('#commentButton').on('click', function() {
        bootbox
            .dialog({
                title: 'Góp ý version 2.0',
                message: $('#frm_details'),
                show: false // We will show it manually later
            })
            .on('shown.bs.modal', function() {
                $('#frm_details')
                    .show()                             // Show the login form
                    
            })	
            .on('hide.bs.modal', function(e) {
                // Bootbox will remove the modal (including the body which contains the login form)
                // after hiding the modal
                // Therefor, we need to backup the form
                $('#frm_details').hide().appendTo('body');
            })
            .modal('show');
    });
$('#frm_details').click(function(){
Comment.init();
form.submit();
});
    
});

$( document ).ajaxError(function(e, x, settings, exception) {
    var message;
    var statusErrorMap = {
       400 : "Server understood the request, but request content was invalid.",
       401 : "Unauthorized access.",
       403 : "Bạn không được cấp quyền sử dụng chức năng này.",
       404 : "Đường dẫn không tồn tại.",
       500 : "Internal server error.",
       503 : "Service unavailable."
     };
    if(x.status==403){
    	toastr.error(statusErrorMap[x.status]);
    return false;	
    }
    
});
<?php $nxt_perm=$_B['active_perm'][$_GET['mod']] ?>
<?php if($_B['user_perm']!='boss') { ?>
//$('.portlet-body').hide();
$('body').find('a,button').each(function(v, k) {
var attrHref=$(this).attr('href');
// var listArray
//if(attrHref!='#' && attrHref!='javascript:void(0)'){ //Co link
var tmp_title=$(this).text().toLowerCase();
//Quyen add
<?php if($nxt_perm['perm_add']==false) { ?>
if(tmp_title.indexOf('đăng')!=-1 || tmp_title.indexOf('thêm')!=-1 || tmp_title.indexOf('add')!=-1 || tmp_title.indexOf('post')!=-1 || tmp_title.indexOf('copy')!=-1 || tmp_title.indexOf('sao chép')!=-1){
$(this).remove();
}
<?php } ?>
// //Quyen edit
<?php if($nxt_perm['perm_edit']==false) { ?>
if($(this).children('i').hasClass('fa-edit') || $(this).children('i').hasClass('fa-history')){
$(this).remove();
}
<?php } ?>




// //Quyen delete
<?php if($nxt_perm['perm_del']==false) { ?>
if($(this).children('i').hasClass('fa-trash-o')){
$(this).remove();
}
<?php } ?>



// //Quyen view
<?php if($nxt_perm['perm_view']==false) { ?>
 if($(this).children('i').hasClass('fa-eye')){
$(this).remove();
}
<?php } ?>


//}
});
//Khong co quyen sua
<?php if($nxt_perm['perm_full']==false && $nxt_perm['perm_edit']==false) { ?>
$('body').find('.editable').each(function(k, v) {
if($(this).hasClass('sortItem')==false){
$(this).removeAttr('class');
}
});
$('body').find('span.fileinput-exists').remove();
$('body').find('span.fileinput-new').remove();
$('body').find('.btn-change').remove();	
<?php } ?>
<?php } ?>
$('#main-content').slideDown(500);
</script>
 
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>