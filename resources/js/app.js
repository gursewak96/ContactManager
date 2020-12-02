require('./bootstrap');
import Vue from "vue";
import router from './router';
import App from "./components/App";

var app = new Vue({
    el: "#app",
    components:{
        App
    },
    router
});