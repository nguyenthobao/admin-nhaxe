var InformationBasic = function () {
    var getDistrict  =function(){
        $('#provinces').change(function(){
            var value = $('#provinces').val();
            if(value ==""){
            $('#show_district').hide();
            $('#show_wardid').hide();
            }else{
                $('#show_district').show();
                $('#show_wardid').show();
            }
            var id_tinh = $(this).find('option:selected').attr('data-id');
            var lang  = $("#information").attr('data-lang');
                $.ajax({
                            url: 'information-ajax-lang-'+lang, 
                            type: 'POST',
                            data: {id_tinh:id_tinh},
                            success: function(data){
                            $('#district').html(data);
                            }
                        });
            });
    }

    var editGetdistrict = function(){
        var key = $('.get_id_province').attr('key');
            if(key>0){
                var lang  = $("#information").attr('data-lang');
                $.ajax({
                            url: 'information-ajax-lang-'+lang, 
                            type: 'POST',
                            data: {key:key},
                            success: function(data){
                            $('#district').html(data);
                            }
                        });
            }
    }

    var getWardid  =function(){
        $('#district').change(function(){
            $('#show_wardid').show();
            var id_huyen = $(this).find('option:selected').attr('data-id');
            var lang  = $("#information").attr('data-lang');
                $.ajax({
                            url: 'information-ajaxwardid-lang-'+lang, 
                            type: 'POST',
                            data: {id_huyen:id_huyen},
                            success: function(data){
                              $('#wardid').html(data);
                            }
                        });
            });
    }

    var editGetwarid = function(){
            var key = $('.get_id_district').attr('key');
            if(key>0){
            var lang  = $("#information").attr('data-lang');
                $.ajax({
                            url: 'information-ajaxwardid-lang-'+lang, 
                            type: 'POST',
                            data: {key:key},
                            success: function(data){
                              $('#wardid').html(data);
                            }
                    });
            }
    }
   
    var initComponents = function(){
        $('.maxlength-handler').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            threshold: 5
        });
    }
    var handleValidation = function() {
        var form_informationbasic = $('#form_informationbasic');
        var error1 = $('.alert-danger', form_informationbasic);
        var success1 = $('.alert-success', form_informationbasic);
        $('.continue').click(function(){
            var con = $(this).attr('data-continue');
            $('input[name="continue"]').val(con);
        });

        form_informationbasic.validate({
            errorElement: 'div', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {
                business: {
                    required: $('input[name="business"]').attr('data-error'),
                },
                address: {
                    required: $('input[name="address"]').attr('data-error'), 
                },
                phone:{
                    required: $('input[name = "phone"]').attr('data-error'),
                },
                provinces:{
                    required: $('select[name ="provinces"]').attr('data-error'),
                },
                email:{
                    required: $('input[name = "email"]').attr('data-error'),
                },
                districtid:{
                    required: $('select[name = "districtid"]').attr('data-error'),
                }
            },
            rules: {
                business:{
                     required: true
                },
                address:{
                    required:true
                },
                phone:{
                    required:true,
                },
                provinces:{
                    required:true
                },
                email:{
                    required:true,
                    email:true
                },
                districtid:{
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

    var handleTagsInput = function(){
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
    return {
        //main function to initiate the module
        init: function () {
            getDistrict();
            handleValidation();
            getWardid();
            initComponents();
            handleTagsInput();
            editGetdistrict();
            editGetwarid();
        }
    };

}();