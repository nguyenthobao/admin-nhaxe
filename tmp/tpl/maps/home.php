<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/maps/home.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/jquery-tags-input/jquery.tagsinput.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/typeahead/typeahead.css">
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-datetimepicker/css/datetimepicker.css"/>
<link rel="stylesheet" type="text/css" href="<?=$_B['mod_theme']?>css/maps.css?rs=<?=$reload?>"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!--<form class="form-horizontal form-row-seperated" action="" id="form_album" class="form-horizontal" enctype="multipart/form-data" method="POST">-->
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list"></i><?php echo lang('title_manager_mod');?>
                    </div>
                    <div class="actions btn-set">
                        <a class="btn green continue" href="/maps-setting"><i class="fa fa-cog"></i> <?php echo lang('caidatrieng');?></a>
</div>
                    <!---->
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
                            <li <?php if($k_lang==$get_lang) { ?>class="active"<?php } ?>>
                                <a class="select_lang" href="<?=$v_lang['url']?>" data-exist="<?=$v_lang['exist']?>"> <?php echo lang('lang_'.$k_lang);?> </a>
                            </li>
                            <?php } } ?>
                            <input type="hidden" name="popup" data-title="<?php echo lang('pop_title');?>" data-yes="<?php echo lang('pop_yes');?>" data-cancel="<?php echo lang('pop_cancel');?>" data-message="<?php echo lang('pop_message');?>" data-close="<?php echo lang('pop_close');?>">
                            <input type="hidden" name="popup_df" data-title="<?php echo lang('pop_df_title');?>" data-yes="<?php echo lang('pop_yes');?>" data-cancel="<?php echo lang('pop_cancel');?>" data-message="<?php echo lang('pop_df_message');?>" data-close="<?php echo lang('pop_close');?>">
                           
                        </ul>

                        <div class="tab-content no-space">
                            <div class="tab-pane active" id="lang_<?=$get_lang?>">
                                <div class="form-body">
                                    <div class="note note-warning">
                                        <p class="block">
                                            <?php echo lang('select_lang','lang_'.$get_lang);?>
                                        </p>
                                    </div>
<div>

