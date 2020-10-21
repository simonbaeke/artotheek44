<template>
    <app-main>
        <template slot="title">Disciplines</template>
        <template slot="content">
            <router-view></router-view>
        </template>
    </app-main>
</template>

<script>
    import appMain from '../basis/main'
    import Type from "../../../store/orm/Type";
    export default {
        name: "Discipline",
        components:{
            appMain
        },
        mounted(){
            Type.dispatch('fetchTypes')
        }
    }
</script>

<style scoped>

</style>
