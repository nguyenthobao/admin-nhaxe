var Product = function () {
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
    }
   

    return {
        //main function to initiate the module
        init: function () {
            initComponents();
            handleOtherInfo();



        
        
        },

    };
}();