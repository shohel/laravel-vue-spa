<template>

    <div>

        <div class="table-responsive" v-if="posts.length">

            <table class="table">
                <thead>
                    <tr><th>Title</th> <th>Status</th> <th>Actions</th> </tr>
                </thead>

                <tbody>
                <tr v-for="post in posts" >
                    <td>{{post.title}}</td>
                    <td>
                        <p class="text-muted" v-if="post.status == 0">Pending</p>
                        <p class="text-success" v-if="post.status == 1">Published</p>
                        <p class="text-danger" v-if="post.status == 2">Blocked</p>
                    </td>
                    <td>
                        <router-link :to="{name: 'single_post', params : {slug: post.slug} }" class="btn btn-sm btn-secondary">
                            <i class="fas fa-eye"></i>
                        </router-link>
                    </td>
                </tr>
                </tbody>

            </table>

            <post-pagination :data="pagination" v-if="pagination.total"></post-pagination>

        </div>

    </div>

</template>

<script>
    import PostPagination from '../components/PostPagination';
    export default {
        name: "OfficePosts",
        components : {
            PostPagination
        },
        data: function(){
            return {
                tag : {},
                posts : [],
                is_loading : true,
                results : false,
                pagination : { total: 0}
            }
        },
        mounted: function(){
            let app = this;
            let params = this.$route.query.page ? '/?page='+this.$route.query.page : '';

            axios.get(laravel.route.get_users_office_posts+params)
                .then(function(res){
                    app.is_loading = false;
                    if (res.data.success){
                        app.posts = res.data.data.data;
                        app.results = true;

                        app.pagination = _.omit(res.data.data, ['data'])
                    }
                });
        }
    }
</script>