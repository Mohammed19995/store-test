var table;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table = $("#user-table").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            "language": dataTableLanguage(),
            "drawCallback": function( settings ) {
                vm.ids = [];
                $('.test-popup-link').magnificPopup({type:'image'});
            },
            ajax: {
                url: "get-users-ajax",
                data: function (e) {
                }
            },
            columns: [
                {data: "select_record" , searchable : false , orderable : false },
                {data: "show_image" , searchable : false , orderable : false },
                {data: "name" , width : "200px"},
                {data: "email"},
                {data: "phone_with_code" , name : 'phone' , class : 'dir-ltr'},
                {data: "show_status" ,name : 'status' },
                {data: "created_at"},
                {data: "actions" , searchable : false , orderable : false},

            ],
            columnDefs: [
                { width: 200, targets: 1 }
            ],
        });

    }
};
jQuery(document).ready(function () {

    DatatablesDataSourceAjaxServer.init()
});