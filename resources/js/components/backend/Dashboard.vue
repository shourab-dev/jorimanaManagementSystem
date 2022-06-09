<template>
    <div>
        <h2>
            Welcome to Dashbaord
            <span class="text-capitalize">Mr. {{ $store.state.auth.name }}</span>
        </h2>
    </div>
</template>

<script>
export default {
    mounted() {
        this.$store.commit("checkAuth");
    },
};
</script>

<style lang="scss" scoped></style>
