var addSlide = function(e) {
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
	var initComponents = function(){
        //init maxlength handler
        $('.maxlength-handler').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            threshold: 5
        });
    }
	return {
		//main function to initiate the module
		init : function(e) {
			initComponents();
			validation();
			handleTagsInput();
		}
	};
}(); 