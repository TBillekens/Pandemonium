<template>
    <dialog id="loginDialog">
        <header>
            <h6>Login</h6>
        </header>
        <form @submit.prevent="login">
            <span v-if="failedLoginError" class="error-text">{{ failedLoginError }}</span>
            <div class="field label round border small-round">
                <input v-model="email" type="text" lazy>
                <label>Email</label>
                <span v-if="emailError" class="error">{{ emailError }}</span>
            </div>
            <div class="field label round border small-round">
                <input v-model="password" type="password" lazy>
                <label>Password</label>
                <span v-if="passwordError" class="error">{{ passwordError }}</span>
            </div>
            <nav class="right-align">
                <button class="button small-round">Login</button>
            </nav>
        </form>
    </dialog>
</template>

<script>
export default {
    data() {
        return {
            email: '',
            password: '',
            emailError: '',
            passwordError: '',
            failedLoginError: ''
        }
    }, 
    computed: {
        isFormInvalid() {
            return !!this.emailError || !!this.passwordError;
        }
    },
    methods: {
        validateEmail() {
            if (!this.email) {
                this.emailError = 'Email is required';
            } else if (!this.email.includes('@')) {
                this.emailError = 'Email is invalid';
            } else {
                this.emailError = '';
            }
        },
        validatePassword() {
            if (!this.password) {
                this.passwordError = 'Password is required';
            } else {
                this.passwordError = '';
            }
        },
        async login() {
            this.validateEmail();
            this.validatePassword();

            if (this.isFormInvalid) return;

            this.$inertia.post('/auth/login', {
                email: this.email,
                password: this.password
            }, {
                onSuccess: () => {
                    this.email = '';
                    this.password = '';
                    this.emailError = '';
                    this.passwordError = '';
                    this.loginError = '';
                    ui('#loginDialog');
                },
                onError: (error) => {
                    console.log(error);
                    this.failedLoginError = error.message ?? '';
                }
            });
            }
        }
    }
</script>