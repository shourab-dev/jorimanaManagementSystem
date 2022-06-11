<template>
    <div>
        <AddFine :isOpen="isOpen" @closeModal="closeModal" />
        <div class="d-flex justify-content-between">
            <h2>All Fines</h2>
            <button type="button" class="btn btn-primary" @click="fineModal">
                Add Jorimana +
            </button>
        </div>
    </div>
</template>

<script>
import AddFine from "./AddFine.vue";
export default {
    components: {
        AddFine,
    },
    data() {
        return {
            isOpen: false,
        };
    },

    // methods
    methods: {
        fineModal() {
            this.isOpen = !this.isOpen;
        },
        closeModal() {
            this.isOpen = false;
        },
    },
};
</script>

<style lang="scss" scoped></style>
