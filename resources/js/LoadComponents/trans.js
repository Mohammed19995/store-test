module.exports = {
    data: function () {
        return {
            msg: {
                success: '',
                error: ''
            },
            loading: false,
            locales : locales,
            locale : _locale,
        }
    },

    methods: {
        /**
         * Translate the given key.
         */
        __(key, replace) {
            let translation, translationNotFound = true

            try {
                translation = key.split('.').reduce((t, i) => t[i] || null, window._translations[window._locale].php)

                if (translation) {
                    translationNotFound = false
                }
            } catch (e) {
                translation = key
            }

            if (translationNotFound) {
                translation = window._translations[window._locale]['json'][key]
                    ? window._translations[window._locale]['json'][key]
                    : key
            }

            _.forEach(replace, (value, key) => {
                translation = translation.replace(':' + key, value)
            })

            return translation
        },

        show_loading: function () {
            this.loading = true;
        },
        hide_loading: function () {
            this.loading = false;
        },

        ///////////////// image  ////////////////////////
        getEmitFile: function (file, attr_name) {
            this.obj_data[attr_name] = file;
        },
        getAdvanceEmitFile: function (file, attr_name) {
            this.obj_data[attr_name] = file.file != null ? file.file : file.id;
        },
        clearEmitFile: function (attr_name) {
            this.obj_data[attr_name] = null;
        },
        SelectImageFromGallery: function (attr_name, selector_id_image) {
            this.attr_name = attr_name;
            this.selector_id_image = selector_id_image;
            $('#GalleryImages').modal('show');
        },

        /////////////////////////////////////////////////

        blockUI: function (attr) {
            KTApp.block(attr, {
                state: 'primary',
                message: this.__('pagination.processing')
            });
        },
        UnblockUI: function (attr) {
            KTApp.unblock(attr, {});
        }


    },
}