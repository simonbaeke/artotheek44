 <template>
<app-content>
    <template slot="toolbar" v-if="volunteer!=null">{{volunteer.firstname}} {{volunteer.lastname}}</template>
    <template slot="text" v-if="volunteer!=null">
       <!-- <volunteer-detail
                :user="volunteer"
                :address="volunteer.address"
                :loading="loading"
        />-->
    </template></app-content>
</template>

<script>
    import User from '../../../store/orm/User'
    import appContent from '../basis/content'
   // import volunteerDetail from '../user/Userinfo'
    export default {
        name: "VolunteerDetail",
        data(){
            return{
                loading:false
            }
        },
        computed:{
            volunteer(){
                return User.query().with('roles').with('address').find(this.$route.params.id)
            }
        },
        components:{
            appContent,
            //volunteerDetail
        },
        mounted(){
            User.dispatch('fetchUser',this.$route.params.id)
        }
    }
</script>

<style scoped>

</style>
