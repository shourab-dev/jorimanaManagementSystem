<template>
    <div
        v-if="
            this.$route.path == '/' || this.$route.path == '/register'
                ? false
                : true
        "
    >
        <ul
            class="navbar-nav sidebar sidebar-light accordion"
            id="accordionSidebar"
        >
            <a
                class="sidebar-brand d-flex align-items-center justify-content-center"
                href="/"
            >
                <div class="sidebar-brand-icon">
                    <img src="/backend/img/logo/logo2.png" />
                </div>
                <div class="sidebar-brand-text mx-3">JMS</div>
            </a>
            <hr class="sidebar-divider my-0" />

            <li class="nav-item" v-for="(link, index) in links" :key="index">
                <router-link
                    class="nav-link collapsed"
                    :to="link.path || `#`"
                    :data-toggle="link.child ? 'collapse' : null"
                    :data-target="`#menu${index}`"
                    aria-expanded="true"
                    aria-controls="collapseBootstrap"
                >
                    <span v-html="link.icon"></span>
                    <span>{{ link.name }}</span></router-link
                >
                <div
                    v-if="link.child"
                    :id="`menu${index}`"
                    class="collapse"
                    aria-labelledby="headingBootstrap"
                    data-parent="#accordionSidebar"
                >
                    <div
                        class="bg-white py-2 collapse-inner rounded"
                        v-for="(child, id) in link.child"
                        :key="id"
                    >
                        <router-link class="collapse-item" :to="child.path">
                            {{ child.name }}
                        </router-link>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import navLinks from "./navLinks.js";
export default {
    data() {
        return {
            links: navLinks,
        };
    },
};
</script>

<style lang="scss" scoped></style>
