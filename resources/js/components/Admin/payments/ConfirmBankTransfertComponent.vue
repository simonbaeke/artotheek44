<template>
    <v-card text>
        <v-card-text>
            <v-layout>
                <v-flex>
                    <v-text-field text
                                  label="Geef gestructureerde mededeling in"
                                  v-model="statement"
                                  :error="hasError"
                                  :error-messages="error"
                                  :success="hasSuccess"
                                  :success-messages="success"
                                  :disabled="checking"
                                  v-on:focus="clearMessages"
                                  id="test"

                    ></v-text-field>
                </v-flex>
            </v-layout>
        </v-card-text>
        <v-card-actions>
            <v-btn text v-on:click="checkStatement">bevestig</v-btn>
            <v-btn text v-on:click="$emit('close')">close</v-btn>
        </v-card-actions>
    </v-card>

</template>

<script>
    import BankTransfert from '../../../store/orm/BankTransfert'

    export default {
        name: "ConfirmBankTransfertComponent",
        data() {
            return {
                statement: "",
                hasError: false,
                error: "",
                hasSuccess: false,
                success: "",
                checking: false,
                allowedpositions: [4, 5, 6, 8, 9, 10, 11, 13, 14, 15, 16, 17]
            }
        }, watch: {
            statement() {

            }
        },
        methods: {
            checkStatement() {
                this.clearError()
                this.clearSuccess()
                this.checking = true
                let statement = this.statement.replace(/\D/g, "")
                if (statement.length != 12){
                    this.setError('Foutieve medeling')
                    this.checking = false

                    return
                }
                axios.get('api/banktransferts/check/' + statement)
                    .then(response => {
                        BankTransfert.insertOrUpdate({data: response.data.data})

                        this.setSuccess('Overschrijving bevestigd')
                        //this.fetchTransfert(response.data.data.id)
                    }).catch(error => {
                    this.setError(error.response.data.message)
                }).finally(() => {
                    this.checking = false
                })
            },
            clearError() {
                this.hasError = false
                this.error = ""
            },
            setError(message) {
                this.clearSuccess()
                this.hasError = true
                this.error = message
            },
            clearSuccess() {
                this.hasSuccess = false
                this.success = ""
            },
            setSuccess(message) {
                this.clearError()
                this.hasSuccess = true
                this.success = message
            },
            clearMessages() {

                let p = this.getCaretPosition('test')
                if (this.allowedpositions.indexOf(p) < 0) {
                    this.setCaretPosition('test', 17)
                }

                if (this.error || this.success) {
                    this.statement = ""
                }
                this.clearError()
                this.clearSuccess()

                //checkposition


            },
            fetchTransfert(id) {
                axios.get('api/banktransferts/' + id).then(response => {
                    BankTransfert.insertOrUpdate({data: response.data.data})
                })
            },
            setCaretPosition(elemId, caretPos) {
                var elem = document.getElementById(elemId);
                console.log('set')

                if (elem != null) {
                    if (elem.createTextRange) {
                        var range = elem.createTextRange();
                        range.move('character', caretPos);
                        range.select();
                    }
                    else {
                        if (elem.selectionStart) {
                            elem.focus();
                            elem.setSelectionRange(caretPos, caretPos);
                        }
                        else
                            elem.focus();
                    }
                }
            },
            getCaretPosition(elemId) {
                var oField = document.getElementById(elemId);

                // Initialize
                var iCaretPos = 0;

                // IE Support
                if (document.selection) {

                    // Set focus on the element
                    oField.focus();

                    // To get cursor position, get empty selection range
                    var oSel = document.selection.createRange();

                    // Move selection start to 0 position
                    oSel.moveStart('character', -oField.value.length);

                    // The caret position is selection length
                    iCaretPos = oSel.text.length;
                }

                // Firefox support
                else if (oField.selectionStart || oField.selectionStart == '0')
                    iCaretPos = oField.selectionStart;

                // Return results
                return iCaretPos;
            }
        }
    }
</script>

<style scoped>

</style>
