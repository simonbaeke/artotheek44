<template>
    <v-flex v-if="bankTransfert">
        Te betalen via overschrijving: {{bankTransfert.amount}} euro, met referentie: {{bankTransfert.statement}}
    </v-flex>
</template>

<script>
    import BankTransfert from '../../../store/orm/BankTransfert'

    export default {
        name: "BankTransfertSummary",
        props: ['id'],
        computed: {
            bankTransfert() {
                return BankTransfert.find(this.id)
            }
        },
        mounted() {
            axios.get('api/banktransferts/' + this.id).then(response => {
                BankTransfert.insertOrUpdate({data:response.data.data})
            })
        }
    }
</script>

<style scoped>

</style>
