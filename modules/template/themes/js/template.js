var Template = function () {
    var handleColorPicker = function () {
        if (!jQuery().colorpicker) {
            return;
        }
        $('.colorpicker-default').colorpicker({
            format: 'hex'
        });
        $('.colorpicker-rgba').colorpicker();
    }
    var deleteLogo = function(){
        $('.delete_logo_select').click(function(){
            var $this = $(this);
            var lang = $("#form_logo").attr('data-lang');
            var key = $('#idlogo').val();
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Xóa Logo. Bạn có chắc chắn xoá ?</li>',
                title: "Xoá Logo",
                buttons: {
                    success: {
                        label: "Đồng ý",
                        className: "green",
                        callback: function() {
                            $.ajax({
                                url: 'template-ajaxtemplate-lang-'+lang,
                                type: 'POST',
                                data: {action:'deleteLogo',key:key},
                                success: function(data){
                                    window.location.reload(true);
                                }
                            });
                        }
                    },
                    danger: {
                        label: "Huỷ",
                        className: "red",
                        callback: function() {
                            return;
                        }
                    }
                }
            });
        });
    }
    var deleteBackground = function(){
        $('.set_default').click(function(){
            var $this = $(this);
            var key = $('#idbg').val();
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Reset nền trang. Bạn có chắc chắn reset ?</li>',
                title: "Reset Nền trang",
                buttons: {
                    success: {
                        label: "Đồng ý",
                        className: "green",
                        callback: function() {
                            $.ajax({
                                url: 'template-ajaxtemplate-lang-vi',
                                type: 'POST',
                                data: {action:'deleteBackground',key:key},
                                success: function(data){
                                    window.location.reload(true);
                                }
                            });
                        }
                    },
                    danger: {
                        label: "Huỷ",
                        className: "red",
                        callback: function() {
                            return;
                        }
                    }
                }
            });
        });
    }
    var validationLogo = function(){
        $("#img_logo").change(function() {
            var val = $(this).val();
            if(val){
                switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
                    case 'gif': case 'jpg': case 'jpge': case 'png': case 'swf':
                        return true;
                        break;
                    default:
                    $(this).val('');
                    // error message here
                    bootbox.dialog({
                        message: '<li class="list-group-item list-group-item-warning">Cảnh báo: File bạn chọn không đúng định dạng ảnh hoặc flash ( gif, jpg, jpge, png, swf ) .</li>',
                        title: "Chọn ảnh logo",
                        buttons: {                    
                            danger: {
                            label: "Huỷ",
                            className: "red",
                                callback: function() {
                                  return;
                                }
                            }
                        }
                    });
                    break;
                }
            }
            
        });
    }
    var validationBackground = function(){
        $("#img_bg").change(function() {
            var val = $(this).val();
            switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
                case 'gif': case 'jpg': case 'jpge': case 'png': case 'swf':
                    return true;
                    break;
                default:
                $(this).val('');
                // error message here
                bootbox.dialog({
                    message: '<li class="list-group-item list-group-item-warning">Cảnh báo: File bạn chọn không đúng định dạng ảnh ( gif, jpg, jpge, png ) .</li>',
                    title: "Chọn ảnh background",
                    buttons: {                    
                        danger: {
                        label: "Huỷ",
                        className: "red",
                            callback: function() {
                              return;
                            }
                        }
                    }
                });
                break;
            }
        });
    }
    var checkLogo = function(){
        var val = $("#type_logo").val();
         if(val){
            switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
                case 'gif': case 'jpg': case 'jpge': case 'png':
                    $(".fileinput-preview").removeClass('disabled');
                    $(".flash-preview").addClass('disabled');
                    break;
                default:
                    $(".fileinput-preview").addClass('disabled');
                    $(".flash-preview").removeClass('disabled');
                break;
            }
        }
    }
    var enableResponsive = function(){
        var $input = $('input[name="active_responsive"]');
        $('input[name="active_responsive"]').bind('click',function(e){
            var checkbox = $input.is(":checked");//.prop( "disabled", true );
            if (checkbox==false) {
                var enable = 0;
            }else{
               var enable = 1; 
            }
            
            $.ajax({
                url: 'template-ajaxtemplate-lang-vi',
                type: 'POST',
                data: {action:'enableResponsive',value:enable},
                success: function(data){
                    console.log(data);
                },
                error: function(err){
                    console.log(err);
                }
            });
        });                
    }
    return {
        //main function to initiate the module
        init: function () {
            checkLogo();
            deleteLogo();
            deleteBackground();
            handleColorPicker();
            validationLogo();
            validationBackground();
            enableResponsive();
        }
    };
}();