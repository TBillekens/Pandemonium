<template>
        <h1>Edit your library</h1>
        <article>
            <p>
                Here you can edit your library.
            </p>
            <form @submit.prevent="updateLibrary">
                <div class="field label round border small-round">
                    <input v-model="title" type="text" lazy>
                    <label>Title</label>
                </div>
                <nav class="right-align">
                    <button class="button small-round">Update</button>
                </nav>
            </form>
        </article>
</template>

<script>
    import { ref } from 'vue';

    export default {
        props: {
            auth: Object,
            library: Object,
        },
        setup(props) {
            const title = ref(props.library.title);
            const user = props.auth.user;

            return {
                title,
                user,
            }
        },
        methods: {
            updateLibrary() {
                this.$inertia.put(`/library/${this.library.id}`, {user_id: this.user.id, title: this.title});
            }
        }
    }
</script>
