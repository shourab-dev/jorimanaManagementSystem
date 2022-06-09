import Vue from "vue";
import Vuex from "vuex";
import router from "../router/router.js";
Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        url: "http://127.0.0.1:8000/",
        token: localStorage.getItem("auth") || "",
        auth: {},
    },
    mutations: {
        setToken(state, token) {
            localStorage.setItem("auth", token);
            state.token = localStorage.getItem("auth");
        },

        clearToken(state) {
            localStorage.removeItem("auth");
            state.token = "";
            state.auth = "";
        },

        checkAuth(state) {
            if (state.token !== "") {
                axios
                    .post(state.url + "api/auth/me", { token: state.token })
                    .then((res) => {
                        state.auth = res.data;
                    })
                    .catch((err) => {
                        this.commit("clearToken");
                        router.push({ name: "login" });
                        state.auth = "";
                    });
            } else {
                router.push({ name: "login" });
                this.commit("clearToken");
                state.auth = "";
            }
        },

        redirectHome(state) {
            if (state.token !== "") {
                axios
                    .post(state.url + "api/auth/me", { token: state.token })
                    .then((res) => {
                        router.push({ name: "dashboard" });
                    })
                    .catch((err) => {
                        this.commit("clearToken");
                        router.push({ name: "login" });
                    });
            } else {
                this.commit("clearToken");
            }
        },
    },
});

export default store;
