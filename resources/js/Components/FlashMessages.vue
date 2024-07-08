<template>
    <div>
        <div
            class="snackbar top active"
            @click="closeMessage"
            v-if="flash.message"
        >
            <i>done</i>
            {{ flash.message }}
        </div>
        <div class="snackbar top active" @click="closeError" v-if="flash.error">
            <i>error</i>
            {{ flash.error }}
        </div>
    </div>
</template>

<script>
export default {
    name: "FlashMessages",
    computed: {
        auth() {
            return this.$page.props.auth;
        },
        flash() {
            return this.$page.props.flash;
        },
    },
    methods: {
        closeMessage() {
            this.flash.message = "";
        },
        closeError() {
            this.flash.error = "";
        },
    },
};
</script>
