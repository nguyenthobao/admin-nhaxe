$( document ).ajaxStart(function() {
    Metronic.startPageLoading('Loadding....');
});

$( document ).ajaxStop(function() {
    Metronic.stopPageLoading();
});
var FormLoad = function () {
    var checkboxAll = function(){
        $('body').on('click','#list_category_select #checkboxAllSelect',function(){
            if($(this).prop("checked") == true){
                $('#list_category_select .checkboxes').each(function( index ) {
                    $(this).prop("checked", true);
                    $(this).parent().addClass('checked');
                });
            }
            else if($(this).prop("checked") == false){
                $('#list_category_select .checkboxes').each(function( index) {
                   $(this).prop("checked",false); 
                   $(this).parent().removeClass('checked');
                });
            }
             
        })
       
        $('body').on('click','#item-news #checkboxAll',function(){
            if($(this).prop("checked") == true){
                $('#item-news .checkboxes').each(function( index ) {
                    $(this).prop("checked", true);
                    $(this).parent().addClass('checked');
                });
            }
            else if($(this).prop("checked") == false){
                $('#item-news .checkboxes').each(function( index) {
                   $(this).prop("checked",false); 
                   $(this).parent().removeClass('checked');
                });
            }
        });
        
    }
    var getCategoryByBao  =function(){
        // $('#news_left li').click(function(){
            $.ajax({
                url: 'news-loadnews',
                type: 'POST',
                dataType:'json',
                data:{action:'tin247_com_cat'},
                success: function(data){
                    var html = '';
                    $.each(data,function(k,v){
                        html += '<li data-cat="'+v.cat_id+'"><label> - '+v.name+'</label></li>';
                    });
                    $('#list_category').html(html);
                }
            });
        // });
    }
    var getNewsByCat  =function(){
        $('#list_category li').live('click',function(){
            $('#list_category li').removeClass('active');
            var $this = $(this);
            if (!$this.hasClass('active')) {
                $this.addClass('active');
            }
            var cat = $(this).attr('data-cat');            
            $.ajax({
                url: 'news-loadnews',
                type: 'POST',
                dataType:'json',
                data:{action:'tin247_com_item',cat_id:cat},
                success: function(data){
                    // console.log(data);
                    var html = '<li class="row_check_all"><label><input id="checkboxAll" type="checkbox" value=""> Chọn tất cả </label></li>';
                    $.each(data,function(k,v){
                        html += '<li> <label><input class="checkboxes select_category" type="checkbox" data-cat="'+v.cat_id+'" name="cat_name['+v.id+']" value="'+v.id+'"> <a class="btn default btn-xs green tooltips view_news" data-original-title="Xem tin" > <i class="fa fa-eye"></i> </a> '+v.title+'</label></li>';
                    });
                    $('#item-news').html(html);
                     $('input:checkbox').uniform();
                }
            });
        });
    }
    var viewNews = function(){
        $('.view_news').live('click',function(){
            var gl=$(this).parents('li').find('input[type="checkbox"]');
            var cat_id=gl.attr('data-cat');
            var str=gl.attr('name');
            var re = /cat_name\[([0-9]+)\]/i; 
            var m;
            var id;
             
            if ((m = re.exec(str)) !== null) {
                if (m.index === re.lastIndex) {
                    re.lastIndex++;
                }
                id=m[1];
            }
             var dataString={
                'id':id,
                'action':'view_news'
            };
            $.ajax({
                type: 'POST', 
                url: 'news-viewnews',
                data:dataString,
                success: function(data){
                    bootbox.dialog({
                        message: data,
                        title: "Chi tiết tin tức",
                        buttons: {
                            danger: {
                                label: "Đóng",
                                className: "red",
                                callback: function() {
                                    return;
                                }
                            },
                        }
                    });
                }
            });
        });
    }
    var getCategory = function(){
        $('body').on('click','.postCat',function(){
            
            $.ajax({
                type: 'POST', 
                url: 'news-ajaxLoad',
                success: function(data){
                    bootbox.dialog({
                        message: data,
                        title: "Chọn danh mục tin tức",
                        buttons: {
                            success: {
                                label: "Đồng ý",
                                className: "green",
                                callback: function() {
                                    var cate_array=[];
                                    var item_array=[];
                                    var cat_id_array=[];
                                    var category_select=$('#list_category_select').find('input[type="checkbox"]:checked');
                                    var item_select=$('#item-news').find('input[type="checkbox"]:checked');
                                    $.each(category_select, function(index, val) {
                                         var self=$(this);
                                         cate_array.push(self.val().trim());
                                    });
                                    $.each(item_select, function(index, val) {
                                         var self=$(this);
                                         item_array.push(self.val().trim());
                                         cat_id_array.push(self.attr('data-cat'));
                                    });
                                    var dataStringCopy={
                                      'cate_array': cate_array, 
                                      'item_array': item_array, 
                                      'cat_id_array': cat_id_array, 
                                      'action':'copy_news'
                                    };
                                    $.ajax({
                                        url: 'news-viewnews',
                                        type: 'POST',
                                        dataType: 'JSON',
                                        data: dataStringCopy,
                                    })
                                    
                                    .success(function() {
                                        console.log("success");
                                    });
                                    
                                    //t = setTimeout(updateStatus(), 1000); 
                                    
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
                    $('input:checkbox').uniform();
                }
            });
        })
        
    }
    
   var updateStatus = function(){ 
          $.ajax({
              url: 'news-viewnews',
              type: 'POST',
              dataType: 'json',
              data: {'action': 'getProcess'},
          })
          .success(function(data) {
              console.log(data.process);
              if(data.process<100){
                  t = setTimeout(updateStatus(), 1000);
                  
              }
          });

}  
    
    return {
        //main function to initiate the module
        init: function () {
            checkboxAll();
            getCategory();
            getCategoryByBao();
            getNewsByCat();
            viewNews();
        }
    };
}();