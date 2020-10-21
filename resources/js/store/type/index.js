import Type from '../orm/Type'

export default {

    mutations: {
        setTypes(state, payload) {
            state.types = payload;
        },

        setType(state, payload) {
            state.types.push(payload)
        }
    },

    getters: {
        getTypes(state) {
            return Type.query().all();
        }
    },

    actions: {
        fetchTypes({commit}, payload) {
            axios.get('/api/types')
                .then((response) => {
                    Type.insertOrUpdate({data: response.data.data})
                })
                .catch(error => {
                    console.log(error)
                })
        },

        createType({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/types', payload)
                    .then(response => {
                        Type.insertOrUpdate({data: response.data.data})
                        resolve(response)
                    })
                    .catch(error => {
                        reject(JSON.parse(error.request.response).errors)

                    })
            })
        },
        updateType({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.put('/api/types/' + payload.id, payload).then(response => {
                    Type.insertOrUpdate({data: response.data.data})
                    resolve(response)
                }).catch(error => {
                    console.log(error)
                    reject(error)
                })
            })
        }
    }

}
