<template>

    <div>

        <div class="table-responsive" v-if="posts.length">

            <table class="table">
                <thead>
                    <tr><th>Title</th> <th>Status</th> <th>Actions</th> </tr>
                </thead>

                <tbody>
                <tr v-for="(post, index) in posts" >
                    <td>{{post.title}}</td>
                    <td>
                        <p class="text-muted" v-if="post.status == 0">Pending</p>
                        <p class="text-success" v-if="post.status == 1">Published</p>
                        <p class="text-danger" v-if="post.status == 2">Blocked</p>
                    </td>
                    <td>
                        <a href="#" v-on:click.stop.prevent="changeStatus('1',index)" v-if="post.status != '1'" class="btn btn-sm btn-success"><i class="fa fa-check-circle"></i> Publish</a>
                        <a href="#" v-on:click.stop.prevent="changeStatus('2',index)" v-if="post.status != '2'" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Block</a>
                    </td>
                </tr>
                </tbody>

            </table>

            <post-pagination :data="pagination" v-if="pagination.total"></post-pagination>

        </div>

    </div>

</template>

<script>
    import PostPagination from '../PostPagination';
    export default {
        name: "OfficeAllPosts",
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

            axios.get(laravel.route.get_all_office_posts+params)
                .then(function(res){
                    app.is_loading = false;
                    if (res.data.success){
                        app.posts = res.data.data.data;
                        app.results = true;

                        app.pagination = _.omit(res.data.data, ['data'])
                    }
                });
        },
        methods : {
            changeStatus: function(status, index){
                let post = this.posts[index];
                let post_id = post.id;
                let data = {post_id : post_id, status: status}
                axios.post(laravel.route.post_status_change, data)
                    .then(function(res){
                        if (res.data.success){
                            post.status = status;
                        }
                    });

            }
        }
    }
</script>