<template>
    <app-main>
        <template slot="title">
            Vrijwilligers
        </template>
        <template slot="content">
            <router-view></router-view>
        </template>
    </app-main>

</template>

<script>
    import appMain from '../basis/main'


    export default {
        name: "Volunteer",

        components:{
            appMain
        }
    }
</script>

<style scoped>

</style>
