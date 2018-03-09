
$( document ).ajaxStart(function() {
    Metronic.startPageLoading('Đang tải....');
});

$( document ).ajaxStop(function() {
    Metronic.stopPageLoading();
});

var settinglang = function () {
    
    var handleDrag = function() {
        
        $( "#NXT_sort" ).sortable({
          revert: true,
          cursor: 'move',
        });
        // $( ".NXT_item" ).draggable({
        //   connectToSortable: "#NXT_sort",
        //   helper: "clone",
        //   revert: "invalid"
        // });
        $( "ul, li" ).disableSelection();
        
            // $("#NXT_ul").sortable({
            //     revert: true
            // });
            // $(".NXT_drag").draggable({
            //     connectToSortable: ".listborder",
            //     accept: '.listborder > li',
            //     appendTo: "body",
            //     helper: "clone",
            //     cursor: 'move',
            //     revert: "invalid" ,
            //     start : function(event, ui) {
            //             var myDrag=ui.helper;
            //             myDrag.width($(this).width());
            //     },
            //     stop:function(event,ui){
                        
            //             // //Xu ly su kien keo tha dung lai
            //             // //Chuoi random
            //             // var NXT_random=handleRanDom(32);
            //             // var myDrag=ui.helper;
            //             // var myClassInput=myDrag.attr('data-class');

            //             // var html='<div class="removeNXT"><a href="javascript:void(0)" class="NXT_setting" data-id-modal="'+NXT_random+'"><i class="fa fa-cog fa-15x"></i></a> <a href="javascript:void(0)" class="redColorNxt" data-id-modal="'+NXT_random+'"><i class="fa fa-times-circle-o fa-15x"></i></a></div>';
            //             // myDrag.addClass('hoverShowAction');
            //             // myDrag.append(html);
            //             // //Them 1 du lieu vao
            //             // myDrag.attr('data-id-modal',NXT_random);
            //             // myDrag.addClass(NXT_random);
            //             // //Tim modal va nhan ban
            //             // $('body').find('#NXT_modal_'+myClassInput).clone().appendTo('#NXT_modal_clone').attr('id', NXT_random);
            //             // var firstChild=myDrag.children(':first-child');
            //             // if(firstChild.find('.checker').length>=1){
            //             //      firstChild.find('.checker').remove();
            //             //      firstChild.append('<input value="1" name="checkbox_1" type="checkbox" class="form-control"/>');
            //             // }else if(firstChild.find('.radio').length>=1){
            //             //      firstChild.find('.radio').remove();
            //             //      firstChild.find('label:last-child').each(function(k, v) {
            //             //             $('<input value="'+parseInt(k+1)+'" type="radio" name="radio_1" class="form-control"/>').insertAfter($(this));    
            //             //      });
            //             // }
            //             // $(':checkbox,:radio').uniform();
            //             // $('.radio').css({
            //             //     marginTop: '-10px'
            //             // });
            //             // $('input[type="radio"]').css({
            //             //     marginLeft: '-10px'
            //             // });
            //      }
            //     }); 
            // $("#NXT_ul").droppable({
            //     accept: '.NXT_drag',
            //     hoverClass: "NXT_remove",
            //     drop: function(ev, ui) {
            //     },
            //     out: function (event, ui) {
            //          var myDrop=ui.helper;
            //          myDrop.remove();
            //     },
            // });
        }
    
    var handleChangePrimary=function(){
        $('body').on('change', 'select[name="langPrimary"]', function(event) {
            event.preventDefault();
            var langS=$(this).val();
             $('.listborder').find('input:disabled').removeAttr('disabled');
            $(".NXT_checkbox[value='"+langS+"']").prop("checked","true");
            $(".NXT_checkbox[value='"+langS+"']").prop("disabled","true");
            $.uniform.update();
            var parent=$(".NXT_checkbox[value='"+langS+"']").parent().parent();
        });
    }
    
    var handleValidation = function() {
        var nxt_form = $('#nxt_form');
        var error1 = $('.alert-danger', nxt_form);
        var success1 = $('.alert-success', nxt_form);
        $('body').on('click', '.continue', function() {
            var con = $(this).attr('data-continue');
            $('input[name="continue"]').val(con);
        });
        nxt_form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {
                'langShowHome[]': {
                    required: '         '
                },
            },
            rules: {
                'langShowHome[]': {
                    required: true,
                },
            },
            errorPlacement: function(error, element) { // render error placement for each input type
                if (element.parent(".input-group").size() > 0) {
                    error.insertAfter(element.parent(".input-group"));
                } else if (element.attr("data-error-container")) {
                    error.appendTo(element.attr("data-error-container"));
                } else if (element.parents('.radio-list').size() > 0) {
                    error.appendTo(element.parents('.radio-list').attr("data-error-container"));
                } else if (element.parents('.radio-inline').size() > 0) {
                    error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
                } else if (element.parents('.checkbox-list').size() > 0) {
                    error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
                } else if (element.parents('.checkbox-inline').size() > 0) {
                    error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
                } else {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }
            },
            invalidHandler: function(event, validator) { //display error alert on form submit
                success1.hide();
                error1.show();
                Metronic.scrollTo(error1, -200);
            },
            highlight: function(element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            unhighlight: function(element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
            },
            success: function(label) {
                label.closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler: function(form) {
                handleSubmitForm(form);
                error1.hide();
                return false;
            }
        });
    }
    var handleSubmitForm=function(form){
        var tmp_sort=[];
      $('body').find('.NXT_checkbox').each(function(k, v) {
          tmp_sort.push($(this).val());
      });
      
        var formObj =$('#nxt_form');
        var formURL = formObj.attr("action");
        var formData = new FormData(form);
        formData.append('sort', tmp_sort);
        // var formData={
        //     'sort':tmp_sort,
        //     'langPrimary':$('select[name="langPrimary"]').val(),
        //     'langShowHome':$('input[name="langShowHome"]').val()
        // };
        
        $.ajax({
            url: formURL,
            type: 'POST',
            data:  formData,
            //mimeType:"multipart/form-data",
            contentType: false,
            cache: false,
            processData:false,
        success: function(data, textStatus, jqXHR) 
        {
            var obj_data = jQuery.parseJSON(data);
            if(obj_data.status==true){
                toastr.success(obj_data.message); 
                setTimeout(function(){
                    window.location.reload();
                },2000);              
            }
        },
         error: function(jqXHR, textStatus, errorThrown) 
         {
         }          
        });
    }
    return {
        //main function to initiate the module
        init: function () {
          handleDrag();
          handleValidation();
          handleChangePrimary();
        },

    };
}();