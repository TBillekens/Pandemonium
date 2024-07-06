<template>
    <h1>OpenLibrary</h1>
    <article>
        <p>
            OpenLibrary is a free, open source project that allows you to search
            for books and authors.
        </p>
        <div>
            <div>
                <div class="max field label border">
                    <input type="text" v-model="searchItem" />
                    <label>Search for books or authors</label>
                    <span v-if="searchError" class="error">{{
                        searchError
                    }}</span>
                </div>
                <nav class="right-align">
                    <button @click="search" class="large small-round">
                        Search
                    </button>
                </nav>
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
    <div v-if="!loading && openLibraryResponse">
        <div class="space"></div>
        <div v-if="openLibraryResponse.numFound > 0">
            <table>
                <thead>
                    <tr>
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
                        <td>{{ doc.title }}</td>
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
                            <button class="square round extra">
                                <i>add</i>
                            </button>
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
import { ref } from "vue";
import axios from "axios";

export default {
    data() {
        return {
            searchItem: "",
            searchError: "",
            isFormInvalid: false,
            openLibraryResponse: null,
            loading: false,
        };
    },
    props: {
        errors: Object,
        auth: Object,
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
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
    },
};
</script>
