function ajax_global(dataString, urlSend, method, type) {
    var res = '';
    $.ajax({
        url: $('base').attr('href') + urlSend + '-lang-' + $('base').attr('lang'),
        type: method,
        async: false,
        dataType: type,
        data: dataString,
    }).success(function(res) {
        result = res;
    }).error(function(error) {
        console.log(error);
    });
    return result;
}
var Language = function() {
    
    
    var handleOnload = function() {
        $('body').find('.radio').css({
            paddingTop: '1px'
        });
        
        $('[data-toggle="tooltip"]').tooltip(); 

    }
    
    var handleClickTab=function() {
        $('body').on('click', '#NXT_nav_tabs li a', function(event) {
            event.preventDefault();
            //Reset progress bar
            handleProgressBarReset();
        });
    }
    var handleLoadFolderLang = function() {
        $('body').on('change', 'input[name="mod"],select[name="lang_select"]', function(event) {
            handleProgressBarReset();
            Metronic.startPageLoading('Đang tải....');
            event.preventDefault();
            var mod = $('input[name="mod"]:checked').val();
            var lang_select = $('select[name="lang_select"]').val();
            if (mod == 'system') {
                var type = 'system';
            } else {
                var type = 'module';
            }
            var urlSend = '/template-Language-ajaxLoadFolderMod';
            $("#nxt_content_left").load($('base').attr('href')+'/template-Language-ajaxLoadFolderMod-lang-vi #nxt_content_left', {
                'mod': mod,
                'lang_select': lang_select,
                'type': type
            }, function(response, status, xhr) {
                if (status == 'success') {
                    $('[data-toggle="tooltip"]').tooltip(); 
                     Metronic.stopPageLoading();
                    //Ajax get custom lang
                    var dataString={
                        'mod': mod,
                        'lang_select': lang_select,
                        'type': type
                    };
                    var urlSend='/template-Language-ajaxGetCustom';
                    var data=ajax_global(dataString,urlSend,'POST','json');
                    if(data.status!=false){
                        var tab=$('#NXT_nav_tabs');
                        $.each(data.content,function(k, v) {
                            var classFile=v.file.replace('.php', '');
                            var tmp_tab=tab.find('li a.'+classFile).attr('href');
                            $.each(v.content,function(k2, v2) {
                                var tmp_tab_content=$(tmp_tab).find('tbody tr.'+k2).find('textarea').val(v2);
                                
                            });
                            //console.log(tmp_tab_content);
                        });
                    }
                    //console.log(data); 
                }
            });
        });
    }
    var handleTranslate = function() {
        $('body').on('click', '.NXT_translate', function(event) {
            event.preventDefault();
            bootbox.dialog({
                message: '<div class="list-group-item list-group-item-warning">Khi sử dụng dịch tự động sẽ mất vài phút để hoàn thành. Hãy kiên nhẫn chờ đợi !</div>',
                title: 'Thông báo',
                buttons: {
                    success: {
                        label: 'Đồng ý',
                        className: "green",
                        callback: function() {
                            Metronic.startPageLoading('Vui lòng đợi tới khi kết thúc quá trình xử lý....');
                            $('.bootbox').fadeOut('fast', function() {
                                //Show Progress  if Firefox
                                if(handleBrowser()=='Firefox'){
                                   $('#NXT_progress').slideDown();
                                    var progressNXT = 1; 
                                }
                                
                                //Ngon ngu nguon
                                var lang_src = $('select[name="lang_select"]').val();
                                //Ngo ngu dich
                                var lang_des = $('select[name="lang_translate"]').val();
                                //Tab duoc chon
                                var tabs_select = $('#NXT_nav_tabs').find('li.active').children('a');
                                //So ban dau
                                var countNXT = parseInt(tabs_select.find('.NXT_nxt_count').text());
                                //File dang duoc active
                                var file_active = tabs_select.attr('href');
                                //Khoi tao mang truyen di
                                //Tim cac input mac dinh
                                var all_input = $(file_active).find('input');
                                var urlSend = '/template-Language-ajaxTranslate';
                                var count = 0;
                                $.each(all_input, function(k, v) {
                                    var tmp_key = $(this).attr('name');
                                    var tmp_value = $(this).val();
                                    var dataString = {
                                        'nxt_translate': tmp_value,
                                        'lang_select': lang_src,
                                        'lang_translate': lang_des
                                    };
                                    
                                    setTimeout(function() {
                                        
                                        var data = ajax_global(dataString, urlSend, 'POST', 'json');
                                        $(file_active).find('tr.' + tmp_key).find('td.NXT_google_translate').text(data.value);
                                        //Tinh toan %
                                        if(progressNXT!=undefined){
                                            var percent = parseInt((k + 1) / countNXT * 100);
                                            handleProgressBar(percent);
                                        }
                                        
                                        var st = parseInt(countNXT - (k + 1));
                                        tabs_select.find('.NXT_nxt_count').text(st);
                                        //Cong them de stop load
                                        if (st == 0) {
                                            Metronic.stopPageLoading();
                                            $(file_active).find('.NXT_copy').prop('disabled', false);
                                            $(file_active).find('.NXT_translate').prop('disabled', true);
                                        }
                                    }, 3000);
                                });
                            });
                        }
                    },
                    danger: {
                        label: 'Hủy',
                        className: "red",
                        callback: function() {
                            Metronic.stopPageLoading();
                        }
                    }
                }
            });
        });
    }
    var handleProgressBar = function(percent) {
        var progress=$('#NXT_progress').find('.progress-bar');
        progress.attr('aria-valuenow', percent).css('width', percent + '%').text(percent+'%');
        if(percent==100){
            progress.removeClass('active');
        }
    }
    
    var handleProgressBarReset = function() {
        var progress=$('#NXT_progress').find('.progress-bar');
        progress.parent().slideUp();
        progress.attr('aria-valuenow', 0).css('width', '0%').text('0%');
        progress.addClass('active');
    }
    
    var handleCopy = function() {
        $('body').on('click', '.NXT_copy', function(event) {
            event.preventDefault();
            //File dang duoc active
            var file_active = $('#NXT_nav_tabs').find('li.active').children('a').attr('href');
            //Find all tr
            var allTr = $(file_active).find('tr');
            $.each(allTr, function(k, v) {
                if (k != 0) {
                    var tmp_textarea = $(this).find('textarea');
                    var tmp_text_translate = $(this).children('.NXT_google_translate').text();
                    if (tmp_textarea.val() == '' || tmp_textarea.val() == undefined || tmp_textarea.val() == false) {
                        tmp_textarea.val(tmp_text_translate);
                    }
                }
            });
        });
    }
    var handleValidationInfo = function() {
        var form_slide = $('#form_slide');
        var error1 = $('.alert-danger', form_slide);
        var success1 = $('.alert-success', form_slide);
        $('.continue').click(function() {
            var con = $(this).attr('data-continue');
            $('input[name="continue"]').val(con);
        });
        form_slide.validate({
            errorElement: 'div', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {
                layout: {
                    required: $('input[name="layout"]').attr('data-error'),
                },
                title: {
                    required: $('input[name="title"]').attr('data-error'),
                },
                route: {
                    required: $('input[name="route"]').attr('data-error'),
                }
            },
            rules: {
                title: {
                    required: true
                },
                layout: {
                    required: true
                },
                route: {
                    required: true
                },
            },
            invalidHandler: function(event, validator) { //display error alert on form submit              
                success1.hide();
                error1.show();
                Metronic.scrollTo(error1, -200);
            },
            highlight: function(element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            unhighlight: function(element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
            },
            success: function(label) {
                label.closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler: function(form) {
                form.submit();
                error1.hide();
            }
        });
    }
    var handleLangDes = function() {
        $('body').on('change', 'select[name="lang_translate"]', function(event) {
            event.preventDefault();
            var file_active = $('#NXT_nav_tabs').find('li.active').children('a').attr('href');
            $(file_active).find('.NXT_translate').prop('disabled', false);
        });
    }
    var handleBrowser = function() {
        var result = '';
        if (navigator.userAgent.indexOf("Chrome") != -1) {
            result = 'Chrome';
        } else if (navigator.userAgent.indexOf("Opera") != -1) {
            result = 'Opera';
        } else if (navigator.userAgent.indexOf("Firefox") != -1) {
            result = 'Firefox';
        } else if ((navigator.userAgent.indexOf("MSIE") != -1) || (!!document.documentMode == true)) //IF IE > 10
        {
            result = 'IE';
        } else {
            result = 'unknown';
        }
        return result;
    }
    
    
    var handleSubmitWriter=function(){
        
        $('body').on('click', '.continue', function(event){
            event.preventDefault();
            var mod=$('input[name="mod"]:checked').val();
            
            var file=$('#NXT_nav_tabs').find('li.active > a').text().trim().split(" ");
            file=file[0];
            
            var langS=$('select[name="lang_select"]').val(); 
            console.log(langS);
            var id_content=$('#NXT_nav_tabs').find('li.active > a').attr('href');
            id_content=id_content.replace('#', '').trim();
            var content=$('#'+id_content).find('tbody').find('tr');
            var key_array=[];
            var text_array=[];
            content.each(function(k, v) {
                var tmp_self=$(this);
                var tmp_key=tmp_self.find('input').attr('name');
                key_array.push(tmp_key);
                //Kiem tra dich
                var tmp_text='';
                var tmp_custom_translate=tmp_self.find('textarea').val();
                var tmp_auto_translate=tmp_self.find('.NXT_google_translate').text();
                var tmp_default=tmp_self.find('input').val();
                if(tmp_custom_translate!=''){
                    tmp_text=tmp_custom_translate;
                }else if(tmp_auto_translate.trim()!='Chưa có'){
                     tmp_text=tmp_auto_translate;
                }else{
                    tmp_text=tmp_default;
                }               
                text_array.push(tmp_text);

            });
            var dataString={
              'mod':mod,
              'file':file,
              'lang':langS,
              'key':key_array,
              'text':text_array 
            };
            var urlSend='/template-Language-ajaxWiter';
            var data=ajax_global(dataString,urlSend,'POST','json');
            if(data.status==true){
                toastr.success(data.message);
            }
            
        })
        
    }
    
    var handleResetDefault=function(){
        $('body').on('click', '.NXT_reset_default', function(event){
            event.preventDefault();
            var parent=$(this).parents('table').find('tbody tr');
            $.each(parent,function(k, v) {
               var tmp_default=$(this).find('input').val();
               $(this).find('textarea').val(tmp_default);
            });
        });
    }
    var handleResetAll=function(){
        $('body').on('click', '.NXT_reset_all', function(){
                 bootbox.dialog({
                message: '<div class="list-group-item list-group-item-warning"><strong>Hãy cân nhắc:</strong> Khi sử dụng tính năng này toàn bộ ngôn ngữ sẽ đưa về mặc định hệ thống!</div>',
                title: 'Thông báo',
                buttons: {
                    success: {
                        label: 'Đồng ý',
                        className: "green",
                        callback: function() {
                            var dataString={
                              'ok':1,
                            };
                            var urlSend='/template-Language-resetAll';
                            var data=ajax_global(dataString,urlSend,'POST','json');
                            if(data.status==true){
                                window.location.reload();
                            }         
                        }
                    },
                    danger: {
                        label: 'Hủy',
                        className: "red",
                        callback: function() {
                            Metronic.stopPageLoading();
                        }
                    }
                }
            });
        });
    }
    
    var handleLanguageDisplay=function(){
        $('body').on('change', 'select[name="lang_display"]', function(event) {
            event.preventDefault();
            Metronic.startPageLoading();
            var lang=$(this).val();
            var dataString={
              'langCus':lang
            };
            var urlSend='/template-Language-changeLangCus';
            var data=ajax_global(dataString,urlSend,'POST','json');
            if(data.status==true){
                Metronic.stopPageLoading();
                toastr.success(data.message);
            }
        });
    }
    var handleEmptyAll=function(){
        $('body').on('click', '.NXT_empty_all', function(event){
            event.preventDefault();
            var parent=$(this).parents('table').find('tbody textarea').val('');
        })
    }
    return {
        //main function to initiate the module
        init: function() {
            handleValidationInfo();
            handleOnload();
            handleLoadFolderLang();
            handleTranslate();
            handleCopy();
            handleLangDes();
            handleClickTab();
            handleSubmitWriter();
            handleResetDefault();
            handleResetAll();
            handleLanguageDisplay();
            handleEmptyAll();
        }
    };
}();