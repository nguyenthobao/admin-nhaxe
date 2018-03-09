var CategoryList = function () {

    var checkboxAll = function(){

        $('#checkboxAll').click(function(){
            if($(this).prop("checked") == true){
                $('.checkboxes').each(function( index ) {
                    $(this).prop("checked", true);
                    $(this).parent().addClass('checked');
                });
                
                $(".btn-del a").removeClass('disabled');                
            }
            else if($(this).prop("checked") == false){
                $('.checkboxes').each(function( index) {
                   $(this).prop("checked",false); 
                   $(this).parent().removeClass('checked');
                });
                $(".btn-del a").addClass('disabled');
            }
        });
    }
    var enableDelete = function()
    {
        var i = 0;
         $('.checkboxes').click(function(){
            var $this = $(this);
            $this.each(function( index ) {
               if($(this).prop("checked") == true){
                i++;
               }
            });
            if (i>=2) {
              $(".btn-del a").removeClass('disabled');
            }
            else
            {
                $(".btn-del a").addClass('disabled');
            }
         })
    }
    
    var fastEdit = function () {
        var lang = $("#categorylist").attr('data-lang');
        $.fn.editable.defaults.mode = 'inline';
         //global settings 
        $.fn.editable.defaults.inputclass = 'form-control';
        $('.catItem').editable({
            url: 'news-ajax-lang-'+lang,
            type: 'text',
            name: 'editTitleCategory',
            success: function(data, config) {
                console.log(data);
                console.log(config);
            }
        });
        var string = '';
        for (var i = 0;i<50;i++) {
            string +="{value: "+i+", text: '"+i+"'},";
        }

        source = '['+string+']';
        
        $.fn.editable.defaults.mode = '';
        
        $('.sortItem').editable({
            url: 'news-ajax-lang-'+lang,
            type: 'text',
            name: 'editSortCategory',
            source: source
        });
    }

    var deleteCategory = function(){
        $('.delete_category').click(function(){

            var $this = $(this);

            var key = $this.parents('tr').attr('data-key');
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Xoá danh mục này toàn bộ danh mục con được xoá theo. Bạn chắc chắn xoá ?</li>',
                title: "Xoá danh mục",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        $.ajax({
                            url: 'news-ajax', //dev2.webbnc.vn/news-ajax-lang-vi|en
                            type: 'POST',
                            data: {action:'deleteCategory',key:key},
                            success: function(data){
                                $this.parents('tr').remove();
                                //Chuyển string sang mảng dùng split
                                var data2 = data.split(",");
                                $.each(data2,function(k,v){
                                    $('#tr_'+v).remove();//xoá thẻ html theo id (vd id="tr_220") <tr id="tr_220"></tr>
                                });
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

    
    var deleteMultiID =function(){
        
        $('.delete_category_select').click(function(){
             bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Xoá danh mục này toàn bộ danh mục con được xoá theo. Bạn chắc chắn xoá ?</li>',
                title: "Xoá danh mục",
                buttons: {
                    success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        //submit form khi nút submit không phải là button hoặc <input type="submit">
                        $('#form_categorylist').submit();
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
    var activeStatusCategory = function(){
        $('.active_status').click(function(e,data){
            var $this = $(this);
            var statusCurren = $this.attr('data-status');
            var key = $this.parents('tr').attr('data-key');
            var lang = $this.parents('tr').attr('data-lang');
            if (statusCurren==1) {var status=0;}else{ var status=1; }
            $.ajax({
                url: 'news-ajax-lang-'+lang,
                type: 'POST',
                data: {action:'activeStatusCategory',key:key,status:status},
                success: function(data){
                    if (statusCurren==1) {
                        $this.removeClass('green-stripe');
                        $this.addClass('red-stripe');
                        $this.text('Đang ẩn');
                        $this.attr('data-status',0);
                    }else{
                        $this.removeClass('red-stripe');
                        $this.addClass('green-stripe');
                        $this.text('Đang hiện');
                        $this.attr('data-status',1);
                    }
                }
            });
        });
    }
     
    
    return {
        //main function to initiate the module
        init: function () {
            //deleteCategorySelect();
            enableDelete();
            checkboxAll();
            deleteCategory();
            activeStatusCategory();
            fastEdit();
            deleteMultiID();
            // handle editable elements on hidden event fired
            $('#categorylist .editable').on('hidden', function (e, reason) {
                if (reason === 'save' || reason === 'nochange') {
                    var $next = $(this).closest('tr').next().find('.editable');
                    if ($('#autoopen').is(':checked')) {
                        setTimeout(function () {
                            $next.editable('show');
                        }, 300);
                    } else {
                        $next.focus();
                    }
                }
            });
        }
    };

}();