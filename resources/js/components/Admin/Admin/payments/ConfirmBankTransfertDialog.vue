<template>

    <v-dialog v-model="dialog" max-width="500px" transition="dialog-bottom-transition">

        <v-btn
                slot="activator"
                flat
        >
            overschrijving bevestigen
        </v-btn>
        <confirm-bank-transfert-component
            v-on:close="dialog=false"
        />

    </v-dialog>


</template>

<script>
    import confirmBankTransfertComponent from './ConfirmBankTransfertComponent'

    export default {
        name: "ConfirmBankTransfertDialog",

        data() {
            return {
                dialog: false
            }
        },
        components: {
            confirmBankTransfertComponent
        }
    }
</script>

<style scoped>

</style>
