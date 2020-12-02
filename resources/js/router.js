import Vue from 'vue'
import VueRouter from 'vue-router'
import Example from "./components/Example";

const routes = [
    { path:"/", component:Example}
]

Vue.use(VueRouter)

export default new VueRouter({
    routes,
    mode:"history"
})