<template>
    <div class="layout">
        <b-navbar class="navigation-bar">
            <template slot="start">
                <b-navbar-item tag="div">
                    <inertia-link :href="$route('home')">
                        <b-button type="is-text">Home</b-button>
                    </inertia-link>
                </b-navbar-item>
            </template>

            <template slot="end">
                <b-navbar-item tag="div">
                    <inertia-link :href="$route('auth.logout')" method="post" v-if="$page.auth.user">
                        <b-button type="is-info is-light">Logout</b-button>
                    </inertia-link>
                    <inertia-link :href="$route('auth')" v-else>
                        <b-button type="is-info is-light">Login</b-button>
                    </inertia-link>
                </b-navbar-item>
            </template>
        </b-navbar>

        <div class="content">
            <slot />
        </div>
    </div>
</template>

<script>
export default {
    //
}
</script>

<style scoped>
.layout {
    display: flex;
    flex-direction: column;
}

.navigation-bar {
    background-color: #bfbfbf;
}

.content {
    padding: 10px;
}
</style>
