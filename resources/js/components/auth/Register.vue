<template>
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">
                                            Register
                                        </h1>
                                    </div>
                                    <form @submit.prevent="signUp">
                                        <div class="form-group">
                                            <label>User Name</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="exampleInputFirstName"
                                                placeholder="Enter User Name"
                                                v-model="form.name"
                                            />
                                        </div>

                                        <div class="form-group">
                                            <label>Email</label>
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
                                            <label>Password</label>
                                            <input
                                                type="password"
                                                class="form-control"
                                                id="exampleInputPassword"
                                                placeholder="Password"
                                                v-model="form.password"
                                            />
                                        </div>
                                        <div class="form-group">
                                            <label>Repeat Password</label>
                                            <input
                                                type="password"
                                                class="form-control"
                                                id="exampleInputPasswordRepeat"
                                                placeholder="Repeat Password"
                                                v-model="form.confirmPassword"
                                            />
                                        </div>
                                        <div class="form-group">
                                            <button
                                                type="submit"
                                                class="btn btn-primary btn-block"
                                            >
                                                Register
                                            </button>
                                        </div>
                                        <hr />
                                        <a
                                            href="index.html"
                                            class="btn btn-google btn-block"
                                        >
                                            <i class="fab fa-google fa-fw"></i>
                                            Register with Google
                                        </a>
                                    </form>
                                    <hr />
                                    <div class="text-center">
                                        <router-link
                                            class="font-weight-bold small"
                                            :to="{ name: 'login' }"
                                            >Already have an
                                            account?</router-link
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
</template>

<script>
export default {
    data() {
        return {
            form: {
                name: "",
                email: "",
                password: "",
                confirmPassword: "",
            },
        };
    },
    // MOUNTED
    mounted() {
        this.$store.commit("redirectHome");
    },

    // METHODS
    methods: {
        signUp() {
            if (this.form.name == "") {
                Toast.fire({
                    icon: "error",
                    title: "User name is required",
                });
            } else if (this.form.email == "") {
                Toast.fire({
                    icon: "error",
                    title: "Email address is required",
                });
            } else if (this.form.password == "") {
                Toast.fire({
                    icon: "error",
                    title: "Password is required",
                });
            } else if (
                this.form.confirmPassword == "" ||
                this.form.password != this.form.confirmPassword
            ) {
                Toast.fire({
                    icon: "error",
                    title: "Confirm password did not match",
                });
            }
            // ACTUAL SIGNUP PROCESS
            else {
                axios
                    .post("http://127.0.0.1:8000/api/auth/sign-in", this.form)
                    .then((res) => {
                        Toast.fire({
                            icon: "success",
                            title: `${this.form.name} is successfully registered`,
                        });
                        this.$router.push({ name: "login" });
                    })
                    .catch((err) => {
                        let errors = err.response.data.errors;
                        if (errors.email[0].length > 0) {
                            Toast.fire({
                                icon: "error",
                                title: errors.email[0],
                            });
                        }
                        if (errors.password[0].length > 0) {
                            Toast.fire({
                                icon: "error",
                                title: errors.password[0],
                            });
                        }
                    });
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
