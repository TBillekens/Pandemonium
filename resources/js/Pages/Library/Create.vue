<template>
    <h1>Create your new library</h1>
    <article>
        <p>Here you can create a new library to keep track of your books.</p>
        <form @submit.prevent="createLibrary">
            <div class="field label round border small-round">
                <input v-model="title" type="text" lazy />
                <label>Title</label>
            </div>
            <nav class="right-align">
                <button class="button small-round">Create</button>
            </nav>
        </form>
    </article>
</template>

<script>
import { ref } from "vue";

export default {
    computed: {
        auth() {
            return this.$page.props.auth;
        },
    },
    setup() {
        const title = ref("");

        return {
            title,
        };
    },
    methods: {
        createLibrary() {
            this.$inertia.post("/library", {
                user_id: this.auth.user.id,
                title: this.title,
            });
        },
    },
};
</script>
