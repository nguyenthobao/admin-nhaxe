function clone_nxt(content) {
  if(content==undefined){
    var clone_t=$('.BNC_preview').contents();
  }else{
    var clone_t=content;
  }
  //console.log(clone_t);
  iframe=document.querySelector('iframe');
  //$('iframe').contents().find('body').html(clone_t);
  $(iframe).contents().find('body').html(clone_t);
}
clone_nxt();
var BlockCustom = function () {
    var initComponents = function(){
        //init maxlength handler
        $('.maxlength-handler').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            threshold: 5
        });
    }
   	var handleKeyUp=function(){
   		
   		$('body').on('keyup', 'textarea[name="html"]', function(event) {
   			event.preventDefault();
   			var content=$(this).val();
   			var style=$('textarea[name="css"]').val();
   			content +='<style>'+style+'</style>';
   			$('.BNC_preview').html(content);
        clone_nxt(content);
   		});
   		
   		$('body').on('keyup', 'textarea[name="css"]', function(event) {
   			event.preventDefault();
   			var content=$('textarea[name="html"]').val();
   			var style=$(this).val();
   			content +='<style>'+style+'</style>';
   			$('.BNC_preview').html(content);
        clone_nxt(content);
   		});
   	}
    var handleValidation = function() {
        var form_product = $('#blockcustom_form');
        var error1 = $('.alert-danger', form_product);
        var success1 = $('.alert-success', form_product);
        $('.continue').click(function() {
            var con = $(this).attr('data-continue');
            $('input[name="continue"]').val(con);
        });
        form_product.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {
                title: {
                    required: $('input[name="title"]').attr('data-error'),
                },
                html: {
                    required: $('textarea[name="html"]').attr('data-error'),
                },
            },
            rules: {
                title: {
                    maxlength: 255,
                    required: true
                },
                html: {
                    required: true
                },
                
            },
            invalidHandler: function(event, validator) { //display error alert on form submit
                success1.hide();
                error1.show();
                // Metronic.scrollTo(error1, -200);
            },
            highlight: function(element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            unhighlight: function(element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
            },
            success: function(label) {
                label.closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler: function(form) {
                form.submit();
                error1.hide();
            }
        });
    }
    
    return {
        //main function to initiate the module
        init: function () {
            initComponents();
            handleKeyUp();
            handleValidation();
        }
    };
}();