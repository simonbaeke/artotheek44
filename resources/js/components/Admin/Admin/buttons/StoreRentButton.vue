<template>
    <v-btn :loading="storing" flat @click.native="storeRent">Opslaan</v-btn>
</template>

<script>

    import {EventBus} from "@/Event";

    export default {
        name: "StoreRentButton",
        props: {
            rent: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                storing: false
            }
        },
        methods: {
            storeRent() {
                this.storing = true;
                this.$store.dispatch('createRent', this.rent).then(response => {

                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message:'Ontlening van ' + response.data.data.artwork.name + ' door ' +  response.data.data.user.fullname +' aangemaakt',
                        type:'success'
                    })

                    this.$emit('close');
                    this.storing = false;
                }).catch(error => {
                    this.storing = false;

                    console.log(error.request.status)
                    if (error.request.status==422){
                        this.$emit('error',JSON.parse(error.request.response).errors)
                    }

                    EventBus.$emit('message',{
                        component:'notificationSnackbar',
                        message:'Ontlening niet aangemaakt: ' + error.request.response,
                        type:'error'
                    })

                    this.$emit('close')
                    //this.$store.commit('setError',error)
                })
            }
        }
    }
</script>

<style scoped>

</style>
