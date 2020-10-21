<template>
<app-content>
    <template slot="toolbar">{{volunteer.firstname}}</template>
    <template slot="text">{{volunteer}}</template></app-content>
</template>

<script>
    import User from '../../../store/orm/User'
    import appContent from '../basis/content'
    export default {
        name: "VolunteerDetail",
        computed:{
            volunteer(){
                return User.query().where('id',this.$route.params.id).with('roles').first()
            }
        },
        components:{
            appContent
        }
    }
</script>

<style scoped>

</style>
