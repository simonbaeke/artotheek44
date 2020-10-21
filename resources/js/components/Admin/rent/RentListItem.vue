<template>
    <tr v-bind:class="classObject">
        <td>{{ rent.artwork.name }}</td>

        <td>{{ rent.artwork.code }}</td>
        <td>{{ rent.user.fullname }}</td>
        <td>{{rent.subscriptionnumber}}</td>

        <started-dialog v-if="isSuperAdmin" :rent="rent"></started-dialog>
        <td v-else>{{rent.started_at}}</td>

        <expire-dialog v-if="isSuperAdmin" :expirable_id="rent.id" :expires_at="expires_at"></expire-dialog>
        <td v-else>{{rent.expires_at}}</td>

        <td v-if="isSuperAdmin" v-on:click="editDialog=true"> {{rent.returned_at}}</td>
        <td v-else>{{rent.returned_at}}</td>

        <td v-if="isSuperAdmin">
            <v-btn text small fab v-on:click="deleteDialog = true">
                <v-icon>delete_outline</v-icon>
            </v-btn>
        </td>


        <edit-returned-at-dialog
                v-if="isSuperAdmin"
                :dialog="editDialog"
                :rent="rent" v-on:close="editDialog=false"/>

        <td v-else>
            {{rent.returned_at}}
        </td>


        <confirm-dialog
                v-if="isSuperAdmin"
                :dialog="deleteDialog"
                :confirming="deleting"
                v-on:confirm="deleteRent"
                v-on:cancel="deleteDialog=false"
        >
            <template slot="text">Verwijder ontlening?</template>
        </confirm-dialog>
    </tr>
</template>

<script>
    import expireDialog from '../dialog/ExpireDialog'
    import startedDialog from '../dialog/StartedDialog'
    import editReturnedAtDialog from '../dialog/EditReturnedAtDialog'
    import confirmDialog from '../dialog/ConfirmDialog'
    import Rent from "../../../store/orm/Rent";

    export default {
        name: "RentListItem",
        props: {
            rent: {
                required: true
            }
        },
        data() {
            return {
                editDialog: false,
                deleteDialog: false,
                deleting: false
            }
        },
        computed: {
            classObject: function () {
                return {
                    'text-danger': this.rent.expired
                }
            },

            classObject: function () {
                return {
                    //active: this.isActive && !this.error,
                    'text-danger': this.toLate
                }
            },
            toLate() {
                return Date.parse(this.rent.expires_at) < Date.now() && this.rent.returned_at == null
            },

            isSuperAdmin() {
                return this.$store.getters['entities/users/userHasRole']('superadmin')
            },

            expires_at(){
                if (this.rent.expires_at == null){
                    return 'niet opgegeven'
                }
                else return this.rent.expires_at
            }




        },
        methods: {
            deleteRent() {
                window.axios.delete('/api/rents/' + this.rent.id)
                    .then((response) => {
                        Rent.delete(this.rent.id)
                        this.deleteDialog = false
                    })
            }
        },
        components: {
            expireDialog,
            startedDialog,
            editReturnedAtDialog,
            confirmDialog
        }
    }
</script>

<style scoped>
    .text-danger {

        background-color: rgba(231, 76, 60,0.8);
    }

    .text-danger:hover {

        background-color: rgba(231, 76, 60,1)!important;
    }

    .expired{
        background-color: rgba(231, 76, 60,0.8);
    }
</style>
