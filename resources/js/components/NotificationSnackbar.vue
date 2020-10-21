<template>
    <!--    <v-container
                v-if="show"
                color="white"
                multi-line
        >
            {{ message }}
            <v-btn
                    color="white"
                    flat
                    @click="$emit('close',index)">
                Sluit
            </v-btn>
        </v-container>-->
    <v-container
            v-if="show"
            multi-line
    >
        <v-alert :value="true"
                 outlined
dense
                 border="bottom"
                 :type="type">

             {{ message }}


                    <v-btn
                            :color="type"
                            text
                            @click="$emit('close',index)">
                        Sluit
                    </v-btn>

            <v-spacer></v-spacer>

        </v-alert>


    </v-container>
</template>

<script>
    export default {
        name: "NotificationSnackbar",
        props: ['message', 'index','type'],
        data() {
            return {
                show: true
            }
        },
        mounted() {
            setTimeout(() => {
                this.$emit('close', this.index)
            }, 20000)
        }
    }

</script>

<style scoped>
    .container {
        width: 100%;
        background-color: white;
        color: white;
        opacity: 0.8;
        padding: 0.5rem 2rem;
    }

    @media only screen and (min-width: 600px) {
        .container {
            width: 100%;
            max-width: 100% !important;

        }
    }
</style>
