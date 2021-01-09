import Vue from 'vue'
import VueRouter from 'vue-router'
import Example from "./components/Example";
import ContactsCreate from "./views/ContactsCreate.vue";
import ContactsShow from "./views/ContactsShow.vue"
import ContactsEdit from "./views/ContactsEdit.vue"
import ContactsIndex from "./views/ContactsIndex.vue"
import BirthdayIndex from "./views/BirthdayIndex.vue"

const routes = [
    { path:"/", component:Example},
    { path:"/contacts", component:ContactsIndex},
    { path:"/contacts/birthdays", component:BirthdayIndex},
    { path:"/contacts/create", component:ContactsCreate},
    { path:"/contacts/:id", component:ContactsShow},
    { path:"/contacts/:id/edit", component:ContactsEdit},
]

Vue.use(VueRouter)

export default new VueRouter({
    routes,
    mode:"history"
})