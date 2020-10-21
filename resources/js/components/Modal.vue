<template>
    <div class="modal" v-if="visible">

        <!-- Modal content -->
        <div class="modal">

            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">
                        <slot name="title"></slot>
                    </p>
                </header>
                <section class="modal-card-body">
                    <slot name="content"></slot>
                </section>
            </div>
            <button class="modal-close is-large" aria-label="close" v-on:click="hide"></button>

        </div>

    </div>
</template>

<script>
    import {eventBus} from "../app";

    export default {
        name: "Modal",
        props: ['sortModal'],
        data() {
            return {
                visible: false
            }
        },
        methods: {
            hide() {
                this.visible = false;
            }
        },
        created() {
            eventBus.$on(this.sortModal, (data) => {
                if (data == 'hide') {
                    this.visible = false;
                    return

                }
                this.visible = true;
            })
        }
    }
</script>

<style scoped>

</style>
