<template>
    <div class="vue-login">

        <div class="loader-container">
            <div class="regot-loader">
                <div class="regot regot1"></div>
                <div class="regot regot2"></div>
                <div class="regot regot3"></div>
                <div class="regot regot4"></div>
                <div class="regot regot5"></div>
            </div>
        </div>

    </div>
</template>


<script>
    export default {
        mounted: function(){
            axios.post(laravel.route.api_logout)
                .then( (res) => {
                    if (res.data.success){
                        location.href = '/';
                    }
                })
        }
    }
</script>