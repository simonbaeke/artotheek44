<template>
    <v-autocomplete
            label="Selecteer een gebruiker"
            :items="users"
            item-text="fullname"
            item-value="id"
            :loading="users.length==0"
            v-on:change="$emit('change',$event)"
    ></v-autocomplete>
</template>

<script>
    import User from "../../../store/orm/User";

    export default {
        name: "SelectKnownUserComponent",

        computed: {
            users() {
                return User.query().get()
            }
        },
        mounted() {
            User.dispatch('fetch', {role: 'ontlener',list:'true'})
                .then(response => {

                });
        }
    }
</script>

<style scoped>

</style>
