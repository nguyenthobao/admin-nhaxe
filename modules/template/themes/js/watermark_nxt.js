var varOnload={type:varOnloadType,text_watermark:$('input[name="text_watermark"]').val(),text_color:$('input[name="text_color"]').val(),text_size:$('input[name="text_size"]').val(),font:$('#font').val(),rotate:$('input[name="rotate"]').val(),opacity:$('input[name="opacity"]').val(),ori_img:$('input[name="ori_img"]').val(),width:$('input[name="width"]').val(),height:$('input[name="height"]').val(),offsetLeft:$('#posx').val(),offsetTop:$('#posy').val()};
if(varOnload['ori_img']==undefined || varOnload['ori_img']==''){
    varOnload['ori_img']='modules/template/themes/js/watermark/images/watermark.png';
}else{
    varOnload['ori_img']=path_upload+varOnload['ori_img'];
}

if(varOnload['offsetLeft']!=0){
    var w=600;
    var pecent_w=w/100;
    varOnload['offsetLeft']=parseInt(pecent_w*varOnload['offsetLeft']);
}
if(varOnload['offsetTop']!=0){
    var h=400;
    var pecent_h=h/100;
    varOnload['offsetTop']=parseInt(pecent_h*varOnload['offsetTop']);
}
 
function getPositionData(el) {
                return $.extend({
                    width: el.outerWidth(false),
                    height: el.outerHeight(false)
                }, el.offset());
            };
function updateCoords (coords){
       // $("#posx").val(coords.x);
       //  $("#posy").val(coords.y);
        // $("#width").val(coords.width);
        // $("#height").val(coords.height);
        //$("#opacity").val(coords.opacity);      
    }
    
    function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
function img_hiden (type) {
    if(type=='show'){
        $('.watermarker-image').show();
        //$('.resizer').show();
        $('.watermarker-remove-item').show();
    }else{
         $('.watermarker-image').hide();
         //$('.resizer').hide();
        $('.watermarker-remove-item').hide();
    }
 }
function removeTxt (type,text_nxt) {
    if(type!='remove'){
        var res='<span style="font-size:'+$('input[name="text_size"]').val()+'px;color:'+$('input[name="text_color"]').val()+'" id="NXT_text_watermark">'+text_nxt+'</span>';
    }else{
        $('#NXT_text_watermark').remove();
        var res='';
    }
    return res;
}
 $("#image").watermarker({
        imagePath: varOnload['ori_img'],
        offsetLeft:varOnload['offsetLeft'],
        offsetTop: varOnload['offsetTop'],  
        onChange: updateCoords,
        onInitialize: updateCoords,
        allowRemove:false,
        //containerClass: "myContainer container",
        watermarkImageClass: "myImage image",       
        watermarkerClass: "js-watermark-1 js-watermark",
        data: {id: 1, "class": "superclass", pepe: "pepe"},     
        onRemove: function(){
            console.log("Removing...");
        },
        onDestroy: function(){
            console.log("Destroying...");
        }
    });


    $(document).on("mousemove",function(event){
        $("#x").val(event.pageX);
        $("#y").val(event.pageY);
       
    });
    
