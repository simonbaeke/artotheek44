<template>
    <v-card
            :elevation="0">

        <v-autocomplete
                :items="users"
                item-text="fullname"
                item-value="id"
                :loading="loading"
                v-model="user"
        />

        <v-btn
                v-on:click="save"
                :loading="loading"
                :disabled="user==null"
                text

        >
            Opslaan
        </v-btn>


    </v-card>
</template>

<script>
    import User from '../../../store/orm/User'
    import {EventBus} from "../../../Event";

    export default {
        name: "createExistingVoluntueer",
        props: {
            loading: {
                default: false
            }
        },

        data() {
            return {
                loading: false,
                user: null
            }
        },
        computed: {
            users() {
                return User.query().get()
            }
        }, methods: {
            save() {
                EventBus.$emit('vrijwilliger aangemaakt', this.user)
            }
        },
        mounted() {
            this.loading = true
            User.dispatch('fetch', {role: 'ontlener', list: 'true'})
                .then(() => {
                    this.loading = false
                })
                .catch(error => {
                    console.log(error)
                    this.loading = false
                })
        }
    }
</script>

<style scoped>

</style>
