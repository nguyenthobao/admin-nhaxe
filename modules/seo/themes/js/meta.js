var SettingMeta = function () {
    var saveMeta =function(){
        $(".saveSetting").click(function(){
            $('form').submit();
        });
    }

    

    return {
        init: function () {
            saveMeta();
        }
    };

}();