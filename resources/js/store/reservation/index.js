import Reservation from '../orm/Reservation'
import Rent from "../orm/Rent";
import Artwork from "../orm/Artwork";
import User from "../orm/User";
import Subscription from "../orm/Subscription";
import Expire from "../orm/Expire";


export default {

    getters: {
        getActiveReservations: (state) => (subscription_id) => {
            return Reservation.query().where('subscription_id', subscription_id).where('active', 1).with('artwork').all()
        },
        getAllReservations:(state) => {
            return Reservation.query().with('artwork').with('user').with('subscription').all()
        },
        getReservationsByArtworkId:(state) => (id) =>  {
            return Reservation.query().where('artwork_id',id).with('user').get()
        }
    },


    actions: {
        makeReservation({commit}, payload) {
            return new Promise((resolve, reject) => {
                window.axios.post('/api/reservations', {
                    artwork_id: payload
                })
                    .then(response => {
                        Reservation.insertOrUpdate({data: response.data.data})
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        stopReservation({commit}, payload) {
            return new Promise((resolve, reject) => {
                window.axios.put('/api/reservations/' + payload.id, {
                    'active': false,
                    'expires': payload.expires
                }).then((response) => {
                    Reservation.insertOrUpdate({data: response.data.data})
                    resolve(response)
                }).catch(error => {
                    console.log(error)
                    reject(error)

                })
            })
        },
        fetchAll({commit},payload){
            return new Promise((resolve,reject)=>{
                window.axios.get('/api/reservations',{
                    params:payload
                }).then(response=>{
                    Reservation.insertOrUpdate({data:response.data.data})
                    resolve(response)
                }).catch(error=>{
                    reject(error)
                })
            })
        },
        fetch({commit}, payload) {
            return new Promise((resolve, reject) => {
                window.axios.get('/api/reservations', {
                    params:
                    payload

                })
                    .then(response => {

                        response.data.data.forEach(newReservation => {


                            Reservation.insertOrUpdate({
                                data: [
                                    {
/*
                                        id: this.attr(null),
                                        user_id: this.attr(''),
                                        active:this.boolean(false),
                                        expired:this.boolean(false),
                                        subscription_id:this.attr(''),
                                        artwork_id:this.attr(''),
                                        user: this.belongsTo(User, 'user_id'),
                                        subscription: this.belongsTo(Subscription, 'subscription_id'),
                                        artwork:this.belongsTo(Artwork,'artwork_id'),
                                        expires_at:this.attr(''),
                                        expire: this.morphOne(Expire, 'expirable_id', 'expirable_type')*/

                                        id: newReservation.id,
                                        artwork_id: newReservation.artwork_id,
                                        expires_at: newReservation.expires_at,
                                        active:newReservation.active,


                                        subscription_id: newReservation.subscription_id
                                    }

                                ]
                            })

                            Artwork.insertOrUpdate({
                                data: newReservation.artwork
                            })
                        })


                        resolve(response)
                    })
                    .catch(error => {
                        console.log(error)
                        reject(error)
                    })
            })

        },

    }

}
