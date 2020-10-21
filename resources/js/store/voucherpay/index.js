import VoucherPay from "../../store/orm/VoucherPay";
import Pay from "../../store/orm/Pay";

export default {
    state: {},
    mutations: {},
    getters: {
    },
    actions: {
        fetch({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.get('/api/voucherpays')
                    .then(response => {
                        VoucherPay.insertOrUpdate({data: response.data.data})

                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        show({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.get('/api/voucherpays/' + payload.id)
                    .then(response => {
                        VoucherPay.insertOrUpdate({data: response.data.data})
                        Pay.insertOrUpdate({data:response.data.data.pay})

                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        store({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/voucherpays', payload)
                    .then(response => {

                            Pay.insertOrUpdate({data: response.data.data})
                            VoucherPay.insertOrUpdate({data: response.data.data.payable})

                            resolve(response)
                        }
                    ).catch(error => {
                    reject(error)
                })
            })

        },

        destroy({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.delete('/api/voucherpays/' + payload.id)
                    .then(response => {
                            VoucherPay.delete(payload.id)
                            resolve(response)

                        }
                    ).catch(error => {
                    reject(error)
                })
            })

        }
    }
}
