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
 
var FormViewList = function () {
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
    
    var handleStatus = function() {
        $('body').on('click', '.status_item', function(event) {
            event.preventDefault();
            var node = $(this);
            var type = node.attr('data-type');
            var alert_title = node.attr('data-alert-title');
            var agree = node.attr('data-agree');
            var cancel = node.attr('data-cancel');
            var message = node.attr('data-message');
            var status = node.attr('data-status');
            var id = node.attr('data-id');
            var lang = $("#product_list").attr('data-lang');
            var text = node.attr('data-text');
            var text2 = node.text();
            if (status == 1) {
                status = 0;
            } else {
                status = 1;
            }
            var data = {
                'id': id,
                'status': status
            };
            var urlSend = '/template-customForm-ajaxEditStatusDataForm';
            var response = ajax_global(data, urlSend, 'POST', 'json');
            if (status == 0) {
                node.removeClass('green-stripe');
                node.addClass('red-stripe');
                node.attr('data-status', 0);
            } else {
                node.removeClass('red-stripe');
                node.addClass('green-stripe');
                node.attr('data-status', 1);
            }
            node.text(text);
            node.attr('data-text', text2);
        });
    }
    var deleteSlide = function(){
        $('.delete_slide').click(function(){
            var $this = $(this);
            var lang = $("#slidelist").attr('data-lang');
            var key = $this.parents('tr').attr('data-key');
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo. Khi xóa dữ liệu này sẽ không thể khôi phục lại </li>',
                title: "Xoá form",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        var dataString={
                            'id':key
                        };
                        var urlSend='/template-customForm-ajaxDeleteData';
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
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo. Khi xóa tất cả dữ liệu đã chọn sẽ không thể khôi phục lại </li>',
                title: "Xoá form",
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
                        var urlSend='/template-customForm-ajaxMultiDeleteData';
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
    
    var handleCopyForm=function(){
        $('body').on('click', '.copy_form', function(event) {
            event.preventDefault();
            var id=$(this).attr('data-id');
            $('#nxt_lang_copy').modal('show');
            $('input[name="id_form"]').val(id);
        });
    }
    
    var handleCopyOK=function(){
        $('body').on('click', '.NXT_ok_copy', function(event) {
            event.preventDefault();
            var id_form=$('input[name="id_form"]').val();
            var lang=$('select[name="nxt_lang_copy"]').val();
            var dataString={
                id_form:id_form,
                lang:lang
            };
            var urlSend='/template-customForm-ajaxCoppyForm';
            var data=ajax_global(dataString,urlSend,'POST','json');
            if(data.status==true){
                toastr.success(data.message);
                $('#nxt_lang_copy').modal('hide');
            }
        });
    }
    
    return {
        //main function to initiate the module
        init: function () {
            enableDelete();
            checkboxAll();
            deleteSlide();
            deleteMultiID();
            handleCopyForm();
            handleCopyOK();
            handleStatus();
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