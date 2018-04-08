<template>
    <div>

        <div class="tags-container" v-if="results">

            <div class="jumbotron p-3 p-md-5 rounded bg-light">
                <div class="col-md-12 px-0 text-center">
                    <h1 class="display-4 font-italic">Author : {{user.name}}</h1>

                </div>
            </div>

            <div class="container posts-list blog-body">
                <div class="row">
                    <div class="col-md-8">

                        <div v-if="results">
                            <blog-post :posts="posts"></blog-post>
                            <post-pagination :data="pagination" v-if="pagination.total"></post-pagination>
                        </div>


                        <div class="error-no-data" v-else>
                            <h1 class="display-3"> <i class="fas fa-info-circle"></i> There is no data found</h1>
                        </div>


                    </div>

                    <div class="col-md-4">
                        <tag-lists></tag-lists>
                    </div>

                </div>
            </div>
        </div>


        <div class="error-no-data" v-else>
            <h1 class="display-3"> <i class="fas fa-info-circle"></i> There is no data found</h1>
        </div>

        <div class="loader-container" v-if="is_loading">
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
    import BlogPost from '../components/BlogPost';
    import TagLists from '../components/TagLists';
    import PostPagination from '../components/PostPagination';

    export default {
        components: {
            BlogPost,
            PostPagination,
            TagLists,
        },
        data: function(){
            return {
                user : {},
                posts : [],
                is_loading : true,
                results : false,
                pagination : { total: 0}
            }
        },
        mounted: function(){
            let app = this;
            let params = this.$route.query.page ? '/?page='+this.$route.query.page : '';

            let api_uri = laravel.route.author_posts.replace('{user_name}', this.$route.params.user_name);
            axios.get(api_uri+params)
                .then(function(res){
                    app.is_loading = false;
                    if (res.data.success){
                        app.user = res.data.data.user;
                        app.posts = res.data.data.posts.data;
                        app.results = true;

                        app.pagination = _.omit(res.data.data.posts, ['data'])
                    }
                });
        }
    }
</script>