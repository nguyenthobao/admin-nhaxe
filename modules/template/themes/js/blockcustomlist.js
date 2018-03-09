
var BlockCustomList = function () {
    var checkboxAll = function() {
        $('#checkboxAll').click(function() {
            if ($(this).prop("checked") == true) {
                $('.checkboxes').each(function(index) {
                    $(this).prop("checked", true);
                    $(this).parent().addClass('checked');
                });

                $(".btn-del a").removeClass('disabled');                
            } else if ($(this).prop("checked") == false) {
                $('.checkboxes').each(function(index) {
                    $(this).prop("checked", false);
                    $(this).parent().removeClass('checked');
                });
                $(".btn-del a").addClass('disabled');                
            }
            if ($('.checkboxes:checked').length > 0) {
                $(".btn-del a").removeClass('disabled');                
            } else {
                $(".btn-del a").addClass('disabled');            
            }
        });
        $('.checkboxes').click(function() {
            if ($(this).prop("checked") == false) {
                $('#checkboxAll').prop("checked", false);
                $('#checkboxAll').parent().removeClass('checked');
            }
        });
    }
    var enableDelete = function() {
        $('.checkboxes').click(function(){
            if ($('.checkboxes:checked').length > 0) {
                $(".btn-del a").removeClass('disabled');
            } else {
                $(".btn-del a").addClass('disabled');                
            }
        
        });
    }
    var fastEdit = function(){
        var lang = $("#slidelist").attr('data-lang');        
        $.fn.editable.defaults.mode = 'inline';
         //global settings 
        $.fn.editable.defaults.inputclass = 'form-control';
            $('.slideItem').editable({
                url: 'template-ajaxBlockcustom-lang-'+lang,
                type: 'text',
                name: 'editTitle',
                validate: function(value) {
                    if (!value.trim()) {
                        return 'Dữ liệu không hợp lệ !';
                    }
                },
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
            url: 'template-ajaxBlockcustom-lang-'+lang,
            type: 'text',
            name: 'editSort',
            source: source
        });
    }
    var editPosition = function(){
        var lang = $("#slidelist").attr('data-lang');
        $.fn.editable.defaults.mode = '';
        $('.positionItem').editable({
            url: 'template-ajaxBlockcustom-lang-'+lang,
            type: 'text',
            name: 'editPosition',
            source: positions_source,
        });
    }
    
    var deleteSlide = function(){
        $('.delete_slide').click(function(){
            var $this = $(this);
            var lang = $("#slidelist").attr('data-lang');
            var key = $this.parents('tr').attr('data-key');
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Xóa block này thì tất cả dữ liệu về Block này sẽ bị xóa vĩnh viễn. Bạn có chắc chắn xoá ?</li>',
                title: "Xoá Xóa block",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        $.ajax({
                            url: 'template-ajaxBlockcustom-lang-'+lang,
                            type: 'POST',
                            data: {name:'deleteBlock',key:key,lang:lang},
                            success: function(data){
                                //Chuyển string sang mảng dùng split
                                $this.parents('tr').remove();
                                var data2 = data.split(",");
                                $.each(data2,function(k,v){
                                    $('#tr_'+v).remove();
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
        $('.delete_slide_select').click(function(){
            var lang = $("#slidelist").attr('data-lang');
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Xóa tất cả các blocks đã chọn sẽ không thể khôi phục lại. Bạn có chắc chắn xoá ?</li>',
                title: "Xoá",
                buttons: {
                    success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        //submit form khi nút submit không phải là button hoặc <input type="submit">
                        
                        $.ajax({
                           type: "POST",
                           url: 'template-ajaxBlockcustom-lang-'+lang,
                           data: $('#form_slidelist').serialize(), // serializes the form's elements.
                           success: function(data)
                           {
                              location.reload();
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
    var activeStatus = function(){
        $('.active_status').click(function(e,data){
            var $this = $(this);
            var statusCurren = $this.attr('data-status');
            var key = $this.parents('tr').attr('data-key');
            var lang = $this.parents('tr').attr('data-lang');
            if (statusCurren==1) {var status=0;}else{ var status=1; }
            $.ajax({
                url: 'template-ajaxBlockcustom-lang-'+lang,
                type: 'POST',
                data: {name:'activeStatus',key:key,status:status},
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
            enableDelete();
            checkboxAll();
            fastEdit();
            editPosition();
            activeStatus();            
            deleteSlide();
            deleteMultiID();
            // handle editable elements on hidden event fired
            $('#slidelist .editable').on('hidden', function (e, reason) {
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