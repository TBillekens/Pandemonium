<template>
    <div>
        <h5>Libraries</h5>
        <article>
            <p>
                Here are all the libraries you have created.
            </p>
            <a v-if="$page.props.libraries !== []" class="button small" href="/library/create">Create a new library</a>
        </article>
        <ul>
            <li v-for="library in $page.props.libraries" :key="library.id">
                <a :href="'/library/' + library.id">{{ library.name }}</a>
            </li>
        </ul>
    </div>
</template>