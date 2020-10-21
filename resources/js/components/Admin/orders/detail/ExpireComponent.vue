<template>
    <span>Verlenging van {{expirables[expire.expirable_type]}} tot {{expire.date}}</span>
</template>

<script>
    import Expire from "../../../../store/orm/Expire";

    export default {
        name: "ExpireComponent",
        props: {
            id: {
                required: true,
                type: Number
            }
        },
        data() {
            return {


                expirables: {
                    'Subscription': 'Lidkaart',
                    'Rent': 'Ontlening'
                }
            }
        },
        computed: {
            expire() {
                return Expire.find(this.id)
            }
        }
    }
</script>

<style scoped>

</style>
