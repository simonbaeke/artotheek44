 <template>
    <v-card text>
        <v-card-text>
            <v-form>
                <v-container>
                    <v-layout row wrap>
                        <v-flex xs12 md6>
                            <v-text-field

                                    v-on:keydown="form.clearError('firstname')"
                                    :error-messages="form.error('firstname','Voornaam')"
                                    :error="form.hasError('firstname')"
                                    v-model="form.firstname"
                                    label="voornaam">
                            </v-text-field>
                        </v-flex>

                        <v-flex xs12 md6>
                            <v-text-field

                                    v-on:keydown="form.clearError('lastname')"
                                    :error-messages="form.error('lastname','Familienaam')"
                                    :error="form.hasError('lastname')"
                                    v-model="form.lastname"
                                    label="familienaam">
                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 md6>
                            <v-text-field
                                    v-on:keydown="form.clearError('email')"

                                    :error-messages="form.error('email','Email')"
                                    :error="form.hasError('email')"
                                    v-model="form.email"
                                    label="Email">
                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 md6>
                            <v-text-field

                                    v-on:keydown="form.clearError('phone')"
                                    :error-messages="form.error('phone','Telefoonnummer')"
                                    :error="form.hasError('phone')"
                                    v-model="form.phone"
                                    label="Telefoonnummer">
                            </v-text-field>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-form>

        </v-card-text>
        <v-card-actions>
            <v-btn
                    text

                    v-on:click="createUser">Opslaan
            </v-btn>
            <v-btn text v-on:click="$router.push({name:'volunteerlist'})">Terug</v-btn>

        </v-card-actions>
    </v-card>
</template>

<script>
    import User from '../../../../store/orm/User'
    import {Form} from "../../../../Form";
    import{EventBus} from "../../../../Event";

    export default {
        name: "VrijwilligerComponent",
        data(){
            return{
                form: new Form({
                    firstname: "",
                    lastname: "",
                    email: "",
                    phone:""
                })
            }
        },
        computed: {
            post() {
                return {
                    firstname: this.form.firstname,
                    lastname: this.form.lastname,
                    email: this.form.email,
                    phone:this.form.phone,
                    roles: ['admin']
                }
            }
        },
        methods: {
            createUser() {
                User.dispatch('create', this.post).then((response) => {
                    this.$router.push({name: 'volunteerlist'})
                    this.form.clearErrors();
                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: 'Ontlener gewijzigd',
                        type:'success'
                    })
                }).catch(error => {
                    this.form.setErrors(error);
                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: 'Ontlener niet gewijzigd',
                        type:'error'
                    })
                })
            }
        }
    }
</script>

<style scoped>

</style>
