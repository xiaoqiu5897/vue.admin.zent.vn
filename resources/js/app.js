import './bootstrap';
import Vue from 'vue';
import VueRouter from 'vue-router';
import App from './App.vue'
import { routes } from './routes'
import VueAxios from 'vue-axios'
import axios from './axios'
import VueParticles from 'vue-particles'

Vue.use(VueAxios, axios)
Vue.use(VueRouter)
Vue.use(VueParticles)

const router = new VueRouter({
	routes
})

new Vue({
    el: "#app",
    router,
    render: h => h(App)
})