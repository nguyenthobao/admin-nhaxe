
$( document ).ajaxStart(function() {
    Metronic.startPageLoading('Đang tải....');
});

$( document ).ajaxStop(function() {
    Metronic.stopPageLoading();
});
var list_domain=[];
var urlLoad='http://adminweb.anvui.vn/information-settingdomain-lang-vi';
function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle) return true;
    }
    return false;
}
function remove_Item_Arr(arr, item) {
      for(var i = arr.length; i--;) {
          if(arr[i] === item) {
              arr.splice(i, 1);
          }
      }
  }
function count_same_domain(arr,domain) {
    var a = [], b = [], prev;

    arr.sort();
    var count=0;
    for ( var i = 0; i < arr.length; i++ ) {
        if(arr[i]==domain){
            count=count+1;
        }
        // if ( arr[i] !== prev ) {
        //     a.push(arr[i]);
        //     b.push(1);
        // } else {
        //     b[b.length-1]++;
        // }
        // prev = arr[i];
    }
   
    return count;
}
var Domain = function () {
    var initComponents = function () {
        //init maxlength handler
        $('.maxlength-handler').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            threshold: 5
        });
    }
    var handleOtherInfo = function () {
        $('body').on('click', '.add_info', function() {
            var html = $(this).parents('.form-group').clone();
            $(this).parents('.form-group').after(html);
            $(this).parents('.form-group').next().find('.control-label').empty();
            $(this).parents('.form-group').next().find('input[type="text"]').val('');
            $(this).removeClass('add_info');
            $(this).find('.fa').removeClass('fa-plus');
            $(this).addClass('delete_info');
            $(this).find('.fa').addClass('fa-minus');
        });
        $('body').on('click', '.delete_info', function() {
            var label = $(this).parents('.form-group').find('.control-label').text();
            if(label != ''){
                $(this).parents('.form-group').next().find('.control-label').text(label);
            }
            $(this).parents('.form-group').remove();
        });
        return false;
    }
   
   var deleteModal=function(){
        $('body').on('click','.BNC_remove_domain',function(event){
            event.preventDefault();
            var domain=$(this).attr('data-domain');
            $('#BNC_remove_domain_modal_body').html(domain);
            $('#BNC_remove_domain_button_modal').attr('data-domain', domain);
            $('#text-danger').html(domain);
            $('#BNC_remove_domain_modal').modal('show');
            return false;
        });
   }

   var infomationDomainVali=function(){
    
    $('body').on('blur','input.BNC_infomation_domain',function(event){
        event.preventDefault();
       
        var seft=$(this);

        $('button.add_info').prop('disabled', false);
        $('button.continue').prop('disabled', false);
        seft.parent(seft).find('span.BNC_error').hide();
        seft.parent(seft).find('span.BNC_exist').hide();
        seft.parent(seft).find('span.BNC_not_dns').hide();
        seft.parent(seft).find('span.BNC_exist_in_web').hide();

        var domain=seft.val();
        var re = new RegExp(/^((?:(?:(?:\w[\.\-\+]?)*)\w)+)((?:(?:(?:\w[\.\-\+]?){0,62})\w)+)\.(\w{2,6})$/); 
        var vali=domain.match(re);
        if($.isArray(vali)){
            // $('button.add_info').prop('disabled', false);
            // $('button.continue').prop('disabled', false);
            
            // seft.parent(seft).find('span.BNC_error').hide();
            // seft.parent(seft).find('span.BNC_exist').hide();
            // seft.parent(seft).find('span.BNC_not_dns').hide();
            seft.parent().removeClass('has-error');

            //Domain
            var list_domain=[];
            $("input.BNC_infomation_domain").each(function(){
                var domainValue = $(this).val();
                list_domain.push(domainValue);
            });
            //  console.log(list_domain);
            // console.log();
            var count_same=count_same_domain(list_domain,domain);
            if(count_same>1 || inArray(domain,domainlist_array)){
                seft.parent(seft).find('span.BNC_exist').show();
                seft.parent().addClass('has-error');
                $('button.add_info').prop('disabled', true);
                $('button.continue').prop('disabled', true);
                return false;
            }
            //console.log(list_domain);
            
            $.ajax({
                url: urlLoad,
                type: 'POST',
                dataType: 'json',
                data: {domaincheck: domain},
            })
            .success(function(res) {
                if(res.status==false){
                    seft.parent(seft).find('span.BNC_not_dns').show();
                    $('button.add_info').prop('disabled', true);
                    $('button.continue').prop('disabled', true);
                    return false;
                }
                // else{
                //     toastr.success(res.msg+domain);
                // }
            });
            
            //Kiem tra xem ten mien da duoc su dung boi web nao chua
            $.ajax({
                url: urlLoad,
                type: 'POST',
                dataType: 'json',
                data: {domain_check_exist_web: domain},
            })
            .success(function(res) {
                if(res.status==false){
                    seft.parent(seft).find('span.BNC_exist_in_web').hide();
                    $('button.add_info').prop('disabled', true);
                    $('button.continue').prop('disabled', true);
                    //Modal show
                    $('#BNC_domain_exist_web_modal').modal('show');
                    return false;
                }
                // if(res.status==true){
                //     toastr.success(res.msg+domain);
                // }
            });

        }else{
             seft.parent(seft).find('span.BNC_error').show();
             seft.parent().addClass('has-error');
             //console.log(seft);
             //seft.focus();
             $('button.add_info').prop('disabled', true);
             $('button.continue').prop('disabled', true);
             return false;
        }
       
    })

   }
   var submitAddDomain=function(){
        $('body').on('click', '.continue', function(event) {
            event.preventDefault();
        
            var selections = [];
            var domain=[];
            $("option:selected").each(function(){
                var optionValue = $(this).val();
                selections.push(optionValue);
            });
            $("input.BNC_infomation_domain").each(function(){
                var domainValue = $(this).val();
                domain.push(domainValue);
            });
            // console.log(selections);
            // console.log(domain);
            $.ajax({
                url: urlLoad,
                type: 'POST',
                dataType: 'json',
                data: {list_ip: selections,list_domain:domain},
                success:function(res){
                    console.log(res);
                    $.each(domain, function(k, v) {
                         domainlist_array.push(v);
                    });
                    $("#BNC_body_add_domain" ).load( urlLoad+" #BNC_body_add_domain" );
                    
                   
                },
                error:function(e){
                    console.log(e);
                }
            });
                
             
            return false;
        });
   }

   var show_hide_tab_domain=function(){
        $('body').on('click', '.BNC_show_add_domain', function(event) {
            event.preventDefault();
            $(this).prop('disabled', true);
            $('.BNC_show_remove_domain').prop('disabled', false);
            $('#BNC_body_remove_domain').hide();
            $('#BNC_body_add_domain').show();
        });
        $('body').on('click', '.BNC_show_remove_domain', function(event) {
            event.preventDefault();
            $(this).prop('disabled', true);
            $('.BNC_show_add_domain').prop('disabled', false);

            $('#BNC_body_add_domain').hide();
            $('#BNC_body_remove_domain').show();  
        });
   }
   var removeDomain=function(){
       $('body').on('click','#BNC_remove_domain_button_modal',function(event){
            event.preventDefault();
            var domain=$(this).attr('data-domain');
            $.ajax({
                url: urlLoad,
                type: 'POST',
                dataType: 'json',
                data: {domainremove: domain},
            })
            .success(function(res) {
                console.log(1240);
                remove_Item_Arr(domainlist_array,domain);
                $('#domain-'+res.domain).remove();
                $('#BNC_remove_domain_modal').modal('hide');
            });
            
       })
   }
    return {
        //main function to initiate the module
        init: function () {
            initComponents();
            handleOtherInfo();
            infomationDomainVali();
            submitAddDomain();
            show_hide_tab_domain();
            removeDomain();
            deleteModal();
        },

    };
}();