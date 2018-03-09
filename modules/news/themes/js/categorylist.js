var CategoryList = function () {

    var checkboxAll = function() {
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
            url: 'news-ajax-lang-'+lang,
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
            url: 'news-ajax-lang-'+lang,
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
            var $this = $(this);
             bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Sao chép danh mục này thì toàn bộ danh mục con được sao chép theo. Bạn chắc chắn sao chép ?</li>',
                title: "Sao chép danh mục",
                buttons: {
                    success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        forms = $('#form_categorylist');
                        forms.append('<input type="hidden" value="copyCategory" name="action">');
                        forms.submit();
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
                    url: 'news-categorylist-lang-'+lang,
                    type: 'POST',
                    data: {action:'ajaxCopyCategory',langData:langData,emptyData:emptyData},
                    success: function(response){
                       $('#copyCat').modal('hide');
                        if(response){
                            toastr.success('Sao chép thành công');
                        }else{
                            toastr.error('error');
                        }                    
                    }
                });
                return false;

        });
    }
    var deleteCategory = function(){
        $('.delete_category').click(function(){

            var $this = $(this);
            var lang = $this.parents('tr').attr('data-lang');
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
                            url: 'news-ajax-lang-'+lang, //dev2.webbnc.vn/news-ajax-lang-vi|en
                            type: 'POST',
                            data: {action:'deleteCategory',key:key},
                            success: function(data){
                                $this.parents('tr').remove();
                                //Chuyển string sang mảng dùng split
                                var data2 = data.split(",");
                                $.each(data2,function(k,v){
                                    $('#tr_'+v).remove();//xoá thẻ html theo id (vd id="tr_220") <tr id="tr_220"></tr>
                                });
                                //console.log(data);
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
            var $this = $(this);
             bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Xoá danh mục này toàn bộ danh mục con được xoá theo. Bạn chắc chắn xoá ?</li>',
                title: "Xoá danh mục",
                buttons: {
                    success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        forms = $('#form_categorylist');
                        forms.append('<input type="hidden" value="deleteMultiID" name="action">');
                        forms.submit();
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
    var activeHomeCategory = function(){
        $('.active_home').click(function(e,data){
            var $this = $(this);
            var homeCurren = $this.attr('data-home');
            var key = $this.parents('tr').attr('data-key');
            var lang = $this.parents('tr').attr('data-lang');
            if (homeCurren==1) {var is_home=0;}else{ var is_home=1; }
            $.ajax({
                url: 'news-ajax-lang-'+lang,
                type: 'POST',
                data: {action:'activeHomeCategory',key:key,is_home:is_home},
                success: function(data){
                    if (homeCurren==1) {
                        $this.removeClass('green-stripe');
                        $this.addClass('red-stripe');
                        $this.text('Đang ẩn');
                        $this.attr('data-home',0);
                    }else{
                        $this.removeClass('red-stripe');
                        $this.addClass('green-stripe');
                        $this.text('Đang hiện');
                        $this.attr('data-home',1);
                    }
                }
            });
        });
    }
    var checkCharacterEdit = function(){
        $('.editable-input input').live('keypress',function(){
            var val = $(this).val();
            var length = val.length;
            if (length < 255 ) {
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
    var checkTitleEditCopy = function(){
        $('.editable-input input').live('paste', function () {     
            var valTitle = $('.editable-input input').val();
            var title = valTitle.split(" ");
            $.each(title , function(key, val) { 
            if (val.length>10) {            
                    alert("Một từ của bạn không được nhập vào quá 10 ký tự");
                    return false;
                }else{
                    return true;
                }
            });
        });
    }
    return {
        //main function to initiate the module
        init: function () {
            //deleteCategorySelect();
            checkCharacterEdit();
            enableDelete();
            checkboxAll();
            deleteCategory();
            activeStatusCategory();
            activeHomeCategory();
            fastEdit();
            deleteMultiID();
            copyCategory();
            handleCopyCategory();
            checkTitleEditCopy();
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