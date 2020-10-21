
export default {
    state: {
        token: null,
        refreshToken: null,
    },

    mutations: {
        setToken(state, payload) {
            state.token = payload;
        },

        setRefreshToken(state, payload) {
            state.refreshToken = payload;
        }
    },

    actions: {
        getToken({commit}, payload) {
            var loginData = {
                email: payload.email,
                password: payload.password
            }

            return new Promise((resolve,reject)=>{

                axios.post('/api/login', loginData)
                //getuser
                    .then(
                        data => {
                            commit('setLoading', false)
                           // axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.data.success.access_token;
                            if(payload.remind){
                               // localStorage.setItem("token", data.data.success.access_token);

                            }
                            //commit('setToken', data.data.access_token)
                           // commit('setRefreshToken', data.data.refresh_token)
                            //commit('setLoggedInStatus',true)
                            resolve(data)
                        }
                    )
                    .catch(
                        error => {
                            commit('setLoading', false)
                           // commit('setError', JSON.parse(error.request.response).message)
                            reject(error)
                        }
                    )
            })


        }
    }

}
