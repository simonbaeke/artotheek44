import Vue from 'vue'
import Router from 'vue-router'

import UserList from '../components/Admin/user/UserList.vue'
import UserDetail from '../components/Admin/user/UserDetail.vue'
import UserCreate from '../components/Admin/user/UserCreate.vue'
import appUser from '../components/Admin/user/User.vue'
import userProfile from '../components/User/user/UserProfile.vue'
import ArtworkList from '../components/Admin/artwork/ArtworkList.vue'
import ReservationList from '../components/Admin/reservation/ReservationList.vue'
import RentList from '../components/Admin/rent/RentList.vue'
import landingNavigation from '../components/Landing/LandingNavigation.vue'
import userNavigation from '../components/User/Navigation.vue'
import landingContent from '../components/Landing/LandingContent.vue'
import catalogus from '../components/User/Catalogus.vue'
import adminNavigation from '../components/Admin/Header.vue'
import adminDashboard from '../components/Admin/DashBoard.vue'
import artworkCreate from '../components/Admin/artwork/ArtworkCreate.vue'
import appArtworkDetail from '../components/Admin/artwork/ArtworkDetail.vue'

import userArtist from '../components/User/Artist/Artist.vue'
import userArtistList from '../components/User/Artist/ArtistList.vue'
import userArtistDetail from '../components/User/Artist/ArtistDetail.vue'
import appArtwork from '../components/Admin/artwork/Artwork.vue'
import userVerify from '../components/User/Verify/UserVerify.vue'
import requestResetPassword from '../components/Password/RequestResetComponent.vue'
import resetPassword from '../components/Password/resetPassword.vue'
import voucherList from '../components/Admin/voucher/VoucherList'
import paymentList from '../components/Admin/payments/PaymentList'

import artworkSearch from '../components/User/ArtworkSearch'
import artistSearch from '../components/User/ArtistSearch'

import UserEdit from '../components/Admin/user/UserEdit'

import mailchimpDashboard from '../components/Admin/mailchimp/MailchimpDashboard'

import landingFooter from '../components/Landing/LandingFooter'
//admin artist
import appArtist from '../components/Admin/artist/Artist'
import artistList from '../components/Admin/artist/ArtistList'
import artistDetail from '../components/Admin/artist/ArtistDetail'
import artistCreate from '../components/Admin/artist/ArtistCreate'
import artistEdit from '../components/Admin/artist/ArtistEdit'

import appVolunteer from '../components/Admin/volunteers/Volunteer'
import volunteerList from '../components/Admin/volunteers/VolunteerList'
import volunteerDetail from '../components/Admin/volunteers/VolunteerDetail'
import volunteerCreate from '../components/Admin/volunteers/VolunteerCreate'

import appSubscription from '../components/Admin/subscription/Subscription'
import subscriptionList from '../components/Admin/subscription/SubscriptionList'
import subscriptionCreate from '../components/Admin/subscription/SubscriptionCreate'
import subscriptionDetail from '../components/Admin/subscription/SubscriptionDetail'

import appDiscipline from '../components/Admin/discipline/Discipline'
import disciplineList from '../components/Admin/discipline/DisciplineList'
import disciplineCreate from '../components/Admin/discipline/DisciplineCreate'

import orderList from '../components/Admin/orders/OrderList'

import editLanding from '../components/Admin/editLanding'

