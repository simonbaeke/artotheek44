<template>
        <v-alert
                transition="scale-transition"
                :value="value"
                :color="messageType"
                outlined

                dismissible
                v-on:input="onClose">
            {{message}}
        </v-alert>
</template>

<script>
    export default {
        name: "Alert",
        props: {
            timer: {
                default: 6000
            }
        },
        data() {
            return {
                value: false,
            }
        },
        methods: {
            onClose() {
                this.$store.commit('clearMessage')
                this.value=false
            }
        },
        computed: {
            message() {
                return this.$store.getters.message;
            },

            messageType() {
                return this.$store.getters.messageType;
            }
        },
        watch: {
            message() {
                if (this.message != null) {
                    this.value = true;
                    setTimeout(() => {
                        this.$store.commit('clearMessage')
                        this.value = false;
                    }, this.timer)
                }
            }
        }
    }
</script>

<style scoped>

    .v-alert--outline {
        position: fixed;
        bottom: 5rem;
        z-index: 100;
        width: 60%;
        background-color:rgba(0,0,0,0.7);
        padding:0.5rem;

    }

    @media (max-width: 56.25em) {
        .v-alert--outline {
            position: fixed;
            bottom:  2rem;
            z-index: 100;
            width: 90%;
            background-color:rgba(0,0,0,0.7);
            padding:0.5rem;
        }

    }
</style>
