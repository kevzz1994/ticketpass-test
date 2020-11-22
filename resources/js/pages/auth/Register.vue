<template>
    <div>
        <form @submit.prevent="register()">
            <h1>Create an Account</h1>
            <h2>Create an account to continue</h2>

            <b-field label="Email" :type="errors.email ? 'is-danger' : ''"
                     :message="errors.email ? 'Email is already in use' : ''">
                <b-input type="email" v-model="email" required/>
            </b-field>

            <b-field label="Name">
                <b-input v-model="name" required/>
            </b-field>

            <b-field label="Password" :type="errors.password ? 'is-danger' : ''"
                     :message="errors.password ? 'Password is too weak' : ''">
                <b-input type="password" v-model="password" password-reveal required/>
            </b-field>

            <b-field>
                <b-checkbox v-model="tos_accept" required>
                    I accept terms and conditions
                </b-checkbox>
            </b-field>

            <div class="actions">
                <b-button native-type="submit" type="is-success" expanded>{{
                        'Sign up'
                    }}
                </b-button>

                <h3>Already have an account? <a :href="$route('auth.login')" >Login</a></h3>
            </div>
        </form>
    </div>
</template>

<script>
import Layout from '@/layouts/General';

export default {
    layout: Layout,
    props: {
        errors: Object
    },
    data() {
        return {
            email: '',
            name: '',
            password: '',
            tos_accept: false,
        }
    },
    methods: {
        register() {
            this.$inertia.post(
                this.$route('auth.register'), {
                    email: this.email,
                    name: this.name,
                    password: this.password,
                }
            );
        }
    }
}
</script>

<style scoped>
form {
    max-width: 500px;
    width: 90%;
    padding: 20px;
    border-radius: 10px;
    background: #f0f0f0;
    margin: auto;
}

h1, h2 {
    text-align: center;
}

h2 {
    margin-top: 0.5714em;
    margin-bottom: 0.5714em;
    font-size: 1.5em;
}

.actions {
    padding-top: 10px;
}

.actions > h3 {
    font-size: 1em;
    margin: 0;
    margin-top: 15px;
}
</style>
