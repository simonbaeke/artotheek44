<template>
    <div>
        <login-form v-if="login" :old="old" :errors="currentloginerror" :showModal="login" v-on:close="closeLogin" v-on:clearLoginError="clearLoginError"/>
        <register-form v-if="register" :old="old" :errors="registererror" :showModal="register" v-on:close="register = false"/>
    </div>
</template>

<script>
    import {EventBus} from "../Event";
    import loginForm from './LoginForm'
    import registerForm from './User/user/UserRegister'

    export default {
        name: "AuthDialog",
        props: ['showlogin', 'loginerror', 'registererror', 'old'],
        data() {
            return {
                login: false,
                register: false,
                currentloginerror:[]
            }
        },
        created() {
            EventBus.$on('showLoginDialog', () => {
                this.login = true;
                this.register = false;
            })
            EventBus.$on('showRegisterDialog', () => {
                this.register = true;
                this.login = false;
            })

        },
        components: {
            loginForm,
            registerForm
        },
        mounted() {
            console.log('mounted')
            console.log(this.loginerror)
            if (this.loginerror.length != 0) {
                this.login = true
                this.register = false
            }

            if (this.registererror.length != 0) {
                this.login = false
                this.register = true
            }

            this.currentloginerror = this.loginerror


        },
        methods:{
            closeLogin(){
                this.clearLoginError()
                this.login = false
            },
            clearLoginError(){
                this.currentloginerror = []
            }
        }
    }
</script>

<style scoped>

</style>
