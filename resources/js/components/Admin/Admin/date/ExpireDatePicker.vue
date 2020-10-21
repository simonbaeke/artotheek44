<template>
    <v-layout row wrap>
        <v-flex xs12 sm7 md7>
            <v-menu
                    :close-on-content-click="false"
                    v-model="menu"
                    :nudge-right="40"
                    lazy
                    transition="scale-transition"
                    offset-y
                    full-width
                    min-width="290px"
            >
                <v-text-field
                        slot="activator"
                        :value="date"
                        label="Selecteer datum"
                        readonly
                ></v-text-field>
                <v-date-picker
                        v-model="date"
                        @input="menu = false"
                        :max="max"
                ></v-date-picker>
            </v-menu>
        </v-flex>
        <v-flex xs4 sm6 md4>
            <count-button :count="month" :down="month>0" :up="dateObject<max" @up="add" @down="subtract"></count-button>
        </v-flex>
    </v-layout>
</template>

<script>
    import countButton from '../buttons/CountButton'
    import {EventBus} from '../../../Event.js'

    export default {
        name: "ExpireDatePicker",
        props: {
            subscription: {
                type: Object,
                required: true
            }
        },

        data() {
            return {
                menu: false,
                date: new Date((new Date()).setMonth(new Date().getMonth() + 6)).toISOString().slice(0,10)
            }
        },
        watch:{
          date(){
                this.$emit('datechange',this.date)
          }
        },
        computed: {
            month() {
                let d = new Date(Date.parse(this.date))
                let month = 0
                let loopDate = new Date(Date.parse(this.startDate))
                let addMonth = loopDate < d
                let loops = 0


                while ((loopDate.getFullYear() != d.getFullYear() || loopDate.getMonth() != d.getMonth()) && loops <20) {
                    if (addMonth) {
                        loopDate.setMonth(loopDate.getMonth() + 1)
                        month++
                    } else {
                        loopDate.setMonth(loopDate.getMonth() - 1)
                        month--
                    }

                    loops ++
                }

                return month
            },
            max() {
                return new Date(Date.parse(this.subscription.expires))
            },
            dateObject(){
                return new Date(Date.parse(this.date))
            },
            startDate(){
                return new Date().toISOString().substr(0, 10)
            }

        },
        methods: {
            add() {
                let d = new Date(Date.parse(this.date))
                d.setMonth(d.getMonth() + 1)
                this.date = d.toISOString().slice(0,10)
            },
            subtract() {
                let d = new Date(Date.parse(this.date))
                d.setMonth(d.getMonth() - 1)
                this.date = d.toISOString().slice(0,10);
            },
            today(){
                return new Date((new Date(Date.parse(this.startDate))).setMonth(new Date(Date.parse(this.startDate)).getMonth() + 6)).toISOString().slice(0,10)
            }
        },
        components: {
            countButton
        },
        mounted(){
            this.$emit('datechange',this.date)

        },
        created(){
            EventBus.$on('resetdate',()=>{
                this.date = this.today()
                this.$emit('datechange',this.date)
            })
        }
    }
</script>

<style scoped>

</style>
