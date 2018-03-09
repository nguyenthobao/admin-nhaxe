<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/template/homes.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?><div class="row">
    <div class="col-md-12">
        <form class="form-horizontal form-row-seperated" action="" id="form_slide" class="form-horizontal" enctype="multipart/form-data" method="POST">
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption"> <i class="fa fa-shopping-cart"></i><?php echo lang('homes_manager');?></div>
                    <div class="actions btn-set">
                        <button type="button" class="btn blue btn-info" data-toggle="modal" data-target="#copyHome"><i class="fa fa-copy"></i> <?php echo lang('saocheptrangchu');?></button>
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
                    <div class="tabbable" id="lang_tab_bar">
                        <ul class="nav nav-tabs">
                            <?php if(is_array($url_lang)) { foreach($url_lang as $k_lang => $v_lang) { ?>
                            <li <?php if($k_lang==$get_lang) { ?>class="active"<?php } ?>> 
                                <a class="select_lang" href="<?=$v_lang['url']?>" > <?php echo lang('lang_'.$k_lang);?> </a>
                            </li>
                            <?php } } ?>
                        </ul>
                        <div class="tab-content no-space">
                            <div class="tab-pane active" id="lang_<?=$get_lang?>">
                                <div class="form-body">
                                    <div class="note note-warning">
                                        <p class="block"><?php echo lang('select_lang','lang_'.$get_lang);?></p>
                                    </div>

                                    <!-- BEGIN PAGE CONTENT-->
                                    <div class="row">
                                        <div class="col-md-8"> 
                                            <div class="todo-content">
    <div class="portlet rio_custom_a">
        <!-- PROJECT HEAD -->
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-bar-chart font-green-sharp hide"></i>
                <span class="caption-helper"><?php echo lang('danhsachblockcua');?> :</span>&nbsp;
                <span class="namemodselect caption-subject font-green-sharp bold uppercase"><?php echo lang($module);?></span>
            </div>
            <div class="actions">
                <div class="btn-group">
                    <a class="btn green-haze btn-circle btn-sm" href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        Chọn module <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu pull-right">

                        <?php if(is_array($web['modules'])) { foreach($web['modules'] as $k => $v) { ?> 
                        <li>
                            <a href="javascript:;" class="select_module" data-name="<?php echo lang($v);?>" data-id="<?=$k?>"><?php echo lang($v);?><span class="badge badge-danger"><?=$count['store'][$k]?></span> </a>
                        </li>
                        <?php } } ?> 


                    </ul>
                </div>
            </div>
        </div>
        <!-- end PROJECT HEAD -->
        <div class="portlet-body">
            <div>
                <div class="rio-list-module">
                    <style type="text/css">
                        #loading_store{
                            text-align: center;
                            display: none;
                            margin: 25px; 
                        } 
                    </style>
                    <div id="loading_store">
                        <img src="http://dev2.webbnc.vn/themes/default/assets/global/img/loading-spinner-default.gif" />
                    </div>
                    <ul class="row" id="store_content">

                     <?php if(is_array($blocks)) { foreach($blocks as $k => $v) { ?>
                     <li class="col-md-4 block_of_module module_<?=$v['module']?>" id="STORE<?=$v['id']?>" data-file="<?=$v['file']?>" data-module-id="<?=$v['module']?>" data-module="<?=$v['module_str']?>" >
                        <div class="rlm-item">
                            <div class="dragTool">
                                <div class="rlm-move">
                                    <span class="fa fa-sort"></span>
                                </div>
                                <div class="rlm-current"></div>
                                <div class="rlm-tool">
                                    <a title="Lên trên" class="rlm-up">
                                        <span class="fa fa-arrow-circle-up"></span>
                                    </a>
                                    <a title="Xuống dưới" class="rlm-down">
                                        <span class="fa fa-arrow-circle-down"></span>
                                    </a>
                                    <a title="Hiện thị" class="rlm-hidden">
                                        <span class="fa fa-eye-slash"></span>
                                    </a>
                                    <a title="Xóa" class="rlm-del">
                                        <span class="fa fa-times"></span>
                                    </a>
                                    <a title="Cài đặt" class="rlm-set cai_dat" data-toggle="modal" data-target="#blockSetting">
                                        <span class="fa fa-cog"></span>
                                    </a>
                                </div>
                            </div>
                            <a class="rlm-use"><?php echo lang('sudung');?></a>
                            <h2><?=$v['name']?></h2>
                             <span class="tieude-df"><?=$v['name_default']?> </span>
                            <img class="img-responsive" src="<?=$v['thumb']?>" />
                        </div>
                    </li>

                    <?php } } ?>          
                </ul>

                <div class="clearfix"></div>
            </div>
        </div>



    </div>
