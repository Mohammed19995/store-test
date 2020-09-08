<template>
    <div class="image-input image-input-outline">
        <div class="image-input-wrapper">
            <img :id="selector_id_image" style="width: 100%;height: 100%" :src="default_image"/>
        </div>
        <span @click="setDefaultImage" data-action="cancel" data-toggle="tooltip" title="" style="display: block!important;"
              data-original-title="Cancel avatar"
              class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"><i
                class="ki ki-bold-close icon-xs text-muted"></i>
                        </span>

    </div>
</template>

<script>
    export default {
        props : ['attr_name','selector_id_image','default_image' , 'shock_event'],
        data : function () {
            return {}
        },
        created : function () {
            this.setImage();
        },
        methods : {
            setDefaultImage : function () {
                this.setImage();
                this.$emit('clear-emit-file' , this.attr_name);
            },
            setImage : function () {
                $('#'+this.selector_id_image).prop('src' , this.default_image);
            }
        },
        watch : {
            shock_event : function () {
                this.setImage();
            }
        }
    }
</script>
