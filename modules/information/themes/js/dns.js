var FormDns = function () {
    var getDns = function(){
        var $this = $(this);
        var domain = $(".BNC_view_dns").attr('data-domain');

        $('.BNC_view_dns').click(function(){
            $.ajax({
                type: 'POST', 
                url: 'information-ajaxLoadDns',
                data: {'domain':domain},
                success: function(data){
                    bootbox.dialog({
                        message: data,
                        title: "Danh sách DNS của tên miền",
                        buttons: {
                            success: {
                                label: "Đồng ý",
                                className: "green",
                                callback: function() {
                                    console.log(data);
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
                }
            });
        });
    }
    return {
        //main function to initiate the module
        init: function () {
            getDns();
        }
    };
}();