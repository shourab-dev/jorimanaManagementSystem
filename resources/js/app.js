require("./bootstrap");

window.Vue = require("vue").default;

import router from "./router/router.js";
import store from "./store/store.js";

// MOMENT JS FOR DATA & TIME FORMAT
const moment = require("moment");
window.moment = moment;

// MOMENT JS FOR DATA & TIME FORMAT
// SWEET ALERT 2

import Swal from "sweetalert2";
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});

window.Toast = Toast;
// SWEET ALERT 2 END

Vue.component("app", require("./components/App.vue").default);

const app = new Vue({
    el: "#app",
    router,
    store: store,
});
