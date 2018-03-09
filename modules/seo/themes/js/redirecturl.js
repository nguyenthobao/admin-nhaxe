function isURL(url){
        if (url == ""|| url == null)
                return false;
  
        url = url.trim();
  
        if (url.indexOf(" ")!=-1)
                return false;
  
        var RegExp = /^http(s)?:\/\/[\w|\-]+(\.[^\.]+)+$/i;
  
        if(RegExp.test(url)){
                return true;
        }else{
                return false;
        }
}
var redirect = function () {
var ajax_url = function(){
        var eu=1;
        $('.portlet-body').find('.cl_title').each(function() {           
            $(this).text(eu+'.');
            eu++;
        });

        $('body').on('click','.add_url',function(){
           $('#list-redirect').append('<div class="form-group">                                <div class="col-md-1"><span class="cl_title"></span>                                </div>                                <div class="col-md-5">                                    <input type="text" class="form-control Urlstart" name="" placeholder="Url hiện tại" value="">                                    <input type="hidden" name="id_url" value="0" class="id_url">                                </div>                                <div class="col-md-5" style="padding-left:0px">                                    <input type="text" class="form-control Urlend" name="" placeholder="Url đích" value="">                                </div><div class="col-md-1" style="padding:0px"><a class="btn red delete_url" style="border-radius:3px !important" href="javascript:void(0)">                                        <i class="fa fa-minus"></i>                                    </a>                                </div></div> ')
            var eu=1;
            $('.portlet-body').find('.cl_title').each(function() {           
                $(this).text(eu+'.');
                eu++;
            });
        });
        $('body').on('click','.delete_url',function(){
            var parents=$(this).parents('.form-group');
            var isMethodPrice=parents.parent();
            id= $(this).parents('.form-group').find('.id_url').val();
            // var imp=$('.portlet-body').find('.form-group').length;
            // alert(imp);
            $.ajax({
                            url: '/seo-ajax-lang-vi',
                            type: 'POST',
                            dataType:'json',
                            data: {action:'delete_url',id:id},
                            success: function(data){
                                                     
                            }
            });
            parents.remove();
            var firstChild=isMethodPrice.children(':first-child');
            firstChild.children('label').text('Chuyển hướng Url');


            var eu=1;
            $('.portlet-body').find('.cl_title').each(function() {           
                $(this).text(eu+'.');
                eu++;
            });
        }); 
        $('.url_save').click(function(){            
            // var Urlstart = $('.Urlstart[]').val();
            // var Urlend = $('.Urlend[]').val();
            var Urlstart= new Array();
            var Urlstart_tmp= new Array();
            var Urlstart_edit = new Array();
            var Urlend= new Array();
            var Urlend_edit = new Array();        
            var id_array= new Array();
            var error=0;
            $('.portlet-body').find('.Urlstart').each(function() {  
                var id= $(this).parents('.form-group').find('.id_url').val();  
                // alert(id);        
                if(isURL($(this).val()))  
                {
                                var start= $(this).val();                 
                                var end= $(this).parents('.form-group').find('.Urlend').val();
                                if ((isURL(end)||end=='/') && end!=start) {
                                    if(id==0)
                                      {
                                            Urlend.push(end);
                                      }else{
                                            Urlend_edit.push(end);
                                      }
                                }else
                                {
                                    error = 1;
                                    $(this).parents('.form-group').find('.Urlend').focus();
                                }
                                if(Urlstart_tmp.indexOf(start)!=-1)
                                {
                                    $(this).focus();
                                    error = 1;
                                }
                                Urlstart_tmp.push(start);
                                if(id==0)
                                {
                                    Urlstart.push(start);
                                }else{
                                    Urlstart_edit.push(start);
                                    id_array.push(id);
                                }                     
                }else{
                                $(this).focus();
                                error = 1;                          
                }                                             
            });
            if(error==0)
            {
                if(Urlstart != '')
                {
                    $.ajax({
                            url: '/seo-ajax-lang-vi',
                            type: 'POST',
                            dataType:'json',
                            data: {action:'redirect_url',Urlend:Urlend,Urlstart:Urlstart},
                            success: function(data){
                                window.location.reload();
                            }
                    });
                }
                
                if(id_array!='')
                {
                  $.ajax({
                            url: '/seo-ajax-lang-vi',
                            type: 'POST',
                            dataType:'json',
                            data: {action:'redirect_edit',Urlend_edit:Urlend_edit,Urlstart_edit:Urlstart_edit,id_array:id_array},
                            success: function(data){
                                window.location.reload();
                            }
                    });  
                }                    
            }                                 
            });

            
    }    
    
    return {
        //main function to initiate the module
        init: function () {
            ajax_url();
        }
    };

}();