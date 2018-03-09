var EmailList = function () {
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
    var fastEditEmail = function(){
        var lang = $("#emaillist").attr('data-lang');        
        $.fn.editable.defaults.mode = 'popup';
         //global settings 
        $.fn.editable.defaults.inputclass = 'form-control';
            $('.emailItem').editable({
                url: 'template-customForm-ajaxChangeTitleEmail-lang-'+lang,
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
    }
    var fastEditName = function(){
        var lang = $("#emaillist").attr('data-lang');        
        $.fn.editable.defaults.mode = 'popup';
         //global settings 
        $.fn.editable.defaults.inputclass = 'form-control';
            $('.nameItem').editable({
                url: 'template-customForm-ajaxChangeTitleName-lang-'+lang,
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
    }
    var deleteEmail = function(){
        $('.delete_email').click(function(){
            var $this = $(this);
            var lang = $("#emaillist").attr('data-lang');
            var key = $this.parents('tr').attr('data-key');
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo. Bạn có muốn xóa Email này bây giờ ?</li>',
                title: "Xoá email nhận",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        var dataString={
                            'id':key
                        };
                        var urlSend='/template-customForm-ajaxDeleteEmail';
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
    var handleValidationEmail = function(){
        var form_email = $('#form_email');
        var error1 = $('.alert-danger', form_email);
        var success1 = $('.alert-success', form_email);
        $('.continue').click(function(){
            var con = $(this).attr('data-continue');
            $('input[name="continue"]').val(con);
        });
        form_email.validate({
            errorElement: 'div', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {
                name: {
                    required: $('input[name="name"]').attr('data-error'),
                },
                email: {
                    required: $('input[name="email"]').attr('data-error'),
                },
            },
            rules: {
                name: {
                    minlength: 3,
                    required: true
                },
                email: {
                    email: true,
                    required: true
                },
            },
            invalidHandler: function (event, validator) { //display error alert on form submit              
                success1.hide();
                error1.show();
                Metronic.scrollTo(error1, -200);
            },
            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },
            success: function (label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler: function (form) {
                form.submit();
                error1.hide();
            }
        });
    }
    
    return {
        //main function to initiate the module
        init: function () {
            checkboxAll();
            fastEditEmail();
            fastEditName();
            deleteEmail();
            handleValidationEmail();
            // handle editable elements on hidden event fired
            $('#emaillist .editable').on('hidden', function (e, reason) {
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