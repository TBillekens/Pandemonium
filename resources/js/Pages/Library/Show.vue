<template>
    <h1>{{ library.title }}</h1>
    <article>
        <p>Here are all the books in this library.</p>
        <nav class="right-align">
            <a class="button small-round" href="/book/create">Add a new book</a>
        </nav>
    </article>
    <table v-if="library.books.length !== 0" class="stripes">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="book in library.books" :key="book.id">
                <td>{{ book.title }}</td>
                <td>{{ book.author }}</td>
                <td>
                    <a>Delete</a>
                </td>
            </tr>
        </tbody>
    </table>
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
        books() {
            return this.$page.props.books;
        },
    },
    methods: {
        deleteLibrary(id) {
            this.$inertia.delete("/library/" + id, {
                onSuccess: () => {
                    this.library = null;
                },
            });
        },
    },
};
</script>
