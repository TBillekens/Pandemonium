<template>
    <nav class="left drawer 1">
        <header>
            <nav>
                <h6>Pandemonium</h6>
            </nav>
        </header>

        <nav v-if="!$page.props.auth.user" class="no-space center-align">
            <button data-ui="#loginDialog" class="border left-round max small">
                <i>person</i>
                <span>Login</span>
            </button>
            <button
                data-ui="#registerDialog"
                class="border right-round max small"
            >
                <i>edit</i>
                <span>Register</span>
            </button>
        </nav>
        <nav v-if="$page.props.auth.user" class="no-space center-align">
            <button class="border left-round max small">
                <i>person</i>
                <span>{{ $page.props.auth.user.name }}</span>
            </button>
            <button @click="logout" class="border right-round max small">
                <i>logout</i>
                <span>Logout</span>
            </button>
        </nav>
        <a href="/">
            <i>home</i>
            <div>Home</div>
        </a>
        <a href="/library/">
            <i>book</i>
            <div>Libraries</div>
        </a>
        <a href="/openlibrary/">
            <i>api</i>
            <div>OpenLibrary</div>
        </a>
    </nav>

    <Login></Login>
    <Register></Register>
</template>

<script>
import Login from "./Auth/Login.vue";
import Register from "./Auth/Register.vue";

export default {
    name: "Navigation",
    components: {
        Login,
        Register,
    },
    props: {
        auth: Object,
    },
    methods: {
        logout() {
            this.$inertia.post(
                "/auth/logout",
                {},
                {
                    preserveState: false,
                }
            );
        },
    },
};
</script>
