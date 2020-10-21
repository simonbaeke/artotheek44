<template>
    <v-menu
            v-if="$route.name=='catalogus'"

            bottom
            left
            class="hidden-sm-and-down"
    >
        <template v-slot:activator="{ on }">
            <v-btn

                    text
                    v-on="on"
            >
                disciplines
            </v-btn>
        </template>

        <v-list>
            <v-list-item>
                <v-list-item-content>
                    <v-checkbox v-model="beschikbaar" v-on:change="emitFilter"></v-checkbox>
                </v-list-item-content>
                <v-list-item-title>Beschikbaar</v-list-item-title>
            </v-list-item>
            <v-divider></v-divider>
            <v-list-item
                    v-for="(type, i) in types"
                    :key="type.name"
            >
                <v-list-item-action>
                    <v-checkbox v-model="filter[type.name]" v-on:change="emitFilter"></v-checkbox>

                </v-list-item-action>
                <v-list-item-title>{{ type.name }}</v-list-item-title>
            </v-list-item>
        </v-list>
    </v-menu>


</template>

<script>
    import Type from '../../../store/orm/Type'
    import {Filter} from "../../../Filter";
    import {EventBus} from "../../../Event";

    export default {
        name: "FilterMenu",
        data() {
            return {
                beschikbaar: false,
                filter: new Filter(this.types),
                available: "Beschikbaar"
            }
        },
        computed: {
            types() {
                return Type.all()
            }
        },
        watch: {
            types() {
                this.filter = new Filter(this.types)
            }
        },
        methods: {
            emitFilter() {
                EventBus.$emit('filter', this.$data)
            }
        },
        mounted() {
            axios.get('api/types').then(result => Type.insertOrUpdate({data: result.data.data}))
            this.emitFilter()
        }
    }
</script>

<style scoped>

</style>
