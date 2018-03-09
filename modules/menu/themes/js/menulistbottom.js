var MenuListBottom = function() {
    var checkboxAll = function() {
        $('#checkboxAll').click(function() {
            if ($(this).prop("checked") == true) {
                $('.checkboxes').each(function(index) {
                    $(this).prop("checked", true);
                    $(this).parent().addClass('checked');
                });
                $(".btn-del a").removeClass('disabled');
                $(".copy_category a").removeClass('disabled');
            } else if ($(this).prop("checked") == false) {
                $('.checkboxes').each(function(index) {
                    $(this).prop("checked", false);
                    $(this).parent().removeClass('checked');
                });
                $(".btn-del a").addClass('disabled');
                $(".copy_category a").addClass('disabled');
            }
            if ($('.checkboxes:checked').length > 0) {
                $(".btn-del a").removeClass('disabled');
                $(".copy_category a").removeClass('disabled');
            } else {
                $(".btn-del a").addClass('disabled');
                $(".copy_category a").addClass('disabled');
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
        $('.checkboxes').click(function() {
            if ($('.checkboxes:checked').length > 0) {
                $(".btn-del a").removeClass('disabled');
                $(".copy_category a").removeClass('disabled');
            } else {
                $(".btn-del a").addClass('disabled');
                $(".copy_category a").addClass('disabled');
            }
        });
    }
    var deleteMenu = function() {
        $('.delete_menu').click(function() {
            var $this = $(this);
            var lang = $("#menulistbelow").attr('data-lang');
            var key = $this.parents('tr').attr('data-key');
            var deletefeed = $("#menulistbelow").attr('data-lang-j');
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">' + deletefeed + '</li>',
                title: "Xoá menu",
                buttons: {
                    success: {
                        label: "Đồng ý",
                        className: "green",
                        callback: function() {
                            $.ajax({
                                url: 'menu-ajax-lang-' + lang,
                                type: 'POST',
                                data: {
                                    actionbelow: 'deleteMenulistBottom',
                                    key: key
                                },
                                success: function(data) {
                                    //Chuyển string sang mảng dùng split
                                    $this.parents('tr').remove();
                                    var data2 = data.split(",");
                                    $.each(data2, function(k, v) {
                                        $('#tr_' + v).remove(); //xoá thẻ html theo id (vd id="tr_220") <tr id="tr_220"></tr>
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
    var activeStatusMenubelow = function() {
        $('.active_status').click(function(e, data) {
            var $this = $(this);
            var statusCurren = $this.attr('data-status');
            var key = $this.parents('tr').attr('data-key');
            var lang = $this.parents('tr').attr('data-lang');
            if (statusCurren == 1) {
                var status = 0;
            } else {
                var status = 1;
            }
            $.ajax({
                url: 'menu-ajax-lang-' + lang,
                type: 'POST',
                data: {
                    actionbelow: 'activeStatusMenulistbelow',
                    key: key,
                    status: status
                },
                success: function(data) {
                    if (statusCurren == 1) {
                        $this.removeClass('green-stripe');
                        $this.addClass('red-stripe');
                        $this.text('Đang ẩn');
                        $this.attr('data-status', 0);
                    } else {
                        $this.removeClass('red-stripe');
                        $this.addClass('green-stripe');
                        $this.text('Đang hiện');
                        $this.attr('data-status', 1);
                    }
                }
            });
        });
    }
    var deleteMultiID = function() {
        $('.delete_contactview_select').click(function() {
            var deletefeed = $("#menulistbelow").attr('data-lang-j');
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">' + deletefeed + '</li>',
                title: "Xoá menu",
                buttons: {
                    success: {
                        label: "Đồng ý",
                        className: "green",
                        callback: function() {
                            //submit form khi nút submit không phải là button hoặc <input type="submit">
                            $('#form_menulistbelow').submit();
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
    var activeNofollowMenubottom = function() {
        $('.active_nofollow').click(function(e, data) {
            var $this = $(this);
            var nofollowCurren = $this.attr('data-nofollow');
            var key = $this.parents('tr').attr('data-key');
            var lang = $this.parents('tr').attr('data-lang');
            if (nofollowCurren == 1) {
                var nofollow = 0;
            } else {
                var nofollow = 1;
            }
            $.ajax({
                url: 'menu-ajax-lang-' + lang,
                type: 'POST',
                data: {
                    actionbelow: 'activeNofollowMenulistbelow',
                    key: key,
                    nofollow: nofollow
                },
                success: function(data) {
                    if (nofollowCurren == 1) {
                        $this.removeClass('green-stripe');
                        $this.addClass('red-stripe');
                        $this.text('No');
                        $this.attr('data-nofollow', 0);
                    } else {
                        $this.removeClass('red-stripe');
                        $this.addClass('green-stripe');
                        $this.text('Yes');
                        $this.attr('data-nofollow', 1);
                    }
                }
            });
        });
    }
    var fastEdit = function() {
        var lang = $("#menulistbelow").attr('data-lang');
        $.fn.editable.defaults.mode = 'inline';
        //global settings 
        $.fn.editable.defaults.inputclass = 'form-control';
        $('.newsItem').editable({
            url: 'menu-ajax-lang-' + lang,
            type: 'text',
            name: 'editTitleMenu',
            validate: function(value) {
                if (!value.trim()) {
                    return 'Dữ liệu không được để trống!'; //DON'T CLOSE THE EDITABLE AREA!!!
                }
            },
            success: function(data, config) {
                console.log(data);
                console.log(config);
            }
        });
        // $('body').on('click', '.link', function(event) {
        //     event.preventDefault();
        //     var link = $(this).attr('data-original-title');
        //     var parent = $(this).parent('td');
        //     parent.find('input').val(link);
        // });
        $.fn.editable.defaults.mode = '';
        // $('.link').editable({
        //     url: 'menu-ajax-lang-' + lang,
        //     type: 'text',
        //     name: 'editlinktoctNews',
        //     validate: function(value) {
        //         if (!value.trim()) {
        //             return 'Dữ liệu không được để trống!'; //DON'T CLOSE THE EDITABLE AREA!!!
        //         }
        //     },
        //     success: function(data, config) {
        //         $(this).attr('data-original-title', config);
        //         var parent = $(this).parent('td');
        //         parent.find('input').val(config);
        //         window.location.reload();
        //     }
        // });
        var string = '';
        for (var i = 0; i < 50; i++) {
            string += "{value: " + i + ", text: '" + i + "'},";
        }
        source = '[' + string + ']';
        $.fn.editable.defaults.mode = '';
        $('.sortItem').editable({
            url: 'menu-ajax-lang-' + lang,
            type: 'text',
            name: 'editSortNews',
            validate: function(value) {
                if (!value.trim()) {
                    return 'Dữ liệu không được để trống!'; //DON'T CLOSE THE EDITABLE AREA!!!
                }
            },
            source: source
        });
    }
    var editLinktoct = function() {
        $('.newsLink').click(function() {
            var $this = $(this);
            var lang = $this.parents('tr').attr('data-lang');
            var key = $this.parents('tr').attr('data-key');
            bootbox.dialog({
                title: 'Sửa nhanh link tới trang nội dung',
                message: '<div class="row">  ' + '<div class="col-md-8"> ' + '<select class="form-control" name="editLink" data-error="{lang contactinfo_error}">' + '<option value="Trang chu">Trang chủ</option>' + '<option value="Trang lien he">Trang liên hệ</option>' + '<option value="Trang gioi thieu">Trang giới thiệu</option>' + '<option value="Trang tin tuc">Trang tin tức</option>' + '<option value="Trang san pham">Trang sản phẩm</option>' + '</select>' + '</div>  </div>',
                buttons: {
                    success: {
                        label: "Lưu",
                        className: "green",
                        callback: function() {
                            /* $('#form_menulistabove').submit();*/
                            var linktoct = $('select').val();
                            $.ajax({
                                url: 'menu-ajax-lang-' + lang,
                                type: 'POST',
                                data: {
                                    actionbelow: 'editLink',
                                    key: key,
                                    linktoct: linktoct
                                },
                                success: function(data) {
                                    $this.text(linktoct)
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
    var copyMenu = function() {
        $('.copyCats').click(function() {
            var $this = $(this);
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Sao chép menu này thì toàn bộ menu con được sao chép theo. Bạn chắc chắn sao chép ?</li>',
                title: "Sao chép danh mục",
                buttons: {
                    success: {
                        label: "Đồng ý",
                        className: "green",
                        callback: function() {
                            forms = $('#form_menulistbelow');
                            forms.append('<input type="hidden" value="copyMenu" name="action">');
                            forms.submit();
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
    return {
        //main function to initiate the module
        init: function() {
            //editLinktoct();
            activeNofollowMenubottom();
            fastEdit();
            deleteMenu();
            activeStatusMenubelow();
            deleteMultiID();
            checkboxAll();
            enableDelete();
            copyMenu();
            // handle editable elements on hidden event fired
            $('#contactview .editable').on('hidden', function(e, reason) {
                if (reason === 'save' || reason === 'nochange') {
                    var $next = $(this).closest('tr').next().find('.editable');
                    if ($('#autoopen').is(':checked')) {
                        setTimeout(function() {
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