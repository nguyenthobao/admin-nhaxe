var addsocial = function() {
    var handleOnload=function(){
        
    }
    
    var handleSubmit=function(){
        $('body').on('click','.continue',function(){
            var el_title=$('input[name="title"]');
            var el_code=$('input[name="url"]');
            if(el_title.val()==false){
                el_title.focus();
                toastr.error(el_title.attr('data-error'));
                return false;
            }else if(el_code.val()==false){
                el_code.focus();
                toastr.error(el_code.attr('data-error'));
                return false;
            }else{
                //Ajax save
                var dataString={
                    'title':el_title.val(),
                    'url':el_code.val(),
                    'position':$('select[name="position"] option:selected').val(),
                    'id':$('input[name="id"]').val() 
                };
                var urlSend='/template-social-ajaxAdd';
                var data=ajax_global(dataString,urlSend,'POST','json');
                if(data.status==true){
                    window.location.reload();
                }
                return false;
            }
        });
        // $('body').on('click','.continuechat',function(){
        //     var el_title=$('input[name="title"]');
        //     var el_code=$('input[name="url"]');
        //     console.log(el_title);
        //     if(el_title.val()==false){
        //         el_title.focus();
        //         toastr.error(el_title.attr('data-error'));
        //         return false;
        //     }else if(el_code.val()==false){
        //         el_code.focus();
        //         toastr.error(el_code.attr('data-error'));
        //         return false;
        //     }else{
        //         //Ajax save
        //         var dataString={
        //             'title':el_title.val(),
        //             'url':el_code.val(),
        //             'id':$('input[name="id"]').val() 
        //         };
        //         var urlSend='/template-social-ajaxAddChat';
        //         var data=ajax_global(dataString,urlSend,'POST','json');
        //         if(data.status==true){
        //             window.location.reload();
        //         }
        //         return false;
        //     }
        // });
        // $('body').on('click','.dellChat',function(){
        //     var id= $('input[name="id"]').val();
        //     if(id!=0){
        //         var dataString={
        //             'id': id 
        //         };
        //         var urlSend='/template-social-ajaxDellChat';
        //         var data=ajax_global(dataString,urlSend,'POST','json');
        //         if(data.status==true){
        //                 window.location.reload();
        //         }
        //         return false;
        //     }
            
            
        // });
    };
    
    
    return {
        //main function to initiate the module
        init: function() {
            handleSubmit();
        }
    };
}();

$(function(){
    addsocial.init(); 
});