function ajax_form(formData,urlSend,method,type) {
    var result='';
    if(FolderAdmin!=undefined && FolderAdmin!=''){
        var urlS=BaseUrl+'/'+FolderAdmin+urlSend+BaseExt;
    }else{
        var urlS=BaseUrl+urlSend+BaseExt;
    }
    $.ajax({
        url: urlS,
        method: method,
        data:  formData,
        async:false,
        dataType: type,
        mimeType:"multipart/form-data",
        contentType: false,
        cache: false,
        processData:false,
    success: function(data, textStatus, jqXHR)
    {
        result=data;
    },
     error: function(jqXHR, textStatus, errorThrown) 
     {
        console.log(errorThrown);
     }          

    });
    return result;

}
var WaterMarkNXT = function () {
    var handOnload=function() {
        if(varOnload['type']==0){
            $('#act').hide();
        }else if(varOnload['type']==1){
            $('#act').show();
            //An tat ca lien quan toi anh
            var parent_input_image=$('#NXT_input_image');
            parent_input_image.hide();
            img_hiden('hiden');
        }else{
            var parent_input_image=$('#NXT_input_image');
            var input_text=$('input[name="text_watermark"]');
            var parent_input_text=input_text.parent().parent().parent();
           $('#act').show();
            //Su dung anh de dong dau
            img_hiden('show');
            //Remove text
            removeTxt('remove','');
            parent_input_text.hide();
            parent_input_image.show();
        }
        
        //Text
        $('#NXT_text_watermark').text(varOnload['text_watermark']);
        var fontFamilyOnload=$('#font option[value="'+varOnload['font']+'"]').attr('data-font');
        $('#NXT_text_watermark').css({
            'color': varOnload['text_color'],
             fontSize: varOnload['text_size']+'px',
             fontFamily:fontFamilyOnload,
        });
        $('.watermarker-container').css({
                        '-webkit-transform': 'rotate(' + varOnload['rotate'] + 'deg)',  //Safari 3.1+, Chrome  
                        '-moz-transform': 'rotate(' + varOnload['rotate'] + 'deg)',     //Firefox 3.5-15  
                        '-ms-transform': 'rotate(' + varOnload['rotate'] + 'deg)',      //IE9+  
                        '-o-transform': 'rotate(' + varOnload['rotate'] + 'deg)',       //Opera 10.5-12.00  
                        'transform': 'rotate(' + varOnload['rotate'] + 'deg)',          //Firefox 16+, Opera 12.50+  
                    });
        //Opa
        $('.watermarker-container').css({
                       opacity:varOnload['opacity'],
                       width:varOnload['width'],
                       height:varOnload['height'],
                    });
        //Change font
        // $('#font option').each(function(k, v) {
        //     var tmp_name=$(this).text();
        //     var tmp_font=$(this).attr('data-font');
        //     var nxt_html='<div style="font-family: '+tmp_font+';">'+tmp_name+'</div>';
        //     $(this).html(nxt_html);
        // });
    }
    var handelCSS = function() {
        $('body').find('.watermarker-wrapper').css({
            width: '1024px',
            height: '768px',
            // marginLeft:'36px'
        });;
        
    }
    var handChangeType=function () {
        //Default
        $('#NXT_input_image').hide();
        img_hiden('hiden');
        var input_text_default=$('input[name="text_watermark"]');
        var addText_default=removeTxt('add',input_text_default.val());
        $('.watermarker-container').append(addText_default);
        //Lay mau vao them vao
        var color_default=$('input[name="text_color"]').val();
        var size_default=$('input[name="text_size"]').val();
        $('#NXT_text_watermark').css({
            'color': color_default,
            'font-size': size_default
        });
        //End default        
        $('body').on('change', 'input[name="type"]', function(event) {
            event.preventDefault();
            var type=$(this).val();
            //Text watermark
            var input_text=$('input[name="text_watermark"]');
            var parent_input_text=input_text.parent().parent().parent();
            
            //Images watermark
            var input_image=$('input[name="image_watermark"]');
            var parent_input_image=$('#NXT_input_image');
            //Kiem tra xem da ton tai span nay chua
            if(type==1){
                $('#act').slideDown();
                //Remove cai cu
                removeTxt('remove',input_text.val());
                var addText=removeTxt('add',input_text.val());
                $('.watermarker-container').append(addText);
                //Dung anh
                parent_input_image.slideUp();
                img_hiden('hiden');
                var input_text=$('input[name="text_watermark"]');
                var parent=input_text.parent().parent().parent();
                parent.slideDown();
            }else if(type==2){
                $('#act').slideDown();
                //Su dung anh de dong dau
                img_hiden('show');
                //Remove text
                removeTxt('remove',input_text.val());
                
                parent_input_text.slideUp();
                parent_input_image.slideDown();
            }else{
                img_hiden('hide');
                removeTxt('remove','');
                $('#act').slideUp();
            }
        });
    }
    var handChangeImage=function () {
       $('body').on('change', 'input[name="image_watermark"]', function(event) {
           event.preventDefault();
           var img_base=window.URL.createObjectURL(this.files[0]);
           $('.watermarker-container').find('img').attr('src', img_base);
           //console.log(img_base);
       });
    }
    var handKeyTextWaterMark=function () {
        $('body').on('keyup', 'input[name="text_watermark"]', function(event) {
            event.preventDefault();
            var text_watermark=$(this).val();
            $('span#NXT_text_watermark').html(text_watermark);
        });
    }
    
    var handChangeColor=function () {
        $('body').on('blur', 'input[name="text_color"]', function(event) {
            event.preventDefault();
            var text_color=$(this).val();
            $('span#NXT_text_watermark').css({
                'color': text_color
            });
        });
    }
    
    var handChangeSize=function () {
        $('body').on('keyup', 'input[name="text_size"]', function(event) {
            event.preventDefault();
            var text_size=$(this).val();
            
            $('span#NXT_text_watermark').css({
                fontSize: text_size+'px',
            });
        });
    }
    
    var handChangeFont=function () {
        $('body').on('change', 'select[name="font"]', function(event) {
            event.preventDefault();
            var font=$(this).val();
            var opt=$('#font option[value="'+font+'"]');
            var fontF=opt.attr('data-font');
            $('span#NXT_text_watermark').css({
                fontFamily: fontF,
            });
        });
    } 
    
    var handChangeRo=function () {
        $('body').on('change', 'input[name="rotate"]', function(event) {
            event.preventDefault();
            var deg=$(this).val();
            $('.watermarker-container').css({
                    '-webkit-transform': 'rotate(' + deg + 'deg)',  //Safari 3.1+, Chrome  
                    '-moz-transform': 'rotate(' + deg + 'deg)',     //Firefox 3.5-15  
                    '-ms-transform': 'rotate(' + deg + 'deg)',      //IE9+  
                    '-o-transform': 'rotate(' + deg + 'deg)',       //Opera 10.5-12.00  
                    'transform': 'rotate(' + deg + 'deg)',          //Firefox 16+, Opera 12.50+  
            });
        });
    }
    var handReset=function () {
        $('body').on('click', '.NXT_refesh', function(event) {
            event.preventDefault();
            location.reload();
        });
    }
    
    return {
        //main function to initiate the module
        init: function () {
            handelCSS();
            handChangeType();
            handChangeImage();
            handKeyTextWaterMark();
            handChangeColor();
            handChangeSize();
            handChangeFont();
            handChangeRo();
            handReset();
            handOnload();
           
        }
        
    };
}();