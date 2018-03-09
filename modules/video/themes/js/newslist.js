var CategoryList = function () {
    var handleRecords = function () {

        var grid = new Datatable();

        grid.init({
            src: $("#categorylist_ajax"),
            onSuccess: function (grid) {
                console.log(grid);
            },
            onError: function (grid) {
                // execute some code on network or other general error  
            },
            loadingMessage: 'Đang tải...',
            dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options 
                "lengthMenu": [
                    [10, 20, 50, 100, 150, -1],
                    [10, 20, 50, 100, 150, "All"] // change per page values here
                ],
                "pageLength": 10, // default record count per page
                "ajax": {
                    "url": "news-categorylistAjax", // ajax source
                },
                "aoColumnDefs": [ 
                    { "bSortable": false, "aTargets": [ 0 ] },
                    {
                      "aTargets": [ 0],
                      "mData": "id",
                      "mRender": function ( data, type, full ) {
                        return '<input name="id[]" type="checkbox" value="'+data+'">';
                        }
                    },
                    {
                      "aTargets": [ 1 ],
                      "mData": grid.title,
                      "mRender": function ( data, type, full ) {
                        return data;
                        },
                    }

                    ],
                "order": [
                    [1, "asc"]
                ] // set first column as a default sort by asc
            }
        });

        // handle group actionsubmit button click
        // grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
        //     e.preventDefault();
        //     var action = $(".table-group-action-input", grid.getTableWrapper());
        //     if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
        //         grid.setAjaxParam("customActionType", "group_action");
        //         grid.setAjaxParam("customActionName", action.val());
        //         grid.setAjaxParam("id", grid.getSelectedRows());
        //         grid.getDataTable().ajax.reload();
        //         grid.clearAjaxParams();
        //     } else if (action.val() == "") {
        //         Metronic.alert({
        //             type: 'danger',
        //             icon: 'warning',
        //             message: 'Chọn hành động trước',
        //             container: grid.getTableWrapper(),
        //             place: 'prepend'
        //         });
        //     } else if (grid.getSelectedRowsCount() === 0) {
        //         Metronic.alert({
        //             type: 'danger',
        //             icon: 'warning',
        //             message: 'Chưa có bản ghi được chọn',
        //             container: grid.getTableWrapper(),
        //             place: 'prepend'
        //         });
        //     }
        // });
        // 
    }
    var checkboxAll = function(){
        $('#checkboxAll').on('switch-change', function (e, data) {
            var $el = $(data.el)
              , value = data.value;
                $('.checkboxes').each(function( index ) {
              $(this).bootstrapSwitch('setState' , value);
            });
        });
    }
    return {
        //main function to initiate the module
        init: function () {
           // handleRecords();
           checkboxAll();
        }
    };

}();