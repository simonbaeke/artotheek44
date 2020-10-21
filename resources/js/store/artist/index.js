import Artist from '../orm/Artist'
import Reservation from "../orm/Reservation";

export default {
    state: {
        artists: []
    },

    mutations: {
        setArtists(state, payload) {
            state.artists = payload
        },

        setArtist(state, payload) {
            state.artists.push(payload)
        }
    },

    getters: {
        getAll(state) {
            return Artist.query().all();
        },
        getArtist: (state) => (id) => {
            return Artist.query().find(id)
        }
    },

    actions: {
        fetchArtists({commit}, payload) {
            axios.get('/api/artists')
                .then(response => {
                    Artist.insertOrUpdate({data: response.data.data})
                })
                .catch(error => {
                    console.log(error)
                })
        },
        fetch({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.get('/api/artists', {
                    params: payload
                })
                    .then(response => {
                        Artist.insertOrUpdate({data: response.data.data})

                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        fetchArtist({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.get('/api/artists/' + payload)
                    .then(response => {
                        Artist.insertOrUpdate({data: response.data.data})

                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },


        createArtist({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/artists', payload)
                    .then(response => {
                        Artist.insertOrUpdate({data:response.data.data})
                        resolve(response)
                    })
                    .catch(error => {
                        reject(JSON.parse(error.request.response).errors)
                    })
            })
        },
        editArtist({commit},payload){
            return new Promise((resolve,reject)=>{
                axios.put('/api/artists/' + payload.id,payload.artist)
                    .then(response =>{
                        Artist.insertOrUpdate({data:response.data.data})
                        resolve(response)
                    })
                    .catch(error=>{
                        console.log(error)
                        reject(error)
                    })
            })
        }


    }


}
