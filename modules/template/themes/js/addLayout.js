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

var addLayout = function () {
    
    var handleValidationInfo = function(){
        var form_slide = $('#form_slide');
        var error1 = $('.alert-danger', form_slide);
        var success1 = $('.alert-success', form_slide);
        $('.continue').click(function(){
            var con = $(this).attr('data-continue');
            $('input[name="continue"]').val(con);
        });
        form_slide.validate({
            errorElement: 'div', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {
                layout: {
                    required: $('input[name="layout"]').attr('data-error'),
                },
                title: {
                    required: $('input[name="title"]').attr('data-error'),
                },
                route: {
                    required: $('input[name="route"]').attr('data-error'),
                }
            },
            rules: {
                title: {
                    required: true
                },
                layout: {
                    required: true
                },
                route: {
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
    var handleCheckExistRoute=function() {
        $('body').on('blur', 'input[name="route"]', function(event) {
            event.preventDefault();
           var route=$(this).val();
           var parent=$(this).parent();
           $('#route-error').remove();
           $('.continue').prop('disabled', false);
           
           if(route){
            var dataString={
                'route':route
            };
            var urlSend='/template-addLayout-ajaxCheckExistRoute';
            var data=ajax_global(dataString,urlSend,'POST','json');
            if(data.status==false){
                var html='<div for="route" id="route-error" class="help-block help-block-error"><p class="text-danger">'+data.messages+'</p></div>';
                $(this).focus();
                parent.append(html);
                $('.continue').prop('disabled', true);
            }
            
           }
        });
    }
    return {
        //main function to initiate the module
        init: function () {
            handleValidationInfo();
            handleCheckExistRoute();
        }
    };
}();