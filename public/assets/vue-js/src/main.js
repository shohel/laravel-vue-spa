// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import PageTitleComponent from './components/page-title';

Vue.component('page-title', PageTitleComponent);
import axios from 'axios'
import VueAxios from 'vue-axios'

Vue.use(VueAxios, axios)
window.axios = axios
window._ = require('lodash');

Vue.config.productionTip = false


/* eslint-disable no-new */
new Vue({
  el: '#vue-app',
  router,
  components: { App },
  template: '<App/>'
})
