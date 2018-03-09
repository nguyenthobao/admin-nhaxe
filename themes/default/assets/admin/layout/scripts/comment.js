var Comment = function () {
    var handleValidationAdver = function(){
        var frm_details = $('#frm_details');
        var error1 = $('.alert-danger', frm_details);
        var success1 = $('.alert-success', frm_details);
        $('.continue').click(function(){
            var con = $(this).attr('data-continue');
            $('input[name="continue"]').val(con);
        });
        frm_details.validate({
            errorElement: 'div', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {
                departments: {
                    required: $('select[id="departments"]').attr('data-error'),
                },
                type: {
                    required: $('select[id="type"]').attr('data-error'),
                },
                name_comment: {
                    required: $('input[name="name_comment"]').attr('data-error'),
                },
                email: {
                    required: $('input[name="email"]').attr('data-error'),
                },
            },
            rules: {
                departments: {
                    required: true
                },
                type: {
                    required: true
                },
                name_comment: {
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

        //main function to initiate the theme
        init: function () {
            handleValidationAdver();
        }
    };

}();