<template>
    <div>
        <div id="wrapper">
            <!-- Sidebar -->
            <Navbar />

            <!-- Sidebar -->
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <TopBar />

                    <!-- Container Fluid-->
                    <div class="container-fluid" id="container-wrapper">
                        <router-view></router-view>

                        <!-- Modal Logout -->
                        <div
                            class="modal fade"
                            id="logoutModal"
                            tabindex="-1"
                            role="dialog"
                            aria-labelledby="exampleModalLabelLogout"
                            aria-hidden="true"
                        >
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5
                                            class="modal-title"
                                            id="exampleModalLabelLogout"
                                        >
                                            Ohh No!
                                        </h5>
                                        <button
                                            type="button"
                                            class="close"
                                            data-dismiss="modal"
                                            aria-label="Close"
                                        >
                                            <span aria-hidden="true"
                                                >&times;</span
                                            >
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to logout?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button
                                            type="button"
                                            class="btn btn-outline-primary"
                                            data-dismiss="modal"
                                        >
                                            Cancel
                                        </button>
                                        <a
                                            href="login.html"
                                            class="btn btn-primary"
                                            >Logout</a
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---Container Fluid-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from "./common/Navbar.vue";
import TopBar from "./common/TopBar.vue";
export default {
    components: {
        Navbar,
        TopBar,
    },
};
</script>

<style lang="scss" scoped></style>
