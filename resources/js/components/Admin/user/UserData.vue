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
                    <v-flex md6 class="hidden-sm-and-down"></v-flex>

                    <v-flex xs12 v-if="phoneNumbers.length == 0"  class="grey--text">Geen telefoonnummers toegevoegd</v-flex>



                    <v-flex xs12 v-for="phonenumber,index in user.phoneNumbers" :key="index">
                        <v-layout row wrap>
                            <v-flex xs12 md6>
                                <v-text-field

                                        v-model="phoneNumbers[index]"
                                        :label="user.phoneNumbers[index].type.name">
                                </v-text-field>
                            </v-flex>
                            <v-flex md6 class="hidden-sm-and-down"></v-flex>
                        </v-layout>
                    </v-flex>


                    <v-flex xs12 v-if="user.address.street == ''">
                        <span class="grey--text">Geen adres toegevoegd</span>
                    </v-flex>


                    <v-flex xs12 md6>
                        <v-text-field
                                :readonly="true"
                                v-model="user.address.street"
                                label="Straat">
                        </v-text-field>
                    </v-flex>
                    <v-flex xs12 md6>
                        <v-text-field
                                :readonly="true"
                                v-model="user.address.number"
                                label="Huisnummer">
                        </v-text-field>
                    </v-flex>
                    <v-flex xs12 md6>
                        <v-text-field
                                :readonly="true"
                                v-model="user.address.zip"
                                label="Postcode">
                        </v-text-field>
                    </v-flex>
                    <v-flex xs12 md6>
                        <v-text-field
                                :readonly="true"
                                v-model="user.address.city"
                                label="Stad">
                        </v-text-field>
                    </v-flex>
                </v-layout>
            </v-container>


        </v-form>
        <v-divider></v-divider>
        <v-card-actions>
            <v-btn text v-on:click="$emit('edit')">Wijzigen</v-btn>
        </v-card-actions>
    </div>

</template>

<script>

    export default {
        name: "UserData",
        props: {
            user: {
                required: true,
            }
        },
        computed: {
            phoneNumbers(){

               if (this.user == null || this.user.phoneNumbers == null){
                   return []
               }

               return  this.user.phoneNumbers.map(phoneNumber =>{
                   let digits = phoneNumber.number.replace(/\D/g,'')

                   if (digits.length ==10){
                       return digits.slice(0,4) + '/'
                           + digits.slice(4,6) + '.'
                           + digits.slice(6,8) + '.'
                           +  digits.slice(8)
                   }

                   if (digits.length == 9){
                       return digits.slice(0,3) + '/'
                           + digits.slice(3,5) + '.'
                           + digits.slice(5,7) + '.'
                           +  digits.slice(7)

                   }
                    return digits;
                })
            }
        }
    }
</script>

<style scoped>

</style>
