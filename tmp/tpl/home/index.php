<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/home/index.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><script src="<?=$_B['mod_theme']?>/js/process.js" type="text/javascript"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
<script src="<?=$_B['mod_theme']?>/js/morris.min.js" type="text/javascript"></script>

<script src="http://bncvn.net/truongdev/adminuser/analytics/js/plugins/flot/excanvas.min.js"></script>
    <script src="<?=$_B['mod_theme']?>/js/jquery.flot.js"></script>
    <script src="<?=$_B['mod_theme']?>/js/jquery.flot.pie.js"></script>
    <script src="http://bncvn.net/truongdev/adminuser/analytics/js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="<?=$_B['mod_theme']?>/js/jquery.flot.tooltip.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?=$_B['mod_theme']?>/js/morris.css">
<div class="row">
    
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat red-intense">
            <div class="visual">
                <i class="fa fa-newspaper-o"></i>
            </div>
            <div class="details">
                <div id="number-product" class="number">
                    0
                </div>
                <div class="desc" style="white-space: nowrap;">
                    Tin tức
                </div>
            </div>
            <a class="more"   href="http://adminweb.anvui.vn/news-newslist-lang-vi">
            Xem chi tiết <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat green-haze">
            <div class="visual">
                <i class="fa fa-picture-o"></i>
            </div>
            <div class="details">
                <div id="number-order" class="number">
                    0
                </div>
                <div class="desc" style="white-space: nowrap;">
                    Album
                </div>
            </div>
            <a class="more"  href="http://adminweb.anvui.vn/album-albums">
            Xem chi tiết <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat blue-madison">
            <div class="visual">
                <i class="fa fa-youtube-play"></i>
            </div>
            <div class="details">
                <div id="number-feedback" class="number">
                    0
                </div>
                <div class="desc" style="white-space: nowrap;">
                    Video
                </div>
            </div>
            <a class="more" href="http://adminweb.anvui.vn/video-videolist-lang-vi">
            Xem chi tiết <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat purple-plum">
            <div class="visual">
                <i class="fa fa-envelope"></i>
            </div>
            <div class="details">
                <div id="number-contact" class="number">
                    0
                </div>
                <div class="desc" style="white-space: nowrap;">
                    Liên hệ
                </div>
            </div>
            <a class="more"   href="#">
            Xem chi tiết <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
</div>

<div class="clearfix"></div> 

  
<div class="row">
        <div class="col-md-6">
                <h3>Quản lý tài khoản</h3> 
                <div class="form-group">
                    <label class="col-md-4 control-label">Mật khẩu cũ</label>
                    <div class="col-md-8">
                        <input type="password" class="form-control" id="txtpassword" name="password" value="" placeholder="Mật khẩu "> 
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Mật khẩu mới</label>
                    <div class="col-md-8">
                        <input type="password" class="form-control" id="txtpassword1" name="password1" value="" placeholder="Mật khẩu mới"> 
                    </div>
                </div>

                <div class="form-group">
                <label class="col-md-4 control-label">Nhập lại mật khẩu</label>
                <div class="col-md-8">
                <input type="password" class="form-control" id="txtpassword2" name="password2" value="" placeholder="Nhập lại mật khẩu"> 
                </div>
                </div>
                <div class="form-group">
                <label class="col-md-4 control-label"></label>
                <div class="col-md-8">
                <button type="button" class="btn btn-primary change_pass">Thay đổi mật khẩu</button>
                </div>
                </div>
        </div>
<div class="col-md-6">
 
 
</div>
<style type="text/css">
.form-group{
height: 30px;
}
</style>
<script type="text/javascript">
$('.change_pass').click(function(){
var pass = $('#txtpassword').val();
var pass1 = $('#txtpassword1').val();
var pass2 = $('#txtpassword2').val();

if(pass1 =='' || pass == '' || pass1 == ''){
alert('Hãy điền đầy đủ thông tin!');
return false;
}

if(pass1 != pass2){
alert('Mật khẩu mới chưa trùng khớp!');
return false;
}

 $.ajax({
        url:'/?changepass=1',
        type:'POST',
        dataType:'json',
        data:{ajaxaction:'changepass',pass: pass, pass1: pass1},
        success:function(res){ 
            if (res.status==false) {
                alert('Mật khẩu cũ không chính xác!'); 
            }
            else
            {
                alert('Đổi mật khẩu thành công!');
                $('#txtpassword').val('');
$('#txtpassword1').val('');
$('#txtpassword2').val(''); 
            }
        },
        error:function(e){
            console.log(e);
        }
    })
});
</script>
  
