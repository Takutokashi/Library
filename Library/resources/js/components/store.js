import { createStore} from "vuex";
import {Axios} from "axios";




const store = createStore({
    state() {
        return {
            genre: '',
            author:'',
            statusAuth: false,
            idUser: null,

        }
    },
    getters: {                                                     //let name = this.$store.getters.STATUS_AUTH; получить значение
        GENRE: state => {
            return state.genre;
        },
        AUTHOR: state => {
            return state.author;
        },
        STATUS_AUTH: state => {
            return state.statusAuth;
        },
        ID_USER: state => {
            return state.idUser;
        },

    },
    mutations: {                                                  //this.$store.commit('SET_GENRE', statusAuth);  записать в хранилище
        SET_GENRE: (state, genre) => {
            state.genre = genre
        },
        SET_AUTHOR: (state, author) => {
            state.author = author
        },
        SET_STATUS_AUTH: (state, statusAuth) => {
            state.statusAuth = statusAuth
        },
        SET_ID_USER: (state, idUser) => {
            state.idUser = idUser
        },

    },
})

export default store
