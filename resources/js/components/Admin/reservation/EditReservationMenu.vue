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
                        v-on:click="stop(item.action)"
                >
                    <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                </v-list-tile>
            </v-list>
        </v-menu>
        <span>Wijzig Reservering</span>
    </v-tooltip>
</template>

<script>

    import {EventBus} from "../../../Event";

    export default {
        name: "EditReservationMenu",
        props: {
            reservation: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                items: [
                    {title: 'Stop', action: "stopreservation"},
                    {title: 'Ontleen', action: "ontleenreservation"},
                    //{title: 'Verleng', action: "verlengreservation"}
                ],
                showDatePicker: false,
                date: new Date().toISOString().substr(0, 10),
                menu: false,
                modal: false,
                menu2: false
            }
        },
        methods: {
            stop(action) {
                EventBus.$emit(action, this.reservation.id)
            }
        }
    }
</script>

<style scoped>

</style>
