<?php 
					/**
					 * @Project BNC v2 -> Adminuser
					 * @File /data/www/superweb/ad/tmp/tpl/template/block_pos_ajax.php 
					 * @Author Quang Chau Tran (quangchauvn@gmail.com) 
					 */
					if(!defined('BNC_CODE')) {
					    exit('Access Denied');
					}
					?> <?php if(is_array($blocks)) { foreach($blocks as $k => $v) { ?>
                            <li data-sort="1" id="<?=$v['id']?>" data-idblock="<?=$v['idblock']?>" data-position="<?=$v['position']?>" data-file="<?=$v['file']?>" data-module="<?=$v['module_str']?>" data-module-id="<?=$v['module']?>"   class="<?php if($v['status']==1) { ?> active <?php } else { ?> noactive <?php } ?> ">
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
                                            <a title="Cài đặt" class="rlm-set cai_dat" data-toggle="modal" data-target="#blockSetting_<?=$v['id']?>">
                                                <span class="fa fa-cog"></span>
                                            </a>
                                        </div>
                                    </div>
                                    <h2 id="h2_tile_block_<?=$v['id']?>"><?=$v['title']?></h2>
                                     <span class="tieude-df"><?=$v['name_default']?> </span>
                                    <a class="rlm-use">Sử dụng</a>
                                    <img class="img-responsive" src="<?=$v['thumb']?>" />
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="blockSetting_<?=$v['id']?>" tabindex="-1" role="dialog" aria-labelledby="blockSettingLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo lang('close');?></span></button>
                                                <h4 class="modal-title" id="blockSettingLabel"><?php echo lang('setting_block');?></h4>
                                            </div>
                                            <div class="modal-body">
                                                  <div class="form-group">
                                                    <label for="title_block_<?=$v['id']?>" class="col-sm-3 control-label"><?php echo lang('title_block');?></label>
                                                    <div class="col-sm-9 prive_posive">
                                                      <input type="text" value="<?=$v['title']?>" class="form-control" id="title_block_<?=$v['id']?>" placeholder="<?php echo lang('title_block');?>">
                                                      <input type="hidden" value="<?=$v['name_default']?>" class="form-control" name="text_default_hd" >
                                                        <button type="button" class="btn btn-primary reset_name"> Mặc định</button>
                                                    </div>
                                                  </div>
                                                  <div class="form-group">
                                                    <label class="col-sm-3 control-label"><?php echo lang('active_module');?></label>
                                                    <style type="text/css">
                                                        .list_modules{
                                                            width: 50%;
                                                            float: left;
                                                        }
                                                    </style>
                                                    <div class="col-sm-9">
                                                       <!-- <div class="list_modules"> 
                                                           <input class="modules_block_label" data="{<?=$v['id']?>" data-value="all" <?php if(1) { ?> checked<?php } ?> type="checkbox" id="modules_block_<?=$v['id']?>_all" name="modules_block_<?=$v['id']?>[]" value="all"> 
                                                           <label class="modules_block_label" data="{<?=$v['id']?>" data-value="all" for="modules_block_<?=$v['id']?>_all"><?php echo lang('all_modules');?></label>
                                                       </div> -->
                                                       <?php if(is_array($mod_in_home)) { foreach($mod_in_home as $km => $vm) { ?>
                                                       <div class="list_modules"> 
                                                           <input class="modules_block_label" data="{<?=$v['id']?>" data-value="<?=$vm?>" <?php if(1) { ?> checked<?php } ?> type="checkbox" id="modules_block_<?=$v['id']?>_<?=$vm?>" name="modules_block_<?=$v['id']?>[]" value="<?=$vm?>"> 
                                                           <label class="modules_block_label" data="{<?=$v['id']?>" data-value="<?=$vm?>" for="modules_block_<?=$v['id']?>_<?=$vm?>"><?php echo lang($vm);?></label>
                                                       </div>
                                                       <?php } } ?>
                                                    </div>
                                                  </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close');?></button>
                                                <button data="<?=$v['id']?>" type="button" class="btn btn-primary save_setting_block"><?php echo lang('save_changes');?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal -->


                            </li>
                            <?php } } ?>
                            <script type="text/javascript">
                            $('.save_setting_block').click(function() {
                                var idblock = $(this).attr('data');
                                var modal_id = '#blockSetting_'+idblock;
                                var h2_tile_block_id = '#h2_tile_block_'+idblock;
                                var title_block_id = '#title_block_'+idblock;
                                var active_module_id = 'input[name^="modules_block_'+idblock+'"]';
                                var title_block = $(title_block_id).val(); 
                                var active_module = [];

                                $(active_module_id).each(function(key, value) {
                                    var module = $(value).val();
                                    if( $(value).is(':checked')) { //if( $(value).checked() ){
                                        active_module.push(module); 
                                    }
                                });
                                
                                $.ajax({
                                    url: 'template-block-ajax-lang-<?=$get_lang?>',
                                    type: 'POST', 
                                    dataType: 'json',
                                    data: {action:'settingBlock',id: idblock,title: title_block,active: active_module},
                                    success: function(data){
                                        if(data.status){
                                            $(modal_id).modal('hide');
                                            $(h2_tile_block_id).html(title_block);
                                        }
                                    }
                                });

                            })
                        </script>