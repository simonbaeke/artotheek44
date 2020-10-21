<template>
    <tr v-bind:class="classObject">
        <td>{{ rent.artwork.name }}</td>
        <td>{{ rent.artwork.code }}</td>
        <td>{{ rent.user.fullname }}</td>
        <started-dialog :rent="rent"></started-dialog>
        <expire-dialog :expire="rent.expire"></expire-dialog>
        <td v-on:click="editDialog=true">{{ rent.returned }}</td>
        <edit-returned-at-dialog :dialog="editDialog" :rent="rent" v-on:close="editDialog=false"/>

    </tr>
</template>

<script>
    import expireDialog from '../dialog/ExpireDialog'
    import startedDialog from '../dialog/StartedDialog'
    import editReturnedAtDialog from '../dialog/EditReturnedAtDialog'

    export default {
        name: "RentListItem",
        props: {
            rent: {
                required: true
            }
        },
        data() {
            return {
                editDialog: false
            }
        },
        computed: {
            classObject: function () {
                return {
                    'text-danger': this.rent.expired
                }
            }
        },
        components: {
            expireDialog,
            startedDialog,
            editReturnedAtDialog
        }
    }
</script>

<style scoped>
    .text-danger {
        color: red;
    }
</style>
