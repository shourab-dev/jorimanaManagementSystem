import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);

// import section
// login
import Login from "../components/auth/Login.vue";
// REGISTER
import Register from "../components/auth/Register.vue";

// DASHBOARD
import Dashboard from "../components/backend/Dashboard.vue";

// import section ends

const routes = [
    {
        path: "/",
        name: "login",
        component: Login,
    },
    {
        path: "/register",
        name: "register",
        component: Register,
    },
    {
        path: "/dashboard",
        name: "dashboard",
        component: Dashboard,
    },
];

const router = new VueRouter({
    mode: "history",
    routes,
});

export default router;
