export default {
    root:true,
    state: {
        loading: false,
        message: null,
        messageType: 'error'
    },
    mutations: {
        setLoading(state, payload) {
            state.loading = payload
        },
        setError(state, payload) {
            state.message = payload
            state.messageType = 'error'
        },
        clearMessage(state) {
            state.message = null
        },

        setSuccess(state, payload) {
            state.message = payload;
            state.messageType = 'success'
        }
    },
    actions: {
        clearMessage({commit}) {
            commit('clearMessage')
        }
    },
    getters: {

        message(state) {
            return state.message
        },

        messageType(state) {
            return state.messageType
        }
    }
}