</div>
</div> 
                                        </div>
                                        <div class="col-md-4"> 
                                            <div class="todo-content">
    <div class="portlet rio_custom_a">
        <!-- PROJECT HEAD -->
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-bar-chart font-green-sharp hide"></i>
                <span class="caption-helper"><?php echo lang('vitri');?>:</span>&nbsp;
                <span class="caption-subject font-green-sharp bold uppercase"><?php echo lang('trangchu');?></span>
            </div>
            
        </div>
        <!-- end PROJECT HEAD -->
        <div class="portlet-body">
            <div class="rio-block-style">
                <div id="rio-drag">
                    <div class="rio-list-module">
                        <ul class="row">
                            <?php if(is_array($blockUse)) { foreach($blockUse as $k => $v) { ?>
                            <li data-sort="1" id="<?=$v['id']?>" data-idblock="<?=$v['idhome']?>"  data-file="<?=$v['file']?>" data-module="<?=$v['module_str']?>" data-module-id="<?=$v['module']?>"   class="<?php if($v['status']==1) { ?> active <?php } else { ?> noactive <?php } ?> block_of_module module_<?=$v['module']?>"  data-module-id="<?=$v['module']?>">
                                <div class="rlm-item">
                                    <div class="dragTool">
                                        <div class="rlm-move">
                                            <span class="fa fa-sort"></span>
                                        </div>
                                        <div class="rlm-current"></div>
                                        <div class="rlm-tool">
                                            <a title="Lên trên" class="rlm-up">
                                                <span class="fa fa-arrow-circle-up"></span>
                                            </a>
                                            <a title="Xuống dưới" class="rlm-down">
                                                <span class="fa fa-arrow-circle-down"></span>
                                            </a>
                                            <a title="<?php if($v['status']==1) { ?> Ẩn  <?php } else { ?> Hiện <?php } ?>" class="rlm-hidden">
                                                <span class="<?php if($v['status']==1) { ?> fa fa-eye-slash <?php } else { ?> fa fa-eye <?php } ?> "></span>
                                            </a>
                                            <a title="Xóa" class="rlm-del">
                                                <span class="fa fa-times"></span>
                                            </a>
                                            <a title="<?php echo lang('caidat');?>" class="rlm-set " data-toggle="modal" data-target="#blockSetting">
                                                <span class="fa fa-cog"></span>
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <h2><?=$v['title']?></h2>
                                     <span class="tieude-df"><?=$v['name_default']?> </span>
                                    <a class="rlm-use"><?php echo lang('sudung');?></a>
                                    <img class="img-responsive" src="<?=$v['thumb']?>" />
                                </div>
                            </li>
                            <?php } } ?>
                            
                        </ul>
                        <div class="clearfix"></div>
                        <!-- Đoạn load popup-->
                        <!-- Modal -->
                        <div class="modal fade" id="blockSetting" tabindex="-1" role="dialog" aria-labelledby="blockSettingLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        <h4 class="modal-title" id="blockSettingLabel"><?php echo lang('caidat');?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal">
                                          <div class="form-group">
                                             <label for="inputEmail3" class="col-sm-4 control-label"><?php echo lang('dieude');?></label>
                                            <div class="col-sm-8">
                                              <input name="titleHome" class="form-control" value="">
                                              <input type="hidden" name="idHome"  value="">
                                            </div>
                                          </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close');?></button>
                                        <button type="button" class="btn btn-primary save_changes"><?php echo lang('save_changes');?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
                                        </div>
                                    </div>
                                    <!-- END PAGE CONTENT-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

<!-- Modal -->
<div class="modal fade" id="copyHome" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<form role="form" id="formCopy" action="/template-Language-copyHomes-lang-<?=$get_lang?>">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('saocheptrangchu');?></h4>
      </div>
      <div class="modal-body">
        <div class="note note-warning">
            <p class="block">
                <?php echo lang('note_trangchu');?><br/>
            </p>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label><?php echo lang('chon_ngon_ngu_copy');?></label>
                <select name="copy[copyHomes]" class="form-control">
                    <?php if(is_array($url_lang)) { foreach($url_lang as $k_lang => $v_lang) { ?>
                                <?php if($k_lang!=$get_lang) { ?>
                                    <option value="<?=$k_lang?>"><?php echo lang('lang_'.$k_lang);?></option>
                                <?php } ?>
                    <?php } } ?>
                </select>
            </div>
            <div class="col-md-6">
                <label><?php echo lang('delallhome');?></label> <br/>
                <input class="form-control" value="1" type="checkbox" name="copy[emptyHomes]"> <?php echo lang('empty_for_copy');?>
            </div>
            <input type="hidden" name="copy[currentLang]" value="<?=$get_lang?>">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close');?></button>
        <button type="submit" class="btn btn-primary"><?php echo lang('ok');?></button>
      </div>
    </div>
  </div>
  </form>
</div>

</div>
<style type="text/css">
 .cai_dat{
      display: none !important;
  }
