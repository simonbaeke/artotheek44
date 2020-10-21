<template>
    <v-flex>Cash betaald: {{cash.amount}}€</v-flex>
</template>

<script>
    import Cash from "@/store/orm/Cash";

    export default {
        name: "CashSummary",
        props: {
            id: {
                required: true
            }
        },
        computed: {
            cash() {
                return Cash.find(this.id)
            }
        },
        mounted() {
            Cash.dispatch('show', {id: this.id})
        }

    }
</script>

<style scoped>

</style>
