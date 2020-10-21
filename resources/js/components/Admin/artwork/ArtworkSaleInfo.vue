<template>
    <v-flex>
        Gekocht door:
        {{user.firstname}}
    </v-flex>
</template>

<script>
    import User from '../../../store/orm/User'
    export default {
        name: "ArtworkSaleInfo",
        props: {
            sale: {
                required: true,
                type: Object
            }
        },
        computed: {
            user(){
                if (this.sale.user_id == null){
                    let userinfo  = JSON.parse(this.sale.user_info)
                    return {
                        firstname: userinfo.firstname,
                        lastname: userinfo.lastname,
                        email: userinfo.email,
                        telefoon:userinfo.phone
                    }
                }

                let userinfo  = User.find(this.sale.user_id)

                if (userinfo!= null){
                    return {
                        firstname: userinfo.firstname,
                        lastname: userinfo.lastname,
                        email: userinfo.email,
                        telefoon:userinfo.phone
                    }
                }

                return {
                    firstname:"",
                    lastname:"",
                    email:"",
                    telefoon:""
                }


            }
        }
    }
</script>

<style scoped>

</style>
