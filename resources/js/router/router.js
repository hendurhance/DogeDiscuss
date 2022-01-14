import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from '../auth/Login.vue'
import Home from '../pages/Home.vue'
import Register from '../auth/Register.vue'
import Forum from '../components/Forum/Forum.vue'
import QuestionDetail from '../components/Forum/QuestionDetail.vue'
import CreateQuestion from '../components/Forum/CreateQuestion.vue'
import EditQuestion from '../components/Forum/EditQuestion.vue'
import CategoryList from '../components/Category/CategoryList.vue'
import CreateCategory from '../components/Category/CreateCategory.vue'
import CategoryDetail from '../components/Category/CategoryDetail.vue'

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
    {
        path: '/q/:slug',
        name: 'question',
        component: QuestionDetail,
        props: true
    },
    {
        path: '/q/:slug/edit',
        name: 'edit',
        component: EditQuestion,
        props: true
    },
    {
        path : '/ask-question',
        name: 'ask-question',
        component: CreateQuestion
    },
    {
        path: '/categories',
        name: 'categories',
        component: CategoryList
    },
    {
        path: '/c/create',
        name: 'create-category',
        component: CreateCategory
    },
    {
        path: '/c/:slug',
        name: 'category',
        component: CategoryDetail,
        props: true
    }
    
    
]


const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
    
})




export default router