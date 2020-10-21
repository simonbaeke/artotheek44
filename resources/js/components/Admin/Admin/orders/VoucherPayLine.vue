<template>
    <div v-if="voucherPay">
        Cadeaubon: {{voucher.amount}}€
    </div>
</template>

<script>
    import VoucherPay from "@/store/orm/VoucherPay";
    import Pay from "@/store/orm/Pay"
    import Voucher from "@/store/orm/Voucher"

    export default {
        name: "VoucherPayLine",
        props: {
            id: {
                required: true,
            }
        },
        computed: {
            voucherPay() {
                return VoucherPay.find(this.id)
            },
            voucher() {
                if (!this.voucherPay) {
                    return null
                }
                return Voucher.find(this.voucherPay.voucher_id)
            },
            pay() {
                if (!this.voucherPay) {
                    return null
                }
                return Pay.query().where('payable_id', this.id).where('payable_type', 'VoucherPay').first()
            }
        },
        mounted() {
            VoucherPay.dispatch('show', {
                id: this.id
            })
        }
    }
</script>

<style scoped>

</style>
