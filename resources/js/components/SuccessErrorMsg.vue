<template>
    <div>
        <div class="alert alert-success success_msg" :class="success == '' ? 'hidden' : ''" style="margin: 10px;">
           <strong> {{ success }}</strong>
        </div>
        <div class="alert alert-danger error_msg" :class="error == '' ? 'hidden' : ''" style="margin: 10px;">
            <strong> {{ error }}</strong>
        </div>
    </div>
</template>


<script>
    export default {
        props : ['success' , 'error'],
        data : function () {
            return {

            }
        },
        methods : {

        }
    }
</script>