var Video = function () {
    var initComponents = function () {
        //init maxlength handler
        $('.maxlength-handler').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            threshold: 5
        });
        $('#title').focus();
    }
     var handleDatetimePicker = function () {
        $(".form_datetime").datetimepicker({
            autoclose: true,
            startDate: '-0d',
            isRTL: Metronic.isRTL(),
            format: "dd/mm/yyyy hh:ii",
            pickerPosition: (Metronic.isRTL() ? "bottom-right" : "bottom-left")
        });
      
    }
    
     var checkboxAll = function(){

        $('#checkboxAll').click(function(){
            if($(this).prop("checked") == true){
                $('.checkboxes').each(function( index ) {
                    $(this).prop("checked", true);
                    $(this).parent().addClass('checked');
                });                
            }
            else if($(this).prop("checked") == false){
                $('.checkboxes').each(function( index) {
                   $(this).prop("checked",false); 
                   $(this).parent().removeClass('checked');
                });
            }
        });
        $('.checkboxes').click(function() {
            if ($(this).prop("checked") == false) {
                $('#checkboxAll').prop("checked", false);
                $('#checkboxAll').parent().removeClass('checked');
            }
        });
    }
   var relatedVideo = function()
    {
        $('#video_left li').live('click', function(){

            var $this = $(this);
            var id = $this.attr('data-id');
            var video_li = '<li data-id="'+id+'">'+$this.html();            
                video_li += '<i class="cancel glyphicon glyphicon-trash font-red"></i>';
                video_li += '<input class="related_video" type="hidden" name="related_id[]" value="'+id+'"/>'
                video_li +='</li>';
            $('#video_right').prepend(video_li);
            $this.remove();
        });
        $('.cancel').live('click',function(){
            var li = $(this).parents('li');
            li.find('.related_video').remove();
            $(this).remove();
            var id = li.attr('data-id');
            var video_li = '<li data-id="'+id+'">';
                video_li += li.html();
                video_li += '</li>';
            $('#video_left').prepend(video_li);            
            li.remove();
        });
    }
    var loadRelatedVideo = function () {
        $start=10; // 10 kết quả mặc định
        $('#more').live('click',function(){
            var lang=$('#langsearch').val();
            $.ajax({
                url: 'video-ajaxvideo-lang-'+lang,
                type: 'POST',
                dataType:'json',
                data:{start:$start,id:$('#idvideo').val(), action:'loadMoreRelated'},
                success:function(data){
                    var li = '';
                    //console.log(data);
                   if (data['data'] == 0) {
                        alert("Đã tải hết dữ liệu !!!");
                    }else{
                        $.each(data['data'],function(id,v){
                            li += printRelatedMore(v.id,v.img,v.title);
                        });
                        $('#video_left').append(li);
                        $start = $start+5; 
                    }
                }
            });
        });
    }
    var printRelatedMore = function(id,image,title){
        return '<li data-id="'+id+'"><span><img src="'+image+'" alt="'+title+'"></span><a href="javascript:void()">'+title+'</a></li>';
    }
    var printNoData = function(){
        return '<li><span>Dữ liệu đã được Load hết .</span></li>';
    }
    var handleValidationVideo = function() {
            var form_category = $('#form_category');
            var error1 = $('.alert-danger', form_category);
            var success1 = $('.alert-success', form_category);
            
            $('.continue').click(function(){
                var str= $('input[name="link_video"]').val();
                var con = $(this).attr('data-continue');
                $('input[name="continue"]').val(con);
            });

            form_category.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                messages: {
                    title: {
                        required: $('input[name="title"]').attr('data-error'),
                    },
                    link_video: {
                        required: $('input[name="link_video"]').attr('data-error'),
                    },
                },
                rules: {
                    title: {
                        required: true
                    },
                    
                    cat_id: {
                        required: true
                    },
                    link_video: {
                        minlength: 5,
                        required: true,
                        url: true
                    },
                   'cat_name[]': {
                        required: true,
                    },

                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success1.hide();
                    error1.show();
                    Metronic.scrollTo(error1, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group

                },

                submitHandler: function (form) {
                    form.submit();
                    error1.hide();
                }
            });
    }
    var popuphuongdan = function(){
        $('.linkyou').click(function(){
           var html= '<div class="form-horizontal widthauto">'+
           '<img src="http://' + window.location.hostname + '/modules/video/themes/images/click.jpg" width="570px" />'+
             '</div>';
            bootbox.dialog({
                message: html,
                title: "Hướng dẫn nhập link video ",
                buttons: {
                  danger: {
                    label: "Đóng",
                    className: "red",
                    callback: function() {
                      return;
                    }
                  }
                }
            });
        });
    }

    var handleTagsInput = function () {
        if (!jQuery().tagsInput) {
            return;
        }
        $('input[name="meta_keyword"]').tagsInput({
            width: 'auto',
            'onAddTag': function () {
                //alert(1);
            },
        });
        $('input[name="tags"]').tagsInput({
            width: 'auto',
            'onAddTag': function () {
                //alert(1);
            },
        });
    }
    var handleSelectCategory = function () {
        $('.select_category').click(function() {
            var id = $(this).val().trim();
            var str_id = $(this).attr('data-id');
            if($(this).is(':checked') == true){
                $('#list_category').find('.select_category').each(function() {
                    var id2 = $(this).val().trim();
                    if(str_id.indexOf('|' + id2 + '|') != -1 && id != id2) {
                        $(this).attr('checked', true);
                        $(this).parent().addClass('checked');
                    }
                });
            }else{
                var flag = true;
                var index = $('#list_category li').index($(this).parents('li'));
                $('#list_category li:gt('+index+')').find('.select_category').each(function() {
                    var str_id2 = $(this).attr('data-id');
                    if(str_id2.indexOf('|' + id + '|') != -1 && $(this).is(':checked') == true) {
                        flag = false;
                    }
                });
                if(flag == false) {
                    $(this).attr('checked', true);
                    $(this).parent().addClass('checked');
                }
            }
        });
    }
    



    var searchVideoLQ=function(){
        $('.btn_search').click(function(){
             var key= new Array();
            $('#video_right').find('.related_video').each(function() {
                    key.push($(this).val());
            
            });
            $('#more').remove();
           var lang=$('#langsearch').val();
            $.ajax({
                url: 'video-ajaxvideo-lang-'+lang,
                type: 'POST',
                data: {actionsearch:'searchVideoLQ','text' : $('#search').val(),key:key,'idsearch' : $('#idsearch').val()},
               // alert $data;
                success: function(response){
                    if(response == 'empty'){
                        $('#video_left').html("<center>Không tìm thấy kết quả nào.</center>");
                    }else{
                        $('#video_left').html(response);
                    }
                }
            });
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            initComponents();
            //checkurlvideo();
            handleTagsInput();
            handleValidationVideo();
            checkboxAll();
            handleDatetimePicker();
            relatedVideo();
            popuphuongdan();
            handleSelectCategory();
            searchVideoLQ();
            loadRelatedVideo();
        }
    };

}();