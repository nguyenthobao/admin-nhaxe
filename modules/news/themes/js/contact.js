var  FormContact=functon(){
     var handleValidationNews = function(){
        
            var form_contact = $('#form_contact');
            var error1 = $('.alert-danger', form_contact);
            var success1 = $('.alert-success', form_contact);
            form_contact.validate({
                errorElement: "span",
                errorClass:'help-block help-block-error',
                 focusInvalid: false,
                  ignore: "",
                   messages:{
                    username:{
                        required: $('input[name="username"]').attr('data-error'),
                        
                    },
                    email:{
                        required : $('input[name="email"]').attr('data-error'),
                        email:$('input[name="email"]').attr("Ð?a ch? email không h?p l?")
                        
                    },
                    phone:{
                         number: $('input[name="phone"]').attr('data-error'),
                    },
                    address:{
                         required: $('input[name="address"]').attr('data-error'),
                    },
                    content:{
                         required: $('input[name="content"]').attr('data-error'),
                    }
                   },
                   rules:{
                    username:{
                        minlength:2,
                        required:true
                        
                    },
                    email:{
                        required: true,
                        email:true
                   
                        
                    },
                    phone:{
                        minlength:6,
                        maxlength:12,
                        number: true
                        
                    },
                    address:{
                        required: true
                        
                    },
                    content:{
                        required:true
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
            })
     }
     return {
        //main function to initiate the module
        init: function () {
            handleValidationNews();
        }
        };

    
}();