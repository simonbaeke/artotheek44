<template>
    <div>
        <create-rent-dialog :dialog="createRentDialog"
                            v-on:close="close(createRentDialog)"/>

        <create-rent-by-artwork-dialog
                :dialog="createRentByArtworkDialog"/>
        <stop-rent-dialog></stop-rent-dialog>
        <edit-rent-dialog></edit-rent-dialog>
    </div>
</template>

<script>
    import {EventBus} from "../../../Event";
    import {Dialog} from "../../../Dialog";
    import createRentDialog from './CreateRentDialog'
    import editRentDialog from './EditRentDialog.vue'
    import createRentByArtworkDialog from './CreateRentByArtworkDialog'
    import stopRentDialog from './StopRentDialog'

    export default {

        name: "EditRent",
        data() {
            return {
                createRentByArtworkDialog: new Dialog({
                    artwork_id: null,
                    expires: null,
                    subscription_id: null,
                    user_id:null
                }),
                createRentDialog: new Dialog({
                    artwork_id: null,
                    expires: null,
                    subscription_id: null,
                }),

                selectedArtwork: null,
                selectedRent: null,
                selectedSubscription: false,
                createRentByArtwork: {
                    dialog: false,
                    object: {}
                },
                createRent: {},


            }
        },
        methods: {
            close(dialog) {
                dialog.close()
            },
            today() {
                return new Date().toISOString().substr(0, 10)
            }

        },
        created() {
            EventBus.$on('createrent', subscription => {
                this.createRentDialog.open({subscription_id: subscription})
            })


            EventBus.$on('createrentbyartwork', artwork => {
                this.createRentByArtworkDialog.open({artwork_id: artwork.id})
            })
        },
        components: {
            createRentDialog,
            editRentDialog,
            createRentByArtworkDialog,
            stopRentDialog
        }

    }
</script>

<style scoped>

</style>
