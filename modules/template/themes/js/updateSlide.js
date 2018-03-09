var updateSlide = function(e) {
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
	    $('.ajax-update-width').keyup(function(){
			var $this = $(this);
		    $.post(e["url"], { id: $this.attr( "data-id" ), width: $this.val(), name: 'pic-update' }, function( data ) {
			    if(data.error){
			    	alert(data.error);
			    }
		    }, "json");
	    });
	    $('.ajax-update-height').keyup(function(){
			var $this = $(this);
		    $.post(e["url"], { id: $this.attr( "data-id" ), height: $this.val(), name: 'pic-update' }, function( data ) {
			    if(data.error){
			    	alert(data.error);
			    }
		    }, "json");
	    });
	    $('.ajax-update-link').keyup(function(){
			var $this = $(this);
		    $.post(e["url"], { id: $this.attr( "data-id" ), link: $this.val(), name: 'pic-update' }, function( data ) {
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
			var titles = $('input[name="title"]');
			$('.titles').removeClass('has-error');
			var err = 0;
			if(titles.val()==''){
			    $('.titles').addClass('has-error');
			    err=1;
			}
			if(err) {showError(); return false;}
		});
	}
	var showError = function() {
		var form_slide = $('#form_slide');
		var error1 = $('.alert-danger', form_slide);
		var success1 = $('.alert-success', form_slide);
		success1.hide();
		error1.show();
		Metronic.scrollTo(error1, -200);
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
	}
	return {
		//main function to initiate the module
		init : function(e) {
			validation();
			handleTagsInput();
			ajaxCallback(e);
		}
	};
}();