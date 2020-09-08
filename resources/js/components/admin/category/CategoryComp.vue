<template>

    <div class="card card-custom gutter-b show-form hidden">
        <div class="card-header">
            <h3 class="card-title" v-text="add ?__('admin.add_data') : __('admin.edit_data') "></h3>
        </div>
        <form class="form">
            <gallery-comp @get-advance-emit-file="getAdvanceEmitFile" :default_image="default_image" :attr_name="attr_name"
                          :selector_id_image="selector_id_image"></gallery-comp>
            <success-error-msg :success="msg.success" :error="msg.error"></success-error-msg>

            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-4" v-for="locale in locales">
                        <label>{{__('admin.name_'+locale)}}</label>
                        <input type="text" v-model="obj_data.name[locale]" :placeholder="__('admin.name_'+locale)" class="form-control">
                    </div>
                    <div class="col-lg-4">
                        <label>{{__('admin.parent')}}</label>
                        <div class="dropdown bootstrap-select form-control dropup">
                            <select class="form-control selectpicker select_category" v-model="obj_data.parent_id"
                                    data-size="7" data-live-search="true"
                                    tabindex="null"
                                    :data-none-selected-text="__('admin.select_parent')">
                                <option value="-1">{{__('admin.main_category')}}</option>
                                <option v-for="category in categories" :value="category.id">
                                    {{category.name[locale] + ' ' + category.get_parents_name}}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-4" v-for="locale in locales">
                        <label>{{__('admin.description_'+locale)}}</label>
                        <input type="text" v-model="obj_data.description[locale]" :placeholder="__('admin.description_'+locale)" class="form-control">
                    </div>
                    <div class="col-lg-4">
                        <button type="button" style="margin-top: -25%" class="btn btn-primary mr-4"
                                @click="SelectImageFromGallery('image' , 'image1')">
                            {{__('admin.select_image')}}
                        </button>
                        <show-image-comp @clear-emit-file="clearEmitFile" attr_name="image" selector_id_image="image1"
                                         :shock_event="shock_event" :default_image="default_image"></show-image-comp>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-2">
                        <button type="button" style="width: 100%" :disabled="loading" @click="makeAction"
                                class="btn btn-primary mt-4"
                                :class="loading ? 'spinner spinner-white spinner-left' : ''">
                            {{__('admin.save')}}
                        </button>

                    </div>
                    <div class="col-sm-2">

                        <button type="button" style="width: 100%"
                                class="btn btn-default mt-4 cancel-button">
                            {{__('admin.cancel')}}
                        </button>

                    </div>
                </div>
            </div>

        </form>
    </div>
</template>


<script>
    let empty_obj = {
        name: getMultiLangField(),
        description : getMultiLangField(),
        parent_id :'',
        image: ''
    };
    export default {
        props: ['default_image', 'data', 'add', 'shock_event' , 'categories'],
        data: function () {
            return {
                attr_name: 'image',
                selector_id_image: 'image1',

                multi_language_fields : ['name' , 'description'],
            }
        },
        filters: {},
        created: function () {
            this.setObjData();
        },
        methods: {
            setObjData: function () {
                this.obj_data = this.add ? JSON.parse(JSON.stringify(empty_obj)) : JSON.parse(JSON.stringify(this.data));
                this.obj_data.parent_id = this.obj_data.parent_id == null ? -1 :this.obj_data.parent_id;
                $('.select_category').val(this.obj_data.parent_id).trigger('change');
            },

            makeAction: function () {
                if (this.add) {
                    this.addCategory();
                } else {
                    this.updateCategory();
                }
            },
            addCategory: function () {
                let this_ = this;
                var formData = new FormData();
                Object.keys(this.obj_data).forEach(function (key) {
                    formData.append(key,this_.multi_language_fields.includes(key) ? JSON.stringify(this_.obj_data[key]) :this_.obj_data[key] );
                });
                this_.show_loading();

                axios.post(api_urls.admin.category.add, formData)
                    .then(function (res) {
                        this_.hide_loading();
                        let resposne = handle_response(this_, res.data, true, false);
                        if(res.data['status']) {
                            this_.$emit('add-category' , res.data['data']['categories']);
                        }

                        table.ajax.reload();
                    }).catch(function (err) {
                    this_.hide_loading();
                });
            },
            updateCategory: function () {
                let this_ = this;
                var formData = new FormData();
                Object.keys(this.obj_data).forEach(function (key) {
                    formData.append(key,this_.multi_language_fields.includes(key) ? JSON.stringify(this_.obj_data[key]) :this_.obj_data[key] );
                });
                formData.append("_method", "PUT");

                this_.show_loading();
                clear_message(this_);

                axios.post(api_urls.admin.category.add + "/" + this_.obj_data.id, formData)
                    .then(function (res) {
                        this_.hide_loading();
                        let resposne = handle_response(this_, res.data, true, false);
                        if(res.data['status']) {
                            this_.$emit('update-category' , res.data['data']['categories']);
                        }
                        table.ajax.reload();
                    }).catch(function (err) {
                    this_.hide_loading();
                });
            },
        },
        watch: {
            shock_event: function () {
                this.setObjData();
                this.msg = {success: '', error: ''};
            }
        }

    }
</script>