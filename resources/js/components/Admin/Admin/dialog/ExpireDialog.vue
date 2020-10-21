<template>
    <td v-on:click="dialog=true">
        {{expire.date}}
        <v-dialog
                v-model="dialog"
                :return-value.sync="date"
                persistent
                lazy
                full-width
                width="290px"
        >

            <v-date-picker v-model="date" color="black">
                <v-btn :loading="updating" flat color="black" @click="save">Opslaan</v-btn>
                <v-btn :disabled="updating" flat color="black" @click="dialog = false">Annuleren</v-btn>
            </v-date-picker>
        </v-dialog>
    </td>
</template>

<script>
    import Expire from '../../../store/orm/Expire'
    import {EventBus} from "@/Event";

    export default {
        name: "ExpireDialog",
        props: {
            expire: {
                required: true
            }
        },
        data() {
            return {
                dialog: false,
                date: new Date(Date.parse(this.expire.date)).toISOString().substr(0, 10),
                updating: false
            }
        },
        methods: {
            save() {
                this.updating = true
                axios.put('api/expires/' + this.expire.id, {
                    date: this.date
                }).then(response => {
                    this.updating = false
                    Expire.insertOrUpdate({data: response.data.data})
                    this.close()
                }).catch(error => {
                    this.close()
                    this.updating = false

                    EventBus.$emit('message',
                        {
                            component: 'notificationSnackbar',
                            message: 'Fout bij wijzigen datum',
                            type: 'error'
                        })
                    console.log(error)
                })
            },
            close() {
                this.date = new Date(Date.parse(this.expire.date)).toISOString().substr(0, 10);
                this.dialog = false;
            }
        }
    }
</script>

<style scoped>

</style>