.divMove{
  position: absolute;
  z-index: 90;
}
.divMovePos{
  position: absolute;
  z-index: 90;
}
.portlet > .portlet-title > .caption { 
  white-space: nowrap;
}
.rio_custom_a {
    padding: 12px 20px 15px 20px;
    background-color: #F7F7F7;
    border: 1px solid #DDD;
}
.rio-block-style {
   border: 1px solid #EDEDED;
background: #FFF;
}
.ui-state-highlight {
    height: 200px;
    line-height: 200px;
    border: 1px dashed #000 !important
}
.rio-list-module {
    position: relative;
}
.rio-list-module ul {
    list-style: none;
    padding: 0;
    margin: 0;
 
}
.rio-list-module ul li{
  margin-bottom: 28px;
  
}
.rio-list-module ul li .dragTool {
    display: none;

}
.rio-list-module ul li .rlm-item a.rlm-use {
    display: none;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
    background: #0E98D5;
    width: 100px;
    height: 24px;
    text-align: center;
    line-height: 24px;
    font-weight: 400;
    border-radius: 3px !important;
    color: #FFF;
    cursor: pointer;
    text-decoration: none;
    box-shadow: 0 0 4px rgba(0, 0, 0, 0.12);
}
.rio-list-module ul li .rlm-item:hover a.rlm-use {
    display: block;
}
.rio-list-module ul li .rlm-item:hover {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.19);
}
.rio-list-module ul li .rlm-item {
   padding: 2px;
border: 1px solid #EDEDED;
background: #FFF;
position: relative;
 
   
}
.rio-list-module ul li h2 {
  margin: 0;
  padding: 0;
  font-size: 12px;
  line-height: 25px;
  background: #0DA3E2;
  color: #FFF;
  font-weight: 400;
  text-align: center;
  position: relative;
}
.rio-list-module ul li img {} .rio-block-style .rio-list-module ul {
    list-style: none;
    padding: 0;
    margin: 0
}
.rio-block-style .rio-list-module ul li .dragTool {
    display: block;
}
.rio-block-style .rio-list-module ul li {
    margin: 14px;
    
}
.rio-block-style .rio-list-module ul li .rlm-item a.rlm-use {
    display: none;
}
.rio-block-style .rio-list-module ul li .rlm-item .rlm-tool {
    display: none;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
    background: #0E98D5;
    width: 147px;
    height: 28px;
    text-align: center;
    line-height: 24px;
    font-weight: 400;
    border-radius: 0px !important;
    color: #FFF;
    cursor: pointer;
    text-decoration: none;
    box-shadow: 0 0 4px rgba(0, 0, 0, 0.12);
}
.rio-block-style .rio-list-module ul li .rlm-item .rlm-move {
    position: absolute;
    top: 0;
    right: 0;
    width: 40px;
    height: 36px;
    color: #FFF;
    text-align: center;
    line-height: 35px;
    background: rgba(0, 0, 0, 0.12);
    cursor: move;
    z-index: 90;
}
.rio-block-style .rio-list-module ul li .rlm-item .rlm-current {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 100%;
    height: 20px;
    color: #FFF;
    text-align: center;
    line-height: 20px;
    background: rgba(0, 0, 0, 0.12);
    cursor: move;
    z-index: 1;
}
.rio-block-style .rio-list-module ul li .rlm-item .rlm-tool a {
    color: #FFF;
    display: inline-block;
    background: rgba(0, 207, 255, 0.23);
    padding: 0px 4px;
    margin: 0;
    margin-top: 2px;
}
.rio-block-style .rio-list-module ul li .rlm-item .rlm-tool a:hover {
    background: rgba(0, 207, 255, 0.83);
}
.rio-block-style .rio-list-module ul li .rlm-item:hover .rlm-tool {
    display: block;
}
.rio-block-style .rio-list-module ul li .rlm-item:hover {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.19);
}
.rio-block-style .rio-list-module ul li .rlm-item {
    padding: 0px;
    border: 1px solid #FF7177;
    margin-bottom: 14px;
    border-radius: 0px !important;
    background: #FFF;
    box-shadow: none;
    position: relative;
}
.rio-block-style .rio-list-module ul li h2 {
    margin: 0;
    padding: 0;
    font-size: 12px;
    line-height: 20px;
    background: #FF7177;
    padding-left: 8px;
    color: #FFF;
    text-transform: uppercase;
    font-weight: 400;
}
.rio-block-style .rio-list-module ul li.noactive h2 {
    margin: 0;
    padding: 0;
    font-size: 12px;
    line-height: 20px;
    background: #9E9E9E;
    padding-left: 8px;
    color: #FFF;
    text-transform: uppercase;
    font-weight: 400;
}
.rio-block-style .rio-list-module ul li.noactive .rlm-item {
    border: 1px solid #A3A3A3;
}
.rio-block-style .rio-list-module ul li.noactive span.tieude-df {
    background: #9E9E9E;
}
.rio-block-style .rio-list-module ul li img {}
.rio-block-style .rio-list-module ul li span.tieude-df{
  display: block;
  text-align: center;
  font-size: 11px;
  color: #fff;
  text-transform:none;
  background: #FF7177;
  width: 100%;
  padding: 1px;
}
#store_content span.tieude-df{
  display: none;
}
@-webkit-keyframes bounceOut {
  0% {
    -webkit-transform: scale(1);
    transform: scale(1);
  }

  25% {
    -webkit-transform: scale(.95);
    transform: scale(.95);
  }

  50% {
    opacity: 1;
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
  }

  100% {
    opacity: 0;
    -webkit-transform: scale(.3);
    transform: scale(.3);
  }
}

