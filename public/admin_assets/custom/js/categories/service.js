var vm = new Vue({
    el: '#app',
    data: {
        ids: [],
        option_id: '',
        option_url: api_urls.admin.category.execute_option,
        options: options,
        categories : categories,

        default_image: JSON.parse(JSON.stringify(default_image)),
        add: true,
        data: '',
        shock_event: '',

        execute_loading: false,
        filter_loading : false ,
    },
    created: function () {
      //  this.setDefaultImage('');
    },
    methods: {
        addCategory : function (categories) {
            this.categories= categories;
            this.updateSelectCategories();

        },
        updateCategory : function (categories) {
            this.categories= categories;
           // Vue.set(this.categories ,this.categories.findIndex(el => el.id == category.id) , category );
            this.updateSelectCategories();

        },


        setData: function (add, data) {
            this.default_image = add ? JSON.parse(JSON.stringify(default_image)) : data.image;
            this.add = add;
            this.data = data;
            this.shock_event = makeid(32);
        },
        delete: function (data) {
            let this_ = this;

            Swal.fire(get_translations.admin.deleting);
            axios.delete(api_urls.admin.category.add + "/" + data.id).then(function (res) {

                var get_res = handle_response(this_, res.data, false, true);
                if (get_res) {
                    this_.categories.splice(this_.categories.findIndex(el => el.id == data.id) , 1);
                    this_.updateSelectCategories();
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
        },
        filterData : function () {
            this.filter_loading = true;
            table.ajax.reload();
        },

        updateSelectCategories : function () {
            Vue.nextTick(function () {
                $('#select_filter_category').selectpicker('refresh');
                $('.select_category').selectpicker('refresh');
            })
        },

    }
});


$(document).ready(function () {

    // init
    $('.test-popup-link').magnificPopup({type: 'image'});

    /////////////////////////////////////////

    dataTableOperation(table, vm);
    checkBoxOptionDataTable(table, vm);

    table.on('click', '.show_children', function () {
        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }
        $('#select_filter_category').val(table.row(row).data().id).trigger('change');
        vm.filterData();

    });
});