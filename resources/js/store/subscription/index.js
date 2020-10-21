import Subscription from '../orm/Subscription'
import Rent from '../orm/Rent'

// or write a mnutation that only updates the values of the object instead of replacing the whole object:
//
//     UPDATE_DATA (state, payload) {
//     Object.key(payload).forEach(key => {
//         state.person[key] = payload[key]
//     })
// }

export default {
    state: {},

    getters: {
        getSubscriptions() {
            return Subscription.query().where('active', 1).all()
        },
        getSubscriptionsByUserId:
            (state) => (id) => {
                console.log(id)
                return Subscription.query().where('user_id', id.toString()).with('reservations').with('reservations.artwork').with('rents').with('rents.artwork').get()
            },

        getMappedSubscriptionsByUserId:
            (state) => (id) => {
                return Subscription.query().where('user_id', id.toString()).with('reservations').with('reservations.artwork').with('rents').with('rents.artwork').get().map(subscription => {
                    return {
                        id: subscription.id,
                        trial: subscription.trial,
                        expires: subscription.expires,
                        active: subscription.active,
                        confirmed: subscription.confirmed,
                        reservations: subscription.reservations,
                        rents: subscription.rents,
                        user_id: subscription.user_id,
                        activeRent: subscription.rents.find(rent => {
                            return rent.returned == 0
                        }),
                        activeReservation: subscription.reservations.find(reservation => {
                            return reservation.active == 1
                        }),
                        available: !subscription.rents.find(rent => {
                            return rent.returned == 0
                        }) && !subscription.reservations.find(reservation => {
                            return reservation.active == 1
                        })
                    }
                })
            },

        getSubscriptionBySubscriptionId:
            (state) => (id) => {
                return Subscription.find(subscription => subscription.id === id)
            },
    }
    ,


    actions: {

        fetch({commit}, payload) {
            return new Promise((resolve,reject)=>{
                window.axios.get('/api/subscriptions', {
                    params:
                        payload

                })
                    .then(response => {
                        Subscription.insertOrUpdate({data: response.data.data})

                        resolve(response)

                    })
                    .catch(error => {
                        console.log(error)
                        reject(error)
                    })
            })

        },
        filter({commit}, payload) {
            window.axios.get('/api/subscriptions', {
                params:
                payload

            })
                .then(response => {
                    Subscription.insertOrUpdate({data: response.data.data})

                })
                .catch(error => {

                    console.log(error)
                })
        },
        fetchSubscriptionById({commit}, payload) {
            return new Promise((resolve, reject) => {
                window.axios.get('/api/subscriptions/' + payload)
                    .then(response => {
                        Subscription.insertOrUpdate({data: response.data.data})
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        }
        ,

        fetchSubscriptionsByUserId({commit}, payload) {

            return new Promise((resolve, reject) => {
                axios.get('/api/subscriptions/' + payload)
                    .then(data => {
                        Subscription.insertOrUpdate({data: data.data.data})

                        resolve(data)
                    })
                    .catch(error => {

                        reject(error)
                    })
            });
        }
        ,

        createSubscription({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/subscriptions', payload)
                    .then(response => {
                        Subscription.insertOrUpdate({data: response.data.data})
                        resolve(response);
                    })
                    .catch(error => {
                        console.log(error);
                        reject(error)
                    })
            })
        },

        updateSubscription({commit}, payload) {
            return new Promise((resolve, reject) => {
                    axios.post('/api/orders', payload)
                        .then(response => {

                            Subscription.insertOrUpdate({data: response.data.data})
                            resolve(response)
                        })
                        .catch(error => {
                            reject(error)
                        })
                }
            )
        },
        update({commit}, payload) {
            return new Promise((resolve, reject) => {
                    axios.post('/api/subscriptions/'+payload.id, payload.params)
                        .then(response => {

                            Subscription.insertOrUpdate({data: response.data.data})
                            resolve(response)
                        })
                        .catch(error => {
                            reject(error)
                        })
                }
            )
        },
        destroy({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.delete('/api/subscriptions/' + payload.id)
                    .then(response => {
                            //delete subscription
                            Subscription.delete(payload.id)
                        resolve(response)

                        }
                    ).catch(error=>{
                        reject(error)
                })
            })

        }

    }
}
