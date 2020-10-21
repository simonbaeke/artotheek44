import Voucher from "../../store/orm/Voucher";


export default {
    state: {},
    mutations: {},
    getters: {

    },
    actions: {
        fetch({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.get('/api/vouchers')
                    .then(response => {
                        Voucher.insertOrUpdate({data: response.data.data})

                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        show({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.get('/api/vouchers/' + payload.id)
                    .then(response => {
                        Voucher.insertOrUpdate({data: response.data.data})
                        resolve(response)
                    }).catch(error => {
                    console.log(error)
                    reject(error)
                })
            })
        },

        store({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/vouchers', payload)
                    .then(response => {

                            Voucher.insertOrUpdate({data: response.data.data})

                            resolve(response)
                        }
                    ).catch(error => {
                    reject(error)
                })
            })

        }
    }
}
