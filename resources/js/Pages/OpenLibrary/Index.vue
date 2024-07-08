<template>
    <h1>OpenLibrary</h1>
    <article>
        <p>
            OpenLibrary is a free, open source project that allows you to search
            for books and authors. You can use the search form below to search
            and add books to your library.
        </p>
        <div>
            <div v-if="libraries.length > 0">
                <div class="max field small label border">
                    <input type="text" v-model="searchItem" />
                    <label>Search for books or authors</label>
                    <span v-if="searchError" class="error">{{
                        searchError
                    }}</span>
                </div>
                <nav class="row">
                    <nav class="row">
                        <select
                            v-for="library in libraries"
                            :key="library.id"
                            v-model="selectedLibraryId"
                            @change="getBooksInLibrary"
                            class="button small-round"
                        >
                            <option :value="library.id">
                                {{ library.title }}
                            </option>
                        </select>
                    </nav>
                    <nav class="row max right-align">
                        <button @click="search" class="small-round">
                            Search
                        </button>
                    </nav>
                </nav>
            </div>
            <div v-else>
                <p>No libraries found</p>
                <div class="space"></div>
                <div class="right-align">
                    <a href="/library/create" class="button small-round">
                        Create Library
                    </a>
                </div>
            </div>
        </div>
    </article>
    <div v-if="loading">
        <div class="center-align">
            <div class="space"></div>
            <progress class="circle large"></progress>
            <p>Loading...</p>
        </div>
    </div>
    <div v-if="!loading && openLibraryResponse && libraries.length > 0">
        <div class="space"></div>
        <div v-if="openLibraryResponse.numFound > 0">
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
                    <tr v-for="doc in openLibraryResponse.docs" :key="doc.key">
                        <td>
                            <div class="absolute center middle">
                                <i
                                    v-if="doc.cover_i"
                                    :id="`tippy-${doc.cover_i}`"
                                    >image</i
                                >
                                <i v-else>error</i>
                            </div>
                        </td>
                        <td>
                            {{ truncateText(doc.title) }}
                        </td>
                        <td v-if="doc.author_name">
                            {{ truncateText(doc.author_name.join(", ")) }}
                        </td>
                        <td v-else>-</td>
                        <td v-if="doc.publisher">
                            {{ truncateText(doc.publisher.join(", ")) }}
                        </td>
                        <td v-else>-</td>
                        <td v-if="doc.publish_date">
                            {{ truncateText(doc.publish_date.join(", ")) }}
                        </td>
                        <td v-else>-</td>
                        <td v-if="doc.language">
                            {{ truncateText(doc.language.join(", ")) }}
                        </td>
                        <td v-else>-</td>
                        <td>
                            <div class="absolute center middle">
                                <button
                                    v-if="getBookFromLibrary(doc) === null"
                                    @click="addBookToLibrary(doc)"
                                    class="square round extra"
                                >
                                    <i>add</i>
                                </button>
                                <button
                                    v-else
                                    @click="
                                        removeBookFromLibrary(
                                            getBookFromLibrary(doc)
                                        )
                                    "
                                    class="square round extra"
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
            <p>No results found</p>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import tippy from "tippy.js";
import { nextTick } from "vue";

export default {
    data() {
        return {
            searchItem: "",
            searchError: "",
            isFormInvalid: false,
            openLibraryResponse: null,
            selectedLibraryId: null,
            booksInLibrary: [],
            loading: false,
        };
    },
    props: {
        errors: Object,
        auth: Object,
        flash: Object,
        libraries: Array,
        books: Array,
    },
    methods: {
        validateSearch() {
            if (this.searchItem === "" || this.searchItem === null) {
                this.searchError = "Search is required";
                this.isFormInvalid = true;
            } else {
                this.searchError = "";
                this.isFormInvalid = false;
            }
        },

        async search() {
            this.validateSearch();

            if (this.isFormInvalid) return;

            this.loading = true;
            axios
                .post("/openlibrary/search", {
                    searchItem: this.searchItem,
                })
                .then((response) => {
                    this.openLibraryResponse = response.data;
                    this.loadImages(); // Load images after setting the response
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    this.loading = false;
                    this.loadImages();
                });
        },

        async addBookToLibrary(doc) {
            this.$inertia.post(
                `/library/${this.selectedLibraryId}/book`,
                {
                    library_id: this.selectedLibraryId,
                    key: doc.key,
                    data: doc,
                },
                {
                    //todo: probably is doing something wrong here but no time to fix it
                    onError: (errors) => {
                        for (const key in errors) {
                            if (key === "library_id") {
                                this.flash.error = "Please select a library";
                            } else {
                                this.flash.error = errors[key];
                            }
                        }
                    },
                    onFinish: () => {
                        this.getBooksInLibrary();
                    },
                }
            );
        },

        async removeBookFromLibrary(book) {
            this.$inertia.delete(
                `/library/${this.selectedLibraryId}/book/${book.id}`,
                {
                    onError: (errors) => {
                        for (const key in errors) {
                            this.flash.error = errors[key];
                        }
                    },
                    onFinish: () => {
                        this.getBooksInLibrary();
                    },
                }
            );
        },

        async getBooksInLibrary() {
            console.log(this.selectedLibraryId);

            axios
                .get(`/library/${this.selectedLibraryId}/books`)
                .then((response) => {
                    this.booksInLibrary = response.data;
                    console.log(this.booksInLibrary);
                })
                .catch((error) => {
                    for (const key in error) {
                        this.flash.error = error[key];
                    }
                })
                .finally(() => {});
        },

        getBookFromLibrary(doc) {
            const foundBook = this.booksInLibrary.find(
                (book) => book.key === doc.key
            );
            return foundBook || null;
        },

        async loadImages() {
            if (this.openLibraryResponse) {
                nextTick(() => {
                    this.openLibraryResponse.docs.forEach((doc) => {
                        if (doc.cover_i) this.imageShow(doc);
                    });
                });
            }
        },

        async fetchImage(url) {
            const img = new Image();
            return new Promise((resolve, reject) => {
                img.onload = () => resolve(url);
                img.onerror = () => reject(url);
                img.src = url;
            });
        },

        async imageShow(doc) {
            const url = `https://covers.openlibrary.org/b/id/${doc.cover_i}-M.jpg`;

            try {
                doc.cover = await this.fetchImage(url);

                tippy(document.getElementById(`tippy-${doc.cover_i}`), {
                    content: `<img src="${url}" alt="Book cover" />`,
                    allowHTML: true,
                    animation: "scale",
                });
            } catch (error) {
                doc.cover = null;
            }
        },

        truncateText(text) {
            if (text.length > 50) {
                return text.substring(0, 50) + "...";
            }
            return text;
        },
    },
};
</script>
