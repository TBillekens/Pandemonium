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
                    <nav v-if="!loading && openLibraryResponse" class="row">
                        <select
                            v-for="library in libraries"
                            :key="library.id"
                            v-model="selectedLibraryId"
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
                                    :id="`hoverImage-${doc.cover_i}`"
                                    >image</i
                                >
                                <i v-else>error</i>
                            </div>
                        </td>
                        <td>
                            {{ doc.title }}
                        </td>
                        <td v-if="doc.author_name">
                            {{ doc.author_name.join(", ") }}
                        </td>
                        <td v-else>-</td>
                        <td v-if="doc.publisher">
                            {{ doc.publisher.join(", ") }}
                        </td>
                        <td v-else>-</td>
                        <td v-if="doc.publish_date">
                            {{ doc.publish_date.join(", ") }}
                        </td>
                        <td v-else>-</td>
                        <td v-if="doc.language">
                            {{ doc.language.join(", ") }}
                        </td>
                        <td v-else>-</td>
                        <td>
                            <div class="absolute center middle">
                                <button
                                    @click="addBookToLibrary(doc)"
                                    class="square round extra"
                                >
                                    <i>add</i>
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
import { ref, toRaw } from "vue";
import axios from "axios";
import tippy from "tippy.js";

export default {
    data() {
        return {
            searchItem: "",
            searchError: "",
            isFormInvalid: false,
            openLibraryResponse: null,
            loading: false,
            selectedLibraryId: null,
        };
    },
    props: {
        errors: Object,
        auth: Object,
        libraries: Array,
        flash: Object,
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
                    this.setImage();
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        async fetchImage(url) {
            const img = new Image();
            return new Promise((resolve, reject) => {
                img.onload = () => resolve(url);
                img.onerror = () => reject(url);
                img.src = url;
            });
        },

        async setImage() {
            this.openLibraryResponse.docs.forEach(async (doc) => {
                if (doc.cover_i) {
                    const url = `https://covers.openlibrary.org/b/id/${doc.cover_i}-M.jpg`;
                    try {
                        doc.cover = await this.fetchImage(url);
                    } catch (error) {
                        doc.cover = null;
                    }
                }

                const image = document.getElementById(
                    `hoverImage-${doc.cover_i}`
                );

                if (doc.cover === null || doc.cover === undefined) {
                    return;
                }

                tippy(image, {
                    content: `<img src="${doc.cover}" alt="${doc.title}" />`,
                    allowHTML: true,
                    interactive: true,
                    placement: "top",
                });
            });
        },

        async addBookToLibrary(doc) {
            this.$inertia.post(
                `/library/${this.selectedLibraryId}/book`,
                {
                    data: doc,
                    library_id: this.selectedLibraryId,
                },
                {
                    //todo: probably is doing something wrong here but no time to fix it
                    onError: (errors) => {
                        for (const key in errors) {
                            this.flash.error = errors[key];
                        }
                    },
                }
            );
        },
    },
};
</script>
