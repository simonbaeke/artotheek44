import RoleUser from '../orm/RoleUser'

export default {

    actions: {
        assign({commit}, payload) {

            console.log('assign')

            return new Promise((resolve, reject) => {
                axios.post('/api/roles/assign/' + payload.user_id, {
                    role: payload.role
                })
                    .then(data => {


                        //REMOVE roles for user


                        RoleUser.delete(roleUser => {
                            return roleUser.user_id == payload.user_id
                        })


                        //asign roles

                        data.data.data.roles.forEach(role => {
                            RoleUser.insertOrUpdate({data: {role_id: role.id, user_id: data.data.data.id}})
                        })


                        resolve(data)

                    })
                    .catch(error => {
                        console.log(error)


                        reject(error)
                    })
            })

        },

        remove({commit}, payload) {


            return new Promise((resolve, reject) => {


                axios.post('/api/roles/remove/' + payload.user_id, {
                    role: payload.role
                })
                    .then(data => {
                        //REMOVE roles for user


                        RoleUser.delete(roleUser => {
                            return roleUser.user_id == payload.user_id
                        })


                        //asign roles

                        data.data.data.roles.forEach(role => {
                            RoleUser.insertOrUpdate({data: {role_id: role.id, user_id: data.data.data.id}})
                        })


                        resolve(data)

                    }).catch((error) => {


                    reject(error)
                })


            })

        }
    }
}
