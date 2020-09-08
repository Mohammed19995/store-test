<template>
    <transition name="fade">
        <div class="row mb-4" v-show="ids.length > 0">
            <div class="col-sm-3">
                <select class="form-control selectpicker select_option" v-model="option_id"
                        :data-none-selected-text="__('admin.select_option')">
                    <option v-for="option in options" :value="option.id">{{option.name}}</option>
                </select>
            </div>
            <div class="col-sm-2">
                <button type="button" style="width: 100%" :disabled="execute_loading" @click="executeOption"
                        class="btn btn-primary" :class="execute_loading ? 'spinner spinner-white spinner-left' : ''">
                    {{__('admin.apply_option')}}
                </button>
            </div>
        </div>
    </transition>

</template>


<script>
    export default {
        props : ['ids' , 'url' , 'options'],
        data : function () {
            return {
                option_id : '',
                execute_loading : false ,
            }
        },
        methods : {
            executeOption : function () {

                let this_ = this;
                let data = {
                    ids : this_.ids ,
                    option_id : this_.option_id
                };
                this_.execute_loading = true;
                axios.post(this_.url, data).then(function (res) {
                    this_.execute_loading = false;
                    var get_res = handle_response(this_ ,res.data , false , true);
                    if (get_res.status) {
                        this_.$emit('emit-execute-option')
                    }
                }).catch(function (err) {
                    this_.execute_loading = false;
                });
            },
        }
    }
</script>

<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>