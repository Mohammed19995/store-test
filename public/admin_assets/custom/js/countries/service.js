var vm = new Vue({
    el: '#app',
    data: {
        ids: [],
        option_id: '',
        option_url: api_urls.admin.country.execute_option,
        options: options,

        default_image: JSON.parse(JSON.stringify(default_image)),
        add: true,
        data: '',
        shock_event: '',

    },
    created: function () {
    },
    methods: {

        setData: function (add, data) {
            this.default_image = add ? JSON.parse(JSON.stringify(default_image)) : data.flag;
            this.add = add;
            this.data = data;
            this.shock_event = makeid(32);
        },
        emitExecuteOption: function () {
            this.ids = [];
            $('#check_all').prop('checked', false);
            table.ajax.reload();
        }

    }
});


$(document).ready(function () {

    // init
    $('.test-popup-link').magnificPopup({type: 'image'});

    /////////////////////////////////////////

    dataTableOperation(table, vm);
    checkBoxOptionDataTable(table, vm);
});