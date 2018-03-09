var MenuListTop = function() {
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
            var lang = $("#menulistabove").attr('data-lang');
            var key = $this.parents('tr').attr('data-key');
            var deletefeed = $("#menulistabove").attr('data-lang-a');
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
                                    actionabove: 'deleteMenulistTop',
                                    key: key
                                },
                                success: function(data) {
                                    $this.parents('tr').remove();
                                    //Chuyển string sang mảng dùng split
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
    var activeStatusMenuabove = function() {
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
                    actionabove: 'activeStatusMenulistabove',
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
    var activeNofollowMenuabove = function() {
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
                    actionabove: 'activeNofollowMenulistabove',
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
    var deleteMultiID = function() {
        $('.delete_contactview_select').click(function() {
            var deletefeed = $("#menulistabove").attr('data-lang-j');
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">' + deletefeed + '</li>',
                title: "Xoá menu",
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
    var view = function() {
        var $modal = $('#contactview');
        $('.btn_view').click(function() {
            var $this = $(this);
            var img = $this.parents('tr').attr('data-img');
            var menu_img = $this.parents('tr').attr('data-menu-img');
            var menu_icon = $this.parents('tr').attr('data-menu-icon');
            var ct_img = $this.parents('tr').find('.ct_img').html();
            var ct_icon = $this.parents('tr').find('.ct_icon').html();
            var name = $this.parents('tr').attr('ct-name');
            // create the backdrop and wait for next modal to be triggered
            bootbox.dialog({
                title: img + name,
                message: '<div class="row">  ' + '<div class="col-md-12"> ' + '<table class="table table-bordered table-advance table-hover"> ' + '<tr > ' + '<td width="170">' + menu_img + '</td>' + '<td>' + ct_img + '</td> ' + '</tr> ' + '<tr> ' + '<td width="170">' + menu_icon + '</td> ' + '<td>' + ct_icon + '</td>' + '</tr> ' + '</table> </div>  </div>',
                buttons: {
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
    var fastEdit = function() {
        var lang = $("#menulistabove").attr('data-lang');
        $.fn.editable.defaults.mode = '';
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
        $.fn.editable.defaults.mode = '';
        $('body').on('click', '.link-none', function(event) {
            event.preventDefault();
            var link=$(this).attr('data-original-title');
            var parent=$(this).parent('td');
            parent.find('input').val(link);
        });
        $('.link-none').editable({
            url: 'menu-ajax-lang-' + lang,
            type: 'text',
            name: 'editlinktoctNews',
            actionabove:1,   
            validate: function(value) { 
                if (!value.trim()) {
                    return 'Dữ liệu không được để trống!'; //DON'T CLOSE THE EDITABLE AREA!!!
                }
            },
            success: function(data, config) {
             $(this).attr('data-original-title',config);
             var parent=$(this).parent('td');
             parent.find('input').val(config);
             window.location.reload();
            }
        });
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
            source: source
        });
    }
    var editLink = function() {
        var lang = $("#menulistabove").attr('data-lang');
        //global settings 
        $.fn.editable.defaults.inputclass = 'form-control';
        var source = [{
            value: 1,
            text: 'Trang chủ'
        }, {
            value: 2,
            text: 'Trang chuyên mục'
        }];
        $.fn.editable.defaults.mode = '';
        $('.newslink').editable({
            url: 'menu-ajax-lang-' + lang,
            type: 'text',
            name: 'editlinktoctNews',
            source: source,
        });
    }
    var editImgNews = function() {
        $('.list-cat-img').mouseover(function() {
            $(this).find('.btn-change').show();
        }).mouseout(function() {
            $(this).find('.btn-change').hide();
        });
        $('input[type="file"]').change(function() {
            $this = $(this).parents('.btn-all');
            $this.find('.btn-save').remove();
            if ($(this).val() != '') {
                $this.append('<input type="button" value="Lưu" class="btn btn-xs default btn-save">');
            }
        });
        //Lưu ảnh khi đã chọn ảnh ok
    }
    var saveImgNews = function() {
            $(".btn-save").live('click', function() {
                var $this = $(this).parents('tr');
                $this.remove('input[name="id_img"]');
                $this.append('<input type="hidden" name="id_img" id="id_img" value="' + $this.attr('data-key') + '" />');
                $('input[name="action"]').val("saveImgFast");
                $('#form_menulistabove').submit();
            });
        }
        /*
          var changelink=function(){
           $this.parents('tr').find('.linktoct1').html();
            if($this.parents('tr').find('.linktoct1').html().length<1){
                $('.linktoct1').hide();
                $('.linkto1').show();
            }
           }*/
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
                            forms = $('#form_menulistabove');
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
            editImgNews();
            saveImgNews();
            deleteMenu();
            activeStatusMenuabove();
            deleteMultiID();
            checkboxAll();
            enableDelete();
            view();
            activeNofollowMenuabove();
            fastEdit();
            copyMenu();
            editLink();
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