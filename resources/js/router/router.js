import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from '../auth/Login.vue'
import Home from '../pages/Home.vue'
import Register from '../auth/Register.vue'
import Forum from '../components/Forum/Forum.vue'

Vue.use(VueRouter)


const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/register',
        name: 'register',
        component: Register
    },
    {
        path: '/forum',
        name: 'forum',
        component: Forum
    },
    
]


const router = new VueRouter({
    mode: 'history',

    routes // short for `routes: routes`
    
})


export default router