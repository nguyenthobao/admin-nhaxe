var Processhome = function (lang) {
    var callInvoice = function(lang){
        	$.ajax({
                url: 'product-process-lang-'+lang,
                type: 'POST',
               	dataType:'json',
                data: {key:'process-home'},
                success: function(data){
                	var html='';

                	if(data.invoice.length!=0){
                		$.each(data.invoice, function(k, v) {
                    	  	html +='<tr><td>'+(k+1)+'</td><td>'+v.invoice+'</td><td>'+v.name+'</td><td>'+v.phone+'</td><td>'+v.create_time+' </td><td>'+v.total+'</td><td class="center_process_home"><a href="/product-cart-cartDetails-'+v.id+'-lang-'+lang+'"><i class="icon icon-eye"></i></a></td></tr>';
                    	});	
                    	
                	}else{
                        $('#process-home thead').remove();
                		html='<tr><td><p class="text-center text-danger">Không có đơn hàng mới</p></td></tr>';
                	}
                	$('#process-home tbody').html(html);
                	//Total number product
                	$('#number-product').html(data.count.product.count);
                    $('#link-product').attr('href', data.count.product.link);
                	$('#number-order').html(data.count.orders.count);
                	$('#link-order').attr('href', data.count.orders.link);
                    
                }
            });
    }
    var callContact=function(lang){
        $.ajax({
                url: 'contact-count-lang-'+lang,
                type: 'POST',
                dataType:'json',
                data: {key:'process-home'},
                success: function(data){
                   if(data.total_contact){
                        $('#number-contact').html(data.total_contact);
                   }else{
                        $('#number-contact').html(0);
                   }
                    $('#link-contact').attr('href', data.link);
                }
            });
        
    } 
    var callFeedback=function(lang){
        $.ajax({
                url: 'feedback-count-lang-'+lang,
                type: 'POST',
                dataType:'json',
                data: {key:'process-home'},
                success: function(data){
                   if(data.total_feedback){
                        $('#number-feedback').html(data.total_feedback);
                   }else{
                        $('#number-feedback').html(0);
                   }
                   $('#link-feedback').attr('href', data.link);
                }
            });
        
    }
   
    return {
        //main function to initiate the module
        init: function (lang) {
           callInvoice(lang);
           callContact(lang);
           callFeedback(lang);
        }
    };

}();