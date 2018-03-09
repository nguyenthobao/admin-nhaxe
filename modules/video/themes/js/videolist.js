var VideoList = function () {

    var checkboxAll = function(){
         $('#checkboxAll').click(function() {
            if ($(this).prop("checked") == true) {
                $('.checkboxes').each(function(index) {
                    $(this).prop("checked", true);
                    $(this).parent().addClass('checked');
                });

                $(".btn-del a").removeClass('disabled');
                $(".copy_video a").removeClass('disabled');
            } else if ($(this).prop("checked") == false) {
                $('.checkboxes').each(function(index) {
                    $(this).prop("checked", false);
                    $(this).parent().removeClass('checked');
                });
                $(".btn-del a").addClass('disabled');
                $(".copy_video a").addClass('disabled');
            }
            if ($('.checkboxes:checked').length > 0) {
                $(".btn-del a").removeClass('disabled');
                $(".copy_video a").removeClass('disabled');
            } else {
                $(".btn-del a").addClass('disabled');
                $(".copy_video a").addClass('disabled');
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
                $(".copy_video a").removeClass('disabled');
            } else {
                $(".btn-del a").addClass('disabled');
                $(".copy_video a").addClass('disabled');
            }
        
        });
    }
    var copyVideo = function(){
       $('.copyCats').click(function(){
            var lang = $("#videolist").attr('data-lang');
            var $this = $(this);
            var key= new Array();
            $('#videolist tr').find('.delete_multi_video').each(function() {
                if($(this).is(':checked')) {
                    key.push($(this).val());
                }
            });
          
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Bạn chắc chắn copy những video đã chọn ?</li>',
                title: "Copy video",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        $.ajax({
                            url: 'video-ajaxvideo-lang-'+lang, //dev2.webbnc.vn/video-ajax-lang-vi|en
                            type: 'POST',
                            data: {action:'copyVideo',key:key},
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
    var fastEdit = function () {
        var lang = $("#videolist").attr('data-lang');
        
        $.fn.editable.defaults.mode = 'inline';
         //global settings 
        $.fn.editable.defaults.inputclass = 'form-control';
        
        $('.catItem').editable({
            url: 'video-ajaxvideo-lang-'+lang,
            type: 'text',
            name: 'editTitleVideo',
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
      //  $(.editable-input input)
        
        $('.orderItem').editable({
            url: 'video-ajaxvideo-lang-'+lang,
            type: 'text',
            name: 'editSortVideo',
            source: source
        });
    }
    var deleteVideo = function(){
        $('.delete_video').click(function(){
            var lang = $("#videolist").attr('data-lang');
            var $this = $(this);
            var key = $this.parents('tr').attr('data-key');
           
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Bạn chắc chắn xoá ?</li>',
                title: "Xoá Video",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        $.ajax({
                            url: 'video-ajaxvideo-lang-'+lang, //dev2.webbnc.vn/video-ajax-lang-vi|en
                            type: 'POST',
                            data: {action:'deleteVideo',key:key},
                            success: function(data){
                                $this.parents('tr').remove();
                                //Chuyển string sang mảng dùng split
                                
                                var data2 = data.split(",");
                               //document.write(data);
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
    var refeshVideo = function(){
        $('.refesh_video').click(function(){
            var lang = $("#videolist").attr('data-lang');
            var $this = $(this);
            var key = $this.parents('tr').attr('data-key');
           
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Bạn chắc chắn làm mới video này</li>',
                title: "Làm mới",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        $.ajax({
                            url: 'video-ajaxvideo-lang-'+lang, //dev2.webbnc.vn/video-ajax-lang-vi|en
                            type: 'POST',
                            data: {action:'refeshVideo',key:key},
                            success: function(data){
                                window.location.reload(true);
                            }
                        });
                    }
                  },
                  danger: {
                    label: "Huỷ",
                    className: "blue",
                    callback: function() {
                      return;
                    }
                  }
                }
            });
        });
    }


     var deleteMulti = function(){
        $('.delete_video_select').click(function(){
            var lang = $("#videolist").attr('data-lang');
            var $this = $(this);
            var key= new Array();
            $('#videolist tr').find('.delete_multi_video').each(function() {
                if($(this).is(':checked')) {
                    key.push($(this).val());
                }
            });
          
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Bạn chắc chắn xoá những video đã chọn ?</li>',
                title: "Xoá Video",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        $.ajax({
                            url: 'video-ajaxvideo-lang-'+lang, //dev2.webbnc.vn/video-ajax-lang-vi|en
                            type: 'POST',
                            data: {action:'deleteMulti',key:key},
                            success: function(data){

                               // $this.parents('tr').remove();
                                //Chuyển string sang mảng dùng split
                                var data2 = data.split(",");
                                
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
    var activeStatusVideo = function(){
        $('.active_status').click(function(e,data){
            var $this = $(this);
            var statusCurren = $this.attr('data-status');
            var key = $this.parents('tr').attr('data-key');
            var lang = $this.parents('tr').attr('data-lang');
            if (statusCurren==1) {var status=0;}else{ var status=1; }
            $.ajax({
                url: 'video-ajaxvideo-lang-'+lang,
                type: 'POST',
                data: {action:'activeStatusVideo',key:key,status:status},
                
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
            //alert($url);
        });
    }
     var activeVipVideo = function(){
        $('.active_vip').click(function(e,data){
            var $this = $(this);
            var statusCurren = $this.attr('data-vip');
            var key = $this.parents('tr').attr('data-key');
            var lang = $this.parents('tr').attr('data-lang');
            if (statusCurren==1) {var vip=0;}else{ var vip=1; }
            $.ajax({
                url: 'video-ajaxvideo-lang-'+lang,
                type: 'POST',
                data: {action:'activeVipVideo',key:key,vip:vip},
                
                success: function(data){
                    if (statusCurren==1) {
                        $this.removeClass('yellow-stripe');
                        $this.addClass('green-stripe');
                        $this.text('Thường');
                        $this.attr('data-vip',0);            
                    }else{
                        $this.removeClass('green-stripe');
                        $this.addClass('yellow-stripe');
                        $this.text('Vip');
                        $this.attr('data-vip',1);
                        
                    }
                }
            });
            //alert($url);
        });
    }
    var activeHotVideo = function(){
        $('.active_hot').click(function(e,data){
            var $this = $(this);
            var statusCurren = $this.attr('data-hot');
            var key = $this.parents('tr').attr('data-key');
            var lang = $this.parents('tr').attr('data-lang');
            if (statusCurren==1) {var hot=0;}else{ var hot=1; }
            $.ajax({
                url: 'video-ajaxvideo-lang-'+lang,
                type: 'POST',
                data: {action:'activeHotVideo',key:key,hot:hot},
                
                success: function(data){
                    if (statusCurren==1) {
                       
                        $this.removeClass('yellow-stripe');
                        $this.addClass('green-stripe');
                        $this.text('Thường');
                        $this.attr('data-hot',0);
                    }else{
                        $this.removeClass('green-stripe');
                        $this.addClass('yellow-stripe');
                        $this.text('Nổi bật');
                        $this.attr('data-hot',1);
                    }
                }
            });
            //alert($url);
        });
    }
   
     var activePostVideo = function(){
        $('.active_post').click(function(e,data){
            var $this = $(this);
            var statusCurren = $this.attr('data-status');
            var key = $this.parents('tr').attr('data-key');
            var lang = $this.parents('tr').attr('data-lang');
            if (statusCurren==1) {var status=0;}else{ var status=1; }
            $.ajax({
                url: 'video-ajaxvideo-lang-'+lang,
                type: 'POST',
                data: {action:'activePostVideo',key:key,status:status},
                
                success: function(data){
                   window.location.reload(true);
                }
            });
            //alert($url);
        });
    }
      var searchVideo = function(){
        $("#bnt_search").live('click',function() {          
            $('input[name="action"]').val("searchVideo");
            $('#form_videolist').submit();
        });
    }
    var editImgVideo = function () {
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
    var saveImgVideo = function(){
        $(".btn-save").live('click',function() {
            var $this = $(this).parents('tr');
            $this.remove('input[name="id_img"]');
            $this.append('<input type="hidden" name="id_img" value="'+$this.attr('data-key')+'" />');
            $('input[name="action"]').val("saveImgFast");
            $('#form_videolist').submit();
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
    var handleCopyVideo=function(){
         $('body').on('click', '.copyCatsLang', function(event) {
            event.preventDefault();
            $('#copyCat').modal('show');
        });
        $("#formCopy").submit(function(e) {
                var langData = $('select[name=langData]').val();
                var emptyData = $('input[name=emptyData]:checked').val();
                if(emptyData == null){
                    emptyData=0;
                }
                $.ajax({
                    url: 'video-videolist-lang-'+lang,
                    type: 'POST',
                    data: {action:'ajaxCopyVideo',langData:langData,emptyData:emptyData},
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
    return {
        //main function to initiate the module
        init: function () {
           checkboxAll();
           deleteVideo();
           activeStatusVideo();
           fastEdit();
           deleteMulti();
           refeshVideo();
           activePostVideo();
           searchVideo();
           editImgVideo();
           saveImgVideo();
           checkCharacterEdit();
           enableDelete();
           activeVipVideo();
           activeHotVideo();
           copyVideo();
           handleCopyVideo();
           // handle editable elements on hidden event fired
            $('#videolist .editable').on('hidden', function (e, reason) {
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