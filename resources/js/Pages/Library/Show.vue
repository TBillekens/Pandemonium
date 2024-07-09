<template>
    <h1>
        {{ library.title }}
    </h1>
    <article>
        <p>
            Here you can view all the books you have put in {{ library.title }}.
        </p>
        <p>
            To add a new book to this library, go to the OpenLibrary API and
            search for a book. Then click on the "+" button.
        </p>
    </article>
    <div class="space"></div>
    <div v-if="books.length > 0">
        <table class="stripes">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Published</th>
                    <th>Language</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="book in books" :key="book.key">
                    <td>
                        <div class="absolute center middle">
                            <i
                                v-if="book.data.cover_i"
                                :id="`tippy-${book.data.cover_i}`"
                                >image</i
                            >
                            <i v-else>error</i>
                        </div>
                    </td>
                    <td>
                        {{ truncateText(book.data.title) }}
                    </td>
                    <td v-if="book.data.author_name">
                        {{ truncateText(book.data.author_name.join(", ")) }}
                    </td>
                    <td v-else>-</td>
                    <td v-if="book.data.publisher">
                        {{ truncateText(book.data.publisher.join(", ")) }}
                    </td>
                    <td v-else>-</td>
                    <td v-if="book.data.publish_date">
                        {{ truncateText(book.data.publish_date.join(", ")) }}
                    </td>
                    <td v-else>-</td>
                    <td v-if="book.data.language">
                        {{ truncateText(book.data.language.join(", ")) }}
                    </td>
                    <td v-else>-</td>
                    <td>
                        <div class="absolute center middle">
                            <button
                                @click="removeBookFromLibrary(book)"
                                class="border square round extra"
                            >
                                <i>remove</i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div v-else>
        <article>
            <p>There are no books in this library yet.</p>
        </article>
    </div>
</template>

<script>
import tippy from "tippy.js";
import { nextTick } from "vue";

export default {
    props: {
        library: Object,
        books: Array,
        config: Object,
    },
    methods: {
        truncateText(text) {
            if (text.length > 50) {
                return text.substring(0, 50) + "...";
            }
            return text;
        },

        removeBookFromLibrary(book) {
            this.$inertia.delete(
                `/library/${this.library.id}/book/${book.id}`,
                {
                    onError: (errors) => {
                        for (const key in errors) {
                            this.flash.error = errors[key];
                        }
                    },
                }
            );
        },

        async loadImages() {
            if (this.books.length > 0) {
                nextTick(() => {
                    this.books.forEach((book) => {
                        if (book.data.cover_i) this.imageShow(book.data);
                    });
                });
            }
        },

        async imageShow(data) {
            const url = `${this.config.openlibrary.covers_url}/b/id/${data.cover_i}-M.jpg`;

            try {
                tippy(document.getElementById(`tippy-${data.cover_i}`), {
                    content: `<img src="${url}" alt="Book cover" />`,
                    allowHTML: true,
                    animation: "scale",
                });
            } catch (error) {}
        },
    },
    mounted() {
        this.loadImages();
    },
};
</script>
