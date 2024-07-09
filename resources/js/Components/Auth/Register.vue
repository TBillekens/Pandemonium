<template>
    <dialog id="registerDialog">
        <header>
            <h6>Register</h6>
        </header>
        <form @submit.prevent="register">
            <span v-if="failedRegisterError" class="error-text">{{
                failedRegisterError
            }}</span>
            <div class="field label round border small-round">
                <input v-model="name" type="text" lazy />
                <label>Name</label>
                <span v-if="nameError" class="error">{{ nameError }}</span>
            </div>
            <div class="field label round border small-round">
                <input v-model="email" type="email" lazy />
                <label>Email</label>
                <span v-if="emailError" class="error">{{ emailError }}</span>
            </div>
            <div class="field label round border small-round">
                <input v-model="password" type="password" lazy />
                <label>Password</label>
                <span v-if="passwordError" class="error">{{
                    passwordError
                }}</span>
            </div>
            <div class="field label round border small-round">
                <input v-model="repeatPassword" type="password" lazy />
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
    props: {
        flash: Object,
        config: Object,
    },
    data() {
        return {
            name: "",
            email: "",
            password: "",
            repeatPassword: "",
            failedRegisterError: "",
            nameError: "",
            passwordError: "",
            emailError: "",
        };
    },
    computed: {
        isFormInvalid() {
            return (
                !!this.nameError ||
                !!this.emailError ||
                !!this.passwordError ||
                !!this.repeatPasswordError
            );
        },
    },
    methods: {
        validateEmail() {
            if (!this.email) {
                this.emailError = "Email is required";
            } else if (!this.email.includes("@")) {
                this.emailError = "Email is invalid";
            } else {
                this.emailError = "";
            }
        },

        validateName() {
            if (!this.name) {
                this.nameError = "Name is required";
            } else {
                this.nameError = "";
            }
        },

        validatePassword() {
            if (!this.password) {
                this.passwordError = "Password is required";
            } else {
                this.passwordError = "";
            }

            if (this.password !== this.repeatPassword) {
                this.repeatPasswordError = "Passwords do not match";
            } else {
                this.repeatPasswordError = "";
            }

            if (this.password.length < 6) {
                this.passwordError = "Password must be at least 6 characters";
            }
        },

        async register() {
            this.validateEmail();
            this.validateName();
            this.validatePassword();

            if (this.isFormInvalid) return;

            this.$inertia.post(
                "auth/register",
                {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                },
                {
                    onError: (error) => {
                        console.log(error);
                    },
                    onSuccess: () => {
                        this.name = "";
                        this.email = "";
                        this.password = "";
                        this.repeatPassword = "";
                        this.nameError = "";
                        this.emailError = "";
                        this.passwordError = "";
                        this.repeatPasswordError = "";
                        this.failedRegisterError = "";
                        ui("#registerDialog");
                    },
                }
            );
        },
    },
};
</script>
