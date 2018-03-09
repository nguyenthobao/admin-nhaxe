var home = function(e) {
	var	ajaxCallback = function(e,a) {
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
				$.post(e["url"], { id: $this.attr( "data-id" ), album_id: $this.attr( "album-id" ), name: 'avatar-update' }, function( data ) {
					if(data.success){
						$('.ajax-file-upload-del').css("top", "");
						$('.ajax-file-upload-statusbar').css("border-color", "");
						$this.parents().css("border-color", "#0DA3E2");
						$this.prev().css("top", "-100px");
						$('#' + a).attr("src", data.path);
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
 var initModals = function (a) {
 	$('.choose-avatar').on('click', function(){
 		var $key = $(this).attr('data-id');
 		var $title = $(this).attr('data-title');
 		var $avatar_id = $(this).attr('data-avatar');
 		var settings = {
 			url: a["urlUpload"],
 			method: "POST",
 			allowedTypes:"jpg,jpeg,png,gif",
 			fileName: "Lfile",
 			formData:{album_id: $key},
 			multiple: true,
 			showDelete: true,
 			dragDropStr: '<span><b>'+a["dragDropStr"]+'</b></span>',
 			chooseStr: a["chooseStr"],
 			abortStr: a["abortStr"],
 			deletelStr: a["delete"],
 			loadingStr: a["loadingStr"],
 			placeholderTextStr: a["placeholderTextStr"],
 			placeholderTextAreaStr: a["placeholderTextAreaStr"],
 			onSuccess:function(files,data,xhr)
 			{$('.modal-body').scrollTop( $('.photo-list').height() )},
 			onError: function(files,status,errMsg)
 			{       
 				alert(a["error_just_not_idea"]);
 			},
 			deleteCallback: function (e) {
 				var obj = $.parseJSON(e);
 				bootbox.dialog({
 					message : '<li class="list-group-item list-group-item-warning">'+a["do_you_really_want_to_delete_pic"]+'</li>',
 					title : a["alert"],
 					buttons : {
 						success : {
 							label : a["ok"],
 							className : "green",
 							callback : function() {
 								$.post(a["url"], { id: obj.id, name: 'pic-delete' }, function( data ) {
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
 							label : a["cancel"],
 							className : "red",
 							callback : function() {
 								return;
 							}
 						}
 					}
 				});
 			},
 			inputCallback: function (e,val) {
 				var obj = $.parseJSON(e);
 				$.post(a["url"], { id: obj.id, title: val, name: 'pic-update' }, function( data ) {
 					if(data.error){
 						alert(data.error);
 					}
 				}, "json");
 				
 			},
 			textareaCallback: function (e,val) {
 				var obj = $.parseJSON(e);
 				$.post(a["url"], { id: obj.id, description: val, name: 'pic-update' }, function( data ) {
 					if(data.error){
 						alert(data.error);
 					}
 				}, "json");
 			},
 			chooseCallback: function (e) {
 				var $this = $(this);
 				var obj = $.parseJSON(e);
 				$.post(a["url"], { id: obj.id, album_id: $key, name: 'avatar-update' }, function( data ) {
 					if(data.success){
 						$('.ajax-file-upload-del').css("top", "");
 						$('.ajax-file-upload-statusbar').css("border-color", "");
 						$this.parents().css("border-color", "#0DA3E2");
 						$this.prev().css("top", "-100px");
 						$('#' + $avatar_id).attr("src", data.path);
 					}
 					if(data.error){
 						alert(data.error);
 					}
 				}, "json");
 				
 			}
 		}
 		$.ajax({
 			url : a["url"],
 			type : 'POST',
 			dataType: "json",
 			data : {
 				name : 'albumAvatarManager',
 				key : $key
 			},
 			success : function(data) {
 				if(data.success){
			//
			bootbox.dialog({
				message : data.html,
				title : data.title + ' - ' + data.titleAlbum,
				buttons : {
					success : {
						label : a["save"],
						className : "green",
						callback : function() {
							return;
						}
					}
				}
			});
			//
			$("#albumImagesUpload").uploadFile(settings);
			$('.ajax-file-upload').css("padding", "6px 10px 4px 10px");
			$('.modal-dialog').css("width", "800px");
			$('.modal-body').slimScroll({
				height: '400px'
			});
			ajaxCallback(a,$avatar_id);
		//
			//
		}
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
	});

 	});

}

var quickEdit = function () {
	var lang = $("#categoryList").attr('data-lang');
	$.fn.editable.defaults.mode = 'inline';
	$.fn.editable.defaults.inputclass = 'form-control';
	$('.ajaxItem').editable({
		type: 'text',
		name : 'editAlbumName',
		url: 'album-ajax-lang-' + lang,
		ajaxOptions: {
			dataType: 'json'
		},
		success: function(response) {
			if(response.msg)
				return response.msg;
		}        
	});
	
	var string = '';
	for (var i = 0;i<50;i++) {
		string +="{value: "+i+", text: '"+i+"'},";
	}

	source = '['+string+']';
	
	$.fn.editable.defaults.mode = '';
	$.fn.editable.defaults.inputclass = '';
	
	$('.sortItem').editable({
		url: 'album-ajax-lang-' + lang,
		type: 'text',
		name: 'editAlbumOrder',
		source: source
	});
	/*
	$.fn.editable.defaults.mode = '';
	$.fn.editable.defaults.inputclass = 'form-control-order-input';
	$('.sortItem').editable({
		url : 'album-ajax-lang-' + lang,
		type : 'text',
		name : 'editAlbumOrder',
		title: false,
		ajaxOptions: {
        dataType: 'json'
	    },
	    success: function(response) {
	    	if(response.msg)
	        return response.msg;
	    } 
	});
*/
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

var deleteItem = function(e) {
	$('.delete_category').click(function() {

		var $this = $(this);

		var key = $this.parents('tr').attr('data-key');
		var lang = $this.parents('tr').attr('data-lang');
		bootbox.dialog({
			message : '<li class="list-group-item list-group-item-warning">'+e["do_you_really_want_to_delete"]+'</li>',
			title : e["alert"],
			buttons : {
				success : {
					label : e["ok"],
					className : "green",
					callback : function() {
						$.ajax({
							url : 'album-ajax-lang-' + lang,
							type : 'POST',
							dataType: "json",
							data : {
								name : 'deleteAlbumItem',
								key : key
							},
							success : function(data) {
								if(data.success){
									$this.parents('tr').fadeOut(500, function(){
										$(this).remove();
									});
									//Chuyển string sang mảng dùng split
									if(data_id){
										var data_id = data.ids.split(",");
										$.each(data_id, function(k, v) {
											$('#tr_' + v).fadeOut(500, function(){
												$(this).remove();
											});
										});
									}
								}
								var n = $( "#categoryList tr" ).length;
								if(n==2){
									window.location.href = location.href
								}
							}
						});
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
});
}
var deleteMultiID = function(a) {

	$('.delete_album_select').click(function(e) {
		var con = $(this).attr('data-continue');
		$('input[name="action"]').val(con);
		bootbox.dialog({
			message : $('#deleteAllDialog').html(),
			title : a["alert"],
			buttons : {
				success : {
					label : a["ok"],
					className : "green",
					callback : function() {
							//submit form khi nút submit không phải là button hoặc <input type="submit">
							$('#formList').submit();
						}
					},
					danger : {
						label : a["cancel"],
						className : "red",
						callback : function() {
							return;
						}
					}
				}
			});

	});
}
var editStatus = function(a) {
	$('.active_status').click(function(e, data) {
		var $this = $(this);
		var statusCurren = $this.attr('data-status');
		var key = $this.parents('tr').attr('data-key');
		var lang = $this.parents('tr').attr('data-lang');
		if(statusCurren==2){
			var status = 2;
			bootbox.dialog({
				message : '<li class="list-group-item list-group-item-warning">' + a["time_post"] + '</li>',
				title : a["alert"],
				buttons : {
					success : {
						label : a["ok"],
						className : "green",
						callback : function() {
							//
							$.ajax({
								url : 'album-ajax-lang-' + lang,
								type : 'POST',
								data : {
									name : 'editAlbumStatus',
									key : key,
									status : status
								},
								dataType: "json",
								success : function(data) {
									if(data.msg){
										bootbox.dialog({
											message : '<li class="list-group-item list-group-item-warning">'+data.msg+'</li>',
											title : "&iexcl;"
										});
									}
									if(data.success){
										if (statusCurren == 1) {
											$this.removeClass('green-stripe');
											$this.addClass('red-stripe');
											$this.text(a["hiding"]);
											$this.attr('data-status', 0);
										} else {
											$this.removeClass('yellow-stripe');
											$this.addClass('green-stripe');
											$this.text(a["showing"]);
											$this.attr('data-status', 1);
										}
									}
									
								}
							});
						//
					}
				},
				danger : {
					label : a["cancel"],
					className : "red",
					callback : function() {
						return;
					}
				}
			}
		});
}else{
	if (statusCurren == 1) {
		var status = 0;
	} else {
		var status = 1;
	}
	$.ajax({
		url : 'album-ajax-lang-' + lang,
		type : 'POST',
		data : {
			name : 'editAlbumStatus',
			key : key,
			status : status
		},
		dataType: "json",
		success : function(data) {
			if(data.msg){
				bootbox.dialog({
					message : '<li class="list-group-item list-group-item-warning">'+data.msg+'</li>',
					title : "&iexcl;"
				});
			}
			if(data.success){
				if (statusCurren == 1) {
					$this.removeClass('green-stripe');
					$this.addClass('red-stripe');
					$this.text(a["hiding"]);
					$this.attr('data-status', 0);
				} else {
					$this.removeClass('red-stripe');
					$this.addClass('green-stripe');
					$this.text(a["showing"]);
					$this.attr('data-status', 1);
				}
			}
			
		}
	});
			}//
		});
}

var common = function (a) {
	$('.form-filter').keydown(function(e) {
			if (e.keyCode == 13) {// mã của phím enter				
				$('input[name="action"]').val("search");
            $('#formList').submit();    //submit form có id là: "form"
        }
    });
	$("#bnt_search").live('click',function() {         
		$('input[name="action"]').val("search");
		$('#formList').submit();
	});
	$(".refesh_new").live('click',function() { 
		$this=$(this);
		$('input[name="f5id"]').remove();
		bootbox.dialog({
			message : '<li class="list-group-item list-group-item-warning">'+a["f5confirm"]+'</li>',
			title : a["alert"],
			buttons : {
				success : {
					label : a["ok"],
					className : "green",
					callback : function() {
						$('#formList').append('<input type="hidden" name="f5id" value="'+$this.attr('data-id')+'" />');
						$('input[name="action"]').val("refesh_new");
						$('#formList').submit();
					}
				},
				danger : {
					label : a["cancel"],
					className : "red",
					callback : function() {
						return;
					}
				}
			}
		});
		
	});
}

var handleCopyAlbum=function(){
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
                    url: 'album-home-lang-'+lang,
                    type: 'POST',
                    data: {action:'ajaxCopyAlbum',langData:langData,emptyData:emptyData},
                    success: function(response){
                       $('#copyCat').modal('hide');
                        if(response){
                            toastr.success(response);
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
		init : function(e) {
			enableDelete();
			checkboxAll();
			deleteItem(e);
			editStatus(e);
			quickEdit();
			deleteMultiID(e);
			common(e);
			initModals(e);
			handleCopyAlbum();
			// handle editable elements on hidden event fired
			$('#formList .editable').on('hidden', function(e, reason) {
				if (reason === 'save' || reason === 'nochange') {
					var $next = $(this).closest('tr').next().find('.editable');
					if ($('#autoopen').is(':checked')) {
						setTimeout(function() {
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