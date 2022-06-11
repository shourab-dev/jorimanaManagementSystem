<template>
    
        <div id="jorimanaModal" v-if="isOpen">
            <form @submit.prevent="storeFine">
                <div class="mainModal">
                    <div class="modalHeader">
                        <div class="d-flex justify-content-between">
                            <h4 class="text-primary">Add Fines</h4>
                            <div class="btn-group">
                                <button class="btn btn-primary">
                                    Add New Student
                                </button>
                                <button
                                    @click="hideModal"
                                    class="btn btn-danger"
                                >
                                    Cancel
                                </button>
                            </div>
                        </div>
                        <hr />
                    </div>
                    <div class="modalBody">
                        <label class="d-block">
                            Select Batch
                            <select class="form-control mb-2">
                                <option value="">new batch</option>
                                <option value="">new batch</option>
                                <option value="">new batch</option>
                            </select>
                            <label class="d-block py-3 border-bottom">
                                Student 1
                                <div class="row">
                                    <div class="col-md-6">
                                        <input
                                            type="text"
                                            placeholder="Student Name"
                                            class="form-control"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <input
                                            type="text"
                                            placeholder="Amount (Dollar / tk)"
                                            class="form-control"
                                        />
                                    </div>
                                </div>
                            </label>
                            <button
                                type="submit"
                                class="btn btn-outline-primary rounded-0 mt-4 d-block w-100"
                            >
                                Save Jorimana List
                            </button>
                        </label>
                    </div>
                </div>
            </form>
        </div>
   
</template>

<script>
export default {
    props: ["isOpen"],

    // METHODS
    methods: {
        hideModal() {
            this.$emit("closeModal");
        },

        storeFine() {
            console.log("done");
        },
    },
};
</script>

<style lang="scss" scoped>
#jorimanaModal {
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.25);
}
#jorimanaModal .mainModal {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    width: 100%;
    max-width: 700px;
    position: fixed;
    top: 150px;
    left: 50%;
    transform: translateX(-50%);
}

</style>
