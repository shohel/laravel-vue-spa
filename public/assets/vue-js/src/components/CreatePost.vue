<template>
    <div>

        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-12 ">

                    <h1>Add a new post</h1>

                    <div v-if="errors.length" class="alert alert-warning">
                        <p>Please correct the following error(s)</p>

                        <ul>
                            <li v-for="error in errors">{{error}}</li>
                        </ul>
                    </div>


                    <form v-on:submit="savePost">
                        <div class="form-group">
                            <label for="post_title">Post Title</label>
                            <input type="text" v-model="post.title" class="form-control" id="post_title" placeholder="Post title">

                        </div>
                        <div class="form-group">
                            <label for="post_content">Post Content</label>
                            <textarea v-model="post.post_content" class="form-control" id="post_content" rows="10"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input type="text" v-model="post.tags" class="form-control" id="tags" placeholder="tag1, tag2, tag3">
                            <small>separate tag by comma (,). ex: tag1, tag2, tag3</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Add New Post</button>
                    </form>

                </div>

            </div>
        </div>

    </div>
</template>


<script>
    export default {
        data: function(){
            return {
                post: {
                    title: '',
                    post_content: '',
                    tags: '',
                },
                errors : []
            }
        },


        methods : {
            savePost(event){
                event.preventDefault();

                this.errors = [];
                if (!this.post.title){
                    this.errors.push("Name required");
                }
                if (!this.post.post_content){
                    this.errors.push("Post Content required");
                }

                let app = this;
                if ( ! this.errors.length) {
                    axios.post(laravel.route.save_new_post, this.post)
                        .then(function (res) {
                            app.$router.push('/')
                        })
                        .catch(function (res) {
                            console.log("Error sending..");
                        });
                }

            }

        }
    }
</script>