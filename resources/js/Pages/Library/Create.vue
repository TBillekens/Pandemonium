<template>
    <div>
        <h5>Create your new library</h5>
        <article>
            <p>
                Here you can create a new library to keep track of your books.
            </p>
            <form @submit.prevent="createLibrary">
                <div class="field label round border small-round">
                <input v-model="title" type="text" lazy>
                <label>Title</label>
                </div>
                <nav class="right-align">
                    <button class="button small-round">Create</button>
                </nav>
            </form>
        </article>
    </div>
</template>

<script>
    import { ref } from 'vue';

    export default {
        props: {
            auth: Object,
        },
        setup(props) {
            const title = ref('');
            const user = props.auth.user;

            return {
                title,
                user,
            }
        },
        methods: {
            createLibrary() {
                this.$inertia.post('/library', {user_id: this.user.id, title: this.title});
            }
        }
    }
</script>
