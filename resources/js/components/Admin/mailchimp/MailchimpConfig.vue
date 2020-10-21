<template>
    <v-card>
        <v-card-title class="headline">mailchimp API settings</v-card-title>
        <v-card-text>
            <v-layout row wrap>
                <v-flex xs12 md12>
                    <v-text-field
                            v-model="form.api"
                            label="API Key"
                    ></v-text-field>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs12 md12>
                    <v-text-field
                            v-model="form.list"
                            label="List ID"
                    ></v-text-field>
                </v-flex>
            </v-layout>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" text @click="save">Opslaan</v-btn>
            <v-btn color="green darken-1" text @click="close">Sluit</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    import {Form} from "../../../Form";

    export default {
        name: "MailchimpConfig",
        data() {
            return {
                form: new Form({
                    api: "",
                    list: ""
                })
            }
        },

        methods: {
            save() {
                axios.post('/api/mailchimp',this.form.data())
                this.close()
            },
            close() {
                this.$emit('close')
            },

        },
        mounted(){
            axios.get('/api/mailchimp')
                .then(response=>{
                    this.form.api = response.data.api
                    this.form.list = response.data.list
                })
        }
    }
</script>

<style scoped>

</style>
