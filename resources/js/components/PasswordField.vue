<template>
    <v-text-field prepend-icon="lock"
                  append-icon="visibility"
                  v-model="password"
                  name="password"
                  :label="label"
                  :type="passwordType"
                  :error="error"
                  :error-messages="errormessage"
                  v-on:click:append="setPasswordVisible"
                  v-on:focus="$emit('clearError')"
                  v-on:input="$emit('changePassword',password)"
                  required></v-text-field>
</template>

<script>
    export default {
        name: "PasswordField",
        props: ['error', 'errormessage', 'label', 'closed'],
        data() {
            return {
                password: '',
                passwordVisible: false
            }
        },
        computed: {
            passwordType() {
                if (this.passwordVisible) {
                    return 'text'
                }
                return 'password'
            }
        },
        watch: {
            closed(){
                if(this.closed){
                    this.password=""
                    console.log('reset pwfield')
                }
            }
        },
        methods: {
            setPasswordVisible() {

                if (!this.passwordVisible) {
                    this.passwordVisible = true;
                    setTimeout(() => {
                        this.passwordVisible = false;
                    }, 1000)
                    return
                }

                this.passwordVisible = false;


            }
        }
    }
</script>

<style scoped>

</style>
