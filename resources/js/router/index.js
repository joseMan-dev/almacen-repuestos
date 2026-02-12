import { createRouter, createWebHistory } from 'vue-router'

const Home = { template: '<div>Home ok</div' }
const Repuestos = { template: '<div>Repuestos ok </div>' }

export default createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', component: Home },
        { path: '/repuestos', component: Repuestos },
    ],
})