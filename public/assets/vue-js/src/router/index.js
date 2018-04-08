import Vue from 'vue'
import Router from 'vue-router'
import Home from '../components/Home';
import VueLogin from '../components/VueLogin';
import LogOut from '../components/LogOut';
import Register from '../components/Register'
import CreatePost from '../components/CreatePost'
import SinglePost from '../components/SinglePost';
import SingleTag from '../components/SingleTag';
import AuthorPosts from '../components/AuthorPosts';
import Office from '../components/Office';
import OfficePosts from '../components/OfficePosts';
import OfficeAllPosts from '../components/office/OfficeAllPosts';

Vue.use(Router)

export default new Router({
    mode: 'history',
    base: laravel.base,
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/sign-in',
            name: 'login',
            component: VueLogin,
            meta: {title: 'Login'}
        },
        {
            path: '/sign-out',
            name: 'logout',
            component: LogOut
        },

        {
            path: '/user-register',
            name: 'register',
            component: Register
        },
        {
            path: '/post/:slug',
            name: 'single_post',
            component: SinglePost,
        },
        {
            path: '/tag/:slug',
            name: 'single_tag',
            component: SingleTag,
        },
        {
            path: '/author/:user_name',
            name: 'author_posts',
            component: AuthorPosts,
        },

        {
            path: '/office',
            name: 'office',
            component: Office,
            beforeEnter: (to, from, next) => {
                if (laravel.user.auth){
                    next();
                }else {
                    next({ name: 'login'})
                }
            },
            children : [
                {
                    path: '/create-post',
                    name: 'create_post',
                    component: CreatePost,
                },
                {
                    path: '/office/posts',
                    name: 'office_posts',
                    component: OfficePosts,
                },
                {
                    path: '/office/all-posts',
                    name: 'office_all_posts',
                    component: OfficeAllPosts,
                },
            ]
        },

    ]
})
