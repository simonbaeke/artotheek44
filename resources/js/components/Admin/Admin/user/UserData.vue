<template>
    <div>
        <v-form>
            <v-container>
                <v-layout row wrap>
                    <v-flex xs12 md6>
                        <v-text-field
                                :readonly="true"
                                v-model="user.firstname"
                                label="voornaam">

                        </v-text-field>
                    </v-flex>
                    <v-flex xs12 md6>
                        <v-text-field
                                :readonly="true"
                                v-model="user.lastname"
                                label="familienaam">

                        </v-text-field>
                    </v-flex>
                    <v-flex xs12 md6>
                        <v-text-field
                                :readonly="true"
                                v-model="user.email"
                                label="email">
                        </v-text-field>
                    </v-flex>
                    <v-flex xs12 md6>
                        <v-text-field
                                :readonly="true"
                                v-model="user.phone"
                                label="Telefoonnummer">
                        </v-text-field>
                    </v-flex>
                    <v-flex xs12 md6>
                        <v-text-field
                                :readonly="true"
                                v-model="user.memberid"
                                label="Lidnummer">
                        </v-text-field>
                    </v-flex>

                    <v-flex xs12 md6>
                        <v-text-field
                                :readonly="true"
                                v-model="address.street"
                                label="Straat">
                        </v-text-field>
                    </v-flex>
                    <v-flex xs12 md6>
                        <v-text-field
                                :readonly="true"
                                v-model="address.number"
                                label="Huisnummer">
                        </v-text-field>
                    </v-flex>
                    <v-flex xs12 md6>
                        <v-text-field
                                :readonly="true"
                                v-model="address.zip"
                                label="Postcode">
                        </v-text-field>
                    </v-flex>
                    <v-flex xs12 md6>
                        <v-text-field
                                :readonly="true"
                                v-model="address.city"
                                label="Stad">
                        </v-text-field>
                    </v-flex>
                </v-layout>
            </v-container>


        </v-form>
        <v-divider></v-divider>
        <v-card-actions>
            <v-btn flat v-on:click="$emit('edit')">Wijzigen</v-btn>
        </v-card-actions>
    </div>

</template>

<script>
    export default {
        name: "UserData",
        props:{
            user:{
                required:true,
            },
            address:{
                required:true
            }
        }
    }
</script>

<style scoped>

</style>
