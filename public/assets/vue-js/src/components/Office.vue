<template>

    <div>

        <div class="container mt-5 mb-5">
            <div class="row">
                <div class="col-md-12"><h2 class="text-center">Back Office</h2></div>
            </div>

            <div class="row">

                <div class="col-md-3">
                    <div class="list-group">
                        <router-link :to="{ name: 'create_post'}" class="list-group-item" active-class="active"> <i class="fas fa-pencil-alt"></i> Create Post </router-link>
                        <router-link :to="{name: 'office_posts'}" class="list-group-item" active-class="active" > <i class="fas fa-list"></i> Posts</router-link>
                        <router-link :to="{name: 'office_all_posts'}" class="list-group-item" active-class="active" v-if="is_admin"><i class="fas fa-list-alt"></i> All Posts</router-link>

                        <router-link :to="{ name: 'logout'}" class="list-group-item"> <i class="fas fa-sign-out-alt"></i> LogOut </router-link>
                    </div>
                </div>


                <div class="col-md-9">
                    <router-view></router-view>
                </div>


            </div>

        </div>


    </div>

</template>

<script>
    export default {
        name: "Office",
        data: function(){
            return {
                is_admin : (laravel.user.data.user_type === 'admin')
            }
        }
    }
</script>