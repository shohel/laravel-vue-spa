<template>
    <div>

        <page-title title="Laravel and Vue SPA Starter Blog"></page-title>

        <div class="jumbotron p-3 p-md-5 rounded bg-light"  v-if="posts.feature && results">
            <div class="col-md-12 px-0">
                <h1 class="display-4 font-italic">{{posts.feature.title}}</h1>

                <div class="mb-1 text-muted" v-if="posts.feature.user">
                    <i class="fas fa-user"></i>

                    <router-link :to="{name: 'author_posts', params : {user_name: posts.feature.user.user_name} }">
                        {{posts.feature.user.name}}
                    </router-link>

                    <i class="fas fa-clock"></i> {{posts.feature.created_at}}
                    <span v-if="posts.feature.tags.length">
                                    <i class="fas fa-tags"></i> <a href="" v-for="tag in posts.feature.tags">{{tag.tag_name}}, </a>
                                </span>
                </div>

                <p class="lead my-3" v-if=" posts.feature.post_content">
                    {{ posts.feature.post_content.slice(0, 200) }}
                </p>
                <p class="lead mb-0" v-if="posts.feature.slug">
                    <router-link :to="{name: 'single_post', params : {slug: posts.feature.slug} }" class=" font-weight-bold">
                        Continue reading...
                    </router-link>

                </p>
            </div>
        </div>


        <div class="container" v-if="results">

            <div class="row mb-2">

                <div class="col-md-6" v-for="(sub_post, index) in posts.sub_feaure">
                    <div class="card flex-md-row  mb-4 box-shadow h-md-250" :class="'card-sub-feature-'+index">
                        <div class="card-body d-flex flex-column align-items-start">
                            <h3 class="mb-2">
                                <router-link :to="{name: 'single_post', params : {slug: sub_post.slug} }" class="text-dark">
                                    {{sub_post.title}}
                                </router-link>
                            </h3>
                            <div class="small mb-2 text-muted">
                                <i class="fas fa-user"></i>
                                <router-link :to="{name: 'author_posts', params : {user_name: sub_post.user.user_name} }">
                                    {{sub_post.user.name}}
                                </router-link>
                                <i class="fas fa-clock"></i> {{sub_post.created_at}}
                                <span v-if="sub_post.tags.length">
                                    <i class="fas fa-tags"></i> <a href="" v-for="tag in sub_post.tags">{{tag.tag_name}}, </a>
                                </span>
                            </div>

                            <p class="card-text mb-auto">{{sub_post.post_content.slice(0, 200)}}</p>

                            <router-link :to="{name: 'single_post', params : {slug: posts.feature.slug} }">
                                Continue reading...
                            </router-link>

                        </div>

                    </div>
                </div>

            </div>

        </div>


        <div class="container posts-list blog-body">
            <div class="row">
                <div class="col-md-8">


                    <div v-if="results">
                        <blog-post :posts="posts.general"></blog-post>
                        <post-pagination :data="pagination" v-if="pagination.total"></post-pagination>
                    </div>


                    <!--
                    <div class="error-no-data" v-else>
                        <h1 class="display-3"> <i class="fas fa-info-circle"></i> There is no data found</h1>
                    </div>-->

                </div>

                <div class="col-md-4">
                    <tag-lists></tag-lists>
                </div>


            </div>
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
        components : {
            BlogPost,
            PostPagination,
            TagLists,
        },
        data: function(){
            return {
                posts : {
                    feature: {},
                    sub_feaure: [],
                    general: [],
                },
                is_loading : true,
                results : false,
                pagination : { total: 0}
            }
        },
        mounted: function(){
            let app = this;

            let params = this.$route.query.page ? '/?page='+this.$route.query.page : '';
            axios.get(laravel.route.get_posts+params)
                .then(function(res){
                    let posts = res.data.posts.data;
                    app.is_loading = false;

                    if (posts.length){
                        app.posts.feature = posts[0];
                        app.posts.sub_feaure = posts.slice(1,3);
                        app.posts.general = posts.slice(3);

                        app.results = true;

                        app.pagination = _.omit(res.data.posts, ['data'])
                    }

                });
        },
    }
</script>