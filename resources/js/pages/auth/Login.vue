<template>
    <div>
        <form @submit.prevent="loginUser()">
            <h1>Log in</h1>

            <article v-if="flash.error" class="message is-danger">
                <div class="message-body">
                    {{ flash.error }}
                </div>
            </article>

            <b-field label="Email" :type="errors.email ? 'is-danger' : ''"
                     :message="errors.email ? 'Email is already in use' : ''">
                <b-input type="email" v-model="email" required/>
            </b-field>

            <b-field label="Password">
                <b-input type="password" v-model="password" password-reveal required/>
            </b-field>

            <div class="actions">
                <b-button native-type="submit" type="is-success" expanded>{{
                       'Log in'
                    }}
                </b-button>

                <h3>Dont have an account yet? <a :href="$route('auth.register')">Register here</a></h3>
            </div>
        </form>
    </div>
</template>

<script>
import Layout from '@/layouts/General';

export default {
    layout: Layout,
    props: {
        errors: Object,
        flash: Object
    },
    data() {
        return {
            email: '',
            password: '',
        }
    },
    methods: {
        loginUser() {
            this.$inertia.post(
                this.$route('auth.login'), {
                    email: this.email,
                    password: this.password,
                },
            );
        },
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
