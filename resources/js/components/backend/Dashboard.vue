<template>
    <div>
        <AddFine :isOpen="isOpen" @closeModal="closeModal" />

        <div class="d-flex justify-content-between">
            <h2>
                Welcome to Dashbaord
                <span class="text-capitalize"
                    >Mr. {{ $store.state.auth.name }}</span
                >
            </h2>
             <button
                    type="button"
                    class="btn btn-primary"
                    @click="isOpen = !isOpen"
                >
                    Add Jorimana +
                </button>
        </div>
    </div>
</template>

<script>
import AddFine from "./fine/AddFine.vue";
export default {
    // COMPONENTS STARTS HERE
    components: {
        AddFine,
    },
    // DATA STARTS HERE
    data() {
        return {
            isOpen: false,
        };
    },
    // MOUNTED STARTS HERE
    mounted() {
        this.$store.commit("checkAuth");
    },
    // METHODS STARTS HERE
    methods: {
        closeModal() {
            this.isOpen = false;
        },
    },
};
</script>

<style lang="scss" scoped></style>
