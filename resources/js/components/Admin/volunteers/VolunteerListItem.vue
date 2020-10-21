<template>
    <tr>
        <router-link tag="td" :to="{ name: 'volunteerdetail', params: { id: volunteer.id }}">{{
            volunteer.fullname }}
        </router-link>
        <router-link tag="td" :to="{ name: 'volunteerdetail', params: { id: volunteer.id }}">{{
            volunteer.email }}
        </router-link>
        <td>
            <v-checkbox
                    :loading="loading"
                    :disabled="disabled"
                    :sucess-messages="successMessages"
                    :success="success"
                    v-model="admin"
                    @click.stop="toggleAdmin"
            ></v-checkbox>
        </td>
        <td>
            <v-btn text small fab v-on:click="deleteDialog = true">
                <v-icon>delete_outline</v-icon>
            </v-btn>
        </td>

        <confirm-dialog
                :dialog="deleteDialog"
                :confirming="deleting"
                v-on:confirm="deleteItem(volunteer)"
                v-on:cancel="deleteDialog=false"
        >
            <template slot="text">Verwijder vrijwilliger?</template>
        </confirm-dialog>
    </tr>
</template>

<script>
    import confirmDialog from '../dialog/ConfirmDialog'
    import {EventBus} from "../../../Event";
    import RoleUser from "../../../store/orm/RoleUser"
    import User from "../../../store/orm/User"

    export default {
        name: "VolunteerListItem",
        props: {
            volunteer: {
                required: true
            }
        },
        data() {
            return {
                deleting: false,
                deleteDialog: false,
                admin: false,
                loading: false,
                disabled: false,
                successMessages: "succes",
                success: false
            }
        },
        computed: {
            roles() {
                return RoleUser.query().where('user_id', this.volunteer.id).with('role').get()
            },
            isAdmin() {


                if (this.volunteer && !this.volunteer.roles) {
                    return false
                }

                return (this.volunteer.roles.findIndex(role => {
                    return role.name == 'admin'
                }) > -1)
            }
        }, watch: {},
        methods: {
            deleteItem(item) {
                this.deleting = true;


                this.removeAdmin()
                axios.post('/api/roles/remove/' + item.id, {
                    role: 'vrijwilliger'
                })
                    .then((response) => {
                        let roleUser = RoleUser.query().where('role_id', 4)
                            .where('user_id', item.id).first()
                        roleUser.$delete()

                        User.insertOrUpdate({
                            data: response.data.data
                        })

                        this.deleting = false
                        this.deleteDialog = false
                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: 'Vrijwilliger verwijderd',
                            type: 'success'
                        })
                    }).catch((error) => {
                    this.deleting = false
                    this.deleteDialog = false
                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: 'vrijwiliger niet verwijderd ' + error,
                        type: 'error'
                    })
                })
            },
            assignAdmin() {

                RoleUser.dispatch('assign', {
                    user_id: this.volunteer.id,
                    role: 'admin'
                }).then(() => {
                    this.admin = this.isAdmin
                })


            },
            removeAdmin() {
                RoleUser.dispatch('remove', {
                    user_id: this.volunteer.id,
                    role: 'admin'
                }).then(() => {
                    this.admin = this.isAdmin
                })
            },
            toggleAdmin() {

                this.disabled = true
                this.loading = true
                let action = 'assign'

                if (this.isAdmin) {
                    action = 'remove'
                }

                RoleUser.dispatch(action, {
                    user_id: this.volunteer.id,
                    role: 'admin'
                }).then(() => {
                    this.admin = this.isAdmin
                }).finally(() => {
                    this.disabled = false
                    this.loading = false
                })

            }

        },
        components: {
            confirmDialog
        },
        mounted() {
            this.admin = this.isAdmin
        }
    }
</script>

<style scoped>

</style>
