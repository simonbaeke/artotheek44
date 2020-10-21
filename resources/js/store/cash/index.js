import Pay from "../../store/orm/Pay";
import Cash from '../../store/orm/Cash'

export default {
    state: {},
    mutations: {},
    getters: {
        getLoading: state => {
            return state.loading
        }
    },
    actions: {
        fetch({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.get('/api/cashs')
                    .then(response => {
                        Pay.insertOrUpdate({data: response.data.data})

                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        show({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.get('api/cashs/'+payload).then(response => {
                    Cash.insertOrUpdate({data: response.data.data})
                    resolve(response)
                }).catch(error => {
                    reject(error)
                })

            })
        },

        store({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/cashs', payload)
                    .then(response => {

                            Pay.insertOrUpdate({data: response.data.data})

                            resolve(response)
                        }
                    ).catch(error => {
                    reject(error)
                })
            })

        }
    }
}
