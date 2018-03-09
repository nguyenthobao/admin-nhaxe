var ContactList=function(){
    
    var insert=function(){
         $("#form_contact").validate({
            errorElement: "span", 
            submitHandler: function(form) {
             
                
                var name        = $('#editor1').attr('value');
                
              
                $.ajax({
                    type: "POST", 
                    url: "ajax.php", 
                    data: "editor1="+ editor1, 
                    success: function(answer){ 
                        $('form#form_contact').hide(); // ?n form di
                        $('div.success').fadeIn(); // hi?n th? th? div success
                        $('div.success').html(answer); 
                    }
                });
        });
    });
    }
	return {
	init: function(){
	insert();
	}
	};
}();