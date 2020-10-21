import Invoice from '../orm/Invoice'


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
                axios.get('/api/invoices', {
                    params: payload
                })
                    .then(response => {
                        commit('setLoading', false)

                        Invoice.insertOrUpdate({data: response.data.data})

                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        }, fetchById({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.get('/api/invoices', {
                    params: {
                        user: payload.id
                    }
                })
                    .then(response => {

                        Invoice.insertOrUpdate({data: response.data.data})

                        resolve(response)
                    })
                    .catch(error => {

                        reject(error)
                    })
            })
        },
        show({commit},payload){
            return new Promise((resolve, reject) => {
                axios.get('/api/invoices/'+payload.id)
                    .then(response => {

                        Invoice.insertOrUpdate({data: response.data.data})

                        resolve(response)
                    })
                    .catch(error => {

                        reject(error)
                    })
            })
        }
        ,

        create({commit}, payload) {
            commit('setLoading', true)
            return new Promise((resolve, reject) => {
                axios.post('/api/invoices', payload)
                    .then(response => {
                            commit('setLoading', false)

                            Invoice.insertOrUpdate({data: response.data.data})

                            resolve(response)
                        }
                    )
            })

        }
    }
}
