<template>

    <div>

        <div class="card card-blog-post" v-for="(post, index) in posts" v-if="posts.length" >
            <div class="card-body">

                <router-link :to="{name: 'single_post', params : {slug: post.slug} }">
                    <h4 class="mb-2 card-title">{{post.title}}</h4>
                </router-link>

                <p class="small mb-2 text-muted">
                    <i class="fas fa-user"></i>

                    <router-link :to="{name: 'author_posts', params : {user_name: post.user.user_name} }">
                        {{post.user.name}}
                    </router-link>
                    <i class="fas fa-clock"></i> {{post.created_at}}
                    <span v-if="post.tags.length">
                                    <i class="fas fa-tags"></i> <a href="" v-for="tag in post.tags">{{tag.tag_name}}, </a>
                                </span>
                </p>

                <p class="card-text">{{post.post_content.slice(0, 200)}}</p>

            </div>
        </div>



    </div>

</template>


<script>
    export default {
        props : ['posts'],
    }
</script>