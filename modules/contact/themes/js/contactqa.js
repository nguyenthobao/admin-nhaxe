var Contactqa = function () {

var feedback = function(){
	$('.answerfeedback').click(function(){

                var lang              = $("#contactview").attr('data-lang');

                var $this             = $(this);
                var email             = $("#contactview").attr('address'); 
                var question          = $("#contactview").attr('question');  
                var key               = $("#contactview").attr('key'); 
                var error             = $("#contactview").attr('data-error-mail');
                var successful        = $("#contactview").attr('data-success-mail');
                var address_mail      = $("#contactview").attr('data-viewf');
                var bc                = $("#contactview").attr('data-viewbb'); 
                var customers         = $("#contactview").attr('customers');
                var title_mail        = $("#contactview").attr('data-title');

              bootbox.dialog({
                
                title:'Trả lời thư !',
                message: '<div class="row">  ' +
                           '<div class="portlet-body form">'+
                              '<form class="form-horizontal" role="form">'+
                                 '<div class="form-body">'+
                                        '<div class ="success">'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                        '<label class="col-md-3 control-label">' +address_mail+
                                        '</label>'+
                                        '<div class="col-md-9">'+
                                         '<textarea class="form-control "id="addressmail" minlength="5" rows="3" cols="5" name="description" style="max-width: 404px; max-height: 40px;width:404px;">'+email+'</textarea>'+
                                        '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                        '<label class="col-md-3 control-label">' +title_mail+
                                        '</label>'+
                                        '<div class="col-md-9">'+
                                            '<input type="text" class="form-control" id="title_mail" placeholder="Nhập tiêu đề thư">'+
                                        '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                        '<label class="col-md-3 control-label">'+bc+
                                        '</label>'+
                                        '<div class="col-md-6">'+
                                        '<textarea class="form-control " minlength="5" rows="6" cols="10" name="description"id="contentmail"style="max-width: 404px; max-height: 134px;width:404px;"></textarea>'+
                                        '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '</form>'+
                                  '</div>'+
  
                        '</div>',
                 buttons: {
                  
                  success: {
                    label: "Gửi",
                    className: "green",
                    callback: function() {
                        var addAddress = $('#addressmail').val();
                        var subject    = $('#title_mail').val();
                        var content    = $('#contentmail').val();
                        if(addAddress==""){
                             $('.success').prepend('<div class="alert alert-danger padding10">'+error+'</div>');
                             $('.alert-danger').remove();
                                return false; 
                        }
                        if(subject==""){
                            $('.alert-danger').remove();
                           $('.success').prepend('<div class="alert alert-danger padding10">'+error+'</div>');
                                return false; 
                        }
                        else 
                        {   $('.alert-danger').remove();
                            $('.bootbox-body').prepend('<div class="alert alert-success padding10">'+successful+'</div>');
                            $.ajax({
                                url: 'contact-ajax-lang-'+lang, 
                                type: 'POST',
                                data: {action:'sendmailsmtp',addAddress:addAddress,question:question,subject:subject,content:content,customers:customers,key:key},
                                success: function(data){

                                                    if(data=="true"){
                                
                                         $('.alert-danger').prepend('<div class="alert alert-success padding10">'+successful+'</div>');
                                    }else{
                                         $('.bootbox-body').prepend('<div class="alert alert-danger padding10">'+error+'</div>');  
                                    }        
                               
                                }
                            });  
                        }
                        
                    	$('#form_contactview').submit();
                        setTimeout(function(){
                                    $('button[data-bb-handler="danger"]').trigger('click');
                                }, 5000);
                                return false;

                    }

                  },
                  danger: {
                    label: "Huỷ",
                    className: "red",
                    callback: function() {
                      return;
                    }
                  }
                }
                 
            } );

    	});
	}

    return {
        //main function to initiate the module
        init: function () {
            feedback();
        }
    };

}();