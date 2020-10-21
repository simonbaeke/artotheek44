<template>
    <div class="grey--text">Cadeaubon: {{voucherPay.voucher.amount}}€</div>
</template>

<script>
    import VoucherPay from "../../../store/orm/VoucherPay";

    export default {
        name: "VoucherPaySummary",
        props: {
            id: {
                required: true
            }
        },
        computed:{
            voucherPay(){
                return VoucherPay.query().where('id',this.id).with('voucher').first()
            }
        },
        mounted() {
                VoucherPay.dispatch('show',{
                    id:this.id
                })
        }
    }
</script>

<style scoped>

</style>
