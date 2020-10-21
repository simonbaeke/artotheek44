import Pay from "../../store/orm/Pay";
import Invoice from "../../store/orm/Invoice";


export default {
    state: {},
    mutations: {
        create(state,payload){
            Pay.insertOrUpdate(payload)
        }
    },
    getters: {

    },
    actions: {
        fetch({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.get('/api/pays')
                    .then(response => {
                        Pay.insertOrUpdate({data: response.data.data})

                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        store({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/pays', payload)
                    .then(response => {

                            Pay.insertOrUpdate({data: response.data.data})

                            resolve(response)
                        }
                    ).catch(error => {
                    console.log(error)
                    reject(error)
                })
            })

        },

        destroy({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.delete('/api/pays/' + payload.id)
                    .then(response => {
                            Pay.delete(payload.id)
                            Invoice.insertOrUpdate({data:response.data.data})
                            resolve(response)

                        }
                    ).catch(error => {
                    reject(error)
                })
            })

        }
    }
}
