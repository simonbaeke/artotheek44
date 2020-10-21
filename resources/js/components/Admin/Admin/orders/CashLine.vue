<template>
    <div class="grey--text" v-if="cash">
        Cash: {{cash.amount}} euro
    </div>
</template>

<script>
    import Cash from "@/store/orm/Cash";

    export default {
        name: "CashLine",
        props: ['id'],
        computed: {
            cash() {
                return Cash.find(this.id)
            }
        },
        mounted() {
            axios.get('api/cashs/' + this.id).then(response => {
                Cash.insertOrUpdate({data: response.data.data})
            })
        }
    }
</script>

<style scoped>

</style>
