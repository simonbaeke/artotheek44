<template>
    <transition name="fade">
        <div v-bind:class="[success ? 'is-success' : 'is-danger', 'notification']" v-if="visible">
            <button text class="delete" v-on:click="clearError"></button>
            {{message}}
        </div>
    </transition>
</template>

<script>
    import {eventBus} from "../app";

    export default {
        name: "Notification",
        data() {
            return {
                visible: false,
                message: "",
                success: true
            }
        },
        computed: {
            class() {
                if (this.type == 'error') {
                    return "notification is-danger"
                }

                return "notification is-success"
            }
        },
        methods: {
            clearError() {
                this.message = "";
                this.visible = false;
            },

            showNotification(data) {
                this.message = data.message;
                this.success = data.success;
                this.visible = true;

                setTimeout(function () {
                    this.visible = false
                }.bind(this), 3000)
            }
        },
        created: function () {
            eventBus.$on('showNotification', data => {
                this.showNotification(data)
            })
        }


    }
</script>

<style scoped>
    .notification {
        position: fixed;
        bottom: 2rem;
        width: 100%;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity 1s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>
