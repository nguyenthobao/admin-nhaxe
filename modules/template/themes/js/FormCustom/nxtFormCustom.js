var nxFormCustom = function () {
    var handleOnload=function(){
        $('body').find('input[type="radio"]').css({
            marginTop: '-10px'
        });
    }
    

    return {
        //main function to initiate the module
        init: function () {
           handleOnload();
        }
    };
}();