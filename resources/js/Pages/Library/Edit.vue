<template>
    <h1>Edit your library</h1>
    <article>
        <p>Here you can edit your library.</p>
        <form @submit.prevent="updateLibrary">
            <div class="field label round border small-round">
                <input v-model="title" type="text" lazy />
                <label>Title</label>
            </div>
            <nav class="right-align">
                <button class="button small-round">Update</button>
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
        library() {
            return this.$page.props.library;
        },
    },
    setup(props) {
        const title = ref(library.title);

        return {
            title,
        };
    },
    methods: {
        updateLibrary() {
            this.$inertia.put(`/library/${this.library.id}`, {
                user_id: this.auth.user.id,
                title: this.title,
            });
        },
    },
};
</script>
