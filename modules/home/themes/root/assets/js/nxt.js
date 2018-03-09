var root = function() {
    var handleOnload = function() {
        $('.end_date_deal,input[name="start_date"],input[name="end_date"],input[name="bcake_begin_date"],input[name="bcake_end_date"]').datepicker({
            format: "dd/mm/yyyy",
            clearBtn: true,
            language: "vi",
            calendarWeeks: true,
            autoclose: true,
            todayHighlight: true,
        });
        handleLoadLogs();
        $('[data-toggle="tooltip"]').tooltip();
    };
    var handleCopyTheme = function() {
        $('body').on('click', '.copy_theme', function(event) {
            event.preventDefault();
            var src = $('input[name="id_theme_src"]').val();
            var des = $('input[name="id_theme_des"]').val();
            if (src == false) {
                $('input[name="id_theme_src"]').focus();
                toastr.error('Vui lòng điền ID theme nguồn');
                return false;
            } else if (des == false) {
                $('input[name="id_theme_des"]').focus();
                toastr.error('Vui lòng điền ID theme đích');
                return false;
            }
            $('#loaderCopyTheme').show();
            $.ajax({
                url: '/home-root-ajaxCopyTheme-lang-vi',
                type: 'POST',
                dataType: 'json',
                data: {
                    src: src,
                    des: des,
                },
            }).success(function(res) {
                if (res.status == true) {
                    toastr.success('Sao chép thành công');
                } else {
                    toastr.error(res.data);
                    $('input[name="id_theme_src"]').focus();
                }
                $('#loaderCopyTheme').hide();
            });
            return false;

        });
    }
    var handleSetApp = function() {
        $('body').on('click', '.change_apps', function() {
            var idw = parseInt($('#infoIdw').text());
            if (!isNaN(idw)) {

                var nxt_feature = [];
                var nxt_feature_name = [];
                var nxt_feature_date = [];
                $('.nxt_feature').each(function(k, v) {
                    var el = $(v);
                    nxt_feature_name.push(el.val());
                    nxt_feature.push(el.prop('checked'));
                });

                $('.nxt_feature_date').each(function(k, v) {
                    var el = $(v);
                    if (nxt_feature[k] == true && el.val() == false) {
                        toastr.error('Vui lòng set ngày sử dụng');
                        return false;
                    }
                    nxt_feature_date.push(el.val());
                });

                $.ajax({
                    url: '/home-root-setApp-lang-vi',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        idw: idw,
                        nxt_feature: nxt_feature,
                        nxt_feature_name: nxt_feature_name,
                        nxt_feature_date: nxt_feature_date,
                    },
                    success: function(data) {
                        if (data.status == true) {
                            toastr.success('Thành công');
                        } else {
                            toastr.error('Lỗi');
                        }
                    }

                });
                return false;
                console.log(nxt_feature);

                // if ($('#hot_deal').is(':checked')) {
                //         var hot_deal= 1;
                // }else{
                //             var hot_deal= 0;
                // }
                // var start_deal = $('input[name="start_date_deal"]').val();
                // var end_deal = $('input[name="end_date_deal"]').val();

                // if ($('#price_quantity').is(':checked')) {
                //             var price_quantity= 1;
                // }else{
                //             var price_quantity= 0;
                // }
                // var start_quantity = $('input[name="start_date_quantity"]').val();
                // var end_quantity = $('input[name="end_date_quantity"]').val();

                // if ($('#price_properties').is(':checked')) {
                //             var price_properties= 1;
                // }else{
                //             var price_properties= 0;
                // }
                // var start_properties = $('input[name="start_date_properties"]').val();
                // var end_properties = $('input[name="end_date_properties"]').val();

                // if ($('#price_big_quantity').is(':checked')) {
                //             var price_big_quantity= 1;
                // }else{
                //             var price_big_quantity= 0;
                // }
                // var start_big = $('input[name="start_date_big"]').val();
                // var end_big = $('input[name="end_date_big"]').val();

                // if ($('#auction').is(':checked')) {
                //             var auction= 1;
                // }else{
                //             var auction= 0;
                // }
                // var start_auction = $('input[name="start_date_auction"]').val();
                // var end_auction = $('input[name="end_date_auction"]').val();

                // alert(start_properties);

                // $.ajax({
                //     url: '/home-root-setApp-lang-vi',
                //     type: 'POST',
                //     data: {
                //         idw: idw,
                //         price_quantity: price_quantity,
                //         price_properties: price_properties,
                //         price_big_quantity: price_big_quantity,
                //         hot_deal: hot_deal,
                //         auction: auction,
                //         start_deal: start_deal,
                //         end_deal: end_deal,
                //         start_quantity: start_quantity,
                //         end_quantity: end_quantity,
                //         start_properties: start_properties,
                //         end_properties: end_properties,
                //         start_big: start_big,
                //         end_big: end_big,
                //         start_auction: start_auction,
                //         end_auction: end_auction
                //     },
                //     success: function(data) {
                //         //alert(data);
                //         toastr.success('Xét tính năng thành công !');
                //     }

                // });

                return false;

            } else {
                toastr.error("Khong co web de kich hoat");
            }


        });

    }
    var handleSetBcake = function() {
        $('body').on('click', '.change_bcake', function() {
            var email = $('#emailBcake').val();
            if (email!='') {
                var date_begin = $('input[name="bcake_begin_date"]').val();
                
                var date_end = $('input[name="bcake_end_date"]').val();
                if (date_begin == false || date_end == false) {
                        toastr.error('Vui lòng set ngày sử dụng');
                        return false;
                }
                $.ajax({
                    url: '/home-root-setBcake-lang-vi',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        email: email,
                        date_begin: date_begin,
                        date_end: date_end,
                    },
                    success: function(data) {
                       // console.log(data);
                        if (data.status == true) {
                            toastr.success('Kích hoạt Bcake thành công');
                        } else {
                            toastr.error('Lỗi');
                        }
                    }

                });
                return false;

            } else {
                toastr.error("Khong co email de kich hoat");
            }


        });

    }
    var handleGetBcake = function() {
        $('body').on('click', '.scan_bcake', function() {
            var email = $('#emailBcake').val();
            if (email!='') {
                $.ajax({
                    url: '/home-root-getBcake-lang-vi',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        email: email,
                    },
                    success: function(data) {
                        //console.log(data);
                        if (data != '') {
                            toastr.success('Quet Bcake thành công');
                            $('input[name="bcake_begin_date"]').val(data.start_date);
                            $('input[name="bcake_end_date"]').val(data.end_date);
                        } else {
                            toastr.error('Email chua kich hoat Bcake');
                        }
                    }

                });
                return false;

            } else {
                toastr.error("Khong co email de kiem tra");
            }


        });

    }
    var handleEditApp = function() {
        $('body').on('click', '.scan_app', function() {
            var idw = parseInt($('#infoIdw').text());

            if (!isNaN(idw)) {
                $.ajax({
                    url: '/home-root-editApp-lang-vi',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        idw: idw
                    },
                }).success(function(res) {
                    if (res.status == false) {
                        toastr.success('Chưa kích hoạt tính năng nào');
                    } else {
                        var content = res.data;
                        $.each(content, function(k, v) {
                            $('.nxt_feature').each(function(k_f, v_f) {
                                var elf = $(v_f);
                                if (elf.val() == k) {
                                    if (v['active'] != 0) {
                                        elf.prop('checked', true);
                                        $('.nxt_feature_date').each(function(k_date, v_date) {
                                            if (k_date == k_f) {
                                                $(v_date).val(v['end_date']);
                                            }
                                        });
                                    } else {
                                        elf.prop('checked', false);
                                    }
                                }
                            });
                        });
                    }
                    // if(res.data['stt_deal'] == 1)
                    // {
                    //     $('#hot_deal').attr( "checked", "checked" );

                    // }
                    // $('#start_date_deal').val(res.data['start_deal']);
                    // $('#end_date_deal').val(res.data['end_deal']);

                    // if(res.data['stt_quantity'] == 1)
                    // {
                    //     $('#price_quantity').attr( "checked", "checked" );

                    // }
                    // $('#start_date_quantity').val(res.data['start_quantity']);
                    // $('#end_date_quantity').val(res.data['end_quantity']);

                    // if(res.data['stt_properties'] == 1)
                    // {
                    //     $('#price_properties').attr( "checked", "checked" );

                    // }
                    // $('#start_date_properties').val(res.data['start_properties']);
                    // $('#end_date_properties').val(res.data['end_properties']);

                    // if(res.data['stt_big'] == 1)
                    // {
                    //     $('#price_big_quantity').attr( "checked", "checked" );

                    // }
                    // $('#start_date_big').val(res.data['start_big']);
                    // $('#end_date_big').val(res.data['end_big']);
                    // if(res.data['stt_auction'] == 1)
                    // {
                    //     $('#auction').attr( "checked", "checked" );

                    // }
                    // $('#start_date_auction').val(res.data['start_auction']);
                    // $('#end_date_auction').val(res.data['end_auction']);


                });
                // $('#loaderCopyTheme').hide();
                return false;
            } else {
                toastr.error("Khong co web de quet ");
            }

        });
    }
    var handleResetPassword = function() {
        $('body').on('click', '.btnReset', function(event) {
            event.preventDefault();
            var pass = randomString(8);
            $('input[name="resetpassword"]').val(pass);
            $('#resetPassword').modal('show');
            return false;
        });
        $('body').on('click', '.resetPasswordBtn', function(event) {
            event.preventDefault();
            var passw = $('input[name="resetpassword"]').val();
            if (passw == false) {
                $('input[name="resetpassword"]').focus();
                toastr.error('Vui lòng điền mật khẩu.');
                return false;
            } else {
                var web = handleWeb();
                $.ajax({
                    url: '/home-root-ajaxResetPassword-lang-vi',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        web: web,
                        passw: passw,
                    },
                })
                    .success(function(res) {
                        if (res.status == false) {
                            toastr.error(res.message);
                            return false;
                        } else {
                            toastr.success(res.message);
                            return false;
                        }
                    });
                return false;
            }
        });
    }
    var randomString = function(len, charSet) {
        charSet = charSet || 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var randomString = '';
        for (var i = 0; i < len; i++) {
            var randomPoz = Math.floor(Math.random() * charSet.length);
            randomString += charSet.substring(randomPoz, randomPoz + 1);
        }
        return randomString;
    }
    var handleViewInfo = function() {
        $('body').on('click', '#viewInfo', function(event) {
            event.preventDefault();
            var web = handleWeb();
            $.ajax({
                url: '/home-root-ajaxViewInfo-lang-vi',
                type: 'POST',
                dataType: 'json',
                data: {
                    web: web
                },
            })
                .success(function(res) {
                    if (res.status == false) {
                        toastr.error('Không tồn tại Website này');
                        return false;
                    } else {
                        $('#infoIdw').text(res.data['idw']);
                        $('#infoEmail').text(res.data['email_user']);
                        $('#infoTheme').text(res.data['theme_id']);
                        $('#infoStartDate').text(res.data['start_date']);
                        $('#infoEndDate').text(res.data['end_date']);
                        $('#infoPhone').text(res.data['phone']);
                        $('#infoShortName').text(res.data['s_name']);
                        $('#infoDomain').html(res.data['domain']);
                        $('#tableViewInfo').slideDown();
                    }
                });

            return false;
        });
    }
    var handleClickSaveDate = function() {
        $('body').on('click', '.save_date', function(event) {
            event.preventDefault();
            var web = handleWeb();
            var start = $('input[name="start_date"]');
            var start_date = start.val();
            var end = $('input[name="end_date"]');
            var end_date = end.val();
            if (web == false) {
                return false;
            } else {
                //Xu ly tiep
                if ($.trim(end_date) === '') {
                    toastr.error('Vui lòng điền ngày kết thúc hợp đồng');
                    end.focus();
                    return false;
                }
                var dataString = {
                    'type': 'date',
                    'web': web,
                    'start_date': start_date,
                    'end_date': end_date,
                };
                $.ajax({
                    url: '/home-root-ajax-lang-vi',
                    type: 'POST',
                    dataType: 'json',
                    data: dataString,
                })
                    .success(function(res) {
                        if (res.status == true) {
                            start.val('');
                            end.val('');
                            $('#website').val('');
                            toastr.success(res.message);
                            //Append log
                            var htm = '<li data-toggle="tooltip" title="" data-original-title="' + res.log_more + '"><i class="fa fa-check-square-o"></i> ' + res.log_mes + '</li>';
                            $('.ul-logs').prepend(htm);
                            $('[data-toggle="tooltip"]').tooltip();
                        } else {
                            toastr.error(res.message);
                        }
                    });
            }
        });
    };
    var handleClickChangeTheme = function() {
        $('body').on('click', '.change_theme', function(event) {
            event.preventDefault();
            var web = handleWeb();
            var themes = $('input[name="id_theme"]');
            var theme_id = themes.val();
            if (web == false) {
                return false;
            } else {
                //Xu ly tiep
                if ($.trim(theme_id) === '') {
                    toastr.error('Vui lòng điền id themes');
                    themes.focus();
                    return false;
                }
                var dataString = {
                    'type': 'theme',
                    'web': web,
                    'theme_id': theme_id,
                };
                $.ajax({
                    url: '/home-root-ajax-lang-vi',
                    type: 'POST',
                    dataType: 'json',
                    data: dataString,
                })
                    .success(function(res) {
                        if (res.status == true) {
                            themes.val('');
                            $('#website').val('');
                            toastr.success(res.message);
                            //Append log
                            var htm = '<li data-toggle="tooltip" title="" data-original-title="' + res.log_more + '"><i class="fa fa-check-square-o"></i> ' + res.log_mes + '</li>';
                            $('.ul-logs').prepend(htm);
                            $('[data-toggle="tooltip"]').tooltip();
                        } else {
                            toastr.error(res.message);
                        }
                    });
            }
        });
    };
    var handleWeb = function() {
        //An thong tin web
        $('#tableViewInfo').slideUp();
        var web = $('#website').val();
        if (web.trim() == '') {
            toastr.error('Vui lòng điền website cần thao tác');
            $('#website').focus();
            return false;
        }
        return web;
    };
    var handleLoadLogs = function() {
        $.ajax({
            url: '/home-root-ajaxLoadLogs-lang-vi',
            type: 'POST',
            dataType: 'json',
            data: {
                str: 21
            },
        })
            .success(function(res) {
                var htm = '';
                $.each(res, function(k, v) {
                    htm += '<li data-toggle="tooltip" title="" data-original-title="' + v.more + '"><i class="fa fa-check-square-o"></i> ' + v.mes + '</li>';
                });
                $('.ul-logs').html(htm);
                $('[data-toggle="tooltip"]').tooltip();
            });
    };
    var handleShowLog = function() {
        $('body').on('click', '#ShowlogWeb', function(event) {
            event.preventDefault();
            $('#modalShowLogs').modal('show');
            $('.ul-modal-logs').html('');
        });
    };
    var handleShowLogsModal = function() {
        $('body').on('click', '.show_logs', function(event) {
            event.preventDefault();
            var web = $('input[name="logs_web"]');
            var web_val = web.val();
            var type = $('select[name="logs_type"]').val();
            if ($.trim(web_val) == '') {
                toastr.error('Vui lòng điền website cần thao tác');
                web.focus();
                return false;
            } else {
                $('.ul-modal-logs').html('');
                $.ajax({
                    url: '/home-root-ajaxLoadLogs-lang-vi',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'web': web_val,
                        'type': type
                    },
                })
                    .success(function(res) {
                        if (res.status == false) {
                            toastr.error(res.message);
                            return false;
                        } else {
                            var htm = '';
                            if (res.message) {
                                htm += res.message;
                            } else {
                                $.each(res.logs, function(k, v) {
                                    htm += '<div class="divLiLogs"><li data-log="' + k + '"><i class="fa fa-check-square-o"></i> ' + v.mes + '</li><div class="divLiMore" id="Log_More_' + k + '">' + v.more + '</div></div>';
                                });
                            }
                            $('.ul-modal-logs').prepend(htm);
                            $('[data-toggle="tooltip"]').tooltip();
                        }

                    });
            }
        });
    };
    var handleShowMoreLog = function() {
        $('body').on('click', '.divLiLogs li', function(event) {
            event.preventDefault();
            var id_log = $(this).attr('data-log');
            $('.divLiMore').slideUp();
            $('#Log_More_' + id_log).slideDown();
        });
    };
    return {
        //main function to initiate the module
        init: function() {
            handleOnload();
            handleCopyTheme();
            handleResetPassword();
            handleViewInfo();
            handleClickSaveDate();
            handleClickChangeTheme();
            handleShowLog();
            handleShowLogsModal();
            handleShowMoreLog();
            handleSetApp();
            handleEditApp();
            handleSetBcake();
            handleGetBcake();
        }
    };
}();
$(function() {
    root.init();
});
$(window).on('beforeunload', function() {
    $.ajax({
        url: '/home-root-unload-lang-vi',
        type: 'POST',
        dataType: 'json',
        data: {
            unload: '1'
        },
    }).success(function() {

    });
});