<table cellpadding="0" cellspacing="0" width="100%">
          <tbody>
          <tr>
        <td><div style="overflow: hidden;" cpms_content="true">

              <table width="100%" style="margin:20px 0px 0px 0px">               
                <tr bgcolor="#F2F2F2">
                    <td colspan="2" class="form_text" style="padding:8px 0px 8px 10px; text-align:right"> 
                    <span><?php echo lang('chon_tp');?>:</span>
                    <select id="city_map" class="form_control table-group-action-input form-control input-inline input-sm width-200" style="padding:2px; margin-right:15px; width:150px;margin-bottom: 0">
                        <option value="1">Hà Nội</option>
                        <option value="2">An Giang</option>
                        <option value="3">Hồ Chí Minh</option>
                        <option value="4">Bà Rịa - Vũng Tàu</option>
                        <option value="5">Bình Dương</option>
                        <option value="6">Bình Phước</option>
                        <option value="7">Bình Thuận</option>
                        <option value="8">Bình Định</option>
                        <option value="9">Bạc Liêu</option>
                        <option value="10">Bắc Giang</option>
                        <option value="11">Bắc Kạn</option>
                        <option value="12">Bắc Ninh</option>
                        <option value="13">Bến Tre</option>
                        <option value="14">Cao Bằng</option>
                        <option value="15">Cà Mau</option>
                        <option value="16">Cần Thơ</option>
                        <option value="17">Gia Lai</option>
                        <option value="18">Hà Giang</option>
                        <option value="19">Đồng Tháp</option>
                        <option value="20">Đồng Nai</option>
                        <option value="21">Điện Biên</option>
                        <option value="22">Đắk Nông</option>
                        <option value="23">Đà Nẵng</option>
                        <option value="24">Đaklak</option>
                        <option value="25">Hà Nam</option>
                        <option value="26">Hà Tĩnh</option>
                        <option value="27">Hải Dương</option>
                        <option value="28">Hải Phòng</option>
                        <option value="29">Hậu Giang</option>
                        <option value="30">Hoà Bình</option>
                        <option value="31">Hưng Yên</option>
                        <option value="32">Khánh Hoà</option>
                        <option value="33">Kiên Giang</option>
                        <option value="34">Kon Tum</option>
                        <option value="35">Lai Châu</option>
                        <option value="36">Lào Cai</option>
                        <option value="37">Lâm Đồng</option>
                        <option value="38">Long An</option>
                        <option value="39">Nam Định</option>
                        <option value="40">Nghệ An</option>
                        <option value="41">Ninh Bình</option>
                        <option value="42">Ninh Thuận</option>
                        <option value="43">Phú Thọ</option>
                        <option value="44">Phú Yên</option>
                        <option value="45">Quảng Bình</option>
                        <option value="46">Quảng Nam</option>
                        <option value="47">Quảng Ngãi</option>
                        <option value="48">Quảng Ninh</option>
                        <option value="49">Quảng Trị</option>
                        <option value="50">Sóc Trăng</option>
                        <option value="51">Sơn La</option>
                        <option value="52">Tây Ninh</option>
                        <option value="53">Thanh Hoá</option>
                        <option value="54">Thái Bình</option>
                        <option value="55">Thái Nguyên</option>
                        <option value="56">Thừa Thiên Huế</option>
                        <option value="57">Tiền Giang</option>
                        <option value="58">Trà Vinh</option>
                        <option value="59">Tuyên Quang</option>
                        <option value="60">Vĩnh Long</option>
                        <option value="61">Vĩnh Phúc</option>
                        <option value="62">Yên Bái</option>
                        <option value="0">Nơi khác</option>
                    </select>
                    <span><?php echo lang('dia_chi');?> :</span>
                    <input class="form_control form-control" type="text" id="address" name="address" value="" style="width:480px; padding:2px; display: inline; margin-bottom: 0" onkeypress="return loadSearchGmap(event)" />
                    <input type="button" class="form_button btn btn-sm green" value=" Tìm kiếm " onClick="findAddress(document.getElementById('address').value)" style="margin-right: 10px; padding: 8px; margin-bottom: 2px" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" colspan="2" style="padding-top: 5px">
                        
                        <div class="span6" style="float: left; width: 30.7179%">
                        <!-- BEGIN BASIC PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-reorder"></i><?php echo lang('danh_sach_dia_chi');?></div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                </div>
                            </div>
                            <div class="portlet-body" style="width: 100%; background-color: #FFFFFF">
                            <div class="actions btn-set btn-del" style="border: 1px dotted #D1D1D1;padding: 10px 5px;position: relative;text-align: left;margin-bottom: 10px;">
                            <input type="checkbox" id="checkboxAll" value=""> Chọn tất cả 
                            <a class="btn btn-sm red continue delete_album_select disabled" data-continue="delete_album_select" style="position: absolute;right: 5px;top: 5px;"><i class="fa fa-trash-o"></i> <?php echo lang('delete');?></a>
                            </div>
                            <div id="s_maps" style="padding:0px 10px 0px 5px">
                            
                            <?php if($mapList) { ?>
                            <?php if(is_array($mapList)) { foreach($mapList as $k => $v) { ?>
                                <div style="padding:10px 0 5px 0; border-bottom:1px solid #cbcbcb">
                                    <a href="Javascript:;" class="left_menu" style="font-weight:bold" onClick="moveToMaker(<?=$v['id']?>)"><?=$v['gmap_address']?></a><?php if($v['gmap_default']==1) { ?><span class="form_text" style="color: #D84A38">(Trụ sở chính)</span><?php } ?>
                                    <br>
                                    <?php if($v['gmap_name']) { ?>
                                    <span class="form_text"><?php echo lang('doanh_nghiep');?>: <?=$v['gmap_name']?></span>
                                    <br>
                                    <?php } ?>
                                    <?php if($v['gmap_phone']) { ?>
                                    <span class="form_text"><?php echo lang('dien_thoai');?>: <?=$v['gmap_phone']?></span>
                                    <br>
                                    <?php } ?>
                                    <?php if($v['gmap_email']) { ?>
                                    <span class="form_text">Email: <a href="mailto:<?=$v['gmap_email']?>"><?=$v['gmap_email']?></a></span>
                                    <br>
                                    <?php } ?>
                                    <?php if($v['gmap_website']) { ?>
                                    <span class="form_text">Website: <a target="_blank" href="<?=$v['gmap_website']?>"><?=$v['gmap_website']?></a></span>
                                    <br>
                                    <?php } ?>
                                    <?php if($v['gmap_time']) { ?>
                                    <span class="form_text"><?php echo lang('thoi_gian_lam_viec');?>: <?=$v['gmap_time']?></span>
                                    <br>
                                    <?php } ?>
                                    <form method="post" id="f<?=$v['id']?>">
                                    <input type="checkbox" name="name_id[]" class="checkboxes"  value="<?=$v['id']?>">
                                    <a data-original-title="<?php echo lang('sua_dia_chi');?>" onClick="moveToMaker(<?=$v['id']?>)" class="btn default btn-xs yellow tooltips" href="Javascript:;"><i class="fa fa-edit"></i></a>
                                    <a data-original-title="<?php echo lang('xoa_dia_chi');?>" class="btn default btn-xs red tooltips delete_category" onClick="alertz('<?php echo lang('co_muon_xoa_ko');?>?', '<?=$v['id']?>')"><i class="fa fa-trash-o"></i></a>
                                        <input type="hidden" name="action" value="delete" />
                                        <input type="hidden" name="record_id" value="<?=$v['id']?>" />
                                        <input type="hidden" name="submit_form" value="ch_map" />
                                        <input type="hidden" name="lang" value="<?=$get_lang?>" />
                                    </form>
                                </div>   
                            <?php } } ?>
                            <?php } else { ?>
                            <div class="alert alert-warning"><?php echo lang('no_data');?></div>
                            <?php } ?>
                        </div>
                            </div>
                        </div>
                        <!-- END BASIC PORTLET-->
                        </div> 
                    
                        <div class="span6" style="float: right; width: 66.7179%">
                        <!-- BEGIN BASIC PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-reorder"></i><?php echo lang('click_de_tao_marker');?></div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                </div>
                            </div>
                            <div class="portlet-body" style="width: 100%; height: 500px">
                                <div id="map_canvas"></div>
                            </div>
                        </div>
                        <!-- END BASIC PORTLET-->
                    </div>
                    
                                          
                    </td>                   
                </tr>
            </table>
            
        </div></td>
                </tr>
                </tbody>
            </table>
            </div>
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="portlet-title topline">
                    <!---->
                </div>
            </div>
        <!--</form>-->
    </div>
