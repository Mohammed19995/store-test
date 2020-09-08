<template>

    <div class="modal fade" id="GalleryImages" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeLg"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" v-text="__('admin.add_image')"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3 vertical-line-left">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" @change="getFile($event)">
                                <label class="custom-file-label"></label>
                            </div>
                        </div>
                        <div class="col-sm-7 gallery_images vertical-line-left">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" v-model="gallery.search"
                                               placeholder="search ...">
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <select class="form-control" v-model="gallery.type_id">
                                            <option value="-1">{{__('admin.all')}}</option>
                                            <option v-for="type in types" :value="type.id" v-text="type.name[locale]"></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="pointer col-sm-3 mt-3" v-for="image in gallery.images"
                                     @click="setSelectedImage(image)">
                                    <img :class="image.id == selected_image.id ? 'image-selected' : ''" width="120"
                                         height="100" :src="image.src"/>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <button @click="showMore" type="button" class="btn btn-primary btn-sm mr-2">
                                        {{__('admin.show_more')}}
                                    </button>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>

                        </div>
                        <div class="col-sm-2">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <img :src="selected_image.src" width="100" height="100">
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-12 word-break">
                                    <label><span>{{__('admin.name')}}</span> : {{selected_image.name[locale]}}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!--<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">-->
                    <!--{{__('admin.cancel')}}-->
                    <!--</button>-->
                    <button @click="sendFile" type="button" style="width: 120px;"
                            class="btn btn-primary font-weight-bold">{{__('admin.save')}}
                    </button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {

        props: ['default_image', 'attr_name', 'selector_id_image'],
        data: function () {
            return {
                gallery: {
                    images: [],
                    search: '',
                    type_id: -1,
                    page: 1,
                    next_page_url: ''
                },
                types: [],
                selected_image: {},
            }
        },
        created: function () {
            this.selected_image = {
                id: '',
                src: this.default_image,
                name: '',
                file: null
            };
            this.getImages(false);
            this.getTypes();
        },
        methods: {
            getTypes: function () {
                let this_ = this;
                axios.get(api_urls.admin.gallery_types.get_remote).then(function (res) {
                    this_.types = res.data['data']['gallery_types'];
                }).catch(function (err) {
                });
            },
            getImages: function (push) {
                let this_ = this;
                this.gallery.page = push ? this.gallery.page++ : 1;

                this_.blockUI('.gallery_images');
                axios.get(api_urls.admin.gallery.get_remote,
                    {
                        params: {
                            search: this_.gallery.search,
                            type_id: this_.gallery.type_id,
                            page: this_.gallery.page
                        }
                    }).then(function (res) {

                    if (push) {
                        res.data['data'].forEach(function (item) {
                            this_.gallery.images.push(item);
                        });
                    } else {
                        this_.gallery.images = res.data['data'];
                    }

                    this_.gallery.next_page_url = res.data['next_page_url'];
                    this_.UnblockUI('.gallery_images');

                }).catch(function (err) {
                    this_.UnblockUI('.gallery_images');
                });
            },

            setSelectedImage: function (image) {
                this.selected_image = {
                    id: image.id,
                    src: image.src,
                    name: image.name,
                    file: null
                };
                $('.custom-file-label').text('');
            },
            getFile: function (event) {
                let this_ = this;
                var file = event.target.files[0];
                this_.addGallery(file);
//                if (file) {
//                    var reader = new FileReader();
//                    reader.onload = function (e) {
//                        this_.selected_image = {
//                            id: -1,
//                            src: e.target.result,
//                            name: '',
//                            file: file
//                        };
//                    };
//                    reader.readAsDataURL(event.target.files[0]);
//                }
            },

            showMore: function () {
                if (this.gallery.next_page_url != null) {
                    this.gallery.page++;
                    this.getImages(true);
                }
            },
            sendFile: function () {
                this.$emit('get-advance-emit-file', this.selected_image , this.attr_name);
                this.$nextTick(function () {
                    $('#'+this.selector_id_image).prop('src' ,this.selected_image.src );
                });
                $('#GalleryImages').modal('hide');
            },

            addGallery : function (file) {
                let this_ = this;

                var formData = new FormData();
                formData.append('name' , JSON.stringify(getMultiLangField(file.name) ));
                formData.append('type_id' , this_.gallery.type_id == -1 ? 1 : this_.gallery.type_id);
                formData.append('src' , file);

                this_.blockUI('.gallery_images');
                axios.post(api_urls.admin.gallery.add, formData)
                    .then(function (res) {
                        this_.UnblockUI('.gallery_images');
                        if(res.data.status) {
                            this_.gallery.images.unshift(res.data['data']['gallery']);
                        }

                    }).catch(function (err) {
                    this_.UnblockUI('.gallery_images');
                });
            },
        },
        watch: {
            "gallery.search": function (value) {
                if (value.length >= 3 || value.length == 0) {
                    this.getImages(false);
                }
            },
            "gallery.type_id": function (value) {
                this.getImages(false);
            },
        }
    }
</script>

<style>
    .image-selected {
        border: 4px solid #3fccc5;
    }

    img {
        border-radius: 17px;
    }

    .vertical-line-left {
        border-left: 1px solid #00000054;
    }

    .vertical-line-right {
        border-right: 1px solid #00000054;
    }
    .word-break {
        word-break: break-all;
    }
    .vertical-scroll {
        height: 400px;
        overflow-y: auto;
    }
</style>