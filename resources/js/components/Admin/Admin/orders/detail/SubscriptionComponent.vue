<template>
    <div>Nieuw Abonnement geldig tot {{expire.date}}</div>
</template>

<script>
    import Expire from "@/store/orm/Expire";

    export default {
        name: "SubscriptionComponent",
        props:{
            id:{
                required:true,
                type:Number
            }
        },
        computed:{
            expire(){
                return Expire.query()
                    .where('expirable_type','Subscription')
                    .where('expirable_id',this.id)
                    .first()
            }
        }
    }
</script>

<style scoped>

</style>
