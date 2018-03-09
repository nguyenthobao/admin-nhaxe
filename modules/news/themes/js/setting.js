var FormSetting = function () {

    var searchNewsVip = function(){
        $start=0; // 10 kết quả mặc định
        $('.btn_search_vip').live('click',function(){
            var lang=$('input[name="getLang"]').val();
            var id_cat = $('#chooseCatSearch').val();
            var titles = $('#news_vip input[name="search"]').val();

            $.ajax({
                url: 'news-ajax-lang-vi',
                type: 'POST',
                dataType:'json',
                data:{start:$start,id_cat:id_cat,titles:titles,action:'searchNewsVip'},
                success:function(data){
                    var li = '';
                    if (data['data']=='0') {
                        alert("Không tìm thấy bản ghi !");
                        $('.news_vip_left').empty();
                    }else{
                        $.each(data['data'],function(id,v){
                            li += printRelatedMore(v.id,v.img,v.title);
                        });
                        $('.news_vip_left').empty().append(li);
                        $start = $start+5;
                    }                                       
                }
            });
        });
    }
    var resetSetting = function(){
        $('.reset_setting').click(function(){
            var $this = $(this);
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Reset setting trang tin tức. Bạn có chắc chắn reset ?</li>',
                title: "Reset Setting",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        $.ajax({
                            url: 'news-ajaxnews-lang-'+lang, //dev2.webbnc.vn/news-ajax-lang-vi|en
                            type: 'POST',
                            data: {action:'resetSetting'},
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
    var searchNewsHot = function(){
        $start=0; // 10 kết quả mặc định
        $('.btn_search_hot').live('click',function(){
            var lang=$('input[name="getLang"]').val();
            var id_cat = $('#chooseCatSearch').val();
            var titles = $('#news_hot input[name="search"]').val();

            $.ajax({
                url: 'news-ajax-lang-vi',
                type: 'POST',
                dataType:'json',
                data:{start:$start,id_cat:id_cat,titles:titles,action:'searchNewsHot'},
                success:function(data){
                    var li = '';
                    if (data['data']=='0') {
                        alert("Không tìm thấy bản ghi !");
                        $('.news_hot_left').empty();
                    }else{
                        $.each(data['data'],function(id,v){
                            li += printRelatedMore(v.id,v.img,v.title);
                        });
                        $('.news_hot_left').empty().append(li);
                        $start = $start+5;
                    }                                       
                }
            });
        });
    }
    
    var saveNewsCat = function(){
        $('.saveSetting').live('click',function (){
            news_vip_id = ',';
            $("input[name='news_vip_id[]']").each(function() {
                news_vip_id += $(this).val()+',';
            });
            news_hot_id = ',';
            $("input[name='news_hot_id[]']").each(function() {
                news_hot_id += $(this).val()+',';
            });
            var news_lasted_qty_cat = $('input[name="news_lasted_qty_cat"]').val();
            $.ajax({
                url:'news-ajax-lang-vi',
                type:'POST',
                dataType:'json',
                data:{'action':'saveSettingNewsCat',news_vip_id:news_vip_id,news_hot_id:news_hot_id,news_lasted_qty_cat:news_lasted_qty_cat},
                success:function(respose){
                    window.location.reload(true);
                }
            });
        });
    }
    var saveNewsHome = function(){
        $('.saveSettingNewsHome').live('click',function (){
            var img_page_news = $('input[name="img_page_news"]').val();
            var icon_page_news = $('input[name="icon_page_news"]').val();
            var bg_page_news = $('input[name="bg_page_news"]').val();
            var meta_title = $('input[name="meta_title"]').val();
            var meta_keyword = $('input[name="meta_keyword"]').val();
            var meta_description = $('input[name="meta_description"]').val();
            $.ajax({
                url:'news-ajax-lang-vi',
                type:'POST',
                dataType:'json',
                data:{'action':'saveSettingNewsHome',img:img_page_news,icon:icon_page_news,bg:bg_page_news,meta_title:meta_title,meta_keyword:meta_keyword,meta_description:meta_description},
                success:function(respose){
                    console.log(respose);
                }
            });
        });
    }
    var printRelatedMore = function(id,image,title){
        return '<li data-id="'+id+'"><span><img src="'+image+'" alt="'+title+'"></span><a href="javascript:void()">'+title+'</a></li>';
    }
    var chooseNewsVip = function(){
        $('.news_vip_left li').live('click', function(){
            var $this = $(this);
            var id = $this.attr('data-id');
            var new_li = '<li data-id="'+id+'">'+$this.html();            
                new_li += '<i class="cancel-vip glyphicon glyphicon-trash font-red"></i>';
                new_li += '<input class="related_news_vip" type="hidden" name="news_vip_id[]" value="'+id+'"/>'
                new_li +='</li>';
            $('.news_vip_right').prepend(new_li);
            $this.remove();
        });
        $('.cancel-vip').live('click',function(){
            var li = $(this).parents('li');
            li.find('.related_news_vip').remove();
            $(this).remove();
            var id = li.attr('data-id');
            var new_li = '<li data-id="'+id+'">';
                new_li += li.html();
                new_li += '</li>';
            $('.news_vip_left').prepend(new_li);
            li.remove();
        });
    }
    var chooseNewsHot = function(){
        $('.news_hot_left li').live('click', function(){
            var $this = $(this);
            var id = $this.attr('data-id');
            var new_li = '<li data-id="'+id+'">'+$this.html();            
                new_li += '<i class="cancel-hot glyphicon glyphicon-trash font-red"></i>';
                new_li += '<input class="related_news_hot" type="hidden" name="news_hot_id[]" value="'+id+'"/>'
                new_li +='</li>';
            $('.news_hot_right').prepend(new_li);
            $this.remove();
        });
        $('.cancel-hot').live('click',function(){
            var li = $(this).parents('li');
            li.find('.related_news_hot').remove();
            $(this).remove();
            var id = li.attr('data-id');
            var new_li = '<li data-id="'+id+'">';
                new_li += li.html();
                new_li += '</li>';
            $('.news_hot_left').prepend(new_li);            
            li.remove();
        });
    }
    var handleTagsInput = function(){
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
    var delImg = function(){
        var lang = $(".view_lang").val();
        $('.del_img').click(function(){            
            var $this = $(this);
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Xóa ảnh đại diện trang tin tức. Bạn có chắc chắn reset ?</li>',
                title: "Xóa ảnh đại diện",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        $.ajax({
                            url: 'news-ajax-lang-'+lang, //dev2.webbnc.vn/news-ajax-lang-vi|en
                            type: 'POST',
                            data: {action:'delImgSetting'},
                            success: function(data){
                                console.log(data);
                                // window.location.reload(true);
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
    var delIcon = function(){
        var lang = $(".view_lang").val();
        $('.del_icon').click(function(){            
            var $this = $(this);
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Xóa biểu tượng trang tin tức. Bạn có chắc chắn reset ?</li>',
                title: "Xóa biểu tượng",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        $.ajax({
                            url: 'news-ajax-lang-'+lang, //dev2.webbnc.vn/news-ajax-lang-vi|en
                            type: 'POST',
                            data: {action:'delIconSetting'},
                            success: function(data){
                                console.log(data);
                                // window.location.reload(true);
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
    var delBg = function(){
        var lang = $(".view_lang").val();
        $('.del_bg').click(function(){            
            var $this = $(this);
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Xóa ảnh nền trang tin tức. Bạn có chắc chắn reset ?</li>',
                title: "Xóa ảnh nền",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        $.ajax({
                            url: 'news-ajax-lang-'+lang, //dev2.webbnc.vn/news-ajax-lang-vi|en
                            type: 'POST',
                            data: {action:'delBgSetting'},
                            success: function(data){
                                console.log(data);
                                // window.location.reload(true);
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
    return {
        //main function to initiate the module
        init: function () {
            searchNewsVip();
            searchNewsHot();
            chooseNewsVip();
            chooseNewsHot();
            saveNewsCat();
            saveNewsHome();
            handleTagsInput();
            resetSetting();
            delImg();
            delIcon();
            delBg();
        }
    };
}();