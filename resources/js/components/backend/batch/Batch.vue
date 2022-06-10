<template>
    <div>
        <div class="col-md-5 mx-auto shadow p-3 rounded">
            <h2>Add New Batch</h2>
            <form @submit.prevent="store">
                <input
                    type="text"
                    v-model="name"
                    class="form-control"
                    placeholder="Batch Name"
                />
                <button class="btn btn-primary mt-2">Submit</button>
            </form>
        </div>

        <!-- ALL DATA -->
        <div class="table-responsive mt-5">
            <table class="table">
                <tr class="bg-primary text-white">
                    <th>#</th>
                    <th>Name</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                <tr
                    class="border-0"
                    v-for="(list, index) in lists.data"
                    :key="index"
                >
                    <td>{{ ++index }}</td>
                    <td>{{ list.name }}</td>
                    <td>{{ list.created_at }}</td>
                    <td>Edit</td>
                </tr>
            </table>
            <pagination :data="lists" @pagination-change-page="fetch" />
        </div>
    </div>
</template>

<script>
import pagination from "laravel-vue-pagination";
export default {
    components: {
        pagination,
    },
    data() {
        return {
            name: "",
            lists: {},
        };
    },
    mounted() {
        this.$store.commit("checkAuth");
        this.fetch();
    },
    methods: {
        fetch(page = 1) {
            axios
                .get(this.$store.state.url + "api/auth/all?page=" + page, {
                    headers: {
                        Authorization: `Bearer ${this.$store.state.token}`,
                    },
                })
                .then((res) => {
                    console.log(res.data);
                    this.lists = res.data;
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
        store() {
            if (this.name == "") {
                Toast.fire({
                    icon: "error",
                    title: "Please enter a batch name",
                });
            } else {
                axios
                    .post(this.$store.state.url + "api/auth/batch", {
                        token: this.$store.state.token,
                        user: this.$store.state.auth.id,
                        name: this.name,
                    })
                    .then((res) => {
                        console.log(res.data);
                        let array = res.data;
                        this.lists.data.unshift(array);
                        this.name = "";
                        Toast.fire({
                            icon: "success",
                            title: `Batch ${res.data.name} has been added`,
                        });
                    })
                    .catch((err) => {
                        let errors = err.response.data.errors;

                        if (errors.name[0]) {
                            Toast.fire({
                                icon: "error",
                                title: "This batch already exits",
                            });
                        }
                    });
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
