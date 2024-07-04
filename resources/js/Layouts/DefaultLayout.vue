<template>
    <body class="dark">
        <Navigation />
        <main class="responsive">
            <slot></slot>
    </main>
    </body>
</template>

<script>
import Navigation from '../Components/Navigation.vue';

export default {
    name: "DefaultLayout",
    components: {
        Navigation
    }
}
</script>