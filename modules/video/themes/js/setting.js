var FormSetting = function () {
    var handleTagsInput = function(){
        if (!jQuery().tagsInput) {
            return;
        }
        $('input[name="meta_keyword"]').tagsInput({
            width: 'auto',
            'onAddTag': function () {
                //alert(1);
            },
        });
    }
     var initComponents = function () {
        //init maxlength handler
        $('.maxlength-handler').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            threshold: 5
        });
    }
    return {
        //main function to initiate the module
        init: function () {
            initComponents();
           // searchNewsVip();
            //searchNewsHot();
            //chooseNewsVip();
            //chooseNewsHot();
           // saveNewsCat();
           // saveNewsHome();
            handleTagsInput();
        }
    };
}();