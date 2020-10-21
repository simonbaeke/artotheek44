<template>
    <td v-on:click="dialog=true">
        {{rent.started_at}}
        <v-dialog
                v-model="dialog"
                persistent
                lazy
                full-width
                width="290px"
        >

            <v-date-picker v-model="date" color="lime">
                <v-btn :loading="updating" flat @click="save">Opslaan</v-btn>
                <v-btn :disabled="updating" flat @click="close">Annuleren</v-btn>

            </v-date-picker>
        </v-dialog>
    </td>
</template>

<script>
    import Rent from "../../../store/orm/Rent";

    export default {

        name: "StartedDialog",
        props: {
            rent: {
                required: true
            }
        },
        data() {
            return {
                date: new Date(Date.parse(this.rent.started_at)).toISOString().substr(0, 10),
                dialog: false,
                updating: false
            }
        },
        methods: {
            save() {
                this.updating = true
                axios.put('api/rents/' + this.rent.id, {
                    created_at: this.date
                }).then(response => {
                    this.updating = false
                    Rent.insertOrUpdate({data: response.data.data})
                    this.dialog = false
                }).catch(error => {

                    EventBus.$emit('message',
                        {
                            component: 'notificationSnackbar',
                            message: 'Fout bij wijzigen datum',
                            type: 'error'
                        })
                    this.updating = false
                    console.log(error)
                })
            },
            close() {
                this.date = new Date(Date.parse(this.rent.started_at)).toISOString().substr(0, 10)
                this.dialog = false
            }
        },
        watch: {
            dialog() {
                if (this.dialog) {
                    this.date = new Date(Date.parse(this.rent.started_at)).toISOString().substr(0, 10)
                }
            }
        },
        mounted() {
            console.log(this.date)
        }
    }
</script>

<style scoped>

</style>
