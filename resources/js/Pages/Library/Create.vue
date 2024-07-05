<template>
    <div>
        <article>
            <h5>Create your new library</h5>
            <p>
                Here you can create a new library to keep track of your books.
            </p>
            <form @submit.prevent="createLibrary">
                <div class="field label round border small">
                <input v-model="title" type="text" lazy>
                <label>Title</label>
                </div>
                <nav class="right-align">
                    <button class="button small">Create</button>
                </nav>
            </form>
        </article>
    </div>
</template>

<script>
    import { ref } from 'vue';

    export default {
        data() {
            return {
                title: ''
            }
        },
        setup() {
            return {
                title: ref('')
            }
        },
        methods: {
            createLibrary() {
                this.$inertia.post('/library/store', {id: 1, title: this.title});
            }
        }
    }
</script>
