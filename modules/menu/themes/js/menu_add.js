var menu_add = function() {
    var handleSelectContent = function() {
        $('body').on('change', 'input[name="op"]', function(event) {
            event.preventDefault();
            var op = $(this).val();
            if (op == 1) {
                $('.link').slideUp();
                $('.content').slideDown();
            } else {
                $('.content').slideUp();
                $('.link').slideDown();
            }
        });
    };
    var handleSelectTypeParent = function() {
        $('body').on('change', 'input[name="type"]', function(event) {
            event.preventDefault();
            var type = $(this).val();
            var dataString = {
                'type': type
            };
            var urlSend = '/menu-menu-ajaxLoadParent';
            var data = ajax_global(dataString, urlSend, 'POST', 'html');
            $('.parentmenu').html(data);
        });
    };
    var handleUploadimg_news = function() {
        var $el2 = $("#menu_img");
        if (typeof menu_img != 'undefined' && typeof statics != 'undefined' && menu_img != '') {
            $el2.fileinput({
                uploadUrl: baseUrl + '/menu-menu-upload-lang-' + lang,
                uploadAsync: false,
                maxFileCount: 1,
                overwriteInitial: false,
                validateInitialCount: true,
                showUpload: false, // hide upload button
                showRemove: false, // hide remove button
                initialPreview: [
                    "<img src='" + statics + "/" + menu_img + "'>",
                ],
                initialPreviewConfig: [{
                    url: baseUrl + "/menu-menu-deleteImg-lang-" + lang,
                    key: menu_img
                }, ],
                uploadExtraData: function() { // callback example
                    var out = {},
                        key, i = 0;
                    $('.kv-input:visible').each(function() {
                        $el = $(this);
                        key = $el.hasClass('kv-new') ? 'new_' + i : 'init_' + i;
                        out[key] = $el.val();
                        i++;
                    });
                    return out;
                },
                deleteExtraData: {
                    type: 'menu_img'
                }
            }).on("filebatchselected", function(event, files) {
                $el2.fileinput("upload");
            });
        } else {
            $el2.fileinput({
                uploadUrl: baseUrl + '/menu-menu-upload-lang-' + lang,
                uploadAsync: false,
                maxFileCount: 1,
                overwriteInitial: false,
                validateInitialCount: true,
                showUpload: false, // hide upload button
                showRemove: false, // hide remove button
                uploadExtraData: function() { // callback example
                    var out = {},
                        key, i = 0;
                    $('.kv-input:visible').each(function() {
                        $el = $(this);
                        key = $el.hasClass('kv-new') ? 'new_' + i : 'init_' + i;
                        out[key] = $el.val();
                        i++;
                    });
                    return out;
                },
                deleteExtraData: {
                    type: 'menu_img'
                }
            }).on("filebatchselected", function(event, files) {
                $el2.fileinput("upload");
            });
        }
    };
    var handleUploadicon_news = function() {
        var $el2 = $("#menu_icon");
        if (typeof menu_icon != 'undefined' && typeof statics != 'undefined' && menu_icon != '') {
            $el2.fileinput({
                uploadUrl: baseUrl + '/menu-menu-upload-lang-' + lang,
                uploadAsync: false,
                maxFileCount: 1,
                overwriteInitial: false,
                validateInitialCount: true,
                showUpload: false, // hide upload button
                showRemove: false, // hide remove button
                initialPreview: [
                    "<img src='" + statics + "/" + menu_icon + "'>",
                ],
                initialPreviewConfig: [{
                    url: baseUrl + "/menu-menu-deleteImg-lang-" + lang,
                    key: menu_icon
                }, ],
                uploadExtraData: function() { // callback example
                    var out = {},
                        key, i = 0;
                    $('.kv-input:visible').each(function() {
                        $el = $(this);
                        key = $el.hasClass('kv-new') ? 'new_' + i : 'init_' + i;
                        out[key] = $el.val();
                        i++;
                    });
                    return out;
                },
                deleteExtraData: {
                    type: 'menu_icon'
                }
            }).on("filebatchselected", function(event, files) {
                $el2.fileinput("upload");
            });
        } else {
            $el2.fileinput({
                uploadUrl: baseUrl + '/menu-menu-upload-lang-' + lang,
                uploadAsync: false,
                maxFileCount: 1,
                overwriteInitial: false,
                validateInitialCount: true,
                showUpload: false, // hide upload button
                showRemove: false, // hide remove button
                uploadExtraData: function() { // callback example
                    var out = {},
                        key, i = 0;
                    $('.kv-input:visible').each(function() {
                        $el = $(this);
                        key = $el.hasClass('kv-new') ? 'new_' + i : 'init_' + i;
                        out[key] = $el.val();
                        i++;
                    });
                    return out;
                },
                deleteExtraData: {
                    type: 'menu_icon'
                }
            }).on("filebatchselected", function(event, files) {
                $el2.fileinput("upload");
            });
        }
    };
    var handleAutoDetectNameMenu = function() {
        $('body').on('change', '#linktoct', function(event) {
            event.preventDefault();
            var valLink = $('#linktoct option:selected').text();
            valLink = replaceAll('-', '', valLink);
            var namemenu = $('input[name="namemenu"]');
            var id_lang_default = $('input[name="id_lang_default"]').val();
            if (id_lang_default == undefined) {
                namemenu.val(valLink);
                setTimeout(function(){
                    $('input[name="namemenu"]').trigger('keyup');
                },100);
            }

        });
    };

    var ajaxUrlSEO = function() {
        $('input[name="namemenu"]').keyup(function() {
            var category_name = $(this).val();
            $.ajax({
                url: 'product-brand-ajaxUrlSEO-lang-' + $('base').attr('lang'),
                type: 'POST',
                dataType: 'json',
                data: {
                    brand_name: category_name
                },
                success: function(res) {
                    $('input[name="alias"]').val(res.data);
                },
                error: function(res) {
                    console.log(res);
                },
            });
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handleSelectContent();
            handleSelectTypeParent();
            handleUploadimg_news();
            handleUploadicon_news();
            handleAutoDetectNameMenu();
            ajaxUrlSEO();
        }
    };
}();
$(function() {
    menu_add.init();
});