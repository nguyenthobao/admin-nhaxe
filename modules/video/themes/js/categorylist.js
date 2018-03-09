var CategoryList = function () {

    var checkboxAll = function(){
         $('#checkboxAll').click(function() {
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
                $(".copy_category a").removeClass('disabled');
            } else {
                $(".btn-del a").addClass('disabled');
                $(".copy_category a").addClass('disabled');
            }
        
        });
    }
     var fastEdit = function () {
        var lang = $("#categorylist").attr('data-lang');
        $.fn.editable.defaults.mode = 'inline';
         //global settings 
        $.fn.editable.defaults.inputclass = 'form-control';
        $('.catItem').editable({
            url: 'video-ajax-lang-'+lang,
            type: 'text',
            name: 'editTitleCategory',
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
            url: 'video-ajax-lang-'+lang,
            type: 'text',
            name: 'editSortCategory',
            source: source
        });
    }
    var copyCategory = function(){
        $('body').on('click', '.copyCatsLang', function(event) {
            event.preventDefault();
            $('#copyCat').modal('show');
        });
       $('.copyCats').click(function(){
            var lang = $("#categorylist").attr('data-lang');
            var $this = $(this);
            var key= new Array();
            $('#categorylist tr').find('.delete_multi').each(function() {
                if($(this).is(':checked')) {
                    key.push($(this).val());
                }
            });
          
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Bạn chắc chắn copy những danh mục đã chọn. Copy những danh mục này toàn bộ danh mục con và video thuộc những danh mục đó cũng được copy theo ?</li>',
                title: "Copy danh mục",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        $.ajax({
                            url: 'video-ajax-lang-'+lang, //dev2.webbnc.vn/video-ajax-lang-vi|en
                            type: 'POST',
                            data: {action:'copyCategory',key:key},
                            success: function(data){
                               
                                 window.location.reload(true);
                                 //document.write(data);
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
    var handleCopyCategory=function(){
        $("#formCopy").submit(function(e) {
                var langData = $('select[name=langData]').val();
                var emptyData = $('input[name=emptyData]:checked').val();
                if(emptyData == null){
                    emptyData=0;
                }
                $.ajax({
                    url: 'video-categorylist-lang-'+lang,
                    type: 'POST',
                    data: {action:'ajaxCopyCategory',langData:langData,emptyData:emptyData},
                    success: function(response){
                       $('#copyCat').modal('hide');
                        if(response){
                            toastr.success('Sao chép thành công !');
                        }else{
                            toastr.error('error ...');
                        }                    
                    }
                });
                return false;

        });
    }
    var deleteCategory = function(){
        $('.delete_category').click(function(){
            var lang = $("#categorylist").attr('data-lang');
            var $this = $(this);
            var key = $this.parents('tr').attr('data-key');
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Xoá danh mục này thì toàn bộ danh mục con và các video thuộc danh mục sẽ xoá theo. Bạn chắc chắn xoá ?</li>',
                title: "Xoá danh mục",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        $.ajax({
                            url: 'video-ajax-lang-'+lang, //dev2.webbnc.vn/video-ajax-lang-vi|en
                            type: 'POST',
                            data: {action:'deleteCategory',key:key},
                            success: function(data){

                               // alert(data);
                               // document.write(data);
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
     var deleteCategoryMulti = function(){
        $('.delete_category_select').click(function(){
            var lang = $("#categorylist").attr('data-lang');
            var $this = $(this);
            var key= new Array();
            $('#categorylist tr').find('.delete_multi').each(function() {
                if($(this).is(':checked')) {
                    key.push($(this).val());
                }
            });
          
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Bạn chắc chắn xoá những danh mục đã chọn. Xoá những danh mục này toàn bộ danh mục con và video thuộc những danh mục đó cũng được xoá theo ?</li>',
                title: "Xoá danh mục",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        $.ajax({
                            url: 'video-ajax-lang-'+lang, //dev2.webbnc.vn/video-ajax-lang-vi|en
                            type: 'POST',
                            data: {action:'deleteCategoryMulti',key:key},
                            success: function(data){
                                 // alert(data);
                               // $this.parents('tr').remove();
                                //Chuyển string sang mảng dùng split
                                var data2 = data.split(",");
                                //document.write(data);
                                 $.each(data2, function(k,v){
                                    $('#tr_' + v).remove();
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
    var activeStatusCategory = function(){
        $('.active_status').click(function(e,data){
            var $this = $(this);
            var statusCurren = $this.attr('data-status');
            var key = $this.parents('tr').attr('data-key');
            var lang = $this.parents('tr').attr('data-lang');
            if (statusCurren==1) {var status=0;}else{ var status=1; }
            $.ajax({
                url: 'video-ajax-lang-'+lang,
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
     var checkCharacterEdit = function () {
        $('.editable-input input').live('keypress',function(){
            var val = $(this).val();
            var length = val.length;
            $('.form-control').attr("maxlength","60");
            if (length < 60 ) {
                var charact = val.split(" ");
                $.each(charact,function(k,v){
                    if (v.length>10) {
                        alert("Một từ của bạn không được nhập vào quá 10 ký tự");
                        $('.editable-input input').val(val.substr(0,10));
                        return false;
                    }
                });
            }
        });
    }
    return {
        //main function to initiate the module
        init: function () {
           checkboxAll();
           deleteCategory();
           activeStatusCategory();
           fastEdit();
           deleteCategoryMulti();
           enableDelete();
           checkCharacterEdit();
           copyCategory();
           handleCopyCategory();
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