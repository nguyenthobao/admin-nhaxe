var category = function(e) {
	
	var quickEdit = function () {
	var lang = $("#categoryList").attr('data-lang');
	$.fn.editable.defaults.mode = 'inline';
	$.fn.editable.defaults.inputclass = 'form-control';
	  $('.ajaxItem').editable({
	    type: 'text',
	    name : 'editCateName',
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
	
	}

	var checkboxAll = function() {

		$('#checkboxAll').click(function() {
			if ($(this).prop("checked") == true) {
				$('.checkboxes').each(function(index) {
					$(this).prop("checked", true);
					$(this).parent().addClass('checked');
				});

				$(".btn-del a").removeClass('disabled');
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
				message : $('#deleteItemDialog').html(),
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
									name : 'deleteCateItem',
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

		$('.delete_category_select').click(function() {
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
	var editCateStatus = function(a) {
		$('.active_status').click(function(e, data) {
			var $this = $(this);
			var statusCurren = $this.attr('data-status');
			var key = $this.parents('tr').attr('data-key');
			var lang = $this.parents('tr').attr('data-lang');
			if (statusCurren == 1) {
				var status = 0;
			} else {
				var status = 1;
			}
			$.ajax({
				url : 'album-ajax-lang-' + lang,
				type : 'POST',
				data : {
					name : 'editCateStatus',
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
						if(data.ids){
						//Chuyển string sang mảng dùng split
						var data_id = data.ids.split(",");
						$.each(data_id, function(k, v) {
							$('#tr_' + v).find('.active_status').removeClass('green-stripe');
							$('#tr_' + v).find('.active_status').addClass('red-stripe');
							$('#tr_' + v).find('.active_status').text(a["hiding"]);
							$('#tr_' + v).find('.active_status').attr('data-status', 0);
							
						});
						}
					} else {
						$this.removeClass('red-stripe');
						$this.addClass('green-stripe');
						$this.text(a["showing"]);
						$this.attr('data-status', 1);
					}
					}
					
				}
			});
		});
	}
	
var common = function () {
	$('#form-filter').keydown(function(e) {
			if (e.keyCode == 13) {// mã của phím enter				
		   	$('input[name="action"]').val("search");
            $('#formList').submit();    //submit form có id là: "form"
		   }
		});
    $("#bnt_search").live('click',function() {          
	$('input[name="action"]').val("search");
	$('#formList').submit();
	});
}

	return {
		//main function to initiate the module
		init : function(e) {
			enableDelete();
			checkboxAll();
			deleteItem(e);
			editCateStatus(e);
			quickEdit();
			deleteMultiID(e);
			common();
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