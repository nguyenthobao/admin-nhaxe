String.prototype.replaceNXT = function(
strTarget, // The substring you want to replace
strSubString // The string you want to replace in.
){
var strText = this;
var intIndexOfMatch = strText.indexOf( strTarget );
while (intIndexOfMatch != -1){
strText = strText.replace( strTarget, strSubString )
intIndexOfMatch = strText.indexOf( strTarget );
}
return( strText );
}

function replaceAll(find, replace, str) {
  return str.replaceNXT(find, replace);
}

var MenuTop = function () {

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
            var error1   = $('.alert-danger', form_menuabove);
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
                    // linkto:{
                    //     required: $('input[name="linkto"]').attr('data-error'),
                    // },
                    sort:{
                        number: $('input[name="sort"]').attr('data-error'), 
                    }
                              
                },
                rules: {
                    namemenu: {
                        required: true
                    },
                    sort:{
                        number:true,
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

    var changelink =function(){
        $('#linkto').change(function(){
            var $this = $(this);
            if($this.val().length>0){
                $('#linktoct').hide();
            }
        });
    }
    var nameMenu  =function(){
        if($('#linktoct').val()==true){
            $('#linkto').hide();
            $('input[name="linkto"]').val('');
        }
        $('#linktoct').change(function(){
            $('#cd-1').rules('remove');
            var id_linktoct =$(this).val();
            var data_basic=$('#linktoct option:selected'); 
            var name_menu=replaceAll('-','',data_basic.text());
            // var isName=$('input[name="namemenu"]').val();
            if(  id_linktoct != ""){
                if(data_basic.attr('data-basic')==undefined){
                    $('#linkto').hide();
                    $('input[name="linkto"]').val('');  
                    if($('input[name="namemenu"]').val()==''){
                        $('input[name="namemenu"]').val(name_menu);     
                    }
                }else{
                    $('#linkto').show();
                    $('input[name="linkto"]').val(data_basic.val());
                    $('#linktoct > option[value=""]').attr("selected", "selected");
                    if($('input[name="namemenu"]').val()==''){
                        $('input[name="namemenu"]').val(name_menu);     
                    }
                }
                
            }else{
                
                $('#linkto').show();
            } 
            var lang  = $("#menutop").attr('data-lang');
                $.ajax({
                            url: 'menu-ajax-lang-'+lang, 
                            type: 'POST',
                            data: {
                                actionabove:'',
                                id_linktoct:id_linktoct
                            },
                            success: function(data){
                              $('#districtid').html(data);
                            }
                        });
            });
    }

    var initComponents = function(){
        //init maxlength handler
        $('.maxlength-handler').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            threshold: 5
        });
    }

    var deleteImg=function(){
        $('body').on('click', '.BNC_remove_image', function(event) {
            event.preventDefault();
            var type=$(this).attr('data-type');
            var id=$(this).attr('data-id');
            var img=$(this).attr('data-image');
            var lang  = $("#menutop").attr('data-lang');
            $.ajax({
                url: 'menu-ajaximage-lang-'+lang,
                type: 'POST',
                dataType: 'json',
                data: {
                    type: type,
                    id:id,
                    img:img
                },
            })
            .success(function(res) {
                console.log(res);
            })
            .done(function() {
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
            
        });
    }
    return {
        //main function to initiate the module
        init: function () {
            handleValidationMenuabove();
            nameMenu();
            changelink();
            initComponents();
            deleteImg();
        }
    };

}();