Vue.use(Router)

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            components: {
                nav: landingNavigation,
                content: landingContent,
                footer: landingFooter
            },
            name: 'landing'
        },
        {
            path: '/catalogus',
            components: {
                nav: userNavigation,
                content: catalogus,
                search: artworkSearch,
                footer: landingFooter

            },
            name: 'catalogus'
        },
        {
            path: '/password/reset',
            components: {
                nav: userNavigation,
                content: requestResetPassword
            },
            name: 'resetpassword',

        },
        {
            path: '/password/reset/:token',
            components: {
                nav: userNavigation,
                content: resetPassword
            },
        }

        ,
        {
            path: '/artiesten',
            components: {
                nav: userNavigation,
                content: userArtist,
                search: artistSearch,
                footer: landingFooter

            },
            children: [
                {path: '', component: userArtistList, name: 'userArtistList'},
                {path: ':id', component: userArtistDetail, name: 'userArtistDetail'},
            ],
        },


        ,
        {
            path: '/profile',
            components: {
                nav: userNavigation,
                content: userProfile
            },
            name: 'profile'
        },
        {
            path: '/verify',
            components: {
                nav: userNavigation,
                content: userVerify
            },
            name: 'verify'
        },
        {
            path: '/admin',
            components: {
                nav: adminNavigation,
                content: adminDashboard,

            },
            name: 'admin',
            meta: {
                requiresAdmin: true
            },
            children: [
                {
                    path: ('gebruiker'),
                    components: {
                        default: appUser,
                    },
                    children: [
                        {path: '', component: UserList, name: 'userlist'},
                        {path: ':id', component: UserDetail, name: 'userdetail'},
                        {path: 'wijzig/:id', component: UserEdit, name: 'useredit'},
                        {path: 'maken', name: 'usercreate', component: UserCreate},
                    ],
                },
                {
                    path: ('kunstwerk'),
                    components: {
                        default: appArtwork
                    },
                    children: [
                        {path: '', component: ArtworkList, name: 'artworklist'},
                        {path: ':id', component: appArtworkDetail, name: 'artworkdetail'},
                        {path: 'maken', component: artworkCreate, name: 'artworkcreate'},
                    ]
                },
                {
                    path: ('reservering'),
                    component: ReservationList,
                    name: 'reservationlist'
                },
                {
                    path: ('ontlening'),
                    component: RentList,
                    name: 'rentlist'
                },
                {
                    path: ('artiest'),
                    components: {
                        default: appArtist,
                    },
                    children: [
                        {path: '', component: artistList, name: 'artistlist'},
                        {path: ':id', component: artistDetail, name: 'artistdetail'},
                        {path: 'maken', name: 'artistcreate', component: artistCreate},
                        {path: 'wijzigen/:id', name: 'artistedit', component: artistEdit},
                    ],
                },
                {
                    path: ('cadeaubon'),
                    component: voucherList,
                    name: 'vouchers'
                },
                {
                    path: ('betaling'),
                    component: paymentList,
                    name: 'payments'
                },
                {
                    path: ('order'),
                    component: orderList,
                    name: 'orders'
                },
                {
                    path: ('vrijwilliger'),
                    components: {
                        default: appVolunteer,
                    },
                    children: [
                        {path: '', component: volunteerList, name: 'volunteerlist'},
                        {path: ':id', component: volunteerDetail, name: 'volunteerdetail'},
                        {path: 'maken', component: volunteerCreate, name: 'volunteercreate'},

                    ],
                },
                {
                    path: ('lidkaarten'),
                    components: {
                        default: appSubscription,
                    },
                    children: [
                        {path: '', component: subscriptionList, name: 'subscriptionlist'},
                        {path: 'maken', component: subscriptionCreate, name: 'subscriptioncreate'},
                        {path: ':id', component: subscriptionDetail, name: 'subscriptiondetail'},


                    ],
                },
                {
                    path: ('disciplines'),
                    components: {
                        default: appDiscipline,
                    },
                    children: [
                        {path: '', component: disciplineList, name: 'disciplinelist'},
                        {path: 'create', component: disciplineCreate, name: 'disciplinecreate'},

                    ],
                },
                {
                    path: ('mailchimp/dashboard'),
                    component: mailchimpDashboard,
                    name:'mailchimp'

                },
                {
                    path:'edithomepage',
                    component: editLanding,
                    name:'edithomepage'
                }

            ]
        }
    ]

})
