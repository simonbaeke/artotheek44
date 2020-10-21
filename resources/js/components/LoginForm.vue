<template>
    <v-dialog v-model="showModal" persistent max-width="500px">
        <v-form name="form" method="post" action="/login">

            <v-card class="elevation-12">
                <v-toolbar dark color="primary">
                    <v-toolbar-title>Login</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn
                            white
                            icon
                            small
                            v-on:click.prevent="close"
                    >
                        <v-icon small>close</v-icon>
                    </v-btn>
                </v-toolbar>
                <v-card-text>
                    <input type="hidden" v-model="token" name="_token">
                    <v-text-field prepend-icon="person"
                                  name="email"
                                  v-model="form.email"
                                  label="Email"
                                  type="email"
                                  :error="form.hasError('email')"
                                  :error-messages="form.error('email')"
                                  v-on:click="$emit('clearLoginError')"

                                  required/>
                    <v-text-field prepend-icon="lock"
                                  append-icon="visibility"
                                  v-model="form.password"
                                  name="password"
                                  label="Password"
                                  :type="passwordType"
                                  :error="form.hasError('password')"
                                  :error-messages="form.error('password')"
                                  v-on:click:append="setPasswordVisible"
                                  v-on:focus="$emit('clearLoginError')"

                                  required></v-text-field>
                    <v-alert  type="error" v-if="hasError">Je login of wachtwoord is niet correct</v-alert>
                    <v-checkbox
                            v-model="form.remember"
                            label="Blijf ingelogd op dit toestel"
                    ></v-checkbox>
                    <v-btn text class="grey--text" v-on:click="register">Maak een account aan</v-btn>
                </v-card-text>
                <v-card-actions>
                    <v-btn
                            color="primary"
                            type="submit"
                    >Login
                    </v-btn>
                    <v-btn color="primary" text v-on:click="sendpasswordmail">Wachtwoord vergeten</v-btn>
                </v-card-actions>
            </v-card>
        </v-form>

    </v-dialog>


</template>

<script>
    import {api} from "../Api.js"
    import {Form} from "../Form";
    import {EventBus} from "../Event";


    export default {
        name: "LoginForm",
        props: ['showModal', 'errors', 'old'],
        data() {
            return {
                form: new Form({
                    email: '',
                    password: '',
                    remember: false,
                }),
                token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                passwordVisible: false
            }
        },

        computed: {

            passwordType() {
                if (this.passwordVisible) {
                    return 'text'
                }
                return 'password'
            },
            oldinput() {
                return JSON.parse(this.old)
            },
            hasError(){
                if (this.errors){
                    return this.errors['email']
                }

                return false

            }

        },
        watch:{
          showModal(){
              if(!showModal){
                  EventBus.$emit('clearError')
              }
          }
        },


        mounted() {
           // this.form.setErrors(this.errors)
           // this.form.set(JSON.parse(this.old))
        },

        methods: {
            close() {
                this.form.clearError('email')
                this.form.clearError('password')
                this.form.reset()
                this.$emit('close')
            },
            onSignin() {
                this.form.route = this.$route.path

                axios.post('/login',
                    this.form.data()
                ).then(response=>{
                    console.log(response)
                })

                /*  this.$store.dispatch('getToken', {email: this.form.email, password: this.form.password,remind:this.stayloggidin})
                      .then(response => {

                          this.$emit('close')
                          this.$router.push({
                              name: 'artwork'
                          })
                      })
                      .catch(error => {
                          this.form.setErrors({
                              email: ["Email en/of paswoord kloppen niet"],
                              password: ['']
                          })
                          this.form.password = ""
                      })*/
            },

            onDismissed() {
                this.$store.dispatch('clearError')
            },
            sendpasswordmail() {
                this.$router.push({name: 'resetpassword'})
                this.close()
            },
            setPasswordVisible() {

                if (!this.passwordVisible) {
                    this.passwordVisible = true;
                    setTimeout(() => {
                        this.passwordVisible = false;
                    }, 1000)
                    return
                }

                this.passwordVisible = false;


            },
            register() {
                EventBus.$emit('showRegisterDialog')
            }
        }
    }
</script>

<style scoped>

</style>
