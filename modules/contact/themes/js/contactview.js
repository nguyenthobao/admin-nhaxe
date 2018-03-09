
var ContactView = function () {


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

    var deleteContact = function(){
        $('.delete_contact').click(function(){

            var $this = $(this);
            var lang  = $("#contactview").attr('data-lang');
            var key   = $this.parents('tr').attr('data-key');
            var key   = $this.parents('tr').attr('data-key');
            var deletefeed =$("#contactview").attr('data-lang-j');
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">' +deletefeed+'</li>',
                title: "Xoá liên hệ",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        $.ajax({
                            url: 'contact-ajax-lang-'+lang, 
                            type: 'POST',
                            data: {action:'deleteContact',key:key},
                            success: function(data){
                                //Chuyển string sang mảng dùng split
                                $this.parents('tr').remove();
                                var data2 = data.split(",");
                                $.each(data2,function(k,v){
                                     $('#tr_'+v).remove();//xoá thẻ html theo id (vd id="tr_220") <tr id="tr_220"></tr>
                                });
                            }
                        });
                    }
                  },
                  danger: {
                    label: "Huỷ",
                    className: "red",
                    callback: function() {
                      return;
                    }
                  }
                }
            });
        });
    }

    var activeStatusContact = function(){
        $('.view_contact').click(function(e,data){
            var $this = $(this);
            var statusCurren = $this.attr('data-status');
            var key  = $this.parents('tr').attr('data-key');
            var lang = $this.parents('tr').attr('data-lang');
            if (statusCurren==1) {var status=0;}else{ var status=1; }
            $.ajax({
                url: 'contact-ajax-lang-'+lang,
                type: 'POST',
                data: {action:'activeStatusContact',key:key,status:status},
                success: function(data){
                   $this.parents('tr').find('.active_status').removeClass('red-stripe');
                   $this.parents('tr').find('.active_status').addClass('green-stripe');
                   $this.parents('tr').find('.active_status').html($this.parents('tr').attr('data-view'));
                   $this.attr('data-status',1);
                }
            });
        });
    }

    var deleteMultiID =function(){
        
        $('.delete_contactview_select').click(function(){
             var deletefeed =$("#contactview").attr('data-lang-a');
             bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">'+deletefeed+'</li>',
                title: "Xoá liên hệ",
                buttons: {
                    success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        //submit form khi nút submit không phải là button hoặc <input type="submit">
                        $('#form_contactview').submit();
                    }
                },
                    danger: {
                    label: "Huỷ",
                    className: "red",
                    callback: function() {
                      return;
                    }
                  }
                }
            });
            
        });
    }

        var feedback = function () {
            var $this   = $(this);
            var $modal  = $('#contactview');
            var string_email = "";
            var string_      = ",";
            var email  = $this.parents('tr').find('.ct_email').html(); 
            $('#checkboxAll').click(function(){
                    if($(this).prop("checked") == true){
                        $('.checkboxes').each(function( index ) {
                            $(this).prop("checked", true);
                            $(this).parent().addClass('checked');
                            var $this   = $(this);
                            var email   = $this.parents('tr').find('.ct_email').html();
                            string_email=string_email+email+string_;

                        });
                    }else if($(this).prop("checked") == false){
                        $('.checkboxes').each(function( index) {
                            $(this).prop("checked",false); 
                            $(this).parent().removeClass('checked');
                            string_email = "";
                        });
                     }
             });
            $('.checkboxes').click(function(){
                var $this = $(this);
                $this.each(function( index ) {
                    if($(this).prop("checked") == true){
                        var email    = $this.parents('tr').find('.ct_email').html();
                        string_email = string_email+email+string_;
                    }
                });
            })
                      
            $('.btn_feedback_add').click(function(){
                var lang              = $("#contactview").attr('data-lang');
                var $this             = $(this);
                var email             = $this.parents('tr').find('.ct_email').html();   
                var content2           = $this.parents('tr').attr('data-content');  
                var address           = $this.parents('tr').attr('data-address');
                var title_mail        = $("#contactview").attr('data-title');  
                var content           = $("#contactview").attr('data-content');
                var key               = $this.parents('tr').attr('data-key'); 
                var error             = $("#contactview").attr('data-error-mail');
                var successful        = $("#contactview").attr('data-success-mail');
                var address_mail      = $("#contactview").attr('data-viewf');
                var bc                = $("#contactview").attr('data-viewbb'); 
                var customers         = $this.parents('tr').find('.ct_customers').html();  
            

            bootbox.dialog({
                
                title:'Trả lời thư !',
                message: '<div class="row">  ' +
                           '<div class="portlet-body form">'+
                              '<form class="form-horizontal" role="form">'+
                                 '<div class="form-body">'+
                                        '<div class = "success">'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                        '<label class="col-md-3 control-label">' +address_mail+
                                        '</label>'+
                                        '<div class="col-md-9">'+
                                         '<textarea id="addressMail"class="form-control "placeholder="Bạn có thể tự nhập email khác"  name="description"id="contentmail"style="max-width: 404px; max-height: 40px;width:404px;">'+string_email+'</textarea>'+
                                        '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                        '<label class="col-md-3 control-label">' +title_mail+
                                        '</label>'+
                                        '<div class="col-md-9">'+
                                            '<input type="text" class="form-control" id="title_mail" placeholder="Nhập tiêu đề thư">'+
                                        '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                        '<label class="col-md-3 control-label">'+bc+
                                        '</label>'+
                                        '<div class="col-md-6">'+
                                        '<textarea class="form-control " minlength="5" rows="6" cols="10" name="description"id="contentmail"style="max-width: 404px; max-height: 134px;width:404px;"></textarea>'+
                                        '</div>'+
                                        '</div><input name="qa" value="'+content+'" type="hidden"/>'+
                                    '</div>'+
                                    '</form>'+
                                  '</div>'+
  
                        '</div>',
                 
            buttons: {
                  success: {
                    label: "Gửi",
                    className: "green",
                    callback: function() {
                        var addAddress = string_email;
                        var subject = $('#title_mail').val();
                        var content = $('#contentmail').val();
                        $.ajax({
                            url: 'contact-ajax-lang-'+lang, 
                            type: 'POST',
                            data: {action:'sendmailsmtp',addAddress:addAddress,subject:subject,content:content,customers:customers,qaa:content2},
                            success: function(data){
                            
                                     $('.success').prepend('<div class="alert alert-success padding10">'+successful+'</div>');
                            
/*                                   $('.bootbox-body').prepend('<div class="alert alert-danger padding10">'+error+'</div>');  
*/                            
                           
                            }
                        });
                        setTimeout(function(){
                                    $('button[data-bb-handler="danger"]').trigger('click');
                                }, 1000);
                                return false;
                    }

                  },
                  danger: {
                    label: "Huỷ",
                    className: "red",
                    callback: function() {
                      return;
                    }
                  }
                }
                 
            } );

        });
            
            $('.btn_feedback').click(function(){

                var lang              = $("#contactview").attr('data-lang');
                var $this             = $(this);
                var email             = $this.parents('tr').find('.ct_email').html();   
                var content2           = $this.parents('tr').attr('data-content');  
                var address           = $this.parents('tr').attr('data-address');
                var title_mail        = $("#contactview").attr('data-title');  
                var content           = $("#contactview").attr('data-content');
                var key               = $this.parents('tr').attr('data-key'); 
                var error             = $("#contactview").attr('data-error-mail');
                var successful        = $("#contactview").attr('data-success-mail');
                var address_mail      = $("#contactview").attr('data-viewf');
                var bc                = $("#contactview").attr('data-viewbb'); 
                var customers         = $this.parents('tr').find('.ct_customers').html();  
            
              bootbox.dialog({
                
                title:'Trả lời thư !',
                message: '<div class="row">  ' +
                           '<div class="portlet-body form">'+
                              '<form class="form-horizontal" role="form">'+
                                 '<div class="form-body">'+
                                        '<div class ="success">'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                        '<label class="col-md-3 control-label">' +address_mail+
                                        '</label>'+
                                        '<div class="col-md-9">'+
                                         '<textarea class="form-control "id="addressmail" minlength="5" rows="3" cols="5" name="description" style="max-width: 404px; max-height: 40px;width:404px;">'+email+'</textarea>'+
                                        '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                        '<label class="col-md-3 control-label">' +title_mail+
                                        '</label>'+
                                        '<div class="col-md-9">'+
                                            '<input type="text" class="form-control" id="title_mail" placeholder="Nhập tiêu đề thư">'+
                                        '</div>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                        '<label class="col-md-3 control-label">'+bc+
                                        '</label>'+
                                        '<div class="col-md-6">'+
                                        '<textarea class="form-control " minlength="5" rows="6" cols="10" name="description"id="contentmail"style="max-width: 404px; max-height: 134px;width:404px;"></textarea>'+
                                        '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '</form>'+
                                  '</div>'+
  
                        '</div>',
                 
           buttons: {
                  
                  success: {
                    label: "Gửi",
                    className: "green",
                    callback: function() {
                        var addAddress = $('#addressmail').val();
                        var subject    = $('#title_mail').val();
                        var content    = $('#contentmail').val();
                        if(addAddress==""){
                             $('.success').prepend('<div class="alert alert-danger padding10">'+error+'</div>');
                             $('.alert-danger').remove();
                                return false; 
                        }
                        if(subject==""){
                            $('.alert-danger').remove();
                           $('.success').prepend('<div class="alert alert-danger padding10">'+error+'</div>');
                                return false; 
                        }
                        else 
                        {   $('.alert-danger').remove();
                            $('.bootbox-body').prepend('<div class="alert alert-success padding10">'+successful+'</div>');
                            $.ajax({
                                url: 'contact-ajax-lang-'+lang, 
                                type: 'POST',
                                data: {action:'sendmailsmtp',addAddress:addAddress,subject:subject,content:content,customers:customers,key:key,qaa:content2},
                                success: function(data){
                                                    if(data==""){
                                
                                         $('.alert-danger').prepend('<div class="alert alert-success padding10">'+successful+'</div>');
                                    }else{
                                         $('.bootbox-body').prepend('<div class="alert alert-danger padding10">'+error+'</div>');  
                                    }        
                               
                                }
                            });  
                        }
                        
                    
                        setTimeout(function(){
                                    $('button[data-bb-handler="danger"]').trigger('click');
                                }, 5000);
                                return false;
                    }

                  },
                  danger: {
                    label: "Huỷ",
                    className: "red",
                    callback: function() {
                      return;
                    }
                  }
                }
                 
            } );

    });
$('.refesh_news').click(function(){

                var lang              = $("#contactview").attr('data-lang');
                var $this             = $(this);
                var email             = $this.parents('tr').find('.ct_email').html();   
                var content           = $this.parents('tr').attr('data-content');  
                var address           = $this.parents('tr').attr('data-address');
                var title_mail        = $("#contactview").attr('data-title'); 
                var key               = $this.parents('tr').attr('data-key'); 
                var error             = $("#contactview").attr('data-error-mail');
                var successful        = $("#contactview").attr('data-success-mail');
                var address_mail      = $("#contactview").attr('data-viewf');
                var bc                = $("#contactview").attr('data-viewbb'); 
                var customers         = $this.parents('tr').find('.ct_customers').html();
                var datetime          = $this.parents('tr').find('.ct_datetime').html();
                var thoigian          = '<i>  Thời gian </i>';
                var content_answer    = $this.parents('tr').attr('data-answer');
                var datetime2         = $this.parents('tr').attr('datetime');
                var admin             = 'Admin';
             

                var Base64 = {
                    _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
                    encode: function(input) {
                        var output = "";
                        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
                        var i = 0;

                        input = Base64._utf8_encode(input);

                        while (i < input.length) {

                            chr1 = input.charCodeAt(i++);
                            chr2 = input.charCodeAt(i++);
                            chr3 = input.charCodeAt(i++);

                            enc1 = chr1 >> 2;
                            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                            enc4 = chr3 & 63;

                            if (isNaN(chr2)) {
                                enc3 = enc4 = 64;
                            } else if (isNaN(chr3)) {
                                enc4 = 64;
                            }

                            output = output + this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) + this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

                        }

                        return output;
                    },
                    decode: function(input) {
                        var output = "";
                        var chr1, chr2, chr3;
                        var enc1, enc2, enc3, enc4;
                        var i = 0;

                        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

                        while (i < input.length) {

                            enc1 = this._keyStr.indexOf(input.charAt(i++));
                            enc2 = this._keyStr.indexOf(input.charAt(i++));
                            enc3 = this._keyStr.indexOf(input.charAt(i++));
                            enc4 = this._keyStr.indexOf(input.charAt(i++));

                            chr1 = (enc1 << 2) | (enc2 >> 4);
                            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
                            chr3 = ((enc3 & 3) << 6) | enc4;

                            output = output + String.fromCharCode(chr1);

                            if (enc3 != 64) {
                                output = output + String.fromCharCode(chr2);
                            }
                            if (enc4 != 64) {
                                output = output + String.fromCharCode(chr3);
                            }

                        }

                        output = Base64._utf8_decode(output);

                        return output;
                    },
                    _utf8_encode: function(string) {
                        string = string.replace(/\r\n/g, "\n");
                        var utftext = "";

                        for (var n = 0; n < string.length; n++) {

                            var c = string.charCodeAt(n);

                            if (c < 128) {
                                utftext += String.fromCharCode(c);
                            }
                            else if ((c > 127) && (c < 2048)) {
                                utftext += String.fromCharCode((c >> 6) | 192);
                                utftext += String.fromCharCode((c & 63) | 128);
                            }
                            else {
                                utftext += String.fromCharCode((c >> 12) | 224);
                                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                                utftext += String.fromCharCode((c & 63) | 128);
                            }

                        }

                        return utftext;
                    },
                    _utf8_decode: function(utftext) {
                        var string = "";
                        var i = 0;
                        var c = c1 = c2 = 0;

                        while (i < utftext.length) {

                            c = utftext.charCodeAt(i);

                            if (c < 128) {
                                string += String.fromCharCode(c);
                                i++;
                            }
                            else if ((c > 191) && (c < 224)) {
                                c2 = utftext.charCodeAt(i + 1);
                                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                                i += 2;
                            }
                            else {
                                c2 = utftext.charCodeAt(i + 1);
                                c3 = utftext.charCodeAt(i + 2);
                                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                                i += 3;
                            }

                        }

                        return string;
                    }
                }
                
                var content1 = Base64.decode(content);
                var content2 = Base64.decode(content_answer); 
                if(content2==""){
                    admin="";
                    thoigian="";
                    datetime2="";
                    content2="Thư chưa được trả lời";

                }else{
                    admin="Admin";
                    
                }
            
              bootbox.dialog({
                
                title:'Trả lời thư !',
                message: '<div class="row">  ' +
                        '<div class="portlet-body" id="chats">'+
                            '<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto;">'+
                            '<div class="scroller" style=" overflow: hidden; width: auto;" data-always-visible="1" data-rail-visible1="1" data-initialized="1">'+
                                '<ul class="chats">'+
                                    '<li class="in">'+
                                        '<div class="message">'+
                                            '<span class="arrow">'+
                                            '</span>'+
                                            '<a href="#" class="name">'+customers+ 
                                            '</a>'+
                                            '<span class="datetime">'+thoigian+datetime+ 
                                            '</span>'+
                                            '<span class="body" style="text-align: justify;">'+content1+
                                             
                                            '</span>'+
                                        '</div>'+
                                    '</li>'+
                                    
                                    '<li class="out">'+
                                        '<div class="message">'+
                                            '<span class="arrow">'+
                                            '</span>'+
                                            '<a href="#" class="name">'+admin+
                                            '</a>'+
                                            '<span class="datetime">'+thoigian+ datetime2+ 
                                            '</span>'+
                                            '<span class="body" style="text-align: justify;">'+content2+
                                          
                                            '</span>'+
                                        '</div>'+
                                    '</li>'+
                                  
                                '</ul>'+
                            '</div>'+

                            '</div>'+
                    '</div>'+
  
                        '</div>',
            } );

    });

    }

    var view = function () {
    
            var $modal  = $('#contactview');
            
            $('.btn_view').click(function(){
                var $this   = $(this);
                var customers         = $this.parents('tr').find('.ct_customers').html();  
                var phone             = $this.parents('tr').find('.ct_phone').html();  
                var email             = $this.parents('tr').find('.ct_email').html();  
                var datetime          = $this.parents('tr').find('.ct_datetime').html();  
                var content           = $this.parents('tr').attr('data-content');  
                var address           = $this.parents('tr').attr('data-address');
                var customerslang     = $this.parents('tr').attr('data-viewa');  
                var emaillang         = $this.parents('tr').attr('data-viewb'); 
                var phonelang         = $this.parents('tr').attr('data-viewc'); 
                var addresslang       = $this.parents('tr').attr('data-viewd'); 
                var contentlang       = $this.parents('tr').attr('data-viewe'); 
                var contactfrom       = $this.parents('tr').attr('data-viewcontact');
                var Base64 = {
                    _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
                    encode: function(input) {
                        var output = "";
                        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
                        var i = 0;

                        input = Base64._utf8_encode(input);

                        while (i < input.length) {

                            chr1 = input.charCodeAt(i++);
                            chr2 = input.charCodeAt(i++);
                            chr3 = input.charCodeAt(i++);

                            enc1 = chr1 >> 2;
                            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                            enc4 = chr3 & 63;

                            if (isNaN(chr2)) {
                                enc3 = enc4 = 64;
                            } else if (isNaN(chr3)) {
                                enc4 = 64;
                            }

                            output = output + this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) + this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

                        }

                        return output;
                    },
                    decode: function(input) {
                        var output = "";
                        var chr1, chr2, chr3;
                        var enc1, enc2, enc3, enc4;
                        var i = 0;

                        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

                        while (i < input.length) {

                            enc1 = this._keyStr.indexOf(input.charAt(i++));
                            enc2 = this._keyStr.indexOf(input.charAt(i++));
                            enc3 = this._keyStr.indexOf(input.charAt(i++));
                            enc4 = this._keyStr.indexOf(input.charAt(i++));

                            chr1 = (enc1 << 2) | (enc2 >> 4);
                            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
                            chr3 = ((enc3 & 3) << 6) | enc4;

                            output = output + String.fromCharCode(chr1);

                            if (enc3 != 64) {
                                output = output + String.fromCharCode(chr2);
                            }
                            if (enc4 != 64) {
                                output = output + String.fromCharCode(chr3);
                            }

                        }

                        output = Base64._utf8_decode(output);

                        return output;
                    },
                    _utf8_encode: function(string) {
                        string = string.replace(/\r\n/g, "\n");
                        var utftext = "";

                        for (var n = 0; n < string.length; n++) {

                            var c = string.charCodeAt(n);

                            if (c < 128) {
                                utftext += String.fromCharCode(c);
                            }
                            else if ((c > 127) && (c < 2048)) {
                                utftext += String.fromCharCode((c >> 6) | 192);
                                utftext += String.fromCharCode((c & 63) | 128);
                            }
                            else {
                                utftext += String.fromCharCode((c >> 12) | 224);
                                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                                utftext += String.fromCharCode((c & 63) | 128);
                            }

                        }

                        return utftext;
                    },
                    _utf8_decode: function(utftext) {
                        var string = "";
                        var i = 0;
                        var c = c1 = c2 = 0;

                        while (i < utftext.length) {

                            c = utftext.charCodeAt(i);

                            if (c < 128) {
                                string += String.fromCharCode(c);
                                i++;
                            }
                            else if ((c > 191) && (c < 224)) {
                                c2 = utftext.charCodeAt(i + 1);
                                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                                i += 2;
                            }
                            else {
                                c2 = utftext.charCodeAt(i + 1);
                                c3 = utftext.charCodeAt(i + 2);
                                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                                i += 3;
                            }

                        }

                        return string;
                    }
                }
                
                var content1 = Base64.decode(content);
              // create the backdrop and wait for next modal to be triggered
              bootbox.dialog({
                
                title:contactfrom + customers ,
                message: '<div class="row">  ' +
                    '<div class="col-md-12"> ' +
                    '<table class="table table-striped table-bordered table-advance table-hover"> ' +
                    '<tr > ' +
                    '<td width="170">'+customerslang+
                    '</td> ' +
                    '<td> '+customers+
                    '</td> ' + 
                    '</tr> ' +
                    '<tr> ' +
                    '<td width="170">'+emaillang+
                    '</td> ' +
                    '<td> ' +email+
                    '</td> ' +
                    '</tr> ' +
                    '<tr> ' +
                    '<td width="170">'+phonelang+
                    '</td> ' +
                    '<td> ' + phone+
                    '</td> ' +
                    '</tr> ' +
                    '<tr> ' +
                    '<td width="170">'+addresslang+
                    '</td> ' +
                    '<td> ' +address+
                    '</td> ' +
                    '</tr> ' +
                    '<tr> ' +
                    '<td width="170">'+contentlang+
                    '</td> ' +
                    '<td style="text-align: justify;"> ' +content1+
                    '</td> ' +
                    '</tr> ' +
                    '</table> </div>  </div>',
                 
            }
        );
            });

            
    } 
   
    var handleDatePickers = function () {
        if (jQuery().datepicker) {
            $('.form_datetime').datepicker({
                rtl: Metronic.isRTL(),
                orientation: "left",
                autoclose: true
            });
            
        }
    }    
     var searchView = function(){
        $('.search_contact').live('click',function() { 
                   
            $('input[name="action"]').val("searchContact"); 

            $('#form_contactview').submit();
        });
    }
     
    return {
        //main function to initiate the module
        init: function () {
            
            deleteContact();
            activeStatusContact();
            deleteMultiID();
            checkboxAll();
            enableDelete();
            view(); 
            searchView();
            handleDatePickers();
            feedback();

            // handle editable elements on hidden event fired
            $('#contactview .editable').on('hidden', function (e, reason) {
                if (reason === 'save' || reason === 'nochange') {
                    var $next = $(this).closest('tr').next().find('.editable');
                    if ($('#autoopen').is(':checked')) {
                        setTimeout(function () {
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

