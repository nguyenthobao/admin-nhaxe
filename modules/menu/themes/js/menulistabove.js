
var MenuListAbove = function () {

     var checkboxAll = function(){
        $('#checkboxAll').click(function(){
            if($(this).prop("checked") == true){
                $('.checkboxes').each(function( index ) {
                    $(this).prop("checked", true);
                    $(this).parent().addClass('checked');
                });
                
                $(".btn-del a").removeClass('disabled');                
            }
            else if($(this).prop("checked") == false){
                $('.checkboxes').each(function( index) {
                   $(this).prop("checked",false); 
                   $(this).parent().removeClass('checked');
                });
                $(".btn-del a").addClass('disabled');
            }
        });
    }
     var enableDelete = function()
    {
        var i = 0;
         $('.checkboxes').click(function(){
            var $this = $(this);
            $this.each(function( index ) {
               if($(this).prop("checked") == true){
                i++;
               }
            });
            if (i>=2) {
              $(".btn-del a").removeClass('disabled');
            }
            else
            {
                $(".btn-del a").addClass('disabled');
            }
         });
    }
    var deleteMenu = function(){
        $('.delete_menu').click(function(){

            var $this = $(this);
            var lang  = $("#menulistabove").attr('data-lang');
            var key   = $this.parents('tr').attr('data-key');
            var deletefeed =$("#menulistabove").attr('data-lang-j');
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">' +deletefeed+'</li>',
                title: "Xoá liên hệ",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        $.ajax({
                            url: 'menu-ajax-lang-'+lang, 
                            type: 'POST',
                            data: {actionabove:'deleteMenulistabove',key:key},
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

   var activeStatusMenuabove = function(){
        $('.active_status').click(function(e,data){
            var $this = $(this);
            var statusCurren = $this.attr('data-status');
            var key = $this.parents('tr').attr('data-key');
            var lang = $this.parents('tr').attr('data-lang');
            if (statusCurren==1) {var status=0;}else{ var status=1; }
            $.ajax({
                url: 'menu-ajax-lang-'+lang,
                type: 'POST',
                data: {actionabove:'activeStatusMenulistabove',key:key,status:status},
                success: function(data){
                    if (statusCurren==1) {
                        $this.removeClass('green-stripe');
                        $this.addClass('red-stripe');
                        $this.text('Đang ẩn');
                        $this.attr('data-status',0);
                    }else{
                        $this.removeClass('red-stripe');
                        $this.addClass('green-stripe');
                        $this.text('Đang hiện');
                        $this.attr('data-status',1);
                    }
                }
            });
        });
    }

    var deleteMultiID =function(){
        
        $('.delete_contactview_select').click(function(){
             var deletefeed =$("#menulistabove").attr('data-lang-j');
             bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">'+deletefeed+'</li>',
                title: "Xoá liên hệ",
                buttons: {
                    success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        //submit form khi nút submit không phải là button hoặc <input type="submit">
                        $('#form_menulistabove').submit();
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
                    '<td> ' +content1+
                    '</td> ' +
                    '</tr> ' +
                    '</table> </div>  </div>',
                buttons: {
                    success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        //submit form khi nút submit không phải là button hoặc <input type="submit">
                        $('#form_menulistabove').submit();
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
            
            deleteMenu();
            activeStatusMenuabove();
            deleteMultiID();
            checkboxAll();
            enableDelete();
            view(); 
            searchView();
            handleDatePickers();

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

