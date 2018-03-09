$( document ).ajaxStart(function() {
    Metronic.startPageLoading('Đang lưu....');
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

var Domain = function () {
    var addDomain = function () {
        $('#check_domainwww').click(function() {
            if($('#check_domainwww').is(':checked')){
                var valuec = 1;
            }else{
                var valuec = 0;
            }
            $.ajax({
                url: 'seo-seo-lang-vi',
                type: 'POST',
                data: {action:'activeDomain',value:valuec},
                    success: function(data){
                }
            });
        });
    }
    var chooseRadOne = function(){
        $('.rad_choose_oness').click(function(){
            var $this = $(this);
            var rad_choose = $('input[name=typeDomain]:checked').val();
            bootbox.dialog({
                message: 'Cảnh báo: Bạn có chắc chắn chọn cài đặt tên miền dạng này ?',
                title: "Cài đặt dạng tên miền",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        $.ajax({
                            url: '/seo-ajax-www-lang-vi',
                            type: 'POST',
                            dataType:'json',
                            data: {action:'wwwDomain',rad_choose:rad_choose},
                            success: function(data){
                                if(data.status==true){
                                   toastr.success(data.message);
                                }
                            }
                        });
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
            });
        });
    }
    var enableSeoUrl = function(){
        var $input = $('input[name="active_seo_url"]');
        $('input[name="active_seo_url"]').bind('click',function(e){
            var checkbox = $input.is(":checked");//.prop( "disabled", true );
            if (checkbox==false) {
                var enable = 0;
            }else{
               var enable = 1;
            }

            $.ajax({
                url: 'seo-ajax-enableSeoUrl-lang-vi',
                type: 'POST',
                data: {action:'enableSeoUrl',value:enable},
                success: function(data){
                    console.log(data);
                },
                error: function(err){
                    console.log(err);
                }
            });
        });
    }

    var handleReset=function(){
        $('body').on('click', '.NXTreset',function(){
            var parent=$(this).parents('.form-group');
            var dataDefault=$(this).attr('data-defaut');
            parent.find('input').val(dataDefault.trim().replace('.html',''));
            return false;
        });

        $('body').on('click', '.NXTresetAll',function(){
            $('.nxtBorder').find('input').each(function(k, v) {
                var parent=$(this).parents('.form-group');
                var dataD=parent.find('button').attr('data-defaut');
                $(this).val(dataD.replace('.html',''));
            });
            return false;
        });
    }
    var handleSave=function(){
        $('body').on('click', '.NXTsave',function(){
             var dataDefault=[];
             var dataCustom=[];
             var cont=false;

             $('.nxtBorder').find('input').each(function(k, v) {
                var parent=$(this).parents('.form-group');
                var dataD=parent.find('button').attr('data-defaut');
                parent.removeClass('has-error');
                if($(this).val()==''){
                    parent.addClass('has-error');
                    $(this).focus();
                    cont=false;

                    return false;
                }else{
                    cont=true;
                  dataCustom.push($(this).val().trim());
                  dataDefault.push(dataD.trim());
                }
            });
             if(cont==true){
                var dataString={
                    'action':'CustomSeoUrl',
                    'dataDefault':dataDefault,
                    'dataCustom':dataCustom,
                };
                var urlSend='/seo-ajax-CustomSeoUrl-lang-vi';
                $.ajax({
                    url: urlSend,
                    type: 'POST',
                    data: dataString,
                    dataType:'json',
                    success: function(data){
                        if(data){
                             window.location.reload();
                         }
                    },
                    error: function(err){
                        console.log(err);
                    }
                });


             }

            return false;
        });
    }
    var handleOnload=function(){
        var dataString={
                    'action':'getCustom',
                };
        var urlSend='/seo-ajax-getCustom';
        var data=ajax_global(dataString,urlSend,'POST','json');
        if(data.length!=0){
            $.each(data, function(k, v) {
                $('input[name="'+k+'"]').val(v);
            });
        }

        var dataString2={
            'action':'getTypeDomain',
        };
        var urlSend2='/seo-ajax-getTypeDomain';
        var data2=ajax_global(dataString2,urlSend2,'POST','json');

        //if(data2.type_value){
            var type2=parseInt(data2.type_value+1);
            $('input[name=typeDomain][value="'+type2+'"]').attr('checked', 'checked');
        //}

    }
    return {
        //main function to initiate the module
        init: function () {
            addDomain();
            chooseRadOne();
            enableSeoUrl();
            handleReset();
            handleSave();
            handleOnload();
        }
    };

}();