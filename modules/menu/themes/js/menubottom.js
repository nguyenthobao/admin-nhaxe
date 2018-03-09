var MenuBottom = function () {

    var initComponents = function () {
        //init maxlength handler
        $('.maxlength-handler').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            threshold: 5
        });
    }
    var handleValidationMenubelow = function() {
            var form_menubelow = $('#form_menubelow');
            var error1 = $('.alert-danger', form_menubelow);
            var success1 = $('.alert-success', form_menubelow);
            $('.continue').click(function(){
                var con = $(this).attr('data-continue');
                $('input[name="continue"]').val(con);
            });
            form_menubelow.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                messages: {
                    namemenu: {
                        required: $('input[name="namemenu"]').attr('data-error'),
                    },
                    // linkto:{
                    //     required: $('input[name="linkto"]').attr('data-error'),
                    // }
                                 
                },
                rules: {
                    namemenu: {
                        
                        required: true,
                    },
                    sort:{
                        number:true
                    },
                    // linkto:{
                    //     required:true
                    // }                    
                    
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
      var nameMenu  =function(){
        $('#linktoct').change(function(){
            $('#cd-1').rules('remove');
            var id_linktoct =$(this).val();
            var data_basic=$('#linktoct option:selected');           
            if(  id_linktoct != ""){
                if(data_basic.attr('data-basic')==undefined){
                    $('#linkto').hide();
                    $('input[name="linkto"]').val('');    
                }else{
                    $('#linkto').show();
                    $('input[name="linkto"]').val(data_basic.val());
                    $('#linktoct > option[value=""]').attr("selected", "selected");
                }
                
            }else{
                
                $('#linkto').show();
            }  
            var lang  = $("#menutop").attr('data-lang');
                $.ajax({
                            url: 'menu-ajax-lang-'+lang, 
                            type: 'POST',
                            data: {actionabove:'',id_linktoct:id_linktoct},
                            success: function(data){
                                $('#districtid').html(data);
                            }
                        });
            });
    }
    var compare = function(){
        $('#menu_parent').change(function(){
            var namemenu = $('#namemenu').attr('name_id');
            var namemenuParent = $('#menu_parent').val();
            if(namemenu == namemenuParent){
                $('#compareError').slideDown('slow');
                $("#menu_parent").focus();
                return false;
            }else{
                $('#compareError').slideUp('slow');
            }
        })
    }
    var initComponents = function(){
        //init maxlength handler
        $('.maxlength-handler').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            threshold: 5
        });
    }
    return {
        //main function to initiate the module
        init: function () {
            handleValidationMenubelow();
            nameMenu();
            initComponents();
            compare();
        }
    };

}();