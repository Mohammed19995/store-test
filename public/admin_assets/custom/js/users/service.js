var vm = new Vue({
    el: '#app',
    data: {
        ids: [],
        option_id: '',
        option_url: api_urls.admin.user.execute_option,
        options: options,

        default_image: JSON.parse(JSON.stringify(default_image)),
        add: true,
        data: '',
        shock_event: '',
        countries: countries,

        execute_loading: false,
    },
    created: function () {
      //  this.setDefaultImage('');
    },
    methods: {
        setData: function (add, data) {
            this.default_image = add ? JSON.parse(JSON.stringify(default_image)) : data.image;
            this.add = add;
            this.data = data;
            this.shock_event = makeid(32);
        },
        delete: function (data) {
            let this_ = this;

            Swal.fire(get_translations.admin.deleting);
            axios.delete(api_urls.admin.user.add + "/" + data.id).then(function (res) {

                var get_res = handle_response(this_, res.data, false, true);
                if (get_res) {
                    table.ajax.reload();
                }

            }).catch(function (err) {
                vm.loading = false;
            });

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