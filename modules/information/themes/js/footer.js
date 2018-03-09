var Footer = function() {
    var initComponents = function() {
        //init maxlength handler
        $('.maxlength-handler').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            threshold: 5
        });
        CKEDITOR.replace( 'editorFooter');


        // CKEDITOR.replace('editorFooter', {
        //     toolbar: [{
        //             name: 'document',
        //             items: ['Source', '-', 'Save', 'NewPage', 'DocProps', 'Preview', 'Print', '-', 'Templates']
        //         }, {
        //             name: 'clipboard',
        //             items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
        //         }, {
        //             name: 'editing',
        //             items: ['Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt']
        //         }, {
        //             name: 'forms',
        //             items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton',
        //                 'HiddenField'
        //             ]
        //         },
        //         '/', {
        //             name: 'basicstyles',
        //             items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']
        //         }, {
        //             name: 'paragraph',
        //             items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv',
        //                 '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'
        //             ]
        //         }, {
        //             name: 'links',
        //             items: ['Link', 'Unlink', 'Anchor']
        //         }, {
        //             name: 'insert',
        //             items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']
        //         },
        //         '/', {
        //             name: 'styles',
        //             items: ['Styles', 'Format', 'Font', 'FontSize']
        //         }, {
        //             name: 'colors',
        //             items: ['TextColor', 'BGColor']
        //         }, {
        //             name: 'tools',
        //             items: ['Maximize', 'ShowBlocks', '-', 'About']
        //         }
        //     ]
        // });
        CKEDITOR.config.entities = false;
        CKEDITOR.config.basicEntities = false;
        CKEDITOR.config.entities_greek = false;
        CKEDITOR.config.entities_latin = false;
        CKEDITOR.config.extraAllowedContent = 'div(!fb-page)[data-*]';
        CKEDITOR.config.extraPlugins = 'lineheight';
        CKEDITOR.config.extraPlugins = 'eqneditor';
        CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;


    }
    var handleOtherInfo = function() {
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
            if (label != '') {
                $(this).parents('.form-group').next().find('.control-label').text(label);
            }
            $(this).parents('.form-group').remove();
        });
    }

    var handlSaveAds = function() {
        $('input[name="on_off_ads_footer"]').on('switchChange.bootstrapSwitch', function(event, state) {
            if (state == true) {
                var status = 1;
            } else {
                var status = 0;
            }
            var dataString = {
                'status': status
            };
            var urlSend = '/information-ajaxAdsFooter-lang-vi';
            $.ajax({
                    url: urlSend,
                    type: 'POST',
                    dataType: 'json',
                    data: dataString,
                })
                .success(function(res) {
                    if (res.status == true) {
                        toastr.success(res.message);
                    }
                    if (status == 1) {
                        $('.status_ads_footer').text(' Bật');
                    } else {
                        $('.status_ads_footer').text(' Tắt');
                    }
                });


        });
    }
    return {
        //main function to initiate the module
        init: function() {
            initComponents();
            handleOtherInfo();
            handlSaveAds();
        },

    };
}();