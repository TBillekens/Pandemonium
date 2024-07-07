<template>
    <body class="dark">
        <Navigation />
        <main class="responsive">
            <FlashMessages />
            <slot></slot>
        </main>
    </body>
</template>

<script>
import Navigation from "../Components/Navigation.vue";
import FlashMessages from "../Components/FlashMessages.vue";

export default {
    name: "DefaultLayout",
    components: {
        Navigation,
        FlashMessages,
    },
};
</script>
