<template>
    <v-text-field

            solo-inverted
            flat
            clearable
            prepend-icon="search"
            :label=placeholder
            v-model="search"
            class="hidden-sm-and-down searchbar"/>
</template>

<script>
    import {EventBus} from "../../Event";

    export default {
        name: "ArtworkSearch",
        data() {
            return {
                search: "",
                placeholder:"Zoek kunstwerk"
            }
        },
        watch: {
            // whenever question changes, this function will run
            search() {
                EventBus.$emit('search', this.search)
            }

        },
        created() {
            EventBus.$on('resetSearchstring', () => {
                this.search = ""
            })
        }
    }
</script>

<style scoped>

    .searchbar{
        margin-top:1.5rem!important;
    }

</style>
