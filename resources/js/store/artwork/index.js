import Artwork from '../orm/Artwork'

export default {

    getters: {
        artworks(state) {
            return Artwork.query().with('artist').with('type').all();
        },

        availableArtworks(state) {
            return Artwork.query().where('available', true).all()
        },

        getArtworksByArtistId: (state) => (id) => {
            return Artwork.query().where('artist_id', id).all()
        },

        getArtworkByArtworkId: (state) => (id) => {
            return Artwork.query().with('artist').with('reservations.*').with('rents.*').find(id)
        }
    },


    actions: {
        fetchArtworks({commit}, payload) {


            return new Promise((resolve, reject) => {

                window.axios
                    .get('/api/artworks', {
                        params: payload
                    })
                    .then(response => {
                        Artwork.insertOrUpdate({
                            data: response.data.data
                        })


                        resolve(response)
                    })
                    .catch(error => {


                        console.log(error.message)
                        reject(error)
                    });
            })
        },
        deleteArtwork({commit}, payload) {
            return new Promise((resolve, reject) => {
                window.axios.delete('/api/artworks/' + payload)
                    .then(response => {

                        resolve(response)
                    })
                    .catch(error => (
                        reject(error)
                    ))
            })
        },

        fetchArtwork({commit}, payload) {

            return new Promise((resolve, reject) => {
                window.axios.get('/api/artworks/' + payload)
                    .then(response => {

                        Artwork.insertOrUpdate({data: response.data.data})
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        updateArtwork({commit}, payload) {
            return new Promise((resolve, reject) => {
                window.axios.post('/api/artworks/' + payload.id, payload.data)
                    .then(response => {
                        Artwork.insertOrUpdate({data: response.data.data})
                        resolve(response)
                    }).catch(error => {
                    reject(error)
                })
            })


        },

        createArtwork({commit}, payload) {
            commit('setLoading', true);

            const config = {
                headers: {'content-type': 'multipart/form-data'}
            }

            //application/json
            return new Promise((resolve, reject) => {
                axios.post('/api/artworks', payload, config)
                    .then(response => {
                        commit('setLoading', false)
                        Artwork.insertOrUpdate({data: response.data.data})
                        resolve(response)
                    })
                    .catch(error => {
                        commit('setLoading', false)
                        reject(error.request)
                    })
            })

        },

        notify({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/artworkavailable/' + payload.artwork_id, payload)
                    .then(response => {
                        Artwork.insertOrUpdate({data: response.data.data})
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        fetchArtworkSold({commit,payload}){
            return new Promise((resolve,reject)=>{
                axios.get('/api/issold',payload)
                    .then(response =>{
                        Artwork.insertOrUpdate({data:response.data.data})
                        resolve(response)
                    })
                    .catch(error=>{
                        resolve(error)
                    })
            })
        }
    },




}
