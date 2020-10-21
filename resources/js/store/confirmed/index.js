import Order from "../../store/orm/Order";
import Confirmed from "../../store/orm/Confirmed";
import Subscription from "../../store/orm/Subscription";
import Expire from "../../store/orm/Expire";

export default {
    state: {
        loading: false
    },
    mutations: {
        setLoading(state, loading) {
            state.loading = loading
        }
    },

    actions: {
        fetch({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.get('/api/confirmds', {
                    params: payload
                })
                    .then(response => {
                        Confirmed.insertOrUpdate({data: response.data.data})
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        show({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.get('/api/confirmds/' + payload.id)
                    .then(response => {
                        Confirmed.insertOrUpdate({data: response.data.data})
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })

        },
        create({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/confirmds', payload)
                    .then(response => {

                        Confirmed.insertOrUpdate({data: response.data.data})
                        Order.insertOrUpdate({data: response.data.data.order})
                        Expire.delete({
                            where(expire) {
                                return expire.expirable_type === 'Subscription' && expire.expirable_id === payload.subscription_id
                            }
                        })
                        Subscription.insertOrUpdate({data: response.data.data.subscription})


                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        destroy({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.delete('/api/confirmds/' + payload.id)
                    .then(response => {
                            let confirmed = Confirmed.find(payload.id)

                            Expire.delete({
                                where(expire) {
                                    return expire.expirable_type === 'Subscription' && expire.expirable_id === confirmed.subscription_id
                                }
                            })

                            Subscription.insertOrUpdate({data: response.data.data})
                            Confirmed.delete(payload.id)

                            resolve(response)

                        }
                    )
            })

        }
    }
}
