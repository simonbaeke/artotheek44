<template>
    <v-tooltip bottom>
        <v-menu offset-y slot="activator">
            <v-btn
                    slot="activator"
                    icon
            >
                <v-icon small>more_vert</v-icon>
            </v-btn>
            <v-list>
                <v-list-tile
                        v-for="(item, index) in items"
                        :key="index"
                        v-on:click="click(item.action)"
                >
                    <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                </v-list-tile>
            </v-list>
        </v-menu>
        <span>Wijzig Ontlening</span>
    </v-tooltip>
</template>

<script>
    import {EventBus} from "../../../Event";

    export default {
        name: "EditRentMenu",
        props: {
            rent: {
                type: Number,
                required: true
            }
        },
        data() {
            return {
                items: [
                    {title: 'Stop ontlening', action: "stoprent"},
                    {title: 'Wijzig ontlening', action: "editrent"},
                ]
            }
        },
        methods: {
            click(action) {
                EventBus.$emit(action, this.rent)
            }
        }
    }
</script>

<style scoped>

</style>
