import Vue from 'vue'
import VueRouter from 'vue-router'
import Example from "./components/Example";
import ContactsCreate from "./views/ContactsCreate.vue";
import ContactsShow from "./views/ContactsShow.vue"

const routes = [
    { path:"/", component:Example},
    { path:"/contacts/create", component:ContactsCreate},
    { path:"/contacts/:id", component:ContactsShow},
]

Vue.use(VueRouter)

export default new VueRouter({
    routes,
    mode:"history"
})