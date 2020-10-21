<template>
    <div class="list-container">
        <div v-for="(item,index) in messages" :key="item.id">
            <component :is="item.component" :message="item.message" :index="item.id" :type="item.type"
                       v-on:close="close($event)"></component>
        </div>
    </div>

</template>

<script>
    import {EventBus} from "../Event";
    import cookieSnackbar from './CookieSnackbar'
    import verifiedSnackbar from './VerifiedSnackbar'
    import notificationSnackbar from './NotificationSnackbar'

    export default {
        name: "MessageList",
        data() {
            return {
                messages: []
            }
        },
        components: {
            cookieSnackbar,
            verifiedSnackbar,
            notificationSnackbar
        },
        methods: {
            generateId() {
                let id = Math.floor((Math.random() * 100) + 1)

                while (this.messages.find(message => {
                    return message.id == id
                })) {
                    id = Math.floor((Math.random() * 100) + 1)
                }

                return id
            },
            close(id) {


                let index = this.messages.findIndex(message => {
                    return message.id == id
                })
                console.log('close ' + index)

                if (index > -1) {
                    this.messages.splice(index, 1);

                }
            }
        },
        created() {
            EventBus.$on('message', newMessage => {
                if (!newMessage.hasOwnProperty('type')){
                    console.log('type invullen')
                    newMessage['type'] = 'success'
                }

                this.messages.push({
                    component: newMessage.component,
                    message: newMessage.message,
                    id: this.generateId(),
                    type:newMessage.type

                })
            })

            EventBus.$on('clearmessages',()=>{
                this.messages.splice(0, this.messages.length)
            })
        }
    }
</script>

<style scoped>
    .list-container {
        z-index: 1000;
        position: fixed;
        bottom: 0px;
        width:100%;
    }
</style>
