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
        <div class="table-responsive mt-5" v-if="lists.data != 0">
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
                    <td>
                        <input
                            @keydown.enter="update(index)"
                            v-if="edit == --index"
                            type="text"
                            v-model="value.name"
                            class="form-control"
                        />
                        <p v-else>{{ list.name }}</p>
                    </td>
                    <td>
                        {{
                            moment(list.created_at).format(
                                "MMMM Do YYYY, h:mm:ss a"
                            )
                        }}
                    </td>
                    <td>
                        <button
                            v-if="edit == index"
                            @click="update(index)"
                            class="btn btn-outline-primary mb-1 btn-sm"
                        >
                            Update
                        </button>
                        <button
                            v-else
                            class="btn btn-outline-primary mb-1 btn-sm"
                            @click="editing(index)"
                        >
                            Edit
                        </button>
                        <button
                            class="btn btn-outline-danger mb-1 btn-sm"
                            @click="batchDelete(list.id, index)"
                        >
                            Delete <i class="fas fa-trash"></i>
                        </button>
                    </td>
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
            value: {
                id: "",
                name: "",
            },
            name: "",
            edit: null,
            lists: {},
        };
    },
    // MOUNTED STARTS HERE
    mounted() {
        this.$store.commit("checkAuth");
        this.fetch();
    },
    // METHODS STARTS HERE
    methods: {
        batchDelete(id, index) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        "Deleted!",
                        "Your file has been deleted.",
                        "success"
                    );

                    axios
                        .delete(
                            this.$store.state.url + "api/auth/batch/delete",
                            {
                                headers: {
                                    Authorization: `Bearer ${this.$store.state.token}`,
                                    id: id,
                                },
                            }
                        )
                        .then((res) => {
                            this.lists.data.splice(index, 1);
                        });
                }
            });
        },
        editing(index, event) {
            this.edit = index;
            this.value.id = this.lists.data[index].id;
            this.value.name = this.lists.data[index].name;
        },

        update(index) {
            if (this.value.name == "") {
                Toast.fire({
                    icon: "error",
                    title: "Batch name can not be empty",
                });
            } else {
                axios
                    .put(this.$store.state.url + "api/auth/batch/update", {
                        token: this.$store.state.token,
                        value: this.value,
                    })
                    .then((res) => {
                        this.edit = null;
                        this.lists.data[index].name = res.data.name;
                        Toast.fire({
                            icon: "success",
                            title: "Batch Name Updated",
                        });
                    })
                    .catch((err) => {
                        Toast.fire({
                            icon: "error",
                            title: "This batch already exits",
                        });
                    });
            }
        },

        moment() {
            return moment();
        },
        fetch(page = 1) {
            axios
                .get(this.$store.state.url + "api/auth/all?page=" + page, {
                    headers: {
                        Authorization: `Bearer ${this.$store.state.token}`,
                    },
                })
                .then((res) => {
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
