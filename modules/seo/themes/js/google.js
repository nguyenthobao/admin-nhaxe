var Google = function () {
    var guideGetID = function(){
        $('.giue-video').click(function(){
             
            var getimg =$(".load_img").attr('data-img');
             bootbox.dialog({
               
                title: "Hướng dẫn lấy ID Google +",
                 message: '<li class="list-group-item list-group-item-warning">'+getimg+ '</li>',
            });
            
        });
    }
    var deleteGoogle =function(){
        $(".deletegoogle").click(function(){
            var success = $('.btn-google').attr('data-success-mail');
            var name = $('#costomer').val();
            var id_google = $('#id_google').val();
            $(".deletegoogle").hide();
            $('.alert-sucess').prepend('<div class="alert alert-success padding10">'+success+'</div>').fadeOut(10000);
                 $.ajax({
                            url: 'seo-ajax-lang-vi', 
                            type: 'POST',
                            data: {action:'deleteGoogle',name:name,id_google:id_google},
                            success: function(data){
                            }
                        });

        })

    }
    var handleValidation = function() {
        var form_google = $('#form_google');
        var error1 = $('.alert-danger', form_google);
        var success1 = $('.alert-success', form_google);
        $('.continue').click(function(){
            var con = $(this).attr('data-continue');
            $('input[name="continue"]').val(con);
        });
        form_google.validate({
            errorElement: 'div', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {
                id_google: {
                    required: $('input[name="id_google"]').attr('data-error'),
                },
                name: {
                    required: $('input[name="name"]').attr('data-error'), 
                }
            },
            rules: {
                id_google:{
                     required: true
                },
                name: {
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


    return {
        //main function to initiate the module
        init: function () {
            guideGetID();
            deleteGoogle();
            handleValidation();
        }
    };

}();