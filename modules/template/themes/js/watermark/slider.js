
var ComponentsjQueryUISliders = function () {

    return {
        //main function to initiate the module
        init: function () {
            // basic
            $(".slider-basic").slider({
                min:-180,
                max:180,
                value: varOnload['rotate'],
                slide: function (event, ui) {
                    
                    $("input[name='rotate']").val(ui.value);
                    $('.watermarker-container').css({
                        '-webkit-transform': 'rotate(' + ui.value + 'deg)',  //Safari 3.1+, Chrome  
                        '-moz-transform': 'rotate(' + ui.value + 'deg)',     //Firefox 3.5-15  
                        '-ms-transform': 'rotate(' + ui.value + 'deg)',      //IE9+  
                        '-o-transform': 'rotate(' + ui.value + 'deg)',       //Opera 10.5-12.00  
                        'transform': 'rotate(' + ui.value + 'deg)',          //Firefox 16+, Opera 12.50+  
                    });
                    
                }
            }); // basic sliders
            
            $(".slider-opacity").slider({
                min:0,
                max:1000,
                value:parseInt(varOnload['opacity']*1000),
                slide: function (event, ui) {
                    var opacity=parseFloat(parseInt(ui.value)/1000);
                    $('.watermarker-container').css({
                       opacity:opacity
                    });
                    $("input[name='opacity']").val(opacity);
                }
                    
            }); 
            
            $(".slider-font-size").slider({
                min:0,
                max:1000,
                value: parseInt(varOnload['text_size']*10),
                slide: function (event, ui) {
                    var text_size=parseInt(ui.value/10);
                    $('span#NXT_text_watermark').css({
                        fontSize: text_size+'px',
                    });
                    $("input[name='text_size']").val(text_size);
                }
                    
            });
            
            

           

        }

    };

}();