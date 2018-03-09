<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/seo/meta.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><!-- BEGIN PAGE CONTENT-->
<div class="row">
<div class="col-md-12">
<form id="saveSettingMeta"  class="form-horizontal form-row-seperated" class="form-horizontal" enctype="multipart/form-data" method="POST" action="/seo-meta-submit-lang-vi">
<?php $i=1 ?>
<?php if(is_array($_DATA['listMod'])) { foreach($_DATA['listMod'] as $kl => $vl) { ?>
<div class="portlet">
<div class="portlet-title">
<?php if($i==1) { ?>
<div class="caption">
<i class="fa fa-navicon"></i><?php echo lang('quan_ly_meta_toan_trang');?></div>

<div class="actions btn-set btn-add">
<a href="javascript:void(0);" class="btn green saveSetting" data-action="saveAll"><i class="fa fa-plus"></i> Lưu </a>
<input type="hidden" name="action" value="saveAll" />
</div>	
</div>
<?php } ?>
<div class="portlet-body">
<div class="form-body">
<div class="portlet light bordered">
<div class="portlet-title">
<div class="caption">
<i class="icon-equalizer font-red-sunglo"></i>
<span class="caption-subject font-red-sunglo bold uppercase"><?=$vl?></span>

</div>
<div class="tools">
<a href="javascript:;" class="collapse"></a>
</div>
</div>
<div class="portlet-body form">
<?php if($kl=='facebook') { ?>
<p class="text-info"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo lang('thongtin_sudung_quanly_binhluan');?></p>
<div class="form-group">
<label class="col-md-2 control-label">Admin Facebook ID</label>
<div class="col-md-4">
<input type="number" class="form-control" name="setting[home][facebook_admin]" value="<?php if($_DATA['meta']['home']['facebook_admin']) { ?><?=$_DATA['meta']['home']['facebook_admin']?><?php } ?>" placeholder="" data-error="">
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label">App Facebook ID</label>
<div class="col-md-4">
<input type="number" class="form-control" name="setting[home][facebook_app]" value="<?php if($_DATA['meta']['home']['facebook_app']) { ?><?=$_DATA['meta']['home']['facebook_app']?><?php } ?>" placeholder="" data-error="">
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"> Version App Facebook</label>
<div class="col-md-4">
<input type="text" class="form-control" name="setting[home][facebook_ver_app]" value="<?php if($_DATA['meta']['home']['facebook_ver_app']) { ?><?=$_DATA['meta']['home']['facebook_ver_app']?><?php } ?>" placeholder="" data-error="">
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label">Link Facebook Chat</label>
<div class="col-md-4">
<input type="text" class="form-control" name="setting[home][link_fanpage]" value="<?php if($_DATA['meta']['home']['link_fanpage']) { ?><?=$_DATA['meta']['home']['link_fanpage']?><?php } ?>" placeholder="link fanpage" data-error="">
</div>
</div>

<div class="form-group">
<label class="col-md-2 col-sm-3 control-label">Google Re-marketing</label>
<div class="col-md-10 col-sm-9">
<div class="demo-analytics portlet light bordered">
<h3><?php echo lang('doan_ma_google');?></h3>
<span><?php echo lang('copy_note_google');?></span>
<hr>
<div class="row col-md-3 col-sm-5">
<input type="text" class="form-control" placeholder="ID Google Re-marketing" value="<?php if($_DATA['meta']['home']['google_remarketing']) { ?><?=$_DATA['meta']['home']['google_remarketing']?><?php } ?>" maxlength="50" name="setting[home][google_remarketing]">
</div>
<div class="clear"></div>
</br>
<p>&lt;script type="text/javascript"&gt;</p>
<p style="text-indent:20px">/ &lt;![CDATA[ /</p>
<p style="text-indent:40px">var google_conversion_id = <span>988990967</span>;</p>
<p style="text-indent:40px">var google_custom_params = window.google_tag_params;</p>
<p style="text-indent:40px">var google_remarketing_only = true;</p>
<p style="text-indent:20px">/ ]]&gt; /</p>
<p>&lt;/script&gt;</p>
<p>&lt;script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"&gt;&lt;/script&gt;</p>
<p>&lt;noscript&gt;</p>
<p style="text-indent:40px">&lt;div style="display:inline;"&gt;</p>
<p style="text-indent:60px">&lt;img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/<span>988990967</span>/?value=0&amp;guid=ON&amp;script=0"/&gt;</p>
<p style="text-indent:40px">&lt;/div&gt;</p>
<p>&lt;/noscript&gt;</p>
</div>
</div>
</div>


<div class="form-group">
<label class="col-md-2 col-sm-3 control-label">Facebook Retarget</label>
<div class="col-md-10 col-sm-9">
<div class="demo-analytics portlet light bordered">
<h3><?php echo lang('doan_ma_facebook');?></h3>
<span><?php echo lang('copy_note_facebook');?></span>
<hr>
<div class="row col-md-3 col-sm-5">
<input type="text" class="form-control" placeholder="ID Facebook Retarget" value="<?php if($_DATA['meta']['home']['facebook_retarget']) { ?><?=$_DATA['meta']['home']['facebook_retarget']?><?php } ?>" maxlength="50" name="setting[home][facebook_retarget]">
</div>
<div class="clear"></div>
<br>
<p>&lt;script type="text/javascript"&gt;</p>
<p style="text-indent:20px">!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','//connect.facebook.net/en_US/fbevents.js');</p>
<p style="text-indent:20px">fbq('init', '<span>FB_PIXEL_ID</span>);</p>
<p style="text-indent:20px">fbq('track', 'PageView');</p>
<p>&lt;/script&gt;</p>
<p>&lt;noscript&gt;</p>
<p style="text-indent:20px">&lt;img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=<span>FB_PIXEL_ID</span>&amp;ev=PageView&amp;noscript=1"
/&gt;</p>
<p>&lt;/noscript&gt;</p>
</div>
</div>
</div>


<?php } else { ?>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('meta_title');?></label>
<div class="col-md-8">
<input type="text" class="form-control maxlength-handler" name="setting[<?=$kl?>][meta_title]" maxlength="170" value="<?php if($_DATA['meta'][$kl]['meta_title']) { ?><?=$_DATA['meta'][$kl]['meta_title']?><?php } ?>" placeholder="" data-error="">
<span class="help-block">
<?php echo lang('maxlength','170');?></span>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('meta_keyword');?></label>
<div class="col-md-8">
<input id="meta_keyword" name="setting[<?=$kl?>][meta_keyword]" type="text" class="form-control tags" value="<?php if($_DATA['meta'][$kl]['meta_keyword']) { ?><?=$_DATA['meta'][$kl]['meta_keyword']?><?php } ?>"/>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label"><?php echo lang('meta_description');?></label>
<div class="col-md-8">
<textarea class="form-control maxlength-handler" rows="4" name="setting[<?=$kl?>][meta_description]" maxlength="500"><?php if($_DATA['meta'][$kl]['meta_description']) { ?><?=$_DATA['meta'][$kl]['meta_description']?><?php } ?></textarea>
<span class="help-block">
<?php echo lang('maxlength','500');?> </span>
</div>
</div>
<?php } ?>

</div>
</div>
</div>
</div>
</div>
<?php $i=$i+1 ?>
<?php } } ?>
</form>
</div>
</div>
<!-- END PAGE CONTENT-->
<style type="text/css">
.demo-analytics > p > span {
    background: rgba(212, 63, 58, 0.4);
    padding: 0px 3px;
}
.clear{
clear: both;
}
</style>
<script src="<?=$_B['mod_theme']?>js/meta.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
SettingMeta.init();
});
</script>




