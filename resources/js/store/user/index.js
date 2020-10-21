import User from '../orm/User'
import RoleUser from '../orm/RoleUser'
import Preferences from '../orm/Preferences'

export default {

    state: {
        loggedInUserId: -1,
        loading: false,
    },

    mutations: {
        setLoggedInUserId(state, payload) {
            state.loggedInUserId = payload;
        },

        setUserLoading(state, payload) {
            state.loading = payload
        }
    },

    actions: {

        delete({commit}, id) {
            let user = User.query().where('id', id).with('role').get()

            User.delete(user)

            let roles = RoleUser.query()
                .where('user_id', id).get()

            RoleUser.delete(roles)


        },

        fetch({commit}, payload) {
            commit('setUserLoading', true)

            return new Promise((resolve, reject) => {
                axios.get('/api/users', {
                    params: payload
                })
                    .then(data => {

                        User.insertOrUpdate({data: data.data.data})

                        data.data.data.forEach(user => {


                            RoleUser.delete(roleUser => {
                                return roleUser.user_id == user.id
                            })


                            if (user.roles != undefined) {
                                user.roles.forEach(role => {
                                    RoleUser.insertOrUpdate({data: {role_id: role.id, user_id: user.id}})
                                })
                            }


                        })
                        commit('setUserLoading', false)

                        resolve(data)

                    })
                    .catch(error => {
                        console.log(error)
                        commit('setUserLoading', false)

                        reject(error)
                    })
            })

        },
        fetchUser({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.get('/api/users/' + payload)
                    .then(data => {
                        User.insertOrUpdate({data: data.data.data})
                        resolve(data)

                    })
                    .catch(error => {
                        console.log(error)
                        reject(error)
                    })
            })
        },

        loggedInUser({commit}, payload) {

            if (payload.id > -1) {
                User.insertOrUpdate({data: payload})

                payload.roles.forEach(role => {
                    RoleUser.insertOrUpdate({data: {role_id: role.id, user_id: payload.id,}})
                })
            }


            commit('setLoggedInUserId', payload.id)

        },

        register({commit}, payload) {

            return new Promise((resolve, reject) => {
                axios.post('/api/register', payload)
                    .then(data => {
                        User.insertOrUpdate({data: data.user})
                        axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.token;
                        localStorage.setItem("token", data.token);
                        resolve(data)
                    })
                    .catch(error => {
                        reject(JSON.parse(error.request.response).errors)
                    })
            });
        },
        create({commit}, payload) {

            return new Promise((resolve, reject) => {
                axios.post('/api/users', payload)
                    .then(data => {
                        User.insertOrUpdate({data: data.data.data})
                        resolve(data)
                    })
                    .catch(error => {
                        reject(JSON.parse(error.request.response).errors)
                    })
            });
        }
        ,
        updateUser({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/users/' + payload.id, payload)
                    .then(data => {
                        User.insertOrUpdate({data: data.data.data})
                        resolve(data)
                    })
                    .catch(error => {
                        console.log(error)
                        reject(JSON.parse(error.request.response).errors)
                    })
            })
        },

        logout({commit}) {
            localStorage.removeItem("token");
            delete axios.defaults.headers.common["Authorization"];
            commit('setLoggedInUserId', -1)


            //remove data
            User.deleteAll()
        },

        setPreference({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/preferences', payload).then(data => {
                    Preferences.insertOrUpdate({data: data.data})
                    resolve(data)
                }).catch(error => {
                    reject(JSON.parse(error.request.response).errors)

                })
            })
        }

    }
    ,
    getters: {

        isLoggedIn(state) {
            return state.loggedInUserId > 0;
        },

        loggedInUser(state) {
            let user = User.query().where('id', state.loggedInUserId).with('roles').with('preferences').first()

            if (user) {
                return user
            }

            return {firstname: 'gast', id: -1, roles: []}
        },
        userHasRole: (state) => (roleToHave) => {
            let user = User.query().where('id', state.loggedInUserId).with('roles').first()

            if (user) {
                return user.roles.findIndex(role => {
                    return role.name == roleToHave
                }) > -1
            }

            return false
        },
        level(state) {

            let user = User.query().where('id', state.loggedInUserId).with('roles').first()

            if (user.roles.findIndex(role => {
                return role.name == 'superadmin'
            }) > -1) {
                return (3)
            }

            //admin
            if (user.roles.findIndex(role => {
                return role.name == 'admin'
            }) > -1) {
                return (2)
            }
            //vrijwilliger

            if (user.roles.findIndex(role => {
                return role.name == 'vrijwilliger'
            }) > -1) {
                return (1)
            }

            if (user.roles.findIndex(role => {
                return role.name == 'ontlener'
            }) > -1) {
                return (0)
            }

            return null

        }
        ,
        loggedInUserId(state) {
            return state.loggedInUserId
        },

        users(state) {
            return User.query().all()
        },
        user: (state) => (id) => {
            console.log(id)
            return User.query().find(id)
        }


    }


}
