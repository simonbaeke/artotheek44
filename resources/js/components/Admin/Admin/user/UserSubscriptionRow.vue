<template>


    <tr v-on:click="$emit('click')" v-bind:class="{verlopen:expired}">
        <td>{{subscription.number.toString().padStart(3,'0')}}</td>
        <td>{{expire.date}}</td>
        <td>{{combined.soort}}</td>
        <td>{{combined.kunstwerk}}</td>
        <td>{{combined.code}}</td>
        <td>{{combined.expires}}</td>
    </tr>
</template>

<script>
    import Rent from '../../../store/orm/Rent'
    import Reservation from '../../../store/orm/Reservation'
    import Expire from "@/store/orm/Expire";

    export default {
        name: "UserSubscriptionRow",
        props: {
            subscription: {
                type: Object,
                required: true
            }
        },
        computed: {
            activeRent() {
                return Rent.query()
                    .where('returned', false)
                    .where('subscription_id', this.subscription.id)
                    .with('artwork').first()
            },
            expire() {
                return Expire.query()
                    .where('expirable_type', "Subscription")
                    .where('expirable_id', this.subscription.id).first()
            },
            activeReservation() {
                return Reservation.query()
                    .where('active', true)
                    .where('subscription_id', this.subscription.id)
                    .where('expired', false)
                    .with('artwork').first()
            },
            available() {
                return !this.subscription.rents.find(rent => {
                    return rent.returned == 0
                }) && !this.subscription.reservations.find(reservation => {
                    return reservation.active == 1
                })
            },
            combined() {
                let status = "Ok";
                if (!this.subscription.confirmed) {
                    status = "Proef"
                }
//tODO code kunstwerk toevoegen
                if (this.activeRent) {
                    return {
                        kunstwerk: this.activeRent.artwork.name,
                        code: this.activeRent.artwork.code,
                        expires: Expire.query()
                            .where('expirable_type', 'Rent')
                            .where('expirable_id', this.activeRent.id)
                            .first().date,
                        soort: "Ontleend",
                        id: this.activeRent.id,
                        status: status
                    }
                }

                if (this.activeReservation) {
                    return {
                        kunstwerk: this.activeReservation.artwork.name,
                        code: this.activeReservation.artwork.code,

                        expires: Expire.query()
                            .where('expirable_type', 'Reservation')
                            .where('expirable_id', this.activeReservation.id)
                            .first().date,
                        soort: "Gereserveerd",
                        id: this.activeReservation.id,
                        status: status
                    }
                }

                return {
                    kunstwerk: "",
                    expires: "",
                    code: "",
                    soort: this.expired ? "Verlopen" : "Actief",
                    id: "",
                    status: status
                }
            },
            expired() {
                if (this.expire) {
                    return Date.parse(this.expire.date) < new Date()
                }
                return false
            }

        }
    }
</script>

<style scoped>
    .verlopen {
        color: red
    }


</style>
