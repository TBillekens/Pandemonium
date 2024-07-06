<template>
    <h1>Libraries</h1>
    <article>
        <p>Here are all the libraries you have created.</p>
        <nav class="right-align">
            <a class="button small-round" href="/library/create"
                >Create a new library</a
            >
        </nav>
    </article>
    <table v-if="libraries.length !== 0" class="stripes">
        <thead>
            <tr>
                <th class="center-align">ID</th>
                <th class="center-align">Title</th>
                <th class="center-align">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="library in libraries" :key="library.id">
                <td class="center-align">{{ library.id }}</td>
                <td class="center-align">
                    <a :href="'/library/' + library.id" class="link">
                        {{ library.title }}
                    </a>
                </td>
                <td>
                    <nav class="no-space center-align">
                        <a
                            :href="'/library/' + library.id + '/edit'"
                            class="button border small left-round"
                        >
                            <i>edit</i>
                        </a>
                        <button
                            @click="deleteLibrary(library.id)"
                            class="border small right-round fill"
                        >
                            <i>delete</i>
                        </button>
                    </nav>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import { ref } from "vue";

export default {
    props: {
        auth: Object,
        libraries: Array,
    },
    setup(props) {
        const user = props.auth.user;
        const libraries = ref(props.libraries);

        return {
            user,
            libraries,
        };
    },
    methods: {
        deleteLibrary(id) {
            this.$inertia.delete("/library/" + id, {
                onSuccess: () => {
                    this.libraries = this.libraries.filter(
                        (library) => library.id !== id
                    );
                },
            });
        },
    },
};
</script>
