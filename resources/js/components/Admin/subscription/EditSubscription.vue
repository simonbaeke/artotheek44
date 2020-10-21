<template>
    <div>
        <edit-subscription-dialog
                :dialog="editSubscriptionDialog"
                :subscription="selectedSubscription"
                v-on:close="editSubscriptionDialog=false"
                v-on:update="updateSubscription($event)"
        />
    </div>


</template>

<script>
    import {EventBus} from "../../../Event";

    import payDialog from '../orders/PayDialog'
    import editSubscriptionDialog from './EditSubscriptionDialog.vue'

    export default {
        name: "EditSubscription",
        data() {
            return {
                editSubscriptionDialog: false,
                payDialog: false,
                selectedSubscription: [],
                dialog: false,
                message: ""
            }
        },
        methods: {
            updateSubscription(e) {
                this.payDialog = true;
                this.message = e.message
            }
        }
        ,
        components: {
            editSubscriptionDialog,
            payDialog
        },
        created() {
            EventBus.$on('editsubcription', subscription => {
                this.selectedSubscription = Object.assign({}, subscription)
                this.editSubscriptionDialog = true
            });
        }
    }
</script>

<style scoped>

</style>
