<template>
    <form action="/register" method="post" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">

        <div class="field">
            <label class="label" for="firstname">Voornaam</label>
            <div class="control">
                <input type="text" class="input" id="firstname" name="firstname" v-model="form.firstname">
            </div>
            <span class="help is-danger" v-if="form.errors.has('firstname')"
                  v-text="form.errors.get('firstname')"></span>
        </div>

        <div class="field">
            <label for="lastname" class="label">Familienaam</label>
            <div class="control">
                <input class="input" type="text" id="lastname" name="lastname" v-model="form.lastname"/>
            </div>
            <span class="help is-danger" v-if="form.errors.has('lastname')" v-text="form.errors.get('lastname')"></span>
        </div>

        <div class="field">
            <label for="email" class="label">Email</label>
            <div class="control">
                <input class="input" type="text" id="email" name="email" v-model="form.email"/>
            </div>
            <span class="help is-danger" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></span>
        </div>

        <div class="field">
            <label for="password" class="label">Password</label>
            <div class="control">
                <input class="input" type="text" id="password" name="password" v-model="form.password"/>
            </div>
            <span class="help is-danger" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></span>
        </div>

        <div class="field">
            <label for="password_confirmation" class="label">Confirm Password</label>
            <div class="control">
                <input class="input" type="text" id="password_confirmation" name="password_confirmation"
                       v-model="form.password_confirmation"/>
            </div>
            <span class="help is-danger" v-if="form.errors.has('password_confirmation')"
                  v-text="form.errors.get('password_confirmation')"></span>
        </div>

        <button class="button" type="submit" v-bind:disabled="form.errors.any()">Registreer</button>
    </form>
</template>

<script>

    import {eventBus} from "../app";

    import {Form} from "../Form.js"


    export default {
        name: "RegisterForm",
        data() {
            return {
                form: new Form({
                    firstname: "",
                    lastname: "",
                    email: "",
                    password: "",
                    password_confirmation: "",
                })
            }
        },
        methods: {
            onSubmit() {
                this.form.submit('post', '/register')
                    .then(response => {
                        console.log(response)
                    }).catch(error => {
                        console.log(error)
                });

            }
        }
    }
</script>

<style scoped>
    form {
        width: 80%;
    }
</style>
