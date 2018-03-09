function ajax_global(dataString,urlSend,method,type){
    var res='';
    $.ajax({
        url: $('base').attr('href')+urlSend+'-lang-'+$('base').attr('lang'),
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

var addLayoutList = function () {
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
        $.fn.editable.defaults.mode = 'popup';
         //global settings 
        $.fn.editable.defaults.inputclass = 'form-control';
            $('.slideItem').editable({
                url: 'template-addLayout-ajaxChangeTitle-lang-'+lang,
                type: 'text',
                validate: function(value) {
                    if (!value.trim()) {
                        return 'Dữ liệu không hợp lệ !';
                    }
                },
                success: function(data, config) {                    
                    console.log(data);
                    console.log(config);
                }
            });
            
            $('.aslideItem').editable({
                url: 'template-addLayout-ajaxChangeLayout-lang-'+lang,
                type: 'text',
                validate: function(value) {
                    if (!value.trim()) {
                        return 'Dữ liệu không hợp lệ !';
                    }
                },
                success: function(data, config) {                    
                    console.log(data);
                    console.log(config);
                }
            });
            
            $('.bslideItem').editable({
                url: 'template-addLayout-ajaxChangeRoute-lang-'+lang,
                type: 'text',
                validate: function(value) {
                    if (!value.trim()) { 
                        return 'Dữ liệu không hợp lệ !';
                    }
                    var dataString={
                        'route':value
                    };
                    var urlSend='/template-addLayout-ajaxCheckExistRoute';
                    var data=ajax_global(dataString,urlSend,'POST','json');
                    if(data.status==false){
                        return data.messages;
                    }
                },
                success: function(data, config) {                    
                    console.log(data);
                    console.log(config);
                }
            });

        
    }
    
  
    var deleteSlide = function(){
        $('.delete_slide').click(function(){
            var $this = $(this);
            var lang = $("#slidelist").attr('data-lang');
            var key = $this.parents('tr').attr('data-key');
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Xóa layout này thì đường dẫn này sẽ không chịu ảnh hưởng từ layout này n. Bạn có chắc chắn xoá ?ữa</li>',
                title: "Xoá layout",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        var dataString={
                            'id':key
                        };
                        var urlSend='/template-addLayout-ajaxDelete';
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
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Xóa tất cả các layout đã chọn, thì các đường dẫn thuộc layout đã chọn sẽ không chịu ảnh hưởng bởi layout đó. Bạn có chắc chắn xoá ?</li>',
                title: "Xoá layout",
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
                        var urlSend='/template-addLayout-ajaxMultiDelete';
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