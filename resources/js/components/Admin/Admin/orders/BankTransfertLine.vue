<template>
    <div v-if="bankTransfert">

        Overschrijving: {{bankTransfert.amount}} euro

    </div>

</template>

<script>
    import BankTransfert from '../../../store/orm/BankTransfert'
    import Pay from "@/store/orm/Pay";

    export default {
        name: "BankTransfertLine",
        props: {
            id: {
                required: true,
            }
        },
        computed: {
            bankTransfert() {
                return BankTransfert.find(this.id)
            },
            pay() {
                if (!this.bankTransfert) {
                    return null
                }
                return Pay.query().where('payable_id', this.id).where('payable_type', 'BankTransfert').first()
            },
            loading() {
                return this.bankTransfert == null
            }
        },
        mounted() {
            axios.get('api/banktransferts/' + this.id).then(response => {
                BankTransfert.insertOrUpdate({data: response.data.data})
            })
        }
    }
</script>

<style scoped>

</style>
