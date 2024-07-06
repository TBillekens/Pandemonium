<template>
    <div v-if="$page.props.auth.user">
        <h1>Dashboard</h1>
        <div>
            <div class="grid">
                <!-- first row need to be a full article -->
                <div class="s12 m12 l12">
                    <article>
                        <h5>Welcome {{ $page.props.auth.user.name }}!</h5>
                        <p>
                            This is your dashboard. From here you can access all
                            the features of the application.
                        </p>
                    </article>
                </div>
                <div class="s12 m12 l6">
                    <article>
                        <h5>Library</h5>
                        <p>
                            In this section of the application you can keep
                            track of your personal collection using OpenLibrary.
                        </p>
                        <nav class="right-align">
                            <a class="button small-round" href="/library/"
                                >Go to Library</a
                            >
                        </nav>
                    </article>
                </div>
                <div class="s12 m12 l6">
                    <article>
                        <h5>OpenLibrary</h5>
                        <p>
                            OpenLibrary is a free, open source project that
                            allows you to search for books and authors.
                        </p>
                        <nav class="right-align">
                            <a class="button small-round" href="/openlibrary/"
                                >Go to OpenLibrary</a
                            >
                        </nav>
                    </article>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <h1>Dashboard</h1>
        <article>
            <p>You are not logged in. Please login to access the dashboard.</p>
        </article>
    </div>
</template>
