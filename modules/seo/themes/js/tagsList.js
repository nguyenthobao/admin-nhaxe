function ajax_global(dataString,urlSend,method,type){
    var res='';
    $.ajax({
        url: $('base').attr('href')+urlSend+'-lang-'+langUse,
        type: method,
        async:false,
        dataType: type,
        data: dataString,
    })
    .success(function(res) {
        result=res;
    })
    .error(function(error) { 
        console.log(error);
    });
    return result;
}

var TagsList = function () {
    var checkboxAll = function() {
        $('#checkboxAll').click(function() {
            if ($(this).prop("checked") == true) {
                $('.checkboxes').each(function(index) {
                    $(this).prop("checked", true);
                    $(this).parent().addClass('checked');
                });

                $(".btn-del a").removeClass('disabled');                
            } else if ($(this).prop("checked") == false) {
                $('.checkboxes').each(function(index) {
                    $(this).prop("checked", false);
                    $(this).parent().removeClass('checked');
                });
                $(".btn-del a").addClass('disabled');                
            }
            if ($('.checkboxes:checked').length > 0) {
                $(".btn-del a").removeClass('disabled');                
            } else {
                $(".btn-del a").addClass('disabled');            
            }
        });
        $('.checkboxes').click(function() {
            if ($(this).prop("checked") == false) {
                $('#checkboxAll').prop("checked", false);
                $('#checkboxAll').parent().removeClass('checked');
            }
        });
    }
    var enableDelete = function() {
        $('.checkboxes').click(function(){
            if ($('.checkboxes:checked').length > 0) {
                $(".btn-del a").removeClass('disabled');
            } else {
                $(".btn-del a").addClass('disabled');                
            }
        });
    }
    var fastEdit = function(){
        var lang = $("#slidelist").attr('data-lang');        
        $.fn.editable.defaults.mode = 'inline';
         //global settings 
        $.fn.editable.defaults.inputclass = 'form-control';
            $('.slideItem').editable({
                url: 'seo-tags-ajaxChangeTitle-lang-'+lang,
                type: 'text',
                validate: function(value) {
                    if (!value.trim()) {
                        return 'Dữ liệu không hợp lệ !';
                    }
                },
                success: function(data, config) {                    
                    // console.log(data);
                    // console.log(config);
                }
            });
            
            $('.meta_title').editable({
                url: 'seo-tags-ajaxChangeMeta-lang-'+lang,
                type: 'text',
                validate: function(value) {
                    if (!value.trim()) {
                        return 'Dữ liệu không hợp lệ !';
                    }
                },
                success: function(data, config) {                    
                    // console.log(data);
                    // console.log(config);
                }
            });
            
            
    }
    
    var handleEditTags=function(){
        $.fn.editable.defaults.mode = 'popup';
         //global settings 
        $.fn.editable.defaults.inputclass = 'form-control';
        $('.description').editable({
                url: 'seo-tags-ajaxChangeDescription-lang-'+lang,
                type: 'textarea',
                validate: function(value) {
                    if (!value.trim()) {
                        return 'Dữ liệu không hợp lệ !';
                    }
                },
                success: function(data, config) {                    
                    // console.log(data);
                    // console.log(config);
                }
            });
    }
    
    var deleteSlide = function(){
        $('.delete_slide').click(function(){
            var $this = $(this);
            var lang = $("#slidelist").attr('data-lang');
            var key = $this.parents('tr').attr('data-key');
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo. Khi xóa tag này sẽ không thể khôi phục lại được. Bạn có muốn xóa ?</li>',
                title: "Xoá Tag",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        var dataString={
                            'id':key
                        };
                        var urlSend='/seo-tags-ajaxDelete';
                        var data=ajax_global(dataString,urlSend,'POST','json');
                        if(data.status==true){
                            $('#tr_'+key).remove();
                        }
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
    var deleteMultiID =function(){
        $('.delete_slide_select').click(function(){
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Khi xóa tất cả tags đã chọn sẽ không thể khôi phục lại được. Bạn có muốn xóa ?</li>',
                title: "Xoá Tags",
                buttons: {
                    success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                    var all=[];
                        $('input:checked').each(function(k, v) {
                            if($(this).val()!='on'){
                                all.push($(this).val());    
                            }
                        });
                        var dataString={
                            'id':all
                        };
                        var urlSend='/seo-tags-ajaxMultiDelete';
                        var data=ajax_global(dataString,urlSend,'POST','json');
                        if(data.status==true){
                             $.each(all, function(k, v) {
                                $('#tr_'+v).remove();
                             });
                        }
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
   
    
    return {
        //main function to initiate the module
        init: function () {
            enableDelete();
            checkboxAll();
            fastEdit();
            deleteSlide();
            deleteMultiID();
            handleEditTags();
            // handle editable elements on hidden event fired
            $('#slidelist .editable').on('hidden', function (e, reason) {
                if (reason === 'save' || reason === 'nochange') {
                    var $next = $(this).closest('tr').next().find('.editable');
                    if ($('#autoopen').is(':checked')) {
                        setTimeout(function () {
                            $next.editable('show');
                        }, 300);
                    } else {
                        $next.focus();
                    }
                }
            });
        }
    };
}();