@keyframes bounceOut {
  0% {
    -webkit-transform: scale(1);
    -ms-transform: scale(1);
    transform: scale(1);
  }

  25% {
    -webkit-transform: scale(.95);
    -ms-transform: scale(.95);
    transform: scale(.95);
  }

  50% {
    opacity: 1;
    -webkit-transform: scale(1.1);
    -ms-transform: scale(1.1);
    transform: scale(1.1);
  }

  100% {
    opacity: 0;
    -webkit-transform: scale(.3);
    -ms-transform: scale(.3);
    transform: scale(.3);
  }
} 
.bounceOut {
  -moz-animation: bounceOut 0.9s;
    animation: bounceOut 0.9s;
    -webkit-animation: bounceOut 0.9s;
}
 
@-webkit-keyframes zoomOutRight {
  40% {
    opacity: 1;
    -webkit-transform: scale3d(.475, .475, .475) translate3d(-42px, 0, 0);
            transform: scale3d(.475, .475, .475) translate3d(-42px, 0, 0);
  }

  100% {
    opacity: 0;
    -webkit-transform: scale(.1) translate3d(2000px, 0, 0);
            transform: scale(.1) translate3d(2000px, 0, 0);
    -webkit-transform-origin: right center;
            transform-origin: right center;
  }
}

@keyframes zoomOutRight {
  40% {
    opacity: 1;
    -webkit-transform: scale3d(.475, .475, .475) translate3d(-42px, 0, 0);
            transform: scale3d(.475, .475, .475) translate3d(-42px, 0, 0);
  }

  100% {
    opacity: 0;
    -webkit-transform: scale(.1) translate3d(2000px, 0, 0);
            transform: scale(.1) translate3d(2000px, 0, 0);
    -webkit-transform-origin: right center;
            transform-origin: right center;
  }
}

.zoomOutRight {
   -moz-animation: zoomOutRight 0.5s;
    animation: zoomOutRight 0.5s;
    -webkit-animation: zoomOutRight 0.5s;
}

 
@-webkit-keyframes zoomInRight {
  0% {
    opacity: 0;
    -webkit-transform: scale3d(.1, .1, .1) translate3d(1000px, 0, 0);
            transform: scale3d(.1, .1, .1) translate3d(1000px, 0, 0);
    -webkit-animation-timing-function: cubic-bezier(0.550, 0.055, 0.675, 0.190);
            animation-timing-function: cubic-bezier(0.550, 0.055, 0.675, 0.190);
  }

  60% {
    opacity: 1;
    -webkit-transform: scale3d(.475, .475, .475) translate3d(-10px, 0, 0);
            transform: scale3d(.475, .475, .475) translate3d(-10px, 0, 0);
    -webkit-animation-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1);
            animation-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1);
  }
}

@keyframes zoomInRight {
  0% {
    opacity: 0;
    -webkit-transform: scale3d(.1, .1, .1) translate3d(1000px, 0, 0);
            transform: scale3d(.1, .1, .1) translate3d(1000px, 0, 0);
    -webkit-animation-timing-function: cubic-bezier(0.550, 0.055, 0.675, 0.190);
            animation-timing-function: cubic-bezier(0.550, 0.055, 0.675, 0.190);
  }

  60% {
    opacity: 1;
    -webkit-transform: scale3d(.475, .475, .475) translate3d(-10px, 0, 0);
            transform: scale3d(.475, .475, .475) translate3d(-10px, 0, 0);
    -webkit-animation-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1);
            animation-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1);
  }
}

.zoomInRight {
   -moz-animation: zoomInRight 1s;
    animation: zoomInRight 1s;
    -webkit-animation: zoomInRight 1s;
}
@-webkit-keyframes zoomInLeft {
  0% {
    opacity: 0;
    -webkit-transform: scale3d(.1, .1, .1) translate3d(-1000px, 0, 0);
            transform: scale3d(.1, .1, .1) translate3d(-1000px, 0, 0);
    -webkit-animation-timing-function: cubic-bezier(0.550, 0.055, 0.675, 0.190);
            animation-timing-function: cubic-bezier(0.550, 0.055, 0.675, 0.190);
  }

  60% {
    opacity: 1;
    -webkit-transform: scale3d(.475, .475, .475) translate3d(10px, 0, 0);
            transform: scale3d(.475, .475, .475) translate3d(10px, 0, 0);
    -webkit-animation-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1);
            animation-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1);
  }
}

@keyframes zoomInLeft {
  0% {
    opacity: 0;
    -webkit-transform: scale3d(.1, .1, .1) translate3d(-1000px, 0, 0);
            transform: scale3d(.1, .1, .1) translate3d(-1000px, 0, 0);
    -webkit-animation-timing-function: cubic-bezier(0.550, 0.055, 0.675, 0.190);
            animation-timing-function: cubic-bezier(0.550, 0.055, 0.675, 0.190);
  }

  60% {
    opacity: 1;
    -webkit-transform: scale3d(.475, .475, .475) translate3d(10px, 0, 0);
            transform: scale3d(.475, .475, .475) translate3d(10px, 0, 0);
    -webkit-animation-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1);
            animation-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1);
  }
}

.zoomInLeft {
   -moz-animation: zoomInLeft 1s;
    animation: zoomInLeft 1s;
    -webkit-animation: zoomInLeft 1s;
}
@-webkit-keyframes flash {
  0%, 50%, 100% {
    opacity: 1;
  }

  25%, 75% {
    opacity: 0;
  }
}

