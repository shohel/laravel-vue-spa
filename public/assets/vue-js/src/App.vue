<template>

  <div>

    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
      <div class="container">

        <router-link :to="{ name: 'home'}" class="navbar-brand"> <i class="fas fa-home"></i> Home </router-link>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
          <!-- Authentication Links -->
          <li v-if="!user.auth"><router-link :to="{ name: 'login'}" class="nav-link"> <i class="fas fa-sign-in-alt"></i> Login </router-link></li>
          <li v-if="!user.auth"><router-link :to="{ name: 'register'}" class="nav-link"> <i class="fas fa-user-plus"></i> Register </router-link></li>
          <li  v-if="user.auth"><router-link :to="{ name: 'office'}" class="nav-link"> <i class="fas fa-user"></i> {{user.data.name}} </router-link></li>
        </ul>

      </div>
    </nav>


    <router-view :key="$route.fullPath"></router-view>

  </div>

</template>

<script>
    export default {
        name: 'App',
        data: function(){
            return {
                user: {auth: false, data: {} },
            }
        },
        created: function(){
            this.user = laravel.user;
        },
    }
</script>

<style>
  #app {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin-top: 60px;
  }
</style>
