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
                    <div class="col-lg-4">
                        <label>{{__('admin.name')}}</label>
                        <input type="text" v-model="obj_data.name" :placeholder="__('admin.name')" class="form-control">
                    </div>
                    <div class="col-lg-4">
                        <label>{{__('admin.email')}}</label>
                        <input type="email" v-model="obj_data.email" :placeholder="__('admin.email')"
                               class="form-control">
                    </div>

                    <div class="col-lg-4">
                        <label>{{__('admin.password')}}</label>
                        <input type="password" v-model="obj_data.password" :placeholder="__('admin.password')"
                               class="form-control">
                    </div>


                </div>
                <div class="form-group row">

                    <div class="col-lg-4">
                        <label>{{__('admin.phone_code')}}</label>
                        <div class="dropdown bootstrap-select form-control dropup">
                            <select class="form-control selectpicker select_phone_code" v-model="obj_data.phone_code"
                                    data-size="7" data-live-search="true"
                                    tabindex="null"
                                    :data-none-selected-text="__('admin.select_phone_code')">
                                <option v-for="country in countries" :value="country.phone_code">
                                    {{country.name}} <span> ( {{country.phone_code}} ) </span>
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <label>{{__('admin.phone')}}</label>
                        <input type="text" v-model="obj_data.phone" :placeholder="__('admin.phone')"
                               class="form-control">
                    </div>

                    <div class="col-lg-4">
                        <button type="button" style="margin-top: -25%" class="btn btn-primary mr-4"
                                @click="SelectImageFromGallery('image' , 'image1')">
                            {{__('admin.select_image')}}
                        </button>
                        <show-image-comp @clear-emit-file="clearEmitFile" attr_name="image" selector_id_image="image1"
                                         :shock_event="shock_event" :default_image="default_image"></show-image-comp>
                    </div>
                    <div class="col-lg-4">
                        <!--<advance-image-comp @getEmitFile="getEmitFile" attr_name="image" :shock_event="shock_event"-->
                        <!--:original_image="obj_data.image" :default_image="default_image"-->
                        <!--selector_id_image="image1" :image_name="__('admin.image')">-->
                        <!--</advance-image-comp>-->
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
        name: '',
        email: '',
        phone_code: '',
        phone: '',
        password: '',
        image: ''
    };
    export default {
        props: ['default_image', 'data', 'add', 'shock_event', 'countries'],
        data: function () {
            return {
                attr_name: 'image',
                selector_id_image: 'image1',
            }
        },
        filters: {},
        created: function () {
            this.setObjData();
        },
        methods: {
            setObjData: function () {
                this.obj_data = this.add ? JSON.parse(JSON.stringify(empty_obj)) : JSON.parse(JSON.stringify(this.data));
                $('.select_phone_code').val(this.obj_data.phone_code).trigger('change');
            },

            makeAction: function () {
                if (this.add) {
                    this.addUser();
                } else {
                    this.updateUser();
                }
            },
            addUser: function () {
                let this_ = this;
                var formData = new FormData();
                Object.keys(this.obj_data).forEach(function (key) {
                    formData.append(key, this_.obj_data[key]);
                });
                this_.show_loading();
                //  clear_message(this_);

                axios.post(api_urls.admin.admin.add, formData)
                    .then(function (res) {
                        this_.hide_loading();
                        let resposne = handle_response(this_, res.data, true, false);
                        table.ajax.reload();
                    }).catch(function (err) {
                    this_.hide_loading();
                });
            },
            updateUser: function () {
                let this_ = this;
                var formData = new FormData();
                Object.keys(this.obj_data).forEach(function (key) {
                    formData.append(key, this_.obj_data[key]);
                });
                formData.append("_method", "PUT");

                this_.show_loading();
                clear_message(this_);

                axios.post(api_urls.admin.admin.add + "/" + this_.obj_data.id, formData)
                    .then(function (res) {
                        this_.hide_loading();
                        let resposne = handle_response(this_, res.data, true, false);
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