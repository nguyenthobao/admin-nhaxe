var SlideList = function () {
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
                url: 'template-ajaxslide-lang-'+lang,
                type: 'text',
                name: 'editTitleSlide',
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
            url: 'template-ajaxslide-lang-'+lang,
            type: 'text',
            name: 'editSortSlide',
            source: source
        });
    }
    var checkCharacterEdit = function(){
        $('.editable-input input').live('keypress',function(){
            var val = $(this).val();
            var length = val.length;
            if (length < 100 ) {
                var charact = val.split(" ");
                $.each(charact,function(k,v){
                    if (v.length>9) {
                        alert("Một từ của bạn không được nhập vào quá 10 ký tự");
                        $('.editable-input input').val(val.substr(0,10));
                        return false;
                    }
                });
            }
        });
    }
    var checkTitleEditCopy = function(){
        $('.editable-input input').live('paste', function () {     
            var valTitle = $('.editable-input input').val();
            var title = valTitle.split(" ");
            $.each(title , function(key, val) { 
            if (val.length>9) {            
                    alert("Một từ của bạn không được nhập vào quá 10 ký tự");
                    return false;
                }else{
                    return true;
                }
            });
        });
    }
    var deleteInfo = function(){
        $('.delete_info').click(function(){
            var $this = $(this);
            var lang = $("#infolist").attr('data-lang');
            var key = $this.parents('tr').attr('data-key');
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Xóa bài giới thiệu này. Bạn có chắc chắn xoá ?</li>',
                title: "Xoá giới thiệu",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        $.ajax({
                            url: 'info-ajaxinfo-lang-'+lang,
                            type: 'POST',
                            data: {action:'deleteInfo',key:key},
                            success: function(data){
                                //Chuyển string sang mảng dùng split
                                $this.parents('tr').remove();
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
        $('.delete_info_select').click(function(){
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Xóa tất cả các bài giới thiệu đã chọn. Bạn có chắc chắn xoá ?</li>',
                title: "Xoá giới thiệu",
                buttons: {
                    success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        //submit form khi nút submit không phải là button hoặc <input type="submit">
                        $('#form_infolist').submit();
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
    var activeStatusInfo = function(){
        $('.active_status').click(function(e,data){
            var $this = $(this);
            var statusCurren = $this.attr('data-status');
            var key = $this.parents('tr').attr('data-key');
            var lang = $this.parents('tr').attr('data-lang');
            if (statusCurren==1) {var status=0;}else{ var status=1; }
            $.ajax({
                url: 'info-ajaxinfo-lang-'+lang,
                type: 'POST',
                data: {action:'activeStatusInfo',key:key,status:status},
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
    var editImgInfo = function(){
        $('.list-cat-img').mouseover(function(){
            $(this).find('.btn-change').show();
        }).mouseout(function(){
            $(this).find('.btn-change').hide();
        });
        $('input[type="file"]').change(function(){
            $this = $(this).parents('.btn-all');
            $this.find('.btn-save').remove();
            if($(this).val() != ""){
                $this.append('<input type="button" value="Lưu" class="btn btn-xs default btn-save">'); 
            }            
        });
       //Lưu ảnh khi đã chọn ảnh ok
    }
    var saveImgInfo = function(){
        $(".btn-save").live('click',function() {
            var $this = $(this).parents('tr');
            $this.remove('input[name="id_img"]');
            $this.append('<input type="hidden" name="id_img" id="id_img" value="'+$this.attr('data-key')+'" />');
            $('input[name="action"]').val("saveImgFast");
            $('#form_infolist').submit();
        });
    }
    var refeshInfo = function(){
        $('.refesh_info').click(function(){
            var $this = $(this);
            var lang = $("#infolist").attr('data-lang');
            var key = $this.parents('tr').attr('data-key');
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Bạn chắc chắn làm mới bài giới thiệu này</li>',
                title: "Làm mới giới thiệu",
                buttons: {
                    success: {
                    label: "Đồng ý",
                    className: "green",
                        callback: function() {
                            $.ajax({
                                url: 'info-ajaxinfo-lang-'+lang,
                                type: 'POST',
                                data: {action:'refeshInfo',key:key},
                                success: function(data){
                                    window.location.reload(true);
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
    var editPostInfo = function(){
        $('.post_info').click(function(e,data){
            var $this = $(this);
            var statusCurren = $this.attr('data-status');
            var key = $this.parents('tr').attr('data-key');
            var lang = $this.parents('tr').attr('data-lang');
            if (statusCurren==1) {var status=0;}else{ var status=1;}
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Bạn chắc chắn đăng ngay bài giới thiệu này</li>',
                title: "Đăng ngay giới thiệu",
                buttons: {
                    success: {
                    label: "Đồng ý",
                    className: "green",
                        callback: function() {
                            $.ajax({
                                url: 'info-ajaxinfo-lang-'+lang,
                                type: 'POST',
                                data: {action:'editPostInfo',key:key,status:status},                
                                success: function(data){
                                   window.location.reload(true);
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
    var searchInfo = function(){
        $("#btn_search").live('click',function() {            
            $('input[name="action"]').val("searchInfo");
            $('#form_infolist').submit();
        });
    }
    return {
        //main function to initiate the module
        init: function () {            
            enableDelete();
            checkboxAll();
            fastEdit();
            activeStatusInfo();            
            deleteInfo();
            deleteMultiID();
            editImgInfo();
            saveImgInfo();
            refeshInfo();
            editPostInfo();
            checkCharacterEdit();
            checkTitleEditCopy();
            searchInfo();
            // handle editable elements on hidden event fired
            $('#infolist .editable').on('hidden', function (e, reason) {
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