<template>
    <v-dialog
            ref="dialog"
            v-model="modal"
            :return-value.sync="picker"
            persistent
            lazy
            full-width
            width="290px"
    >
        <template slot="activator">
            <v-text-field
                    v-model="picker"
                    label="Einddatum abonnement"
                    prepend-icon="event"
                    readonly
            ></v-text-field>
        </template>
        <v-date-picker v-model="picker" >
            <v-spacer></v-spacer>
            <v-btn flat color="primary" @click="modal = false">Annuleren</v-btn>
            <v-btn flat color="primary" @click="save(picker)">OK</v-btn>
        </v-date-picker>
    </v-dialog>
</template>

<script>
    import Expire from "../../../store/orm/Expire";
    import Subscription from '../../../store/orm/Subscription'

    export default {
        name: "EditSubscriptionDateDialog",
        props: {
            expire: {
                required: true,
                default: {
                    date: Date.now()
                }
            }
        },
        data() {
            return {
                picker: new Date(Date.parse(this.expire.date)).toISOString().substr(0, 10),
                modal: false
            }
        },
        watch: {

        },
        methods: {
            save(date) {
                axios.put('api/expires/' + this.expire.id, {
                    date: date
                }).then(response => {
                    Expire.insertOrUpdate({data: response.data.data})
                    this.modal = false
                }).catch(error => {
                    this.modal = false
                    console.log(error)
                })
            }
        }
    }
</script>

<style scoped>

</style>
