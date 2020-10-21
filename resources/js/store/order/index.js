import Order from "../../store/orm/Order";
import Invoice from "../../store/orm/Invoice";


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
                axios.get('/api/orders', {
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

        destroy({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.delete('/api/orders/' + payload.id)
                    .then(response => {

                            let order = Order.find(payload.id)
                            let store = Order.store()

                            //delete all orders in invoice

                            //delete payments when invoice deleted

                            store.dispatch('entities/delete', {
                                entity: order.orderable_type.toLowerCase() + 's',
                                where: order.orderable_id
                            })

                            store.dispatch('entities/delete', {
                                entity: 'invoices',
                                where: order.invoice_id
                            })

                            Order.delete((record) => {
                                    return record.invoice_id == order.invoice_id
                                }
                            )

                            if (response.data.data.hasOwnProperty('id')) {
                                Invoice.insertOrUpdate({data: response.data.data})

                            }


                            resolve(response)

                        }
                    )
            })

        }
    }
}
