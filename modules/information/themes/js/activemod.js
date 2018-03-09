
$( document ).ajaxStart(function() {
    Metronic.startPageLoading('Đang tải....');
});

$( document ).ajaxStop(function() {
    Metronic.stopPageLoading();
});
function ajax_global(dataString, urlSend, method, type) {
    var res = '';
    $.ajax({
        url: $('base').attr('href') + urlSend,
        type: method,
        async: false,
        dataType: type,
        data: dataString,
    }).success(function(res) {
        result = res;
    }).error(function(error) {
        console.log(error);
    });
    return result;
}
var activemod = function () {
    
    var handleDrag = function() {
        
         $( ".listborder2" ).sortable({
          revert: true,
          cursor: 'move',
        });
        $( "ul, li" ).disableSelection();
        
        }
    
    
    
    var handleSubmitSaveMod=function(){
        $('body').on('click','.continue',function(event){
            event.preventDefault();
            var active_mod=[];
            var active_mod_default=[];
            $('input:checked').each(function(k, v) {
                active_mod.push($(this).val());
            });
            
            $('input[name="mod_active[]"]').each(function(k, v) {
                active_mod_default.push($(this).val());
            });
            var dataString={
              'active_mod' :active_mod,
              'active_mod_default':active_mod_default
            };
            var urlSend='/information-activemod-ajaxActiveMod';
            var data=ajax_global(dataString,urlSend,'POST','json');
            if(data.status==true){
                toastr.success(data.message);
                setTimeout(function(){
                    window.location.reload();
                }, 3000);
            }
        })
    }
    return {
        //main function to initiate the module
        init: function () {
          handleDrag();
          handleSubmitSaveMod();
        },

    };
}();