@keyframes flash {
  0%, 50%, 100% {
    opacity: 1;
  }

  25%, 75% {
    opacity: 0;
  }
}

.flash {
  -moz-animation: flash 0.7s;
    animation: flash 0.7s;
    -webkit-animation: flash 0.7s;
}

@-webkit-keyframes pulse {
  0% {
    -webkit-transform: scale3d(1, 1, 1);
            transform: scale3d(1, 1, 1);
  }

  50% {
    -webkit-transform: scale3d(1.05, 1.05, 1.05);
            transform: scale3d(1.05, 1.05, 1.05);
  }

  100% {
    -webkit-transform: scale3d(1, 1, 1);
            transform: scale3d(1, 1, 1);
  }
}

@keyframes pulse {
  0% {
    -webkit-transform: scale3d(1, 1, 1);
            transform: scale3d(1, 1, 1);
  }

  50% {
    -webkit-transform: scale3d(1.05, 1.05, 1.05);
            transform: scale3d(1.05, 1.05, 1.05);
  }

  100% {
    -webkit-transform: scale3d(1, 1, 1);
            transform: scale3d(1, 1, 1);
  }
}

.pulse {
  -moz-animation: pulse 1s;
    animation: pulse 1s;
    -webkit-animation: pulse 1s;
}
 

@-webkit-keyframes shake {
  0%, 100% {
    -webkit-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
  }

  10%, 30%, 50%, 70%, 90% {
    -webkit-transform: translate3d(-10px, 0, 0);
            transform: translate3d(-10px, 0, 0);
  }

  20%, 40%, 60%, 80% {
    -webkit-transform: translate3d(10px, 0, 0);
            transform: translate3d(10px, 0, 0);
  }
}

@keyframes shake {
  0%, 100% {
    -webkit-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
  }

  10%, 30%, 50%, 70%, 90% {
    -webkit-transform: translate3d(-10px, 0, 0);
            transform: translate3d(-10px, 0, 0);
  }

  20%, 40%, 60%, 80% {
    -webkit-transform: translate3d(10px, 0, 0);
            transform: translate3d(10px, 0, 0);
  }
}

.shake {
  -moz-animation: shake 1s;
    animation: shake 1s;
    -webkit-animation: shake 1s;
}
@-webkit-keyframes zoomOutDown {
  40% {
    opacity: 1;
    -webkit-transform: scale3d(.475, .475, .475) translate3d(0, -60px, 0);
            transform: scale3d(.475, .475, .475) translate3d(0, -60px, 0);
    -webkit-animation-timing-function: cubic-bezier(0.550, 0.055, 0.675, 0.190);
            animation-timing-function: cubic-bezier(0.550, 0.055, 0.675, 0.190);
  }

  100% {
    opacity: 0;
    -webkit-transform: scale3d(.1, .1, .1) translate3d(0, 2000px, 0);
            transform: scale3d(.1, .1, .1) translate3d(0, 2000px, 0);
    -webkit-transform-origin: center bottom;
            transform-origin: center bottom;
    -webkit-animation-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1);
            animation-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1);
  }
}

@keyframes zoomOutDown {
  40% {
    opacity: 1;
    -webkit-transform: scale3d(.475, .475, .475) translate3d(0, -60px, 0);
            transform: scale3d(.475, .475, .475) translate3d(0, -60px, 0);
    -webkit-animation-timing-function: cubic-bezier(0.550, 0.055, 0.675, 0.190);
            animation-timing-function: cubic-bezier(0.550, 0.055, 0.675, 0.190);
  }

  100% {
    opacity: 0;
    -webkit-transform: scale3d(.1, .1, .1) translate3d(0, 2000px, 0);
            transform: scale3d(.1, .1, .1) translate3d(0, 2000px, 0);
    -webkit-transform-origin: center bottom;
            transform-origin: center bottom;
    -webkit-animation-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1);
            animation-timing-function: cubic-bezier(0.175, 0.885, 0.320, 1);
  }
}

