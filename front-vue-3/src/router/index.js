//import vue router
import { createRouter, createWebHashHistory } from 'vue-router'

//defione a routes
const routes = [
    {
        path: '/',
        name: 'post.index',
        component: () => import('@/views/post/Index.vue')
    },
    {
        path: '/create',
        name: 'post.create',
        component: () => import('@/views/post/Create.vue')
    },
    {
        path: '/edit/:id',
        name: 'post.edit',
        component: () => import('@/views/post/Edit.vue')
    }
]

//create router
const router = createRouter({
    history: createWebHashHistory(),
    routes //config routes
})

export default router