<!-- END DASHBOARD STATS -->

</div>



 
<script type="text/javascript">
   
    
  

</script>
<style type="text/css">
#site_statistics_loading, #pie_chart_3_loading{
    text-align: center; 
}
.bnc-store {
    margin: 0;
    background: #fff;
    border-bottom: 1px solid #DBDBDB;
    border-right: 1px solid #DBDBDB;
    margin-bottom: -1px;
}
.bnc-store .store-module {
    padding: 0;
    margin: 0;
    position: relative;
    overflow: hidden;
}
.bnc-store .store-module .s-module-div {
    background: #fff;
    border-left: 1px solid #DBDBDB;
    border-top: 1px solid #DBDBDB;
    cursor: pointer;
}
.bnc-store .store-module .s-module-item {
    padding: 10px;
}
.bnc-store .store-module .s-module-item a {
    display: block;
}
.bnc-store .store-module .s-module-hv-item a.inline {
    display: block;
text-decoration: none;
color: #333;
}
.bnc-store .store-module .s-module-item a img {} .bnc-store .store-module .s-module-hv-item {
    padding: 20px;
}
.bnc-store .store-module .s-module-hv-item h4 {
    font-weight: 700
}
.bnc-store .store-module .s-module-hv-item p {
    display: block;
    margin-top: 10px;
    margin-bottom: 20px
}
a.actionbt {
    padding: 5px 12px;
    background: #006EFF;
    border-radius: 2px !important;
    color: #FFF;
    text-decoration: none;
    font-weight: 700;
    text-transform: uppercase;
    box-shadow: 0 0 4px rgba(0, 0, 0, 0.26);
}
a.actionbt:hover {
    background: red;
}
.bnc-store .store-module .s-module-hover {
    position: absolute;
    bottom: -100%;
    left: 0;
    background: #ececec;
    width: 100%;
    height: 100%;
    border-left: 1px solid #DBDBDB;
    border-top: 1px solid #DBDBDB;
    -webkit-transition: bottom 0.15s cubic-bezier(0.3, 0.1, 0.7, 1) 0.2s;
    -moz-transition: bottom 0.15s cubic-bezier(0.3, 0.1, 0.7, 1) 0.2s;
    -ms-transition: bottom 0.15s cubic-bezier(0.3, 0.1, 0.7, 1) 0.2s;
    -o-transition: bottom 0.15s cubic-bezier(0.3, 0.1, 0.7, 1) 0.2s;
    transition: bottom 0.15s cubic-bezier(0.3, 0.1, 0.7, 1) 0.2s;
}
.bnc-store .store-module:hover .s-module-hover {
    bottom: 0;
    zoom: 1;
}
.fancybox-skin {
    padding: 0px !important;
}
.fancybox-wrap {
    width: 980px !important;
}
.fancybox-overlay {
    z-index: 9999 !important
}
.fancybox-inner {
    width: auto !important;
    height: auto !important;
}
.fancybox-prev {
    left: -48px !important;
}
.fancybox-nav {
    width: 52px !important;
}
.fancybox-next {
    right: -48px !important;
}
.s-module-popup {} .smp-head {
    background: #FFF;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.27);
    padding: 10px;
}
.smp-head img {
    display: inline-block;
    width: 90px;
    border: 1px solid #F1F1F1;
    border-radius: 4px !important;
    padding: 3px;
    background: #DBDBDB;
    margin-right: 10px;
}
.smp-head h1 {
    padding: 0;
    margin: 0;
    display: inline-block;
}
.smp-head span {} .smp-body {
    padding: 10px;
    margin-bottom: 10px;
    margin-top: 10px;
}
.smp-body .smp-slide-img {
    float: left;
    width: 630px;
    margin-right: 0px;
    border-right: 1px solid #E8E8E8;
    margin-left: 19px;
}
.smp-body .smp-detail {
    float: right;
    width: 310px;
    text-align: justify;
    padding-left: 24px;
    padding-right: 20px;
}
.twoaction {
    margin-top: 32px;
    margin-right: 28px;
}
</style>
 
<script type="text/javascript">
$(function(){
    Processhome.init('<?=$_B["cf"]["lang"]?>');
}); 
</script>
 