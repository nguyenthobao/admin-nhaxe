var MenuListTop = function() {
    var checkboxAll = function() {
        $('#checkboxAll').click(function() {
             $('tbody').find('tr').each(function(k,v){
                   var self=$(this);
                   self.find('input[type="checkbox"]').prop('disabled',false);  
                   $(":checkbox").uniform();
             });
            if ($(this).prop("checked") == true) {
                $('.checkboxes').each(function(index) {
                    $(this).prop("checked", true);
                    $(this).parent().addClass('checked');
                });
                $(".btn-del a").removeClass('disabled');
                $(".copy_category a").removeClass('disabled');
            } else if ($(this).prop("checked") == false) {
                $('.checkboxes').each(function(index) {
                    $(this).prop("checked", false);
                    $(this).parent().removeClass('checked');
                });
                $(".btn-del a").addClass('disabled');
                $(".copy_category a").addClass('disabled');
            }
            if ($('.checkboxes:checked').length > 0) {
                $(".btn-del a").removeClass('disabled');
                $(".copy_category a").removeClass('disabled');
            } else {
                $(".btn-del a").addClass('disabled');
                $(".copy_category a").addClass('disabled');
            }
        });
    }
    
    var handleCheckParent=function(){
       $('body').on('click','.checkboxes',function() {
             var tr=$(this).parents('tr');
             var id=tr.attr('data-key'); 
            if ($(this).prop("checked") == false) {
                $('#checkboxAll').prop("checked", false);
                $('#checkboxAll').parent().removeClass('checked');
                
                $('tbody').find('tr[data-parent="tr_'+id+'"]').each(function(k,v){
                   var self=$(this);
                   self.find('input[type="checkbox"]').prop("checked", false).prop('disabled',false);  
                   $(":checkbox").uniform();
                });
            }else{
                $('tbody').find('tr[data-parent="tr_'+id+'"]').each(function(k,v){
                   var self=$(this);
                   self.find('input[type="checkbox"]').prop("checked", true).prop('disabled',true);  
                   $(":checkbox").uniform();
                });
            }
        });
    }
    
    var enableDelete = function() {
        $('.checkboxes').click(function() {
            if ($('.checkboxes:checked').length > 0) {
                $(".btn-del a").removeClass('disabled');
                $(".copy_category a").removeClass('disabled');
            } else {
                $(".btn-del a").addClass('disabled');
                $(".copy_category a").addClass('disabled');
            }
        });
    }
    var handleDeleteMenu = function() {
        $('body').on('click', '.delete_menu', function(event) {
            event.preventDefault();
            var key = $(this).parents('tr').attr('data-key');
            var deletefeed = $("#menulist").attr('data-lang-a');
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">' + deletefeed + '</li>',
                title: "Xoá menu",
                buttons: {
                    success: {
                        label: "Đồng ý",
                        className: "green",
                        callback: function() {
                            var dataString={
                                'value':key,
                                'name':'delete',
                                'pk':key
                            };
                            var urlSend='/menu-menu-ajaxDelete';
                            var data=ajax_global(dataString,urlSend,'POST','json');
                            $('#tr_'+key).remove();
                            getNotify();
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
    var handleStatus = function() {
        $('body').on('click', '.active_status', function(event) {
            event.preventDefault();
            var statusCurren = $(this).attr('data-status');
            var key =  $(this).parents('tr').attr('data-key');
            if (statusCurren == 1) {
                var status = 0;
            } else {
                var status = 1;
            }
            var dataString={
                'value':status,
                'name':'status',
                'pk':key
            };
            var urlSend='/menu-menu-ajaxChange';
            var data=ajax_global(dataString,urlSend,'POST','json');
            if(data.status==true){
                setStatus($(this),status);
              
            }
            getNotify();
        });
        
    }
    var handleDoFollow = function() {
        $('body').on('click', '.active_nofollow', function(event) {
            event.preventDefault();
             var nofollowCurren = $(this).attr('data-nofollow');
             var key = $(this).parents('tr').attr('data-key');
             if (nofollowCurren == 1) {
                    var nofollow = 0;
             } else {
                    var nofollow = 1;
             }
             var dataString={
                'value':nofollow,
                'name':'follow',
                'pk':key
             };
             var urlSend='/menu-menu-ajaxChange';
             var data=ajax_global(dataString,urlSend,'POST','json');
             if(data.status==true){
               if (nofollowCurren == 1) {
                        $(this).removeClass('green-stripe');
                        $(this).addClass('red-stripe');
                        $(this).text('No');
                        $(this).attr('data-nofollow', 0);
                    } else {
                        $(this).removeClass('red-stripe');
                        $(this).addClass('green-stripe');
                        $(this).text('Yes');
                        $(this).attr('data-nofollow', 1);
                    }
             }
             getNotify();
        });

    }
    var handleDeleteMenuMulti = function() {
        $('body').on('click', '.delete_contactview_select', function(event) {
            event.preventDefault();
            var deletefeed = $("#menulist").attr('data-lang-j');
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">' + deletefeed + '</li>',
                title: "Xoá menu",
                buttons: {
                    success: {
                        label: "Đồng ý",
                        className: "green",
                        callback: function() {
                            var allChecked=$('tbody').find('span[class="checked"]');
                            var checked=[];
                            $.each(allChecked, function(k, v) {
                                 var self=$(this);
                                 var tmp_id=self.find('input[type="checkbox"]').val();
                                 checked.push(tmp_id);
                            });
                            var dataString={
                                'name':'deleteMulti',
                                'idm':checked
                            };
                            var urlSend='/menu-menu-ajaxDelete';
                            var data=ajax_global(dataString,urlSend,'POST','json');
                            $.each(checked, function(k, v) {
                                $('#tr_'+v).remove();
                            });
                            getNotify();
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
    var handleEditTitle = function() {
        $.fn.editable.defaults.mode = 'inline';
        //global settings
        $.fn.editable.defaults.inputclass = 'form-control';
        $('.nameItem').editable({
            url: baseUrl+'/menu-menu-ajaxChange-lang-' + lang,
            name:'title',
            type: 'text',
            validate: function(value) {
                if (!value.trim()) {
                    return 'Dữ liệu không được để trống!';
                }
            },
            success: function(data, config) {
                console.log(data);
                console.log(config);
            }
        });
        
        var string = '';
        for (var i = 0; i < 100; i++) {
            string += '{"value": ' + i + ', "text": "' + i + '"},';
        }
        string=string.substr(0,string.length-1);
        source = '[' + string + ']';

        $.fn.editable.defaults.mode = '';
        $('.sortItem').editable({
            url: baseUrl+'/menu-menu-ajaxChange-lang-' + lang,
            name:'sort',
            type: 'text',
            source: source
        });
    };

    
    var handleCopyMenu = function() {
        $('body').on('click', '.copyCats', function(event) {
            event.preventDefault();
            var $this = $(this);
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Sao chép menu này thì toàn bộ menu con được sao chép theo. Bạn chắc chắn sao chép ?</li>',
                title: "Sao chép danh mục",
                buttons: {
                    success: {
                        label: "Đồng ý",
                        className: "green",
                        callback: function() {
                             var allChecked=$('tbody').find('span[class="checked"]');
                                var checked=[];
                                $.each(allChecked, function(k, v) {
                                     var self=$(this);
                                     var tmp_id=self.find('input[type="checkbox"]').val();
                                     checked.push(tmp_id);
                                });
                                var dataString={
                                    'ids':checked
                                };
                                var urlSend='/menu-menu-ajaxCopy';
                                var data=ajax_global(dataString,urlSend,'POST','json');
                                getNotify(); 
                                setTimeout(function(){
                                       window.location.reload();
                                },1000);
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
       
    };
    var handleCopyCatsProduct=function(){
        $('body').on('click', '.copyCatsProduct', function(event) {
            event.preventDefault();
           bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Sử dụng tính năng này sẽ sao chép tất cả danh mục sản phẩm sang phần menu này.Bạn có đồng ý sao chép ?</li>',
                title: "Sao chép danh mục sản phẩm ",
                buttons: {
                    success: {
                        label: "Đồng ý",
                        className: "green",
                        callback: function() {
                           var dataString={
                             'author':'nxt'
                           };
                           var urlSend='/menu-menu-ajaxCopyCatsProduct';
                           var data=ajax_global(dataString,urlSend,'POST','json');
                           if(data.status===true){
                            getNotify();
                            setTimeout(function(){
                                window.location.reload();
                            },1000);
                           }
                           return;
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
    };
    return {
        //main function to initiate the module
        init: function() {
            checkboxAll();
            enableDelete();
            handleDeleteMenuMulti();
            handleDeleteMenu();
            handleStatus();
            handleDoFollow();
            handleEditTitle();
            handleCopyMenu();
            handleCheckParent();
            handleCopyCatsProduct();
        }
    };
}();

$(function(){
   MenuListTop.init();
});