.zoomOutDown {
 -moz-animation: zoomOutDown 1s;
    animation: zoomOutDown 1s;
    -webkit-animation: zoomOutDown 1s;
}
</style>  
<link rel="stylesheet" href="<?=$_B['home_theme']?>assets/global/plugins/jquery-ui/jquery-ui.css">
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery-ui/jquery-ui.js"></script>
<script src="<?=$_B['home_theme']?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-toastr/toastr.min.css"/>
<script type="text/javascript" src="<?=$_B['home_theme']?>assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
<script>
$(document).ajaxStart(function() {
    Metronic.startPageLoading('Đang khởi tạo dữ liệu....');
});
$(document).ajaxStop(function() {
    Metronic.stopPageLoading();
});
$(document).ready(function(){

$(function() {

    $("#formCopy").submit(function(e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url : $(this).attr("action"),
                type: 'POST',
                dataType: 'json',
                data: formData,
                cache : false,
                processData: false,
                contentType: false
            }).success(function(response) {
                $('#copyHome').modal('hide');
                if(response.status==true){
                    toastr.success(response.message);
                }else{
                    toastr.error('Error');
                }
            });
            return false;
    });

    $('.select_module').click(function(){
        var idmod = $(this).attr('data-id');
        var namemod = $(this).attr('data-name');
        if(idmod == 0){
            $('.block_of_module').fadeIn();
        }
        else
        {
            var element ='.module_'+idmod;
            $('.block_of_module').fadeOut();
            $(element).fadeIn();
        }
        $('.namemodselect').text(namemod);
    });


    $("#rio-drag ul").sortable({
        placeholder: "ui-state-highlight",
        handle: ".rlm-move",
        stop: function() { 

            $(this).find("li").removeClass("zoomInLeft");
            $(this).find("li").addClass("pulse");
            getArray("drag");
        }
    });

    $("#rio-drag ul").disableSelection();

    //Ham lay ra vi mang vi tri hien tai
    function getArray(act,id) {
        var arr = new Array();
        $("#rio-drag ul li").each(function(dataIndex) {
            var old_sort = $(this).attr("data-sort");
            $(this).attr("data-sort", dataIndex + 1);
            var id_block = $(this).attr("data-idblock");
            //var pos_block = $(this).attr("data-position");
            var current_sort = $(this).attr("data-sort");
            var name_block = $(this).find('h2').text();
            var module_name_block = $(this).attr("data-module");
            var module_id_block = $(this).attr("data-module-id");
            var file_block =  $(this).attr("data-file");
             

            arr.push({  
                idhome: id_block,
                module: module_id_block,
                module_str: module_name_block,
                file: file_block,
                sort: current_sort,
                title: name_block
         
            });

            
            //$(this).find(".rlm-current").text("Thứ tự: " + cid + " - Mã: " + bid + " - Vị trí: " + pid);
            
        });
       
       
        
        if (act=='use-block') {
            var arrJs =JSON.stringify(arr);
            //Insert and update block
            save_Data(arrJs);  
        }
        else if(act=='del-block')
        {
            delete_Data(id);

        }else if (act=='hide-block') 
        {
            var sArr = {status:0};
            var arrJs =JSON.stringify(sArr);
            update_status_block(arrJs,id,"hide" );
        }else if (act=='show-block') 
        {
            var sArr = {status:1};
            var arrJs =JSON.stringify(sArr);
            update_status_block(arrJs,id,"show" );
        }else if(act=='drag-up-block'){
             var arrJs =JSON.stringify(arr);
             save_Data(arrJs,'drag');  
        }else if(act=='drag-down-block'){
             var arrJs =JSON.stringify(arr);
             save_Data(arrJs,'drag');  
        }else if(act=='drag'){
             var arrJs =JSON.stringify(arr);
             save_Data(arrJs,'drag');  
        };

          
        //Delete block
        return arr; 
    }

    function save_Data(arrJs,pos,action){
        $.ajax({
            url: 'template-homes-ajax-lang-<?=$get_lang?>',
            type: 'POST', 
            data: {action:'saveposition', arr: arrJs},
            success: function(data){
                console.log(data);
                if (action == 'drag') {
                    toastr.success("Cập nhập vị trí thành công !");    
                }else{
                    toastr.success("Thêm block thành công !");
                };
                
               
            }
        });
    }

    function delete_Data(idhome){
       //alert(idblock +" - "+idposition);
        $.ajax({
            url: 'template-homes-ajax-lang-<?=$get_lang?>',
            type: 'POST', 
            data: {action:'delblock',id: idhome},
            success: function(data){
                console.log(data);
                toastr.success("Xóa block thành công !");
            }
        });
    }

    function update_status_block(arrJs,idblock,status){
       
        $.ajax({
            url: 'template-homes-ajax-lang-<?=$get_lang?>',
            type: 'POST', 
            data: {action:'hiddenblock',arr: arrJs, id: idblock},
            success: function(data){
                console.log(data);
                if (status=="show") {
                    toastr.success("Hiện thị block thành công!");
                }else{
                    toastr.success(" block thành công !");
                };
                
            }
        });
    }


//     function reloadstore(){
//         $('#loading_store').slideToggle('slow');
//         $('#store_content').html('');
//         $.ajax({
//             url: 'template-block-ajax-lang-vi',
//             type: 'POST',
//             data: {action:'getstore'},
//             success: function(data){
//                 $('#loading_store').slideToggle('slow');
//                 $.each( data.blocks, function( key, value ) { 
// var html = '<li class="col-md-4" id="STORE'+value.id+'">'+
// '<div class="rlm-item">'+
// '    <div class="dragTool">'+
// '       <div class="rlm-move">'+
// '          <span class="fa fa-sort"></span>'+
// '     </div>'+
// '    <div class="rlm-current"></div>'+
// '   <div class="rlm-tool">'+
// '       <a title="Lên trên" class="rlm-up">'+
// '           <span class="fa fa-arrow-circle-up"></span>'+
// '       </a>'+
// '       <a title="Xuống dưới" class="rlm-down">'+
// '       <span class="fa fa-arrow-circle-down"></span>'+
// '       </a>'+
// '       <a title="Hiện thị" class="rlm-hidden">'+
// '          <span class="fa fa-eye-slash"></span>'+
// '       </a>'+
// '    <a title="Xóa" class="rlm-del">'+
// '         <span class="fa fa-times"></span>'+
// '       </a>'+
// '       <a title="Cài đặt" class="rlm-set" data-toggle="modal" data-target="#blockSetting">'+
// '           <span class="fa fa-cog"></span>'+
// '       </a>'+
// '   </div>'+
// ' </div>'+
// ' <a class="rlm-use">Sử dụng</a>'+
// ' <h2>'+value.name+'</h2>'+
// ' <img class="img-responsive" src="'+value.thumb+'" />'+
// '</div>'+
// '</li> ';
//                     $('#store_content').append(html);
//                 });
//             }
//         });
//     }
        //Add block to position

    function checkBlock(){


    }
    $("#store_content").on('click','.rlm-use',function() {


        var divDrag = $("#rio-drag");      
        var divDragOffset = divDrag.offset();

        var currentClickDiv=$(this).parent().parent();

        var newDiv = $("#store_content").append("<li class='col-md-4 divMove '>"+currentClickDiv.html()+"</li>");
        // newDiv.css("position","absolute");
        // alert(currentClickDiv.position.top);

        var id_block = currentClickDiv.attr("id").replace(/STORE/i,"");
                   var pos_block = currentClickDiv.attr("data-position");
                   var current_sort = currentClickDiv.attr("data-sort");
                   var name_block = currentClickDiv.find('h2').text();
                   var module_name_block = currentClickDiv.attr("data-module");
                   var module_id_block = currentClickDiv.attr("data-module-id");
                    
                   var file_block =  currentClickDiv.attr("data-file");

                   var newBlock = "<li  data-idblock="+id_block+" data-file="+file_block+" data-module="+module_name_block+" data-module-id="+module_id_block+"   class='bounceIn' >" + currentClickDiv.html() + "</li>";
                    divDrag.find("ul").prepend(newBlock);
                    getArray('use-block');

        currentClickDiv.find(".rlm-item").css({"background":"#C2C2C2","opacity":"0.5"});
        //currentClickDiv.find("h2").text("");
        currentClickDiv.find(".rlm-use").hide();
        $(".divMove").css({top:currentClickDiv.position().top,left:currentClickDiv.position().left});
        $(".divMove").animate({
            top:10,
            left:(divDragOffset.left - $(window).scrollLeft())- divDrag.width(),
            opacity:0.2
        },500,function(){
             
                 
                   $(this).remove();
        });
          
        currentClickDiv.fadeToggle(1000,"linear",function(){

            currentClickDiv.remove();
        });
            




        // var divDrag = $("#rio-drag");
        // var topOfDrag = parseInt(divDrag.offset().top);
        // var leftOfDrag = divDrag.offset().left;
        // var topCurentDiv = $(this).offset().top;
        // var leftCurentDiv = $(this).offset().left;
        // var newOffsetTop = parseInt(topOfDrag - topCurentDiv + 70);
        // var newOffsetLeft = parseInt(leftOfDrag - leftCurentDiv + 70);
        // var currentClickDiv=$(this).parent().parent();
        // //console.log(clickL);
        // currentClickDiv.css({
        //     "z-index": "9999"
        // });
 
        // //ham animation tam thoi ko dung ------------------------
        //     $(this).parent().parent().animate({
        //        top: newOffsetTop,
        //         left: newOffsetLeft,
        //         opacity: 0,
        //         visibility:"hidden"
        //     }, 1000, function() {

        //         $(this).animate({
        //            // width: 0,
        //             padding: 0
        //         }, 500, function() {
                    
        //             var id_block = $(this).attr("id").replace(/STORE/i,"");
        //             var pos_block = $(this).attr("data-position");
        //             var current_sort = $(this).attr("data-sort");
        //             var name_block = $(this).find('h2').text();
        //             var module_name_block = $(this).attr("data-module");
        //             var module_id_block = $(this).attr("data-module-id");
                    
        //             var file_block =  $(this).attr("data-file");

        //             var newBlock = "<li  data-idblock="+id_block+" data-file="+file_block+" data-module="+module_name_block+" data-module-id="+module_id_block+"   class='bounceIn' >" + $(this).html() + "</li>";
        //             divDrag.find("ul").prepend(newBlock);
        //             getArray('use-block');
        //             $(this).remove();
        //         });

        //     });
        //     // $(this).hide();
        //     // $(this).parent().toggle("scale",400,function(){
        //     // $(this).parent().remove();
        //     //});
        // //--------------------------------------------------------
    });
    
    $("#rio-drag").on('click','.rlm-hidden',function(){
        var parentDiv=$(this).parent().parent().parent().parent();
        if (parentDiv.hasClass("noactive")) {
             parentDiv.removeClass("noactive");
            $(this).find("span").removeClass("fa-eye");
            $(this).find("span").addClass("fa-eye-slash");
            $(this).attr("title","Ẩn");
            var id = parentDiv.attr('data-idblock');
            getArray('show-block',id);
        }else{
             parentDiv.addClass("noactive");
            $(this).find("span").removeClass("fa-eye-slash");
            $(this).find("span").addClass("fa-eye");
            $(this).attr("title","Hiện thị");
            var id = parentDiv.attr('data-idblock');
            getArray('hide-block',id);
        };
       
    });

    $("#rio-drag").on('click','.rlm-del',function(){
        var parentDiv = $(this).parent().parent().parent().parent();
        var id = parentDiv.attr('data-idblock');
         
        var curentBlockId = $(this).parent().parent().parent().parent().attr("data-idblock");
        var file=parentDiv.attr("data-file");
        var module=parentDiv.attr("data-module-id");
        var namemodule=parentDiv.attr("data-module");

        var curentDivPost = parentDiv.offset().left;
        //alert($("#store_content li").size());
            
        if ($("#store_content li").size() >0) {
             var lastchildBlockPos = $('#store_content li:first-child').offset().left;
             var lastchildBlockPosTop = $('#store_content li:first-child').offset().top;
        }else{
            lastchildBlockPos=0;
            lastchildBlockPosTop=0;
        };
       
        var movePos = parseInt(lastchildBlockPos - curentDivPost);
        //alert(curentDivPost +"-"+lastchildBlockPos);
        parentDiv.removeClass("zoomInLeft");
        parentDiv.removeClass("pulse");
        //parentDiv.addClass("bounceOut");
        setTimeout(function(){
           parentDiv.css({'position':'absolute','width':'60%'});
            
        },300);
            
        var store_content = $("#store_content");
        var newDiv = $("#rio-drag ul").append("<li class='divMovePos '>"+parentDiv.html()+"</li>"); 
         $(".divMovePos").css({top:parentDiv.position().top,left:parentDiv.position().left});
        $(".divMovePos").animate({
            top:-10,
            left:-(store_content.offset().left + store_content.width()) + parentDiv.width() - 30,
            opacity:0.1,
            width:"63%"
        },500,function(){
             
                 
                   $(this).remove();
        }); 
        
        setTimeout(function(){
            
            $('#store_content').prepend("<li class='col-md-4' id='STORE"+curentBlockId+"' data-file='"+file+"' data-module='"+namemodule+"' data-module-id='"+module+"'>"+parentDiv.html()+"</li");
            getArray('del-block',id);
            parentDiv.remove();
        },800);
    });
    
    $("#rio-drag").on('click','.rlm-down',function(){
        var parentDiv=$(this).parent().parent().parent().parent();
        var nextDiv=parentDiv.next();
       
       if (parentDiv.is(":last-child")) {
        parentDiv.removeClass("zoomInLeft");
        parentDiv.removeClass("pulse");
        parentDiv.removeClass("bounceOut");
        parentDiv.addClass("shake");
       }else{
        var newDiv=parentDiv.clone();

         $(newDiv).insertAfter(nextDiv);
            parentDiv.remove();
            getArray('drag-down-block');
             $('html, body').animate({
                            scrollTop: nextDiv.offset().top+100
              }, 200);
            newDiv.removeClass("zoomInLeft");
            newDiv.removeClass("pulse");
            newDiv.removeClass("bounceOut");
            newDiv.removeClass("shake");
            newDiv.addClass("pulse");
       };
    });
     

     $("#rio-drag").on('click','.rlm-up',function(){
        var parentDiv=$(this).parent().parent().parent().parent();
        var prevDiv=parentDiv.prev();
       
       if (parentDiv.is(":first-child")) {
        parentDiv.removeClass("zoomInLeft");
        parentDiv.removeClass("pulse");
        parentDiv.removeClass("bounceOut");
        parentDiv.addClass("shake");
       }else{
        var newDiv=parentDiv.clone();
            
            $(newDiv).insertBefore(prevDiv);
            $('html, body').animate({
                            scrollTop: newDiv.offset().top-100
              }, 200);
            parentDiv.remove();
            getArray('drag-up-block');
             
            newDiv.removeClass("zoomInLeft");
            newDiv.removeClass("pulse");
            newDiv.removeClass("bounceOut");
            newDiv.removeClass("shake");
            newDiv.addClass("pulse");
       };
    });
     
     $("#rio-drag").on('click','.rlm-set',function(){
        var name=$(this).parents('li').find('h2').text();
        var id=$(this).parents('li').attr('id');
        var HomeSetting=$('#blockSetting');
        HomeSetting.find('input[name="titleHome"]').val(name);
        HomeSetting.find('input[name="idHome"]').val(id);
    }); 
    
    $('body').on('click','.save_changes',function(event) {
            event.preventDefault();
            var HomeSetting=$('#blockSetting');
            var name=HomeSetting.find('input[name="titleHome"]').val();
            var id=HomeSetting.find('input[name="idHome"]').val();
            $.ajax({
                url: $('base').attr('href')+'/template-homes-ajax-lang-'+$('base').attr('lang'),
                type: 'POST',
                dataType: 'json',
                data: {action: 'savetitle',title:name,id:id},
            })
            .success(function(res) {
               if(res.status==true){
                    toastr.success(res.message);
                    $("#rio-drag").find('li[id="'+id+'"]').find('h2').text(name);
                    HomeSetting.modal('hide');
               }
            });
    });

});

});
</script> 
