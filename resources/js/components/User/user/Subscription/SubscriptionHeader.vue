<template>
    <div>
        <div class="mdl-card__menu">
            <button id="edit-subscription" v-if="!edit"
                    class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect mdl-button--colored">
                <i class="material-icons" v-on:click="onClickEdit()">edit</i>
            </button>

            <button id="save-edit-subscription" v-if="edit"
                    class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect mdl-button--colored">
                <i class="material-icons" v-on:click="onClickSaveEdit">save</i>
            </button>
            <div class="mdl-tooltip" data-mdl-for="save-edit-subscription">
                Bewaar Wijzigingen
            </div>
            <button id="cancel-edit-subscription" v-if="edit"
                    class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect mdl-button--colored">
                <i class="material-icons" v-on:click="onClickCancelEdit()">cancel</i>
            </button>
            <div class="mdl-tooltip" data-mdl-for="cancel-edit-subscription">
                Annuleer wijzigen
            </div>
        </div>
        <div>Abonnement verloopt op: {{expires}}</div>

    </div>
</template>

<script>

    export default {
        name: "SubscriptionHeader",
        props: ['expires', 'editing'],
        data() {
            return {
                edit: false
            }
        },
        methods: {
            onClickEdit() {
                if (!this.editing) {
                    this.edit = true;
                }
            },

            onClickCancelEdit() {

                this.edit = false;
            },

            onClickSaveEdit() {
                console.log('niet geimplementeerd')
            }
        }
    }
</script>

<style scoped>

</style>
