var FormNews = function () {

    var initComponents = function () {
        //init maxlength handler
        $('.maxlength-handler').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            threshold: 5
        });
    }
    var handleDatetimePicker = function () {
        $(".form_datetime").datetimepicker({
            autoclose: true,
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
    }
    var checkboxParent = function(){
        $('.cat_check').on('click', function (ev) {
            if ($(this).is(':checked')) {
                // check all children
                // check inputs on the way up
                $(this).parents('li').each(function(i, el){
                    $(el).children('input').prop('checked', true);
                });
            }    
        });
    }
    var handleValidationNews = function() {
        var form_news = $('#form_news');
        var error1 = $('.alert-danger', form_news);
        var success1 = $('.alert-success', form_news);
        $('.continue').click(function(){
            var con = $(this).attr('data-continue');
            $('input[name="continue"]').val(con);
        });
        form_news.validate({
            errorElement: 'div', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {
                title: {
                    required: $('input[name="title"]').attr('data-error'),
                },
            },
            rules: {
                title: {
                    minlength: 3,
                    required: true
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
    }

    var relatedNews = function()
    {
        $('#news_left li').live('click', function(){
            var $this = $(this);
            var id = $this.attr('data-id');
            var new_li = '<li data-id="'+id+'">'+$this.html();            
                new_li += '<i class="cancel glyphicon glyphicon-trash font-red"></i>';
                new_li += '<input class="related_news" type="hidden" name="related_id[]" value="'+id+'"/>'
                new_li +='</li>';
            $('#news_right').prepend(new_li);
            $this.remove();
        });
        $('.cancel').live('click',function(){
            var li = $(this).parents('li');
            li.find('.related_news').remove();
            $(this).remove();
            var id = li.attr('data-id');
            var new_li = '<li data-id="'+id+'">';
                new_li += li.html();
                new_li += '</li>';
            $('#news_left').prepend(new_li);            
            li.remove();
        });
    }
    var searchRelatedNews = function(){
        $('.btn_search').click(function(){
             var key= new Array();
            $('#news_right').find('.related_video').each(function() {
                key.push($(this).val());            
            });
            var lang=$('#langsearch').val();
            $.ajax({
                url: 'news-ajaxnews-lang-'+lang,
                type: 'POST',
                data: {actionsearch:'searchRelatedNews','text' : $('#search').val(),key:key,'idsearch' : $('#idsearch').val()},
               // alert $data;
                success: function(response){
                    if(response == 'empty'){
                        $('#news_left').html("<center>Không tìm thấy kết quả nào.</center>");
                    }else{
                        $('#news_left').html(response);
                    }
                }
            });
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
    var loadRelatedNews = function () {
        $start=10; // 10 kết quả mặc định
        $('#more').live('click',function(){
            var lang=$('#langsearch').val();
            $.ajax({
                url: 'news-ajax-lang-'+lang,
                type: 'POST',
                dataType:'json',
                data:{start:$start,id:$('#idnews').val(), action:'loadMoreRelated'},
                success:function(data){
                    var li = '';
                    //console.log(data);
                    if (data == 'empty')
                    {
                        li += printNoData();
                        $('#news_left').append(li);                        
                    }else{
                        $.each(data['data'],function(id,v){
                            li += printRelatedMore(v.id,v.img,v.title);
                        });
                        $('#news_left').append(li);
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
    return {
        //main function to initiate the module
        init: function () {
            relatedNews();
            checkboxAll();
            initComponents();
            handleTagsInput();
            handleValidationNews();
            handleDatetimePicker();
            checkboxParent();
            searchRelatedNews();
            handleSelectCategory();
            loadRelatedNews();
        }
    };
}();