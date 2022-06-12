<template>
    <div>
        <h2>Batch No {{ batch.name }}</h2>

        <!-- FILTER SECTION HERE -->
        <!-- FILTER SECTION ENDS HERE -->
        <div class="allFines mt-5">
            <div class="accordion" id="accordionExample">
                <div
                    class="accordion-item"
                    v-for="(student, index) in students"
                    :key="index"
                >
                    <h2
                        class="accordion-header"
                        :id="`headingOne${index}`"
                        @click="studentFine(student.name, student.batch_id)"
                    >
                        <button
                            class="accordion-button"
                            type="button"
                            data-bs-toggle="collapse"
                            :data-bs-target="`#collapseOne${index}`"
                            style="font-size: 30px; text-transform: capitalize"
                        >
                            {{ student.name }}
                        </button>
                    </h2>
                    <div
                        :id="`collapseOne${index}`"
                        class="accordion-collapse collapse"
                        aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample"
                    >
                        <div class="accordion-body">
                            <div class="row justify-content-evenly">
                                <div
                                    class="col-md-2 card myDetail text-center bg-success text-white"
                                >
                                    <p class="m-0 py-3">
                                        Total Received
                                        <span class="bigFont">{{
                                            amounts.paid
                                        }}</span>
                                        tk
                                    </p>
                                </div>
                                <div
                                    class="col-md-2 card myDetail text-center bg-danger text-white"
                                >
                                    <p class="m-0 py-3">
                                        Total Due
                                        <span class="bigFont">{{
                                            amounts.unPaid
                                        }}</span>
                                        tk
                                    </p>
                                </div>
                                <div
                                    class="col-md-2 card myDetail text-center bg-primary text-white"
                                >
                                    <p class="m-0 py-3">
                                        Total
                                        <span class="bigFont">{{
                                            amounts.total
                                        }}</span>
                                        tk
                                    </p>
                                </div>
                            </div>

                            <div class="table-responsive fullTable mt-4">
                                <table class="table">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Amount</th>
                                        <th>Paid/Unpaid</th>
                                        <th>Date</th>
                                    </tr>
                                    <tr
                                        class="text-center border-0"
                                        v-for="(fine, index) in fines"
                                        :key="index"
                                    >
                                        <td>{{ ++index }}</td>
                                        <td>
                                            <b>{{ fine.amount }}</b> tk
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    role="switch"
                                                    :id="`flexSwitchCheckChecked${index}`"
                                                    :checked="fine.ispaid == 1"
                                                    @click="
                                                        updateFine(
                                                            fine.id,
                                                            index
                                                        )
                                                    "
                                                />
                                                <label
                                                    class="form-check-label"
                                                    :for="`flexSwitchCheckChecked${index}`"
                                                    >{{
                                                        fine.ispaid == 1
                                                            ? "Paid"
                                                            : "Unpaid"
                                                    }}</label
                                                >
                                            </div>
                                        </td>
                                        <td>
                                            {{
                                                moment(fine.created_at).format(
                                                    "MMMM Do YYYY, h:mm:ss a"
                                                )
                                            }}
                                        </td>
                                    </tr>
                                </table>
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
            batch: {},
            students: [],
            fines: [],
            amounts: {
                paid: 0,
                unPaid: 0,
                total: 0,
            },
        };
    },
    // MOUNTED STARTS HERE
    mounted() {
        this.$store.commit("checkAuth");
        let id = this.$route.params.id;
        axios(this.$store.state.url + "api/auth/batch/fine/info", {
            headers: {
                Authorization: `Bearer ${this.$store.state.token}`,
                id: this.$route.params.id,
            },
        }).then((res) => {
            this.batch = res.data.batch;
            this.students = res.data.list;
        });
    },

    // METHODS STARTS HERE
    methods: {
        moment() {
            return moment();
        },
        studentFine(name, batchId) {
            axios
                .post(this.$store.state.url + "api/auth/student-fine", {
                    token: this.$store.state.token,
                    name: name,
                    batchId: batchId,
                })
                .then((res) => {
                    let data = res.data;
                    this.fines = [];
                    this.fines = res.data;
                    this.amounts.total = 0;
                    this.amounts.paid = 0;
                    this.amounts.unPaid = 0;

                    data.filter((fine) => {
                        if (fine.ispaid == 1) {
                            this.amounts.paid += fine.amount;
                        }
                        this.amounts.total += fine.amount;
                        this.amounts.unPaid =
                            this.amounts.total - this.amounts.paid;
                    });

                    // ENDS HERE
                });
        },

        // update paid / unpaid
        updateFine(fineId, index) {
            axios
                .put(this.$store.state.url + "api/auth/student-fine/update", {
                    token: this.$store.state.token,
                    fineId: fineId,
                })
                .then((res) => {
                    this.fines.splice(--index, 1, res.data);
                    if (res.data.ispaid == 0) {
                        this.amounts.paid = this.amounts.paid - res.data.amount;
                        this.amounts.unPaid =
                            this.amounts.unPaid + res.data.amount;
                    } else {
                        this.amounts.paid = this.amounts.paid + res.data.amount;
                        this.amounts.unPaid =
                            this.amounts.unPaid - res.data.amount;
                    }
                });
        },
    },
};
</script>

<style lang="scss" scoped>
span.bigFont {
    font-size: 30px;
}
</style>