</div>
<!-- END PAGE CONTENT-->
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript" src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=AIzaSyCoR8teGdKR7y3ZedCE89MeaWCoOiAt69M"></script>
<script src="<?=$_B['mod_theme']?>js/maps.js?rs=<?=$reload?>" type="text/javascript"></script>

<script>
    jQuery(document).ready(function() {
    initialize();
    document.getElementById("map_canvas").style.width = "100%";
    document.getElementById("map_canvas").style.height = "100%";
    $('#s_maps').slimScroll({
            height: '450px'
    });
    //$('.slimScrollDiv').css("overflow", "");
    var person = new Array()
    person["ok"] = "<?php echo lang('ok');?>";
    person["cancel"] = "<?php echo lang('cancel');?>";
    person["alert"] = "<?php echo lang('alert');?>"; 
    person["deleteAllDialog"] = "<?php echo lang('deleteAllDialog');?>"; 
    maps.init(person);
    });
    
</script>
<script language="javascript" type="text/javascript">
            var map = null;
            var geocoder = null;
            var clickmarker = null;
            var marker_placed = false;
            var marker = new Array();
            var infoWindowArray = new Array();
            var city_location = new Array();
            
            // Khởi tạo map
            function initialize() {

                var defaultLatLng = new GLatLng(<?=$lat?>, <?=$lng?>);

                if (GBrowserIsCompatible()) {
                    map = new GMap2(document.getElementById("map_canvas"));
                    var customUI = map.getDefaultUI();
                    customUI.zoom.scrollwheel = true;
                    map.setUI(customUI);
                    //map.enableGoogleBar();
                    map.setCenter(defaultLatLng, 16);
                    geocoder = new GClientGeocoder();
                }
                
                //
                <?php if(is_array($mapList)) { foreach($mapList as $k => $v) { ?>
                var arrLatLng = new GLatLng(<?=$v['lat']?>, <?=$v['lng']?>);
                    infoWindowArray[<?=$v['id']?>] = '<form method="post" id="a<?=$v['id']?>"><table width="350">'+
                    '<tr><td colspan="2" class="content_title"><?php echo lang('sua_xoa_dia_chi');?></td></tr>'+
                    '<tr><td nowrap="nowrap" class="form_name"><?php echo lang('dia_chi');?>:<font color="red">*</font></td><td><input type="text" name="gmap_address" id="gmap_address_<?=$v['id']?>" class="form_control" style="width:230px" maxlength="200" value="<?=$v['gmap_address']?>" /></td></tr>'+
                    '<tr><td class="form_name"><?php echo lang('doanh_nghiep');?>:</td><td><input type="text" name="gmap_name" class="form_control" style="width:230px" maxlength="200" value="<?=$v['gmap_name']?>"/></td></tr>'+
                    '<tr><td class="form_name"><?php echo lang('dien_thoai');?>:</td><td><input type="text" name="gmap_phone" class="form_control" style="width:230px" maxlength="200" value="<?=$v['gmap_phone']?>"/></td></tr>'+
                    '<tr><td class="form_name">Email:</td><td><input type="text" name="gmap_email" id="gmap_email_<?=$v['id']?>" class="form_control" style="width:230px" maxlength="200" value="<?=$v['gmap_email']?>"/></td></tr>'+
                    '<tr><td class="form_name">Website:</td><td><input type="text" name="gmap_website" id="gmap_website_<?=$v['id']?>" class="form_control" style="width:230px" maxlength="200" value="<?=$v['gmap_website']?>"/></td></tr>'+
                    '<tr><td class="form_name"><?php echo lang('thoi_gian_lam_viec');?>:</td><td><input type="text" name="gmap_time" id="gmap_time_<?=$v['id']?>" class="form_control" style="width:230px" maxlength="200" value="<?=$v['gmap_time']?>"/></td></tr>'+
                    '<tr><td class="form_name"><?php echo lang('thu_tu');?>:</td><td><input type="text" name="gmap_order" class="form_control" style="width:50px" maxlength="5" value="<?=$v['gmap_order']?>"/></td></tr>'+
                    '<tr><td class="form_name">Trụ sở chính:</td><td><input type="checkbox" name="gmap_default" value="1" class="form_control" <?php if($v['gmap_default']==1 ) { ?> checked<?php } ?>/ ></td></tr>'+
                    '<tr><td colspan="2" align="center"><input type="submit" value="<?php echo lang('sua');?>" class="form_button" onclick="return checkForm(<?=$v['id']?>)"/>&nbsp;&nbsp;&nbsp;<input type="button" value="<?php echo lang('xoa');?>"'+
                    ' onclick="alertz(\'<?php echo lang('co_muon_xoa_ko');?>?\', this.form, 1)" class="form_button"/></td></tr>'+
                    '</table><input type="hidden" name="action" value="update" /><input type="hidden" name="record_id" value="<?=$v['id']?>" /><input type="hidden" name="submit_form" value="ch_map" />'+
                    '<input type="hidden" name="lang" value="<?=$get_lang?>" />'+
                    '<input type="hidden" name="lat" value="<?=$v['lat']?>" />'+
                    '<input type="hidden" name="lng" value="<?=$v['lng']?>" /></form>';
    
                    loadMarker(arrLatLng, infoWindowArray[<?=$v['id']?>], <?=$v['id']?>);
                <?php } } ?>
                //

                GEvent.addListener(map, 'click', function(overlay, latlng) {
                    if (!overlay) {
                        //Nếu đã đặt icon rồi thì phải cancel
                        if (marker_placed) {
                            Cancel();
                        }
                        placeMarker(latlng);
                        marker_placed = true;
                    }
                });

                // Mang chua toa do cua city
                city_location[1] = new GLatLng(21.027521, 105.852449);
                city_location[1]["location"] = 'Hà Nội Việt Nam';
                //
                city_location[2] = new GLatLng(10.52166895771762, 105.12599238756593);
                city_location[2]["location"] = 'An Giang Việt Nam';
                //
                city_location[3] = new GLatLng(10.759579, 106.668661);
                city_location[3]["location"] = 'Hồ Chí Minh Việt Nam';
                //
                city_location[4] = new GLatLng(10.345570793890843, 107.08427023913828);
                city_location[4]["location"] = 'Vũng Tàu Việt Nam';
                //
                city_location[5] = new GLatLng(11.142697887918361, 106.62966799762216);
                city_location[5]["location"] = 'Bình Dương Việt Nam';
                //
                city_location[6] = new GLatLng(11.751306591365156, 106.72371697452036);
                city_location[6]["location"] = 'Bình Phước Việt Nam';
                //
                city_location[7] = new GLatLng(10.980606696702662, 108.26175999667612);
                city_location[7]["location"] = 'Bình Thuận Việt Nam';
                //
                city_location[8] = new GLatLng(13.783111051471368, 109.21995234515634);
                city_location[8]["location"] = 'Bình Định Việt Nam';
                //
                city_location[9] = new GLatLng(9.290022308998463, 105.5008013251063);
                city_location[9]["location"] = 'Bạc Liêu Việt Nam';
                //
                city_location[10] = new GLatLng(21.291033796209984, 106.18697476413217);
                city_location[10]["location"] = 'Bắc Giang Việt Nam';
                //
                city_location[11] = new GLatLng(22.30339085266883, 105.8762462141749);
                city_location[11]["location"] = 'Bắc Kạn Việt Nam';
                //
                city_location[12] = new GLatLng(21.184111647939826, 106.05653357531992);
                city_location[12]["location"] = 'Bắc Ninh Việt Nam';
                //
                city_location[13] = new GLatLng(10.241656018862644, 106.37674641635385);
                city_location[13]["location"] = 'Bến Tre Việt Nam';
                //
                city_location[14] = new GLatLng(22.663858381030632, 106.26776289966074);
                city_location[14]["location"] = 'Cao Bằng Việt Nam';
                //
                city_location[15] = new GLatLng(9.183489736283441, 105.15020442035166);
                city_location[15]["location"] = 'Cà Mau Việt Nam';
                //
                city_location[16] = new GLatLng(10.031970859097568, 105.78406405475107);
                city_location[16]["location"] = 'Cần Thơ Việt Nam';
                //
                city_location[17] = new GLatLng(13.972092776403676, 108.01561903979746);
                city_location[17]["location"] = 'Gia Lai Việt Nam';
                //
                city_location[18] = new GLatLng(22.802927516201063, 104.9792940619227);
                city_location[18]["location"] = 'Hà Giang Việt Nam';
                //
                city_location[19] = new GLatLng(10.455064204354324, 105.63428950335947);
                city_location[19]["location"] = 'Đồng Tháp Việt Nam';
                //
                city_location[20] = new GLatLng(10.957497686849008, 106.8429358008143);
                city_location[20]["location"] = 'Đồng Nai Việt Nam';
                //
                city_location[21] = new GLatLng(21.409525291033344, 103.03585124042002);
                city_location[21]["location"] = 'Điện Biên Việt Nam';
                //
                city_location[22] = new GLatLng(12.003768425215497, 107.68789601352182);
                city_location[22]["location"] = 'Đắk Nông Việt Nam';
                //
                city_location[23] = new GLatLng(16.0516699311548, 108.21513247516123);
                city_location[23]["location"] = 'Đà Nẵng Việt Nam';
                //
                city_location[24] = new GLatLng(12.710092852536377, 108.23804926898447);
                city_location[24]["location"] = 'Đaklak Việt Nam';
                //
                city_location[25] = new GLatLng(20.583597118027985, 105.9232170584437);
                city_location[25]["location"] = 'Hà Nam Việt Nam';
                //
                city_location[26] = new GLatLng(18.34065569936021, 105.90768170382944);
                city_location[26]["location"] = 'Hà Tĩnh Việt Nam';
                //
                city_location[27] = new GLatLng(20.93743260344624, 106.31484103229013);
                city_location[27]["location"] = 'Hải Dương Việt Nam';
                //
                city_location[28] = new GLatLng(20.861438494892425, 106.6800506117579);
                city_location[28]["location"] = 'Hải Phòng Việt Nam';
                //
                city_location[29] = new GLatLng(9.757995350225787, 105.64145636584726);
                city_location[29]["location"] = 'Hậu Giang Việt Nam';
                //
                city_location[30] = new GLatLng(20.83075733529618, 105.34016919162241);
                city_location[30]["location"] = 'Hoà Bình Việt Nam';
                //
                city_location[31] = new GLatLng(20.852675952317668, 106.01726603534189);
                city_location[31]["location"] = 'Hưng Yên Việt Nam';
                //
                city_location[32] = new GLatLng(12.238903966747701, 109.1970355513331);
                city_location[32]["location"] = 'Khánh Hoà Việt Nam';
                //
                city_location[33] = new GLatLng(9.825088743730479, 105.1261503699061);
                city_location[33]["location"] = 'Kiên Giang Việt Nam';
                //
                city_location[34] = new GLatLng(14.349838872226798, 108.00072741534677);
                city_location[34]["location"] = 'Kon Tum Việt Nam';
                //
                city_location[35] = new GLatLng(22.355572962953545, 103.26660704638925);
                city_location[35]["location"] = 'Lai Châu Việt Nam';
                //
                city_location[36] = new GLatLng(22.27607132828315, 104.19336390521494);
                city_location[36]["location"] = 'Lào Cai Việt Nam';
                //
                city_location[37] = new GLatLng(11.940543729262199, 108.45856976535288);
                city_location[37]["location"] = 'Lâm Đồng Việt Nam';
                //
                city_location[38] = new GLatLng(10.533108529272548, 106.40554261233774);
                city_location[38]["location"] = 'Long An Việt Nam';
                //
                city_location[39] = new GLatLng(20.420095382556642, 106.16860699679819);
                city_location[39]["location"] = 'Nam Định Việt Nam';
                //
                city_location[40] = new GLatLng(19.148472313711395, 104.84572005298105);
                city_location[40]["location"] = 'Nghệ An Việt Nam';
                //
                city_location[41] = new GLatLng(20.25074283376275, 105.9746725561854);
                city_location[41]["location"] = 'Ninh Bình Việt Nam';
                //
                city_location[42] = new GLatLng(11.58270857437525, 108.99149251010385);
                city_location[42]["location"] = 'Ninh Thuận Việt Nam';
                //
                city_location[43] = new GLatLng(21.260761060801563, 105.12617182757822);
                city_location[43]["location"] = 'Phú Thọ Việt Nam';
                //
                city_location[44] = new GLatLng(13.10583302589209, 109.29533314731088);
                city_location[44]["location"] = 'Phú Yên Việt Nam';
                //
                city_location[45] = new GLatLng(17.466014095264097, 106.59866166141);
                city_location[45]["location"] = 'Quảng Bình Việt Nam';
                //
                city_location[46] = new GLatLng(15.598154776229306, 107.85865616824594);
                city_location[46]["location"] = 'Quảng Nam Việt Nam';
                //
                city_location[47] = new GLatLng(15.123916014623632, 108.81197762515512);
                city_location[47]["location"] = 'Quảng Ngãi Việt Nam';
                //
                city_location[48] = new GLatLng(21.24336241860444, 107.1959574225184);
                city_location[48]["location"] = 'Quảng Ninh Việt Nam';
                //
                city_location[49] = new GLatLng(16.80897795745287, 107.08965611484018);
                city_location[49]["location"] = 'Quảng Trị Việt Nam';
                //
                city_location[50] = new GLatLng(9.60265406884958, 105.97417902972666);
                city_location[50]["location"] = 'Sóc Trăng Việt Nam';
                //
                city_location[51] = new GLatLng(21.327156967360718, 103.91437125232187);
                city_location[51]["location"] = 'Sơn La Việt Nam';
                //
                city_location[52] = new GLatLng(11.36766867692905, 106.11955475833383);
                city_location[52]["location"] = 'Tây Ninh Việt Nam';
                //
                city_location[53] = new GLatLng(19.809507663862764, 105.77694010760752);
                city_location[53]["location"] = 'Thanh Hoá Việt Nam';
                //
                city_location[54] = new GLatLng(20.4464965818465, 106.33685660388437);
                city_location[54]["location"] = 'Thái Bình Việt Nam';
                //
                city_location[55] = new GLatLng(21.56727806650309, 105.82547736194101);
                city_location[55]["location"] = 'Thái Nguyên Việt Nam';
                //
                city_location[56] = new GLatLng(16.463558632211658, 107.5849635603663);
                city_location[56]["location"] = 'Thừa Thiên Huế Việt Nam';
                //
                city_location[57] = new GLatLng(10.376662550478379, 106.34413075473276);
                city_location[57]["location"] = 'Tiền Giang Việt Nam';
                //
                city_location[58] = new GLatLng(9.95145710601434, 106.33488249804941);
                city_location[58]["location"] = 'Trà Vinh Việt Nam';
                //
                city_location[59] = new GLatLng(21.8185763698503, 105.21163773562876);
                city_location[59]["location"] = 'Tuyên Quang Việt Nam';
                //
                city_location[60] = new GLatLng(10.244971178751854, 105.9590942862269);
                city_location[60]["location"] = 'Vĩnh Long Việt Nam';
                //
                city_location[61] = new GLatLng(10.244950063193466, 105.95913720157114);
                city_location[61]["location"] = 'Vĩnh Phúc Việt Nam';
                //
                city_location[62] = new GLatLng(21.716865760736894, 104.89887070682016);
                city_location[62]["location"] = 'Yên Bái Việt Nam';

            }

            // Tao 1 maker moi voi form de insert
            function placeMarker(location) {
                clickmarker = new GMarker(location, {
                    draggable : true
                });
                var location = clickmarker.getLatLng();
                map.setCenter(location);

                var contentString = '<form method="post"><input type="hidden" name="cityNum" value="' + document.getElementById("city_map").value + '" />'+
                '<table width="350"><tr><td colspan="2" class="content_title"><?php echo lang('nhap_dia_chi_moi');?></td></tr>'+
                '<tr><td nowrap="nowrap" class="form_name">Địa chỉ:<font color="red">*</font></td><td><input type="text" name="gmap_address" id="gmap_address_0" class="form_control" style="width:230px" maxlength="200" /></td></tr>'+
                '<tr><td class="form_name"><?php echo lang('doanh_nghiep');?>:</td><td><input type="text" name="gmap_name" class="form_control" style="width:230px" maxlength="200" /></td></tr>'+
                '<tr><td class="form_name"><?php echo lang('dien_thoai');?>:</td><td><input type="text" name="gmap_phone" class="form_control" style="width:230px" maxlength="200" /></td></tr>'+
                '<tr><td class="form_name">Email:</td><td><input type="text" name="gmap_email" id="gmap_email_0" class="form_control" style="width:230px" maxlength="200" /></td></tr>'+
                '<tr><td class="form_name">Website:</td><td><input type="text" name="gmap_website" id="gmap_website_0" class="form_control" style="width:230px" maxlength="200" placeholder="VD: (http://webbnc.net)" /></td></tr>'+
                '<tr><td class="form_name"><?php echo lang('thoi_gian_lam_viec');?>:</td><td><input type="text" name="gmap_time" id="gmap_time_0" class="form_control" style="width:230px" maxlength="200" /></td></tr>'+
                '<tr><td class="form_name"><?php echo lang('thu_tu');?>:</td><td><input type="text" name="gmap_order" class="form_control" style="width:50px" maxlength="5" /></td></tr>'+
                '<tr><td class="form_name"><?php echo lang('tru_so_chinh');?>:</td><td><input type="checkbox" name="gmap_default" class="form_control" value="1" /></td></tr>'+
                '<tr><td colspan="2" align="center"><input type="submit" value="<?php echo lang('luu_lai');?>" class="form_button" onclick="return checkForm(0)" />&nbsp;&nbsp;&nbsp;<input type="button" value="<?php echo lang('huy_bo');?>" onclick="Cancel();" class="form_button"/></td></tr>'+
                '</table><input type="hidden" name="lat" value="' + location.lat() + '" /><input type="hidden" name="lng" value="' + location.lng() + '" /><input type="hidden" name="action" value="insert" /><input type="hidden" name="submit_form" value="ch_map" /><input type="hidden" name="lang" value="<?=$get_lang?>" /></form>';

                map.addOverlay(clickmarker);
                clickmarker.openInfoWindow(contentString);

                // bat dau keo tha thi tat infowindow
                GEvent.addListener(clickmarker, 'dragstart', function() {
                    clickmarker.closeInfoWindow();
                });

                // ket thuc keo tha thi bat infowindow de insert o toa do moi
                GEvent.addListener(clickmarker, 'dragend', function(latlng) {
                    map.setCenter(latlng);

                    // Khi dragend thi lay toa do moi

                    var contentString = '<form method="post"><input type="hidden" name="cityNum" value="' + document.getElementById("city_map").value + '" />'+
                    '<table width="350"><tr><td colspan="2" class="content_title"><?php echo lang('nhap_dia_chi_moi');?></td></tr>'+
                    '<tr><td nowrap="nowrap" class="form_name">Địa chỉ:<font color="red">*</font></td><td><input type="text" name="gmap_address" id="gmap_address_0" class="form_control" style="width:230px" maxlength="200" /></td></tr>'+
                    '<tr><td class="form_name"><?php echo lang('doanh_nghiep');?>:</td><td><input type="text" name="gmap_name" class="form_control" style="width:230px" maxlength="200" /></td></tr>'+
                    '<tr><td class="form_name"><?php echo lang('dien_thoai');?>:</td><td><input type="text" name="gmap_phone" class="form_control" style="width:230px" maxlength="200" /></td></tr>'+
                    '<tr><td class="form_name">Email:</td><td><input type="text" name="gmap_email" id="gmap_email_0" class="form_control" style="width:230px" maxlength="200" /></td></tr>'+
                    '<tr><td class="form_name">Website:</td><td><input type="text" name="gmap_website" id="gmap_website_0" class="form_control" style="width:230px" maxlength="200" placeholder="VD: (http://webbnc.net)" /></td></tr>'+
                    '<tr><td class="form_name"><?php echo lang('thoi_gian_lam_viec');?>:</td><td><input type="text" name="gmap_time" id="gmap_time_0" class="form_control" style="width:230px" maxlength="200" /></td></tr>'+
                    '<tr><td class="form_name"><?php echo lang('thu_tu');?>:</td><td><input type="text" name="gmap_order" class="form_control" style="width:50px" maxlength="5" /></td></tr>'+
                    '<tr><td class="form_name"><?php echo lang('tru_so_chinh');?>:</td><td><input type="checkbox" name="gmap_default" class="form_control" value="1" /></td></tr>'+
                    '<tr><td colspan="2" align="center"><input type="submit" value="<?php echo lang('luu_lai');?>" class="form_button" onclick="return checkForm(0)" />&nbsp;&nbsp;&nbsp;<input type="button" value="<?php echo lang('huy_bo');?>" onclick="Cancel();" class="form_button"/></td></tr>'+
                    '</table><input type="hidden" name="lat" value="' + location.lat() + '" /><input type="hidden" name="lng" value="' + location.lng() + '" /><input type="hidden" name="action" value="insert" /><input type="hidden" name="submit_form" value="ch_map" /><input type="hidden" name="lang" value="<?=$get_lang?>" /></form>';
                    clickmarker.openInfoWindow(contentString);
                });

                // click thi bat infowindow
                GEvent.addListener(clickmarker, 'click', function() {
                    clickmarker.openInfoWindow(contentString);
                });
            }

            // Truong hop da click va tao 1 maker roi thi an no di
            function Cancel() {
                if (clickmarker) {
                    clickmarker.hide();
                }
                map.closeInfoWindow();
                marker_placed = false;
            }

            //Tao ra 1 maker tai vi tri myLocation, co form sua du lieu myInfoWindow
            function loadMarker(myLocation, myInfoWindow, id) {
                marker[id] = new GMarker(myLocation);
                map.addOverlay(marker[id]);

                var popup = myInfoWindow;
                // Khi click vao maker thi mo inforwindow dong thoi set center tai vi tri maker cho de nhin
                marker[id].bindInfoWindow(popup);
                GEvent.addListener(marker[id], 'click', function(latlng) {
                    map.setCenter(latlng);
                });
            }

            // Ham check form nhap lieu
            function checkForm(id) {
                if (document.getElementById("gmap_address_" + id).value == "") {
                    bootbox.dialog({
                        message : '<li class="list-group-item list-group-item-warning"><?php echo lang('hay_nhap_vao_mot_dia_chi');?></li>',
                        title : "<?php echo lang('alert');?>",
                        buttons : {
                            success : {
                                label : "<?php echo lang('ok');?>",
                                className : "green",
                                callback : function() {
                                
                                }
                            }
                        }
                    });
                    //alert('<?php echo lang('hay_nhap_vao_mot_dia_chi');?>');
                    document.getElementById("gmap_address_" + id).focus();
                    return false;
                }
                if (document.getElementById("gmap_email_" + id).value != ""){
                    if(!checkEmail(document.getElementById("gmap_email_" + id).value)){
                    bootbox.dialog({
                        message : '<li class="list-group-item list-group-item-warning"><?php echo lang('hay_nhap_vao_mot_email');?></li>',
                        title : "<?php echo lang('alert');?>",
                        buttons : {
                            success : {
                                label : "<?php echo lang('ok');?>",
                                className : "green",
                                callback : function() {
                                
                                }
                            }
                        }
                    });
                    //alert('<?php echo lang('hay_nhap_vao_mot_email');?>');
                    document.getElementById("gmap_email_" + id).focus();
                    return false;
                    }
                }
                if (document.getElementById("gmap_website_" + id).value != ""){
                    if(!checkURL(document.getElementById("gmap_website_" + id).value)){
                    bootbox.dialog({
                        message : '<li class="list-group-item list-group-item-warning"><?php echo lang('hay_nhap_mot_url');?></li>',
                        title : "<?php echo lang('alert');?>",
                        buttons : {
                            success : {
                                label : "<?php echo lang('ok');?>",
                                className : "green",
                                callback : function() {
                                
                                }
                            }
                        }
                    });
                    //alert('<?php echo lang('hay_nhap_mot_url');?>');
                    document.getElementById("gmap_website_" + id).focus();
                    return false;
                    }
                }
                return true;
            }
            function checkURL(value) {
                var urlregex = new RegExp("^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
                if (urlregex.test(value)) {
                    return true;
                }
                return false;
            }
            function checkEmail(email) {
                var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (filter.test(email)) {
                return true;
                }
                return false;
                }
                
            //Đổi độ rộng bản đồ
            function change_map_size(value) {
                switch (value) {
                    case "1":
                        document.getElementById("map_canvas").style.width = "600px";
                        document.getElementById("map_canvas").style.height = "400px";
                        break;
                    case "2":
                        document.getElementById("map_canvas").style.width = "800px";
                        document.getElementById("map_canvas").style.height = "500px";
                        break;
                    case "3":
                        document.getElementById("map_canvas").style.width = "1024px";
                        document.getElementById("map_canvas").style.height = "600px";
                        break;
                }
            }

            // Tim theo dia chi nhap vao
            function findAddress(address) {
                if(document.getElementById("city_map").value!=0){
                find_address = address + " " + city_location[document.getElementById("city_map").value]["location"];
                    }else{
                    find_address = address;
                        }
                if (geocoder) {
                    geocoder.getLatLng(find_address, function(point) {
                        if (!point) {
                            bootbox.dialog({
                                message : '<li class="list-group-item list-group-item-warning"><?php echo lang('ko_tim_thay_vi_tri');?> ' + address + ' <?php echo lang('ko_tim_thay_vi_tri2');?> !</li>',
                                title : "<?php echo lang('alert');?>",
                                buttons : {
                                    success : {
                                        label : "<?php echo lang('ok');?>",
                                        className : "green",
                                        callback : function() {
                                        
                                        }
                                    }
                                }
                            });
                            //alert("<?php echo lang('ko_tim_thay_vi_tri');?> " + address + " <?php echo lang('ko_tim_thay_vi_tri2');?> !");
                        } else {
                            map.setCenter(point, 16);
                            if (marker_placed) {
                                Cancel();
                            }
                            clickmarker = new GMarker(point, {
                                draggable : true
                            });
                            map.addOverlay(clickmarker);
                            marker_placed = true;

                            GEvent.addListener(clickmarker, 'dragstart', function() {
                                clickmarker.closeInfoWindow();
                            });

                            GEvent.addListener(clickmarker, 'dragend', function(latlng) {
                                map.setCenter(latlng);

                                var contentString = '<form method="post"><input type="hidden" name="cityNum" value="' + document.getElementById("city_map").value + '" /><table width="350"><tr><td colspan="2" class="content_title">Nhập mới địa chỉ</td></tr><tr><td nowrap="nowrap" class="form_name">Địa chỉ:<font color="red">*</font></td><td><input type="text" name="gmap_address" id="gmap_address_0" class="form_control" style="width:230px" maxlength="200" /></td></tr><tr><td class="form_name">Doanh nghiệp:</td><td><input type="text" name="gmap_name" class="form_control" style="width:230px" maxlength="200" /></td></tr><tr><td class="form_name">Điện thoại:</td><td><input type="text" name="gmap_phone" class="form_control" style="width:230px" maxlength="200" /></td></tr><tr><td class="form_name">Email:</td><td><input type="text" name="gmap_email" id="gmap_email_0" class="form_control" style="width:230px" maxlength="200" /></td></tr><tr><td class="form_name">Website:</td><td><input type="text" name="gmap_website" id="gmap_website_0" class="form_control" style="width:230px" maxlength="200" placeholder="VD: (http://webbnc.net)" /></td></tr><tr><td class="form_name">Thời gian làm việc:</td><td><input type="text" name="gmap_time" id="gmap_time_0" class="form_control" style="width:230px" maxlength="200" /></td></tr><tr><td class="form_name">Thứ tự:</td><td><input type="text" name="gmap_order" class="form_control" style="width:50px" maxlength="5" /></td></tr><tr><td class="form_name">Trụ sở chính:</td><td><input type="checkbox" name="gmap_default" class="form_control" value="1" /></td></tr><tr><td colspan="2" align="center"><input type="submit" value="Lưu lại" class="form_button" onclick="return checkForm(0)" />&nbsp;&nbsp;&nbsp;<input type="button" value="Hủy bỏ" onclick="Cancel();" class="form_button"/></td></tr></table><input type="hidden" name="lat" value="' + location.lat() + '" /><input type="hidden" name="lng" value="' + location.lng() + '" /><input type="hidden" name="action" value="insert" /><input type="hidden" name="submit_form" value="ch_map" /></form>';
                                clickmarker.openInfoWindow(contentString);
                            });

                            GEvent.addListener(clickmarker, 'click', function(latlng) {

                                var contentString = '<form method="post"><input type="hidden" name="cityNum" value="' + document.getElementById("city_map").value + '" /><table width="350"><tr><td colspan="2" class="content_title">Nhập mới địa chỉ</td></tr><tr><td nowrap="nowrap" class="form_name">Địa chỉ:<font color="red">*</font></td><td><input type="text" name="gmap_address" id="gmap_address_0" class="form_control" style="width:230px" maxlength="200" /></td></tr><tr><td class="form_name">Doanh nghiệp:</td><td><input type="text" name="gmap_name" class="form_control" style="width:230px" maxlength="200" /></td></tr><tr><td class="form_name">Điện thoại:</td><td><input type="text" name="gmap_phone" class="form_control" style="width:230px" maxlength="200" /></td></tr><tr><td class="form_name">Email:</td><td><input type="text" name="gmap_email" id="gmap_email_0" class="form_control" style="width:230px" maxlength="200" /></td></tr><tr><td class="form_name">Website:</td><td><input type="text" name="gmap_website" id="gmap_website_0" class="form_control" style="width:230px" maxlength="200" placeholder="VD: (http://webbnc.net)" /></td></tr><tr><td class="form_name">Thời gian làm việc:</td><td><input type="text" name="gmap_time" id="gmap_time_0" class="form_control" style="width:230px" maxlength="200" /></td></tr><tr><td class="form_name">Thứ tự:</td><td><input type="text" name="gmap_order" class="form_control" style="width:50px" maxlength="5" /></td></tr><tr><td class="form_name">Trụ sở chính:</td><td><input type="checkbox" name="gmap_default" class="form_control" value="1" /></td></tr><tr><td colspan="2" align="center"><input type="submit" value="Lưu lại" class="form_button" onclick="return checkForm(0)" />&nbsp;&nbsp;&nbsp;<input type="button" value="Hủy bỏ" onclick="Cancel();" class="form_button"/></td></tr></table><input type="hidden" name="lat" value="' + location.lat() + '" /><input type="hidden" name="lng" value="' + location.lng() + '" /><input type="hidden" name="action" value="insert" /><input type="hidden" name="submit_form" value="ch_map" /></form>';
                                clickmarker.openInfoWindow(contentString);
                            });
                        }
                    });
                }
            }

            //Di chuyển đến địa chỉ click
            function moveToMaker(id) {
                //Thiết lập vị trí center
                var location = marker[id].getLatLng();
                map.setCenter(location);
                marker[id].openInfoWindow(infoWindowArray[id]);
            }

            function loadSearchGmap(e) {
                mykey = (e.keyCode ? e.keyCode : e.charCode);
                if (mykey == 13 || e == "") {
                    findAddress(document.getElementById('address').value);
                    return false;
                }
                return true;
            }
        function alertz (e,f,x) {
          bootbox.dialog({
                    message : '<li class="list-group-item list-group-item-warning">'+e+'</li>',
                    title : "<?php echo lang('alert');?>",
                    buttons : {
                        success : {
                            label : "<?php echo lang('ok');?>",
                            className : "green",
                            callback : function() {
                            if(x){
                                f.action.value='delete';
                                f.submit();
                            }else{
                            document.getElementById('f'+f).submit();
                            }
                            }
                        },
                        danger : {
                            label : "<?php echo lang('cancel');?>",
                            className : "red",
                            callback : function() {
                                return;
                            }
                        }
                    }
                });
        }
        </script>
