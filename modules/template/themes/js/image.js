var FormImage = function () {
    var initComponents = function(){
        //init maxlength handler
        $('.maxlength-handler').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            threshold: 5
        });
    }
    var handleDatetimePicker = function(){        
        $('.form_datetime').datepicker({
            rtl: Metronic.isRTL(),
            orientation: "left",
            autoclose: true
        });  
    }
    var handleValidationInfo = function(){
        var form_image = $('#form_image');
        var error1 = $('.alert-danger', form_image);
        var success1 = $('.alert-success', form_image);
        $('.continue').click(function(){
            var con = $(this).attr('data-continue');
            $('input[name="continue"]').val(con);
        });
        form_image.validate({
            errorElement: 'div', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {
                slide_id: {
                    required: $('select[name="slide_id"]').attr('data-error'),
                },
                img_slide: {
                    required: $('span[class="image_slide"]').attr('data-error'),
                }
            },
            rules: {
                slide_id: {
                    required: true
                },
                img_slide: {
                    required: true
                }
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
    var checkCharacterEdit = function(){
        $('.row_input_title input').live('keypress',function(){
            var val = $(this).val();
            var length = val.length;
            if (length < 100 ) {
                var charact = val.split(" ");
                $.each(charact,function(k,v){
                    if (v.length>10) {
                        alert("Một từ của bạn không được nhập vào quá 10 ký tự");
                        $('.row_input_title input').val(val.substr(0,10));
                        return false;
                    }
                });
            }
        });
    }
    var checkTitleEditCopy = function(){
        $('.row_input_title input').live('paste', function () {     
            var valTitle = $('.row_input_title input').val();
            var title = valTitle.split(" ");
            $.each(title , function(key, val) { 
            if (val.length>10) {            
                    alert("Một từ của bạn không được nhập vào quá 10 ký tự");
                    return false;
                }else{
                    return true;
                }
            });
        });
    }
    var validationImage = function(){
        $("#img_slide").change(function() {
            var val = $(this).val();
            switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
                case 'gif': case 'jpg': case 'jpge': case 'png': case '':
                    return true;
                    break;
                default:
                // error message here
                bootbox.dialog({
                    message: '<li class="list-group-item list-group-item-warning">Cảnh báo: File bạn chọn không đúng định dạng ảnh ( gif, jpg, jpge, png ) .</li>',
                    title: "Chọn ảnh slide",
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
    var deleteMultiID =function(){
        $('.delete_image_select').click(function(){
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Xóa tất cả các ảnh đã chọn. Bạn có chắc chắn xoá ?</li>',
                title: "Xoá ảnh slide",
                buttons: {
                    success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        //submit form khi nút submit không phải là button hoặc <input type="submit">
                        $('#form_imagelist').submit();
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
            initComponents();
            handleValidationInfo();
            handleDatetimePicker();
            checkCharacterEdit();
            checkTitleEditCopy();
            validationImage();
        }
    };
}();