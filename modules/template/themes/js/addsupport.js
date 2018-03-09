
var addsupport = function() {
    var handleAddNew=function(){
        $('body').on('click', '.addNew', function(event) {
            event.preventDefault();
            //Dem so phan tu da ton tai
            var support=$('.divNick').find('.nick').length;
            var parents=$(this).parents('.nick');
            //Clone
            var clone_nick=parents.clone();
            clone_nick.find('label').text('');
            clone_nick.find('input[name="nick"]').val('');
            //This
            $(this).removeClass('addNew').addClass('removeNew');
            $(this).find('span').removeClass('glyphicon-plus').addClass('glyphicon-minus');
            $('.divNick').append(clone_nick);
            //Dua ten nhan vien vao mang
            
            $.uniform.update();
        });
    };
    
    var handleAddNewInfo=function(){
        $('body').on('click', '.addNewInfo', function(event) {
            event.preventDefault();
            //Dem so phan tu da ton tai
            var support=$('.divNick').find('.support_info').length;
            var parents=$(this).parents('.support_info');
            //Clone
            var clone_nick=parents.clone();
            clone_nick.find('input[name="nick"]').val('');
            //This
            $(this).removeClass('addNewInfo').addClass('removeNewInfo');
            $(this).find('span').removeClass('glyphicon-plus').addClass('glyphicon-minus');
            $('.divNick').append(clone_nick);
            //Dua ten nhan vien vao mang
            
            $.uniform.update();
        });
    };
    
    var handleRemove=function(){
        $('body').on('click', '.removeNew', function(event) {
            event.preventDefault();
            var parents=$(this).parents('.nick');
            //Kiem tra xem con bao nhieu phan tu
            var support=$('.divNick').find('.nick').length;
            if(support==1){
                //Bang 1 thi ko xoa nua ma thay doi thuoc tinh
                $(this).removeClass('removeNew').addClass('addNew');
                $(this).find('span').removeClass('glyphicon-minus').addClass('glyphicon-plus');
            }else{
                parents.remove();    
            }
            $.uniform.update();
        });
    };
    var handleSubmit=function(){
    	$('body').on('click','.continue',function(){
    		var el_title=$('input[name="title"]');
            var position=$('select[name="position"] option:selected').val();
            var id=$('input[name="id"]').val();
            
    		var nick=$('.divNick').find('.nick');
            var allNick=[];
            $.each(nick, function(k, v) {
                 var self=$(this);
                 if(self.find('input[name="nick"]').val()!=false && self.find('input[name="name"]').val()!=false){
                   var tmp_nick = {
                        name:self.find('input[name="name"]').val(), 
                        nick:self.find('input[name="nick"]').val(), 
                        type:self.find('select[name="type"] option:selected').val(), 
                     };
                    allNick.push(tmp_nick);
                 }
                 
            });
    		if(el_title.val()==false){
    			el_title.focus();
    			toastr.error(el_title.attr('data-error'));
    			return false;
    		}else if(allNick.length==0){
    			toastr.error('Bạn phải điền ít nhất một thông tin về tài khoản hỗ trợ');
    			return false;
    		}else{
    			//Ajax save
    			var dataString={
    				'title':el_title.val(),
    				'id':id,
    				'position':position,
                    'data_custome':allNick
    			};
    			var urlSend='/template-support-ajaxAdd';
    			var data=ajax_global(dataString,urlSend,'POST','json');
    			if(data.status==true){
    				window.location.reload();
    			}
    			return false;
    		}
    	});
    };
    
    
    return {
        //main function to initiate the module
        init: function() {
            handleSubmit();
            handleAddNew();
            handleRemove();
            handleAddNewInfo();
        }
    };
}();

$(function(){
	addsupport.init(); 
});