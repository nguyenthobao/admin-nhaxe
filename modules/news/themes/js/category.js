var NewsCategory = function () {

    var initComponents = function () {
        //init maxlength handler
        $('.maxlength-handler').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            threshold: 5
        });
    }
    var handleValidationCategory = function() {
            var form_category = $('#form_category');
            var error1 = $('.alert-danger', form_category);
            var success1 = $('.alert-success', form_category);
            $('.continue').click(function(){
                var con = $(this).attr('data-continue');
                $('input[name="continue"]').val(con);
            });
            form_category.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                messages: {
                    title: {
                        required: $('input[name="title"]').attr('data-error'),
                    },
                    // sort:{
                    //     required: $('input[name="sort"]').attr('data-error'),  
                    // },
                },
                rules: {
                    title: {
                        minlength: 3,
                        required: true
                    },                    
                    cat_id: {
                        required: true
                    },
                    // sort: {
                    //     number: true,
                    //     required: true
                    // },

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
    var handleTagsInput = function () {
        if (!jQuery().tagsInput) {
            return;
        }
        $('input[name="meta_keyword"]').tagsInput({
            width: 'auto',
            'onAddTag': function () {
                //alert(1);
            },
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
            if (val.length>9) {            
                    alert("Một từ của bạn không được nhập vào quá 10 ký tự");
                    return false;
                }else{
                    return true;
                }
            });
        });
    }
    var validationImg = function(){
        $("#img_cat").change(function() {
            var val = $(this).val();
            switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
                case 'gif': case 'jpg': case 'jpge': case 'png': case '':
                    return true;
                    break;
                default:
                // error message here
                bootbox.dialog({
                    message: '<li class="list-group-item list-group-item-warning">Cảnh báo: File bạn chọn không đúng định dạng ảnh ( gif, jpg, jpge, png ) .</li>',
                    title: "Chọn ảnh đại diện cho danh mục tin tức",
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
    var validationIcon = function(){
        $("#icon_cat").change(function() {
            var val = $(this).val();
            switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
                case 'gif': case 'jpg': case 'jpge': case 'png': case '':
                    return true;
                    break;
                default:
                // error message here
                bootbox.dialog({
                    message: '<li class="list-group-item list-group-item-warning">Cảnh báo: File bạn chọn không đúng định dạng ảnh ( gif, jpg, jpge, png ) .</li>',
                    title: "Chọn biểu tượng cho danh mục tin tức",
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
    var validationBg = function(){
        $("#bg_cat").change(function() {
            var val = $(this).val();
            switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
                case 'gif': case 'jpg': case 'jpge': case 'png': case '':
                    return true;
                    break;
                default:
                // error message here
                bootbox.dialog({
                    message: '<li class="list-group-item list-group-item-warning">Cảnh báo: File bạn chọn không đúng định dạng ảnh ( gif, jpg, jpge, png ) .</li>',
                    title: "Chọn hình nền cho danh mục tin tức",
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
    return {
        //main function to initiate the module
        init: function () {
            checkCharacterEdit();
            initComponents();
            handleTagsInput();
            handleValidationCategory();
            checkTitleEditCopy();
            validationImg();
            validationIcon();
            validationBg();
        }
    };

}();