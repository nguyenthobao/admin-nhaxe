var MenuTabLang = function () {
    
var handleDialogs = function() {
            $('.select_lang').click(function(){
                var $this = $(this);
                var checklang = $this.attr('data-exist');
                var pop_df = $('input[name="popup_df"]');
                var pop = $('input[name="popup"]');
                if (checklang=='notExist'){
                    bootbox.dialog({
                        message: pop_df.attr('data-message'), //"Bạn phải đăng ngôn ngữ mặc định trước",
                        title: pop_df.attr('data-title'),//"Thông báo",
                        buttons: {
                          danger: {
                            label: pop_df.attr('data-close'),//"Đóng",
                            className: "blue",
                            callback: function() {
                              return;
                            }
                          }
                        }

                    });
                }
            })
    }
     return {
        //main function to initiate the module
        init: function () {
            handleDialogs();
        }
    };
}();


 /*bootbox.dialog({
                        message: pop.attr('data-message'),// "Chọn ngôn ngữ khác sẽ reset lại form. Bạn chắc chắn muốn thực hiện ?",
                        title: pop.attr('title'),//"Thay đổi ngôn ngữ",
                        buttons: {
                          success: {
                            label: pop.attr('yes'), //"Đồng ý !",
                            className: "green",
                            callback: function() {
                                //reset all form 
                                $("#form_category").find("textarea,select,input[type=text]").val('').end().find("input[type=checkbox], input[type=radio]").prop("checked", "").end();
                                //end reset all form
                                var lang = $this.attr('data-lang');
                                $('input[name="lang"]').val(lang);
                                $('.result_lang').text($this.text());
                                $('.li_select_lang').parent().removeClass('active');
                                $this.parent().addClass('active');
                            }
                          },
                          danger: {
                            label: pop.attr('cancel'),//"Huỷ",
                            className: "red",
                            callback: function() {
                              return;
                            }
                          }
                        }
                    });*/