<template>
    <div>
        <component
                v-if="!loading"
                :is="selectedComponent"
                v-on:edit="selectedComponent='userEdit'"
                v-on:cancel="selectedComponent='userData'"
                :user="user"
                :address="address"
        ></component>
        <v-progress-linear
                v-if="loading"
                :active="loading"
                :indeterminate=true
                :query="true"
                color="primary"
        ></v-progress-linear>
    </div>



</template>

<script>
    import userEdit from './UserEdit'
    import userData from './UserData'

    export default {
        name: "UserInfo",
        props: ['user', 'address','loading'],
        data() {
            return {
                selectedComponent: 'userData'
            }

        },
        components: {
            userData,
            userEdit
        }
    }
</script>

<style scoped>
</style>
