import Rent from '../orm/Rent'
import Subscription from "../../store/orm/Subscription";
import Artwork from '../orm/Artwork'

export default {

    getters: {
        getRents: (state) => {
            return Rent.query().with('artwork').with('user').all()
        },
        getRentsByArtworkId: (state) => (id) => {
            return Rent.query().where('artwork_id', id).with('subscription.*').get()
        }
    }
    ,

    actions: {
        fetch({commit}, payload) {
            return new Promise((resolve, reject) => {
                window.axios.get('/api/rents', {
                    params:
                    payload

                })
                    .then(response => {

                        response.data.data.forEach(newRent => {


                            Rent.insertOrUpdate({
                                data: [
                                    {
                                        id: newRent.id,
                                        artwork_id: newRent.artwork_id,
                                        expires_at: newRent.expires_at,
                                        returned: newRent.returned,
                                        started_at: newRent.started_at,
                                        returned_at: newRent.returned_at,
                                        subscription_id: newRent.subscription_id
                                    }

                                ]
                            })

                            Artwork.insertOrUpdate({
                                data: newRent.artwork
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
        fetchRent({commit}, payload) {

            return new Promise((resolve, reject) => {
                window.axios.get('/api/rents/' + payload)
                    .then(response => {

                        Rent.insertOrUpdate({data: response.data.data})
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },


        fetchAll({commit}, payload) {
            return new Promise((resolve, reject) => {
                window.axios.get('/api/rents', {
                    params: payload
                }).then(response => {
                    Rent.insertOrUpdate({data: response.data.data})
                    resolve(response)
                }).catch(error => {
                    reject(error)
                })
            })
        },

        createRent({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/rents', payload)
                    .then(response => {
                        //set subscription unavailable
                        Rent.insertOrUpdate({data: response.data.data})
                        //update subscription ==> set unavailable
                        Subscription.update({where: payload.subscription_id}, {
                            data: {available: false}
                        })

                        resolve(response)
                    }).catch(error => {
                    reject(error)
                })
            })
        },
        destroy({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.delete('/api/rents/' + payload.id)
                    .then(response => {
                            //delete subscription
                            Rent.delete(payload.id)

                        }
                    )
            })

        },
        stopRent({commit}, payload) {
            payload._method = "PUT"
            return new Promise((resolve, reject) => {
                axios.post('/api/rents/stop/' + payload.id, payload)

                    .then(response => {

                        Rent.insertOrUpdate({data: response.data.data})
                        resolve(response)
                    }).catch(error => {
                    reject(error)
                })
            })
        },
        renewRent() {

        }
        ,

        updateRent({commit}, payload) {
            payload._method = "PUT"
            return new Promise((resolve, reject) => {
                axios.post('/api/rents/' + payload.id, payload)

                    .then(response => {

                        Rent.insertOrUpdate({data: response.data.data})
                        resolve(response)
                    }).catch(error => {
                    reject(error.request)
                })
            })
        },

        updateExpire({commit}, payload) {
            console.log(payload)
            Rent.insertOrUpdate({
                data: [
                    {
                        id: payload.id,
                        expires_at: payload.expires_at
                    }
                ]
            })
        }
    }
}
