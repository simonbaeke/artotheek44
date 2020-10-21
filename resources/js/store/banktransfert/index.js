import BankTransfert from "../../store/orm/BankTransfert";
import Pay from "../../store/orm/Pay";

export default {
    state: {},
    mutations: {
        create(state,payload){
            BankTransfert.insertOrUpdate(payload)
        }
    },
    getters: {
        getLoading: state => {
            return state.loading
        }
    },
    actions: {
        fetch({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.get('/api/banktransferts')
                    .then(response => {
                        BankTransfert.insertOrUpdate({data: response.data.data})

                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        store({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/banktransferts', payload)
                    .then(response => {

                            Pay.insertOrUpdate({data: response.data.data})
                            //BankTransfert.insertOrUpdate({data: response.data.data.payment})

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
                axios.delete('/api/banktransferts/' + payload.id)
                    .then(response => {
                            BankTransfert.delete(payload.id)
                            resolve(response)

                        }
                    ).catch(error => {
                    reject(error)
                })
            })

        }
    }
}
