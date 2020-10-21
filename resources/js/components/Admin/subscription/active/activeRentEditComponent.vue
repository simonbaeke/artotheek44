<template>
    <div>
        <span class="headline">Lopende ontlening</span>

        <v-simple-table>
            <template v-slot:default>
                <thead>
                <tr>
                    <th class="text-left">Kunstwerk</th>
                    <th class="text-left">Code</th>
                    <th class="text-left">Ontleend op</th>
                    <th class="text-left">Terugbrengen op</th>
                    <th class="text-right"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{rent.artwork.name}}</td>
                    <td>{{rent.artwork.code}}</td>
                    <td>
                        <v-menu
                                ref="started_at_menu"
                                v-model="started_atMenu"
                                :close-on-content-click="false"
                                :return-value.sync="editRent.started_at"
                                transition="scale-transition"
                                offset-y
                                min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                        v-model="editRent.started_at"
                                        label="started_at"
                                        prepend-icon="event"
                                        readonly
                                        v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker v-model="editRent.started_at" no-title scrollable>
                                <v-spacer></v-spacer>
                                <v-btn text color="primary" @click="started_atMenu = false">Cancel</v-btn>
                                <v-btn text color="primary"
                                       @click="$refs.started_at_menu.save(editRent.started_at)">OK
                                </v-btn>
                            </v-date-picker>
                        </v-menu>
                    </td>
                    <td>
                        <v-menu
                                ref="expire_at_menu"
                                v-model="expire_atMenu"
                                :close-on-content-click="false"
                                :return-value.sync="editExpire.date"
                                transition="scale-transition"
                                offset-y
                                min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                        v-model="editExpire.date"
                                        label="started_at"
                                        prepend-icon="event"
                                        readonly
                                        v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker v-model="editExpire.date" no-title scrollable>
                                <v-spacer></v-spacer>
                                <v-btn text color="primary" @click="expire_atMenu = false">Cancel</v-btn>
                                <v-btn text color="primary" @click="$refs.expire_at_menu.save(editExpire.date)">OK
                                </v-btn>
                            </v-date-picker>
                        </v-menu>
                    </td>
                    <td class="text-right">
                        <v-btn outlined v-on:click="save">Opslaan</v-btn>
                        <v-btn outlined v-on:click="$emit('cancel')">Cancel</v-btn>
                    </td>
                </tr>
                </tbody>
            </template>
        </v-simple-table>
    </div>
</template>

<script>
    import Expire from '../../../../store/orm/Expire'
    import Rent from '../../../../store/orm/Rent'
    import {EventBus} from "../../../../Event";


    export default {
        name: "activeRentEditComponent",
        props: {
            rent: {
                required: true,
                type: Object
            }
        },
        data() {
            return {
                editRent: {
                    started_at: ""
                },
                editExpire: {
                    date: ""
                },
                started_atMenu: false,
                expire_atMenu: false,
                editing: false
            }
        },
        methods: {
            save() {
                this.editing = true
                let s = this.updateRent()
                let t = this.updateExpire()

                Promise.all([s, t]).then(() => {
                    console.log('promise.all')
                }).then(() => {
                    this.editing = false
                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: 'Ontlening gewijzigd',
                        type: 'success'
                    })
                    this.$emit('cancel')
                })
            },
            updateRent() {
                return Rent.dispatch('updateRent', {
                    id: this.rent.id,

                    'created_at': this.editRent.started_at,
                    '_method': 'PUT'

                })
            },
            updateExpire() {
                return Expire.dispatch('update', {
                    id: this.rent.expire.id,
                    params: {
                        'date': this.editExpire.date,
                        'updated_at': Date.parse(Date.now()),
                        '_method': 'PUT'
                    }
                })
            }
        },
        mounted() {
            this.editRent.started_at = this.rent.started_at
            this.editExpire.date = this.rent.expire.date
        }
    }
</script>

<style scoped>

</style>
