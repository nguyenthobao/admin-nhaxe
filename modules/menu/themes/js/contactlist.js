var ContactList = function () {

    var initComponents = function () {
        //init maxlength handler
        $('.maxlength-handler').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            threshold: 5
        });
    }
    var handleValidationContactinfo = function() {
            var form_contactinfo = $('#form_contactinfo');
            var error1 = $('.alert-danger', form_contactinfo);
            var success1 = $('.alert-success', form_contactinfo);
            $('.continue').click(function(){
                var con = $(this).attr('data-continue');
                $('input[name="continue"]').val(con);
            });
            form_contactinfo.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                messages: {
                    info: {
                        required: $('input[name="info"]').attr('data-error'),
                    }               
                },
                rules: {
                    info: {
                        
                        required: true
                    }                    
                    
                },       
            });
    }
    return {
        //main function to initiate the module
        init: function () {
            handleValidationContactinfo();
        }
    };

}();