<template>
    <td>Verlenging van {{expire.expirable_type}} tot {{expire.date}}</td>
</template>

<script>
    import Expire from "@/store/orm/Expire";

    export default {
        name: "ExpireComponent",
        props:{
            id:{
                required:true,
                type:Number
            }
        },
        computed:{
            expire(){
                return Expire.find(this.id)
            }
        }
    }
</script>

<style scoped>

</style>
