<template>
    <div>Nieuwe Cadaubon terwaarde van {{voucher.amount}}</div>
</template>

<script>
    import Voucher from "@/store/orm/Voucher";

    export default {
        name: "VoucherComponent",
        props: {
            id: {
                required: true
            }
        },
        computed: {
            voucher() {
                return Voucher.find(this.id)
            }
        },
        mounted(){
            Voucher.dispatch('show',{id:this.id})
        }
    }
</script>

<style scoped>

</style>
