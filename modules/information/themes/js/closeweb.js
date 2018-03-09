var Closeweb = function () {
    
   
    var handlSaveCloseWeb=function(){
        $('#saveCloseweb').on('click', function(event, state) {
            var styleClose = $('.styleClose').find('.active').attr('data-style');
            var content = CKEDITOR.instances['contentCloseweb'].getData();
            var status = $('#status').val();
             var urlSend='/information-closeweb-index-lang-vi';
             $.ajax({
                 url: urlSend,
                 type: 'POST',
                 dataType: 'json',
                 data: {action:'saveCloseweb',status:status,styleClose:styleClose,content:content},
             })
             .success(function(res) {
                console.log(res);
                if(res.status==true){
                    toastr.success(res.message);
                }
             });
             
            
        });
    }
    var activeStyleClose = function(){
        $('.styleClose').on('click',function(){
                $('.styleClose img').removeClass('active');
                $(this).find('img').addClass('active');
        });
    }
    return {
        //main function to initiate the module

        init: function () {
            handlSaveCloseWeb();
            activeStyleClose();
        },

    };
}();