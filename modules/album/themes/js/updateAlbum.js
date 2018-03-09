var updateAlbum = function(e) {
var	ajaxCallback = function(e) {
	$(".ajax-link").click(function() {
    var $this = $(this);
    if($this.attr( "data-type" )=='delete'){
    bootbox.dialog({
                message : '<li class="list-group-item list-group-item-warning">'+e["do_you_really_want_to_delete_pic"]+'</li>',
                title : e["alert"],
                buttons : {
                    success : {
                        label : e["ok"],
                        className : "green",
                        callback : function() {
                        $.post(e["url"], { id: $this.attr( "data-id" ), name: 'pic-delete' }, function( data ) {
                        if(data.success){
                            $this.parent().fadeOut(500, function(){
                            $(this).remove();
                        });
                        }
                        if(data.error){
                        alert(data.error);
                        }
                        }, "json");
                        }
                    },
                    danger : {
                        label : e["cancel"],
                        className : "red",
                        callback : function() {
                            return;
                        }
                    }
                }
            });
    }
    if($this.attr( "data-type" )=='choose-avatar'){
    $.post(e["url"], { id: $this.attr( "data-id" ), album_id: e["album_id"], name: 'avatar-update' }, function( data ) {
    if(data.success){
    $('.ajax-file-upload-del').css("top", "");
    $('.ajax-file-upload-statusbar').css("border-color", "");
    $this.parents().css("border-color", "#0DA3E2");
    $this.prev().css("top", "-100px");
    $('input[name="avatar_id"]').val(data.id);
    $('input[name="avatar"]').val(data.path_none_domain);
    }
    if(data.error){
    alert(data.error);
    }
    }, "json");
    }
 	});
 	//
	$('.ajax-update-title').keyup(function(){
	var $this = $(this);
    $.post(e["url"], { id: $this.attr( "data-id" ), title: $this.val(), name: 'pic-update' }, function( data ) {
    if(data.error){
    alert(data.error);
    }
    }, "json");
    });
	$('.ajax-update-description').keyup(function(){
	var $this = $(this);
    $.post(e["url"], { id: $this.attr( "data-id" ), description: $this.val(), name: 'pic-update' }, function( data ) {
    if(data.error){
    alert(data.error);
    }
    }, "json");
    });
    
	}
var validation = function() {
	$('.continue').click(function() {
	var con = $(this).attr('data-continue');
	$('input[name="continue"]').val(con);
	var param1 = $('input[name="title"]');
	var param2 = $('input[name="category_id[]"]:checked').length;
	var param3 = $('input[name="avatar_id"]');
	$('.none_avatar').hide();
	$('.param1, .param2, .param3').removeClass('has-error');
	var err = 0;
	if(param1.val()==''){
		    $('.param1').addClass('has-error');
		    err=1;
	}
	
	if(param2==0){
		    $('.param2').addClass('has-error');
		    err=1;
	}
	
	if(param3.val()==''){
			$('.none_avatar').show();
		    $('.param3').addClass('has-error');
		    err=1;
	}
	if(err) {showError(); return false;}
			
});
}
var showError = function() {
	var form_album = $('#form_album');
	var error1 = $('.alert-danger', form_album);
	var success1 = $('.alert-success', form_album);
	success1.hide();
	error1.show();
	Metronic.scrollTo(error1, -200);
}
var maxId = function(selector) {
    var min=null, max=null;
    $(selector).each(function() {
        var id = parseInt(this.id, 10);
        if (isNaN(id)) { return; }
        if ((min===null) || (id < min)) { min = id; }
        if ((max===null) || (id > max)) { max = id; }
    });
    return max
}
var getId = function() {
	var res=[];
    $( "#news_right li" ).each(function() {
	res.push($(this).attr('data-id'));
	});
	return res;
}
var	synchronizeChildAndParentCategory = function () {
	$('.chil').click(function(){
	    if($(this).is(':checked')){
	        $(this).parents('li').children().children().children().children('input[type=checkbox]').prop('checked', true);
	        $(this).parents('li').children().children().children().addClass('checked');
	    } else {
	        $(this).parent().parent().parent().parent().find('li input[type=checkbox]').prop('checked', false);
	        $(this).parent().parent().parent().parent().find('span').removeClass('checked');
	    }
	
	});
}
var initComponents = function(a) {
	$( "#reset" ).live('click', function(){
	$('#news_left').html('');
	$('input[name="search"]').val('');
	$( "#more" ).trigger( "click" );
	});
	$('input[name="title"]').keyup(function(){
    if($(this).val().length > 2)
    $('.param1').removeClass('has-error');
	});
	$('.checkboxes, #checkboxAll').click(function(){
		$('.param2').removeClass('has-error');
	});
	
		$('#search').keydown(function(i) {
		if (i.keyCode == 13) {// mã của phím enter				
		   	return false;
		   }
		});
		
		//init maxlength handler
		$('.maxlength-handler').maxlength({
			limitReachedClass : "label label-danger",
			alwaysShow : true,
			threshold : 5
		});
		$('input[name="order_by"]').numericOnly();
		$(".form_datetime").datetimepicker({
            autoclose: true,
            startDate: '-0d',
            isRTL: Metronic.isRTL(),
            format: "yyyy-mm-dd hh:ii",
            pickerPosition: (Metronic.isRTL() ? "bottom-right" : "bottom-left")
        });  
        //
        $("#sortB_").sortable({ opacity: 0.6, cursor: 'move', update: function(e) {
            var order = $(this).sortable( "serialize", {attribute: "data-item"})+'&name=imgOrder';
            $.post(a['url'], order, function( data ) {
            if(data.error){
            alert(data.error);
            }
            }, "json");                                        
        }                                 
        });
	}
var checkboxAll = function() {
		$('#checkboxAll').click(function() {
			if ($(this).prop("checked") == true) {
				$('.checkboxes').each(function(index) {
					$(this).prop("checked", true);
					$(this).parent().addClass('checked');
				});
			} else if ($(this).prop("checked") == false) {
				$('.checkboxes').each(function(index) {
					$(this).prop("checked", false);
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

var handleTagsInput = function() {
		if (!jQuery().tagsInput) {
			return;
		}
		$('input[name="meta_keywords"]').tagsInput({
			width : 'auto',
			'onAddTag' : function() {
				//alert(1);
			},
		});
		$('input[name="tags"]').tagsInput({
			width : 'auto',
			'onAddTag' : function() {
				//alert(1);
			},
		});
	}
var related = function()
    {
        $('#news_left li').live('click', function(){
            var $this = $(this);
            var id = $this.attr('data-id');
            var new_li = '<li data-id="'+id+'" class="l'+id+'">'+$this.html();            
                new_li += '<i class="cancel glyphicon glyphicon-trash font-red"></i>';
                new_li += '<input class="related_news" type="hidden" name="related_id[]" value="'+id+'"/>'
                new_li +='</li>';
            $('#news_right').find(".l"+id).remove();
            $('#news_right').prepend(new_li);
            $this.remove();
        });
        $('.cancel').live('click',function(){
            var li = $(this).parents('li');
            li.find('.related_news').remove();
            $(this).remove();
            var id = li.attr('data-id');
            var new_li = '<li data-id="'+id+'" class="l'+id+'">';
                new_li += li.html();
                new_li += '</li>';
            $('#news_left').find(".l"+id).remove();
            $('#news_left').prepend(new_li);            
            li.remove();
        });
    }
var loadRelated = function () {
        $('#more').live('click',function(){
        	$this=$(this);
        	var ID=maxId('#news_left li');//$("#news_left li:last").attr("data-id");
        	if($('#reset').attr('id')=='reset') {
        		ID = 0;
        		$('#reset').remove();
        		}
            var lang=$('#langsearch').val();
            $this.hide();
            $.ajax({
                url: 'album-ajax-lang-'+lang,
                type: 'POST',
                dataType:'json',
                data:{id:ID, not_in: getId(), name:'loadMoreRelated'},
                success:function(data){
                    var li = '';
                    $.each(data['data'],function(id,v){
                        li += printRelatedMore(v.id,v.avatar,v.title);
                    });
                    $('#news_left').append(li);    
                    if(data.num < 10){
                    $this.hide();	
                    }else{
                    $this.show();
                    }           
                }
            });
        });
    }
var searchRelated = function(e){
        //$('.btn_search').click(function(){
        $('#search').keyup(function(){
        	if($(this).val()!=''){
        	var $this = $(this);
            var ID = $this.attr('data-id');
            var lang=$('#langsearch').val();
            $.ajax({
                url: 'album-ajax-lang-'+lang,
                type: 'POST',
                dataType:'json',
                data:{search: $(this).val(), id: ID, not_in: getId(), name: 'searchRelated'},
                success:function(data){
                    var li = '';
                    if(data['data']){
                    $.each(data['data'],function(id,v){
                        li += printRelatedMore(v.id,v.avatar,v.title);
                    });
                    $('#news_left').html(li);
                    $('#more').hide();
                    $('#news_left').append('<div id="reset">'+e['reset']+'</div>');
                    }else{
                    $('#news_left').html('<center>'+data.empty+'</center>');
                    $('#news_left').append('<div id="reset">'+e['reset']+'</div>');
                    }
                                       
                }
            });
            }
        });
    }
var printRelatedMore = function(id,image,title){
        return '<li data-id="'+id+'" class="l'+id+'"><span><img src="'+image+'" alt="'+title+'"></span><a href="javascript:;">'+title+'</a></li><li id="'+id+'" style="display: none"></li>';
    }
	return {
		//main function to initiate the module
		init : function(e) {
			searchRelated(e);
			related();
			loadRelated();
			initComponents(e);
			checkboxAll();
			validation();
			handleTagsInput();
			synchronizeChildAndParentCategory();
			ajaxCallback(e);
		}
	};
}(); ; 