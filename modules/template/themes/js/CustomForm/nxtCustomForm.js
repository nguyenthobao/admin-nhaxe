var arrayTitleField = [];
var arrayNameField = [];

$("#NXT_form").disableSelection();

function ajax_global(dataString, urlSend, method, type) {
    var res = '';
    $.ajax({
        url: $('base').attr('href') + urlSend + '-lang-' + lang,
        type: method,
        async: false,
        dataType: type,
        data: dataString,
    })
        .success(function(res) {
            result = res;
        })
        .error(function(error) {
            console.log(error);
        });
    return result;
}
var nxtCustomForm = function() {
    var handleFixAutoVal = function() {
        $('body').on('change keyup', '#NXT_modal_clone input', function(event) {
            event.preventDefault();
            var vl = $(this).val();
            $(this).attr('value', vl);
        });
    }
    var handleOnload = function() {
        $('body').find('input[type="radio"]').css({
            marginLeft: '-10px'
        });
        $('div.radio').css({
            marginTop: '-10px'
        });
        $("#NXT_sortable,.NXT_tab_content").disableSelection();
    }
    var handleRemove = function() {
        $('body').on('click', '.redColorNxt', function(event) {
            event.preventDefault();
            var NXT_parent = $(this).parent().parent();
            var classOr = NXT_parent.attr('data-class');
            var positonOr = $('.NXT_tab_content').find('.' + classOr);
            var offSet = positonOr.offset();
            NXT_parent.animate({
                top: offSet.top * (-1),
                //left: offSet.left*(-1),
            }, 500, function() {
                $(this).remove();
            });
            //Remove modal
            var modal_id = $(this).attr('data-id-modal');
            $('#' + modal_id).remove();

            // NXT_parent.slideUp('400', function() {
            //     NXT_parent.remove();
            // });
        });
    }
    var handleSetting = function() {
        $('body').on('click', '.NXT_setting', function(event) {
            event.preventDefault();
            var modal_id = $(this).attr('data-id-modal');
            $('body').find('#NXT_modal_clone').find('#' + modal_id).modal('show');
        });
    }
    var handleSaveEditInput = function() {
        $('body').on('click', '.NXT_save_edit_input', function(event) {
            event.preventDefault();
            var inputClass = $(this).parent().parent().parent().parent();
            var id = inputClass.attr('id');
            var inputDrag = $('body').find('.' + id);
            var classInput = inputDrag.attr('data-class');
            var name = inputClass.find('input[name="label"]').val();
            var required = inputClass.find('input[name="require"]').parent('span').hasClass('checked');
            if (required == true) {
                inputClass.find('input[name="require"]').attr('checked', 'checked');
            }
            var pro_name = inputClass.find('input[name="name"]').val();
            if (classInput == 'input_1_1' || classInput == 'input_1_2' || classInput == 'input_1_5') {
                var valueDefault = inputClass.find('input[name="default"]').val();
                var placeholder = inputClass.find('input[name="placeholder"]').val();
                inputDrag.find('label').text(name + ':');
                inputDrag.find('input').val(valueDefault);
                inputDrag.find('input').attr('placeholder', placeholder);
                if (required == true) {
                    inputDrag.find('input').attr('required', required);
                }
                //inputDrag.find('input').attr('name',pro_name);
            } else if (classInput == 'input_1_3') {
                var valueDefault = inputClass.find('input[name="default"]').val();
                var placeholder = inputClass.find('input[name="placeholder"]').val();
                //Or
                var min = parseInt(inputClass.find('input[name="min"]').val());
                var max = parseInt(inputClass.find('input[name="max"]').val());
                inputDrag.find('label').text(name + ':');
                inputDrag.find('input').val(valueDefault);
                inputDrag.find('input').attr('placeholder', placeholder);
                inputDrag.find('input').attr('min', min);
                inputDrag.find('input').attr('max', max);
                if (required == true) {
                    inputDrag.find('input').attr('required', required);
                }
                //inputDrag.find('input').attr('name',pro_name);
            } else if (classInput == 'input_1_4') {
                var valueDefault = inputClass.find('input[name="default"]').val();
                var placeholder = inputClass.find('input[name="placeholder"]').val();
                inputDrag.find('label').text(name + ':');
                inputDrag.find('textarea').val(valueDefault);
                inputDrag.find('textarea').attr('placeholder', placeholder);
                if (required == true) {
                    inputDrag.find('input').attr('required', required);
                }
                //inputDrag.find('input').attr('name',pro_name);
            } else if (classInput == 'input_2_1' || classInput == 'input_2_2') {
                var valueDefault = inputClass.find('input[name="default"]').val();
                inputDrag.find('label').text(name + ':');
                var allSelect = inputClass.find('input');
                var arraySelect = [];
                $.each(allSelect, function(k, v) {
                    if ($(this).attr('name') != 'name' && $(this).attr('name') != 'default' && $(this).attr('name') != 'label') {
                        var tmp_name_option = $(this).val();
                        if (tmp_name_option != undefined && tmp_name_option !== '1') {
                            arraySelect.push(tmp_name_option);
                        }
                    }
                });
                var htmlSelect = '';
                $.each(arraySelect, function(k, v) {
                    if (k % 2 == 0) {
                        var tmp_name = v;
                        var tmp_value = arraySelect[k + 1];
                        if (tmp_name === valueDefault) {
                            htmlSelect += '<option selected value="' + tmp_value + '">' + tmp_name + '</option>';
                        } else {
                            htmlSelect += '<option value="' + tmp_value + '">' + tmp_name + '</option>';
                        }

                    }
                });

                inputDrag.find('select').html(htmlSelect);
                if (required == true) {
                    inputDrag.find('input').attr('required', required);
                }
                //inputDrag.find('select').attr('name',pro_name);
            } else if (classInput == 'input_2_3') {
                var allSelect = inputClass.find('input');
                var arraySelect = [];
                console.log(arraySelect);
                $.each(allSelect, function(k, v) {
                    if ($(this).attr('name') != 'name' && $(this).attr('name') != 'default' && $(this).attr('name') != 'label') {
                        var tmp_name_option = $(this).val();
                        if (tmp_name_option != undefined && tmp_name_option !== '1') {
                            arraySelect.push(tmp_name_option);
                        }

                    }
                });
                var htmlCheckbox = '<label>' + name + ':</label><br/>';
                $.each(arraySelect, function(k, v) {
                    if (k % 3 == 0) {
                        var tmp_label = v;
                        var tmp_name = arraySelect[k + 1];
                        var tmp_value = arraySelect[k + 2];
                        htmlCheckbox += '<label>' + tmp_label + '</label><input type="checkbox" value="' + tmp_value + '" name="' + tmp_name + '"/>';
                    }
                });
                inputDrag.children(':first-child').html(htmlCheckbox);
                $(':checkbox').uniform();
            } else if (classInput == 'input_2_4') {
                var allSelect = inputClass.find('input');
                var valueDefault = inputClass.find('input[name="default"]').val();
                var arraySelect = [];
                $.each(allSelect, function(k, v) {
                    if ($(this).attr('name') != 'name' && $(this).attr('name') != 'default' && $(this).attr('name') != 'label') {
                        var tmp_name_option = $(this).val();
                        if (tmp_name_option != undefined && tmp_name_option !== '1') {
                            arraySelect.push(tmp_name_option);
                        }

                    }
                });
                var htmlRadio = '<label>' + name + ':</label><br/>';
                $.each(arraySelect, function(k, v) {
                    if (k % 2 == 0) {
                        var tmp_label = v;
                        var tmp_value = arraySelect[k + 1];
                        if (tmp_label == valueDefault) {
                            htmlRadio += '<label>' + tmp_label + '</label><input  type="radio" checked value="' + tmp_value + '" name="' + pro_name + '"/>&nbsp;';
                        } else {
                            htmlRadio += '<label>' + tmp_label + '</label><input  type="radio" value="' + tmp_value + '" name="' + pro_name + '"/>&nbsp;';
                        }

                    }
                });
                inputDrag.children(':first-child').html(htmlRadio);
                $(':radio').uniform();
                $('.radio').css({
                    marginTop: '-10px'
                });
                $('input[type="radio"]').css({
                    marginLeft: '-10px'
                });

            } else if (classInput == 'input_3_1' || classInput == 'input_3_2') {
                inputDrag.find('button:first-child').text(name);
            } else if (classInput == 'input_3_3') {
                inputDrag.find('label').text(name);
                //inputDrag.find('input[type="file"]').attr('name',pro_name);
            } else if (classInput == 'input_3_4') {
                var allSelect = inputClass.find('input');
                var arraySelect = [];
                $.each(allSelect, function(k, v) {
                    if ($(this).attr('name') != 'name' && $(this).attr('name') != 'default' && $(this).attr('name') != 'label') {
                        var tmp_name_option = $(this).val();
                        if (tmp_name_option != undefined) {
                            arraySelect.push(tmp_name_option);
                        }

                    }
                });

                var htmlButton = '';
                $.each(arraySelect, function(k, v) {
                    if (k % 2 == 0) {
                        var tmp_label = v;
                        var tmp_type = arraySelect[k + 1];
                        htmlCheckbox += '<button type="button" data-type="' + tmp_type + '" class="btn btn-default">' + tmp_label + '</button>&nbsp;';
                    }
                });
                inputDrag.find('button').remove();
                $(htmlCheckbox).prependTo(inputDrag);

            }

            inputClass.modal('hide');
        });
    }

    var handleDrag = function() {
        $("#NXT_ul").sortable({
            revert: true
        });
        $(".NXT_drag").draggable({
            connectToSortable: "#NXT_ul",
            accept: '#NXT_ul',
            appendTo: "body",
            helper: "clone",
            cursor: 'move',
            revert: "invalid",
            start: function(event, ui) {
                var myDrag = ui.helper;
                myDrag.width($(this).width());
            },
            stop: function(event, ui) {

                //Xu ly su kien keo tha dung lai
                //Chuoi random
                var NXT_random = handleRanDom(32);
                var myDrag = ui.helper;
                var myClassInput = myDrag.attr('data-class');

                var html = '<div class="removeNXT"><a href="javascript:void(0)" class="NXT_setting" data-id-modal="' + NXT_random + '"><i class="fa fa-cog fa-15x"></i></a> <a href="javascript:void(0)" class="redColorNxt" data-id-modal="' + NXT_random + '"><i class="fa fa-times-circle-o fa-15x"></i></a></div>';
                myDrag.addClass('hoverShowAction');
                myDrag.append(html);
                //Them 1 du lieu vao
                myDrag.attr('data-id-modal', NXT_random);
                myDrag.addClass(NXT_random);
                //Tim modal va nhan ban
                $('body').find('#NXT_modal_' + myClassInput).clone().appendTo('#NXT_modal_clone').attr('id', NXT_random);
                var firstChild = myDrag.children(':first-child');
                if (firstChild.find('.checker').length >= 1) {
                    firstChild.find('.checker').remove();
                    firstChild.append('<input value="1" name="checkbox_1" type="checkbox" class="form-control"/>');
                } else if (firstChild.find('.radio').length >= 1) {
                    firstChild.find('.radio').remove();
                    firstChild.find('label:last-child').each(function(k, v) {
                        $('<input value="' + parseInt(k + 1) + '" type="radio" name="radio_1" class="form-control"/>').insertAfter($(this));
                    });
                }
                $(':checkbox,:radio').uniform();
                $('.radio').css({
                    marginTop: '-10px'
                });
                $('input[type="radio"]').css({
                    marginLeft: '-10px'
                });
            }
        });
        $("#NXT_ul").droppable({
            accept: '.NXT_drag',
            hoverClass: "NXT_remove",
            drop: function(ev, ui) {},
            out: function(event, ui) {
                var myDrop = ui.helper;
                myDrop.remove();
            },
        });
    }

    var handleRanDom = function(len, charSet) {
        charSet = charSet || 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var randomString = '';
        for (var i = 0; i < len; i++) {
            var randomPoz = Math.floor(Math.random() * charSet.length);
            randomString += charSet.substring(randomPoz, randomPoz + 1);
        }
        return randomString;
    }
    var handleRemoveSelect = function() {
        $('body').on('click', '.remove_select', function(event) {
            event.preventDefault();
            var parent = $(this).parent().parent();
            var parentNext = parent.next();
            if (parentNext.children(':first-child').text() == '') {
                parentNext.children(':first-child').text(parent.children(':first-child').text());
            }
            parent.remove();
        });
    }

    var handleNewSelect = function() {
        $('body').on('click', '.new_select', function(event) {
            event.preventDefault();
            var parent = $(this).parent().parent();
            var parentForm = parent.parent();
            parent.clone().appendTo(parentForm).find('input').val('');
            $(this).removeClass('new_select').addClass('remove_select');
            $(this).html('<i class="fa fa-minus"></i>');
        });
    }

    var handleRemoveCheckbox = function() {
        $('body').on('click', '.remove_checkbox', function(event) {
            event.preventDefault();
            var parent = $(this).parent().parent();
            var parentNext = parent.next();
            if (parentNext.children(':first-child').text() == '') {
                parentNext.children(':first-child').text(parent.children(':first-child').text());
            }
            parent.remove();
        });
    }

    var handleNewCheckbox = function() {
        $('body').on('click', '.new_checkbox', function(event) {
            event.preventDefault();
            var parent = $(this).parent().parent();
            var parentForm = parent.parent();
            parent.clone().appendTo(parentForm).children(':first-child').text('');
            parentForm.children(':last-child').find('input').val('');
            $(this).removeClass('new_checkbox').addClass('remove_checkbox');
            $(this).html('<i class="fa fa-minus"></i>');
        });
    }

    var handleRemoveRadio = function() {
        $('body').on('click', '.remove_radio', function(event) {
            event.preventDefault();
            var parent = $(this).parent().parent();
            var parentNext = parent.next();
            if (parentNext.children(':first-child').text() == '') {
                parentNext.children(':first-child').text(parent.children(':first-child').text());
            }
            parent.remove();
        });
    }

    var handleNewRadio = function() {
        $('body').on('click', '.new_radio', function(event) {
            event.preventDefault();
            var parent = $(this).parent().parent();
            var parentForm = parent.parent();
            parent.clone().appendTo(parentForm).children(':first-child').text('');
            parentForm.children(':last-child').find('input').val('');
            $(this).removeClass('new_radio').addClass('remove_radio');
            $(this).html('<i class="fa fa-minus"></i>');
        });
    }

    var handleRemoveButton = function() {
        $('body').on('click', '.remove_button', function(event) {
            event.preventDefault();
            var parent = $(this).parent().parent();
            var parentNext = parent.next();
            if (parentNext.children(':first-child').text() == '') {
                parentNext.children(':first-child').text(parent.children(':first-child').text());
            }
            parent.remove();
        });
    }

    var handleNewButton = function() {
        $('body').on('click', '.new_button', function(event) {
            event.preventDefault();
            var parent = $(this).parent().parent();
            var parentForm = parent.parent();
            parent.clone().appendTo(parentForm).children(':first-child').text('');
            parentForm.children(':last-child').find('input').val('');
            $(this).removeClass('new_radio').addClass('remove_radio');
            $(this).html('<i class="fa fa-minus"></i>');
        });
    }

    var handleSaveForm = function() {
        $('body').on('click', '.continue, .NXT_save_form', function(event) {
            event.preventDefault();
            var name_form = $('input[name="name_form"]').val();
            var id_form = $('input[name="id_form"]').val();
            if (name_form == '' && id_form == '') {
                $('#name_form').modal('show');
                return false;
            } else {
                var form_frontend = handleAnalyzeForm();
                var trimForm = form_frontend.trim();
                if (trimForm == '') {
                    toastr.error('Hãy thiết kế form trước khi lưu.');
                    $('.NXT_progress').slideUp();
                    return false;
                } else {
                    var form_backend = handleFormBackEnd();
                    var form_modal_backend = handleFormModalBackEnd();

                    if (id_form == '') {
                        var result = handleSaveFormToData(form_backend, form_modal_backend, form_frontend, name_form, null);
                    } else {
                        var result = handleSaveFormToData(form_backend, form_modal_backend, form_frontend, name_form, id_form);
                    }
                    if (result.status == true) {

                        toastr.success(result.message);
                        setTimeout(function() {

                            if ($(this).attr('data-continue') != undefined && $(this).attr('data-continue') == 'slidelist') {
                                location.reload();
                            } else {
                                location.href = '/template-customForm-listForm-lang-' + lang;
                            }
                        }, 3000);
                    }
                }
            }
        });
    }
    var handleFormBackEnd = function() {
        return $('body').find('#NXT_sortable').children('ul').html().toString();
    }
    var handleFormModalBackEnd = function() {
        return $('body').find('#NXT_modal_clone').html().toString();
    }

    var handleAnalyzeForm = function() {
        //Clone
        var nxt_clone = $('body').find('#NXT_tmp_clone_form_basic');
        nxt_clone.empty();
        $('#NXT_ul').clone().appendTo("#NXT_tmp_clone_form_basic");
        //remove all parent
        var allItem = $('#NXT_tmp_clone_form_basic').children(':first-child').find('.borderInput');
        allItem.find('.removeNXT').remove();
        $('.NXT_progress').slideDown();
        for (var i = 0; i <= 100; i++) {
            $('.NXT_progress').children('div').attr('aria-valuenow', i).text(i + '%').css({
                width: i + '%',
            });
            allItem.find('input,textarea,select,button').unwrap().removeAttr('class');
        };
        //Process name
        var all_after_clone = $('#NXT_tmp_clone_form_basic').find('input,select,textarea');
        var all_after_clone_button = $('#NXT_tmp_clone_form_basic').find('button');
        all_after_clone_button.each(function(k, v) {
            var tmp_type = $(this).attr('data-type');
            $(this).removeAttr('data-type');
            $(this).attr('type', tmp_type);
        });
        var data_name = [];

        all_after_clone.each(function(k, v) {
            $(this).removeAttr('style');
            var tmp_name = $(this).attr('name');
            if ($.inArray(tmp_name, data_name) == -1) {
                data_name.push(tmp_name);
            } else {
                var tmp_name_new = $(this).attr('name') + '_' + k;
                $(this).attr('name', tmp_name_new);
                data_name.push(tmp_name_new);
            }
        });

        var all_after_clone_label = $('#NXT_tmp_clone_form_basic').find('label');
        all_after_clone_label.each(function(k, v) {
            if ($(this).next().is('label') != true) {
                var tmp_name_label = $(this).next().attr('name');
                var tmp_text_label = $(this).text();

                arrayTitleField.push(tmp_text_label);
                arrayNameField.push(tmp_name_label);
            }
        });
        console.log(arrayTitleField);
        console.log(arrayNameField);
        return $('#NXT_tmp_clone_form_basic').children('ul').html().toString();
    }

    var handleSaveFormToData = function(form_backend, modal_backend, form_frontend, title, id) {
        var dataString = {
            'id': id,
            'title': title,
            'form_backend': form_backend,
            'modal_backend': modal_backend,
            'form_frontend': form_frontend,
            'arrayTitleField': arrayTitleField,
            'arrayNameField': arrayNameField,
        };
        var urlSend = '/template-customForm-saveForm';
        var data = ajax_global(dataString, urlSend, 'POST', 'json');
        return data;
    }

    var array2json = function(arr) {
        var parts = [];
        var is_list = (Object.prototype.toString.apply(arr) === '[object Array]');

        for (var key in arr) {
            var value = arr[key];
            if (typeof value == "object") { //Custom handling for arrays
                if (is_list) parts.push(array2json(value)); /* :RECURSION: */
                else parts.push('"' + key + '":' + array2json(value)); /* :RECURSION: */
                //else parts[key] = array2json(value); /* :RECURSION: */
            } else {
                var str = "";
                if (!is_list) str = '"' + key + '":';

                //Custom handling for multiple data types
                if (typeof value == "number") str += value; //Numbers
                else if (value === false) str += 'false'; //The booleans
                else if (value === true) str += 'true';
                else str += '"' + value + '"'; //All other things
                // :TODO: Is there any more datatype we should be in the lookout for? (Functions?)

                parts.push(str);
            }
        }
        var json = parts.join(",");

        if (is_list) return '[' + json + ']'; //Return numerical JSON
        return '{' + json + '}'; //Return associative JSON
    }


    return {
        //main function to initiate the module
        init: function() {
            handleOnload();
            handleDrag();
            handleRemove();
            handleSetting();
            handleSaveEditInput();
            handleRemoveSelect();
            handleNewSelect();
            handleNewCheckbox();
            handleRemoveCheckbox();
            handleNewRadio();
            handleRemoveRadio();
            handleNewButton();
            handleRemoveButton();
            handleSaveForm();
            handleFixAutoVal();
        }
    };
}();