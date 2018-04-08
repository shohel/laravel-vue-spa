<template>

<div>
    <page-title :title="post.title" v-if="post.title && (post.status == '1' || self_view) " ></page-title>

    <page-title title="404 error, Your requested content could not be found." v-if="post.title && ! self_view " ></page-title>

    <div v-if="!is_loading">

        <div class="jumbotron jumbotron-fluid" v-if="post.status == '1' || self_view">
            <div class="container">

                <div class="alert alert-warning" v-if="self_view">
                    <h4>Only you can see this post</h4>
                </div>

                <h1 class="display-4">{{post.title}}</h1>
                <p class="text-muted">
                    <span><i class="fas fa-plus-square"></i> {{post.created_at}} </span>
                    <span><i class="fas fa-pencil-alt"></i> {{post.updated_at}} </span>
                </p>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div style="white-space : pre-line;"  v-if="post.status == '1' || self_view ">{{post.post_content}}</div>

                    <div class="card text-center" v-if="post.status != '1' &&  ! self_view ">
                        <div class="card-header">
                            404 error, Your requested content could not be found.
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">404</h5>
                            <p class="card-text">This could be happen either post has been removed, or not published yet.</p>
                            <router-link :to="{name: 'home'}" class="btn btn-primary">Go to Home</router-link>
                        </div>
                        <div class="card-footer text-muted">
                            Please say sorry to us for visiting an invalid page
                        </div>
                    </div>

                </div>


                <div class="col-md-4">
                    <tag-lists></tag-lists>
                </div>

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
import TagLists from '../components/TagLists';
    export default {
        components: {
            TagLists,
        },
        data: function(){
            return {
                post : {},
                is_loading : true,
                self_view: false,
            }
        },

        mounted : function(){
            let app = this;

            let api_uri = laravel.route.api_get_single_post.replace('{slug}', this.$route.params.slug);
            axios.get(api_uri)
                .then(function(res){
                    if (res.data.success){
                        app.post = res.data.post;
                        app.title = app.post.title;
                        app.is_loading = false;

                        if (app.post.status != '1'){
                            if (laravel.user.auth && laravel.user.data.id === app.post.user_id){
                                app.self_view = true;
                            }
                        }
                    }
                })
                .catch(function(res){
                    app.is_loading = false;
                    console.log('network error')
                })
        }
    }

</script>