var FormNews = function () {

    // basic validation
    var handleValidationNews = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form_news = $('#form_news');
            var error1 = $('.alert-danger', form_news);
            var success1 = $('.alert-success', form_news);

            form_news.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                messages: {
                    new_title: {
                        required: $('input[name="new_title"]').attr('data-error'),
                    },
                    
                    new_source: {
                        required: $('input[name="new_source"]').attr('data-error'),
                    },
                    new_select_cat: {
                        required: $('select[name="new_select_cat"]').attr('data-error'),
                    },
                    new_des:{
                       required: $('textarea[name="new_des"]').attr('data-error'),
                    }
                },
                rules: {
                    new_title: {
                        minlength: 2,
                        required: true
                    },
                    
                    new_source: {
                        minlength: 5,
                    },
                    new_select_cat: {
                        required: true
                    },
                    new_des:{
                        minlength:5,
                        required: true,

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
            handleValidationNews();
        }

    };

}();