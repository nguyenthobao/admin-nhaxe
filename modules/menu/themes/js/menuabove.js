var MenuAbove = function () {

    var initComponents = function () {
        //init maxlength handler
        $('.maxlength-handler').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            threshold: 5
        });
    }
  var handleValidationMenuabove = function() {
            var form_menuabove = $('#form_menuabove');
            var error1 = $('.alert-danger', form_menuabove);
            var success1 = $('.alert-success', form_menuabove);
            $('.continue').click(function(){
                var con = $(this).attr('data-continue');
                $('input[name="continue"]').val(con);
            });
            form_menuabove.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                messages: {
                    namemenu: {
                        required: $('input[name="namemenu"]').attr('data-error'),
                    },
                    sort:{
                        required: $('input[name="namemenu"]').attr('data-error')
                    }               
                },
                rules: {
                    namemenu: {
                        
                        required: true
                    },
                    sort:{
                        required:true,
                        number:true
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
    return {
        //main function to initiate the module
        init: function () {
            handleValidationMenuabove();
        }
    };

}();