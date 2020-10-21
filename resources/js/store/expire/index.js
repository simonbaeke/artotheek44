import Order from "../../store/orm/Order";
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
                axios.get('/api/expires', {
                    params: payload
                })
                    .then(response => {
                        Order.insertOrUpdate({data: response.data.data})
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        update({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/expires/'+payload.id, payload.params)
                    .then(response => {
                        Expire.insertOrUpdate({data: response.data.data})
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        create({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/expires', payload)
                    .then(response => {
                        Expire.delete((expire) => {
                            return expire.expirable_type === payload.expirable_type && expire.expirable_id === payload.expirable_id
                        })
                        Expire.insertOrUpdate({data: response.data.data})
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        destroy({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.delete('/api/expires/' + payload.id)
                    .then(response => {
                            Expire.delete(payload.id)
                            Expire.insertOrUpdate({data: response.data.data})
                            resolve(response)

                        }
                    )
            })

        }
    }
}
