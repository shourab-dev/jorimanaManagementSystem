<template>
    <div id="jorimanaModal" v-if="isOpen">
        <div class="mainModal">
            <div class="modalHeader">
                <div class="d-flex justify-content-between">
                    <h4 class="text-primary">Add Fines</h4>
                    <div class="btn-group">
                        <button class="btn btn-primary" @click="addNewStudent">
                            Add New Student
                        </button>
                        <button @click="hideModal" class="btn btn-danger">
                            Cancel
                        </button>
                    </div>
                </div>
                <hr />
            </div>
            <div class="modalBody">
                <label class="d-block">
                    Select Batch
                    <select class="form-control mb-2" v-model="batchId">
                        <option
                            v-for="(batch, index) in batches"
                            :value="batch.id"
                            :key="index"
                        >
                            {{ batch.name }}
                        </option>
                    </select>
                    <label
                        class="d-block py-3 border-bottom"
                        v-for="(form, index) in forms"
                        :key="index"
                    >
                        Student {{ ++index }}
                        <div class="row">
                            <div class="col-md-4">
                                <input
                                    type="text"
                                    placeholder="Student Name"
                                    class="form-control"
                                    v-model="form.name"
                                />
                            </div>
                            <div class="col-md-4">
                                <input
                                    type="text"
                                    placeholder="Amount (Dollar / tk)"
                                    class="form-control"
                                    v-model="form.amount"
                                />
                            </div>
                            <div class="col-md-3">
                                <select
                                    class="form-control"
                                    v-model="form.paid"
                                >
                                    <option value="false">Un-Paid</option>
                                    <option value="true">Paid</option>
                                </select>
                            </div>
                            <div class="col-1 text-start px-0">
                                <button
                                    v-if="forms.length > 1"
                                    class="btn btn-danger"
                                    @click="deleteStudentRecord(--index)"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </label>
                    <button
                        @click="storeFines"
                        type="submit"
                        class="btn btn-outline-primary rounded-0 mt-4 d-block w-100"
                    >
                        Save Jorimana List
                    </button>
                </label>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["isOpen"],

    // DATA
    data() {
        return {
            batchId: "",
            batches: [],
            forms: [
                {
                    name: "",
                    amount: "",
                    paid: false,
                },
            ],
        };
    },
    mounted() {
        // FETCH ALL BATCHES
        this.$store.commit("checkAuth");
        axios
            .get(this.$store.state.url + "api/auth/all-batch", {
                headers: {
                    Authorization: `Bearer ${this.$store.state.token}`,
                },
            })
            .then((res) => {
                this.batches = res.data;
            });
    },
    // METHODS
    methods: {
        addNewStudent() {
            this.forms.push({
                name: "",
                amount: "",
                paid: false,
            });
        },
        hideModal() {
            this.$emit("closeModal");
        },

        storeFine() {
            console.log("done");
        },
        deleteStudentRecord(index) {
            if (this.forms.length > 1) {
                this.forms.splice(index, 1);
            }
        },

        storeFines() {
            if (this.batchId == "") {
                Toast.fire({
                    icon: "error",
                    title: `Please select a batch`,
                });
                return;
            }
            this.forms.map((form, index) => {
                if (form.name == "") {
                    Toast.fire({
                        icon: "error",
                        title: `Please Enter Student ${++index} name`,
                    });
                    return;
                } else if (form.amount == "") {
                    Toast.fire({
                        icon: "error",
                        title: `Please Enter Student ${++index} amount`,
                    });
                    return;
                }
                if (form.paid === "true") {
                    form.paid = true;
                } else {
                    form.paid = false;
                }
            });

            //   AXIOS REQUEST AFTER VALIDATION
            axios
                .post(this.$store.state.url + "api/auth/store-fines", {
                    token: this.$store.state.token,
                    batchId: this.batchId,
                    forms: this.forms,
                })
                .then((res) => {
                    this.$emit("refreshBatch");

                    this.hideModal();
                    Toast.fire({
                        icon: "success",
                        title: `Successfully Added`,
                    });
                    this.forms.splice(1, this.forms.length);
                    this.forms = [
                        {
                            name: "",
                            amount: "",
                            paid: false,
                        },
                    ];
                })
                .catch((err) => {
                    console.log(err.response);
                });
        },
    },
};
</script>

<style lang="scss" scoped>
#jorimanaModal {
    position: fixed;
    inset: 0;
    z-index: 999999;
    background-color: rgba(0, 0, 0, 0.25);
}
#jorimanaModal .mainModal {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    width: 100%;
    max-width: 700px;
    position: fixed;
    top: 100px;
    left: 50%;
    transform: translateX(-50%);
}
#jorimanaModal .modalBody {
    overflow-x: hidden;
    overflow-y: auto;
    max-height: 350px;
}
::-webkit-scrollbar {
    width: 3px;
}
::-webkit-scrollbar-track {
    background: #f1f1f1;
}
::-webkit-scrollbar-thumb {
    background: rgb(199, 221, 255);
    border-radius: 10px;
}
::-webkit-scrollbar-thumb:hover {
    background: rgb(159, 159, 159);
}
</style>
