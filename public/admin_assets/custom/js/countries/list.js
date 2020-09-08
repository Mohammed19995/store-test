var table;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table = $("#country-table").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            "language": dataTableLanguage(),
            "drawCallback": function( settings ) {
                vm.ids = [];
                $('.test-popup-link').magnificPopup({type:'image'});
            },
            order: [6 , 'desc'],
            ajax: {
                url: api_urls.admin.country.get_remote,
                data: function (e) {
                }
            },
            columns: [
                {data: "select_record" , searchable : false , orderable : false },
                {data: "show_image" , searchable : false , orderable : false },
                {data: "name" , name : 'name_ar' , width : "200px"},
                {data: "iso2"},
                {data: "phone_code" ,  class : 'dir-ltr'},
                {data: "currency.symbol_ar" , name : "currency.symbol_ar"},
                {data: "show_status" ,name : 'status' },
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