<template>
    <v-form ref="form">
        <v-container>
            <v-row>
                <v-col
                        cols="12"
                        md="6"
                >
                    <v-text-field
                            v-on:change="change"
                            v-model="user.firstname"
                            :rules="firstnameRules"
                            label="Voornaam">
                    </v-text-field>


                </v-col>
                <v-col
                        cols="12"
                        md="6"
                >
                    <v-text-field
                            v-on:change="change"
                            :rules="lastnameRules"

                            v-model="user.lastname"
                            label="Familienaam"
                    />
                </v-col>
            </v-row>
            <v-row>
                <v-col
                        cols="12"
                        md="6"
                >
                    <v-text-field
                            v-on:change="change"
                            :rules="emailRules"
                            v-model="user.email"
                            label="Email">
                    </v-text-field>


                </v-col>
                <v-col
                        cols="12"
                        md="6"
                >
                    <v-text-field
                            v-on:change="change"
                            :rules="phoneRules"
                            v-model="user.phone"
                            label="Telefoonnummer"
                    />
                </v-col>
            </v-row>
        </v-container>

    </v-form>
</template>

<script>
    export default {
        name: "unknownUserComponent",
        data() {
            return {
                user: {
                    firstname: '',
                    lastname: '',
                    email: '',
                    phone: ''
                },

                firstnameRules: [
                    v => !!v || 'Voornaam is verplicht',
                ],
                lastnameRules: [
                    v => !!v || 'Familienaam is verplicht',
                ],
                emailRules: [
                    v => !!v || 'Email is verplicht',
                    v => /.+@.+\..+/.test(v) || 'Geef een geldig email adres op',
                ],
                phoneRules: [
                    v => !!v || 'Telefoonnummer is verplicht',
                ],
            }
        },
        methods: {
            change() {
                if (this.$refs.form.validate()) {
                    this.$emit('change',JSON.stringify(this.user))
                }

            }
        }
    }
</script>

<style scoped>

</style>
