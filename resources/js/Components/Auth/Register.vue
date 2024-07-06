<template>
    <dialog id="registerDialog">
        <header>
            <h6>Register</h6>
        </header>
        <form>
            <div class="field label round border small-round">
                <input type="text" lazy>
                <label>Username</label>
            </div>
            <div class="field label round border small-round">
                <input type="email" lazy>
                <label>Email</label>
            </div>
            <div class="field label round border small-round">
                <input type="password" lazy>
                <label>Password</label>
            </div>
            <div class="field label round border small-round">
                <input type="password" lazy>
                <label>Repeat Password</label>
            </div>
            <nav class="right-align">
                <button class="button small-round">Register</button>
            </nav>
        </form>
    </dialog>
</template>

<script>
export default {
    data() {
        return {
            username: '',
            email: '',
            password: '',
            repeatPassword: ''
        }
    },
    methods: {
        async register() {
            try {
                const response = this.$inertia.post('/register', {
                    username: this.username,
                    email: this.email,
                    password: this.password,
                });
                this.$inertia.visit('/');
            } catch (error) {
                console.error('Registration failed:', error);
            }
        }
    }
}

</script>