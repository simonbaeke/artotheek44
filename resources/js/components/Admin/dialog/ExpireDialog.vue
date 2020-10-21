<template>
    <td v-on:click="dialog=true">
        {{expires_at}}
        <v-dialog
                v-model="dialog"
                :return-value.sync="date"
                persistent
                lazy
                width="290px"
        >

            <v-date-picker v-model="date" color="lime">
                <v-btn :loading="updating" text  @click="save">Opslaan</v-btn>
                <v-btn :disabled="updating" text  @click="dialog = false">Annuleren</v-btn>
            </v-date-picker>
        </v-dialog>
    </td>
</template>

<script>
    import Expire from '../../../store/orm/Expire'
    import Rent from '../../../store/orm/Rent'

    import {EventBus} from "../../../Event";

    export default {
        name: "ExpireDialog",
        props: {
            expires_at: {
                required: true,
                default:'xxx'
            },
            expirable_id:{
                required:true
            }
        },
        data() {
            return {
                dialog: false,
                date: this.expires_at == 'niet opgegeven'?new Date().toISOString().substr(0, 10) :  new Date(Date.parse(this.expires_at)).toISOString().substr(0, 10),
                updating: false
            }
        },
        methods: {
            save() {
                this.updating = true
                axios.post('/api/expire/update', {
                    expirable_type:'Rent',
                    expirable_id:this.expirable_id,
                    date: this.date,
                    _method:'put'
                }).then(response => {
                    this.updating = false

                    //change date in store from rent
                    Expire.insertOrUpdate({data: response.data.data})
                    Rent.dispatch('updateExpire',{
                        id:response.data.data.expirable_id,
                        expires_at:response.data.data.date
                    })
                    this.close()
                }).catch(error => {

                    this.close()
                    this.updating = false

                    EventBus.$emit('message',
                        {
                            component: 'notificationSnackbar',
                            message: error.response.data.message,
                            type: 'error'
                        })
                    console.log(error)
                })
            },
            close() {
                this.date =  this.expires_at == 'niet opgegeven'?new Date().toISOString().substr(0, 10) :  new Date(Date.parse(this.expires_at)).toISOString().substr(0, 10),
                this.dialog = false;
            }
        }
    }
</script>

<style scoped>

</style>
