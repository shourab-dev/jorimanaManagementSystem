<template>
    <div>
        <AddFine
            :isOpen="isOpen"
            @closeModal="closeModal"
            @refreshBatch="batchFine"
        />
        <div class="d-flex justify-content-between">
            <h2>All Fines</h2>
            <button type="button" class="btn btn-primary" @click="fineModal">
                Add Jorimana +
            </button>
        </div>

        <hr style="border-color: #eee" />

        <!-- ALL BATCHES WITH FINES -->
        <div
            class="card my-3"
            v-for="(batch, index) in batches.data"
            :key="index"
        >
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col-lg-6">
                        <h4>{{ batch.name }}</h4>
                        <p>
                            Total Due =
                            {{ batch.totalFines - batch.collectFines }} tk
                        </p>
                        <p>Total Received = {{ batch.collectFines || 0 }} tk</p>
                        <p>Total Jorimana = {{ batch.totalFines || 0 }} tk</p>
                    </div>
                    <div
                        class="col-lg-2 d-flex justify-content-between align-items-center"
                    >
                        <button
                            class="btn btn-primary"
                            @click="viewBatch(batch.id)"
                        >
                            View Reports
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <pagination :data="batches" @pagination-change-page="batchFine" />
        <!-- ALL BATCHES WITH FINES ends -->
    </div>
</template>

<script>
import AddFine from "./AddFine.vue";
import pagination from "laravel-vue-pagination";

export default {
    components: {
        pagination,
        AddFine,
    },
    data() {
        return {
            isOpen: false,
            batches: {},
        };
    },
    // MOUNTED
    created() {},
    mounted() {
        this.$store.commit("checkAuth");
        this.batchFine();
    },
    // methods
    methods: {
        fineModal() {
            this.isOpen = !this.isOpen;
        },
        closeModal() {
            this.isOpen = false;
        },

        batchFine(page = 1) {
            axios
                .get(
                    this.$store.state.url + "api/auth/batch-fine?page=" + page,
                    {
                        headers: {
                            Authorization: `Bearer ${this.$store.state.token}`,
                        },
                    }
                )
                .then((res) => {
                    console.log(res.data);
                    this.batches = res.data;
                })
                .catch((err) => {
                    console.log(err.response);
                });
        },

        viewBatch(id) {
            this.$router.push({ name: "batchWiseFine", params: { id: id } });
        },
    },
};
</script>

<style lang="scss"></style>
