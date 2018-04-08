<template>

    <div>
        <div class="p-3 mb-3 bg-light rounded" v-if="tags.length">
            <h4 class="font-italic">Tags</h4>

            <ul class="list-unstyled">
                <li v-for="tag in tags">  <router-link :to="{name: 'single_tag', params : {slug: tag.tag_slug} }">  {{tag.tag_name}} </router-link> </li>
            </ul>
        </div>
    </div>

</template>


<script>
    export default {
        data: function(){
            return {
                tags : [],
            }
        },
        mounted: function(){
            let app = this;
            axios.get(laravel.route.get_tags)
                .then(function(res){
                    app.tags = res.data;
                });
        }
    }
</script>