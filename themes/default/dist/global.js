// $(document).ajaxStart(function() {
//     Metronic.startPageLoading('Đang tải....');
// });
// $(document).ajaxStop(function() {
//     Metronic.stopPageLoading();

// });

var optsSpin = {
    lines: 9,
    length: 28,
    width: 5,
    scale: 1,
    corners: 0.6,
    color: 'rgba(13, 163, 226, 0.73)',
    opacity: 0,
    rotate: 59,
    direction: 1,
    speed: 2.2,
    trail: 49,
    fps: 20,
    zIndex: 2e9,
    className: 'spinner',
    top: '50%',
    left: '50%',
    shadow: false,
    hwaccel: true,
    position: 'absolute'
};


String.prototype.replaceNXT = function(
    strTarget, // The substring you want to replace
    strSubString // The string you want to replace in.
) {
    var strText = this;
    var intIndexOfMatch = strText.indexOf(strTarget);
    while (intIndexOfMatch != -1) {
        strText = strText.replace(strTarget, strSubString);
        intIndexOfMatch = strText.indexOf(strTarget);
    }
    return (strText);
};

function replaceAll(find, replace, str) {
    return str.replaceNXT(find, replace);
}

function getNotify() {
    return false;
    // var dataString = {
    //     'author': 'nxt'
    // };
    // var urlSend = '/home-any-getNotify';
    // var data = ajax_global(dataString, urlSend, 'POST', 'json');
    // if (data.status === true) {
    //     toastr.success(data.message);
    // } else {
    //     toastr.error(data.message);
    // }
}

function ajax_global(dataString, urlSend, method, type) {
    var target = document.getElementById('spinLoading');
    var spinner = new Spinner(optsSpin).spin();
    target.appendChild(spinner.el);
    var res, err;
    var result;
    if (lang == '') {
        lang = 'vi';
    }
    var request = $.ajax({
        url: baseUrl + urlSend + '-lang-' + lang,
        method: method,
        cache: false,
        async: false,
        dataType: type,
        data: dataString,
    });
    //Request
    request.success(function(res) {
        result = res;
        $('#spinLoading').html('');
    });
    request.error(function(err) {
        console.log(err);
        $('#spinLoading').html('');
        return false;
    });
    return result;

}

function setStatus(self, status) {
    if (status == 1) {
        self.removeClass('red-stripe');
        self.addClass('green-stripe');
        self.text('Đang hiện');
        self.attr('data-status', 1);
    } else {
        self.removeClass('green-stripe');
        self.addClass('red-stripe');
        self.text('Đang ẩn');
        self.attr('data-status', 0);
    }
}
$(function() {
    $('body').on('click', '.select_lang', function(event) {
        event.preventDefault();
        var checklang = $(this).attr('data-exists');
        if (checklang === undefined) {
            checklang = $(this).attr('data-exist');
        }
        if (checklang === undefined) {
            window.location.href = $(this).attr('href');
        }
        if (checklang.toLowerCase() === 'notexist') {
            bootbox.dialog({
                message: popup_df_lang, //"Bạn phải đăng ngôn ngữ mặc định trước",
                title: pop_df_title, //"Thông báo",
                buttons: {
                    danger: {
                        label: pop_close, //"Đóng",
                        className: "blue",
                        callback: function() {
                            return;
                        }
                    }
                }
            });
        } else {
            window.location.href = $(this).attr('href');
        }
    });

    $('body').on('click', '.lang_map_not', function(event) {
        event.preventDefault();
        window.location.href = $(this).attr('href');
    });

    $('body').on('click', '#header_notification_bar', function(event) {
        event.preventDefault();
        var dataString = {
            'author': 'truongnguyen'
        };
        var urlSend = '/notify-notify-activeStatus';
        var data = ajax_global(dataString, urlSend, 'POST', 'json');
        //getNotifyGlobal();
    });
    $('body').on('click', '#allExternalMessage', function(event) {
        event.preventDefault();
        window.location.href = $(this).find('a').attr('href');
    });
    $('body').on('click', '#liNotify li', function(event) {
        event.preventDefault();
        window.location.href = $(this).find('a').attr('href');
    });
    //Get notityf
    getNotifyGlobal();
    setInterval(function() {
        getNotifyGlobal();
    }, 30000);


});

function updateUniForm() {
    $('input:checkbox,input:radio').uniform();
}
/**
 * Get Notify
 */
var sound_active = false;

function getNotifyGlobal() {
    return false;
    // var currentUrl = document.URL;
    // if (currentUrl == 'http://adminweb.anvui.vn/product-synchronous-vatgia-lang-vi') {
    //     return false;
    // }
    // var dataString = {
    //     'author': 'truongnguyen'
    // };
    // var urlSend = '/notify-notify-getNotify';
    // var data = ajax_global(dataString, urlSend, 'POST', 'html');
    // $('#header_notification_bar').html(data);
    // var count = $(data).filter('input#isNotifyNew').val();
    // var sound = $(data).filter('input#isNotifyNewSound').val();
    // if (count != 0 && sound_active == false) {
    //     var audio = new Audio(sound);
    //     audio.play();
    //     sound_active = true;
    // }


}
updateUniForm();
//$('input:checkbox,input:radio').uniform();