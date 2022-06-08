<template>
    <div>
        <div class="container-login">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-12 col-md-9">
                    <div class="card shadow-sm my-5">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="login-form">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">
                                                Login
                                            </h1>
                                        </div>
                                        <form @submit.prevent="login">
                                            <div class="form-group">
                                                <input
                                                    type="email"
                                                    class="form-control"
                                                    id="exampleInputEmail"
                                                    aria-describedby="emailHelp"
                                                    placeholder="Enter Email Address"
                                                    v-model="form.email"
                                                />
                                            </div>
                                            <div class="form-group">
                                                <input
                                                    type="password"
                                                    class="form-control"
                                                    id="exampleInputPassword"
                                                    placeholder="Password"
                                                    v-model="form.password"
                                                />
                                            </div>

                                            <div class="form-group">
                                                <button
                                                    type="submit"
                                                    class="btn btn-primary btn-block"
                                                >
                                                    Login
                                                </button>
                                            </div>
                                            <hr />
                                            <a
                                                href="index.html"
                                                class="btn btn-google btn-block"
                                            >
                                                <i
                                                    class="fab fa-google fa-fw"
                                                ></i>
                                                Login with Google
                                            </a>
                                        </form>
                                        <hr />
                                        <div class="text-center">
                                            <router-link
                                                class="font-weight-bold small"
                                                :to="{ name: 'register' }"
                                                >Create an Account!</router-link
                                            >
                                        </div>
                                        <div class="text-center"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                email: "",
                password: "",
            },
        };
    },

    mounted() {
        this.$store.commit("redirectHome");
    },

    // METHODS
    methods: {
        login() {
            if (this.form.email == "") {
                Toast.fire({
                    icon: "error",
                    title: "Enter your email",
                });
            } else if (this.form.password == "") {
                Toast.fire({
                    icon: "error",
                    title: "Please enter a password",
                });
            } else {
                axios
                    .post(this.$store.state.url + "api/auth/login", this.form)
                    .then((res) => {
                        Toast.fire({
                            icon: "success",
                            title: "Login Successfull",
                        });
                        this.$store.commit("setToken", res.data.access_token);
                        this.$router.push({ name: "dashboard" });
                    })
                    .catch((err) => {
                        Toast.fire({
                            icon: "error",
                            title: err.response.data.error,
                        });
                    });
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
