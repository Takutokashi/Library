<template>
    <h2>Жанры</h2>
    <div v-for="category in categories" key="category">
        <ul>
            <router-link :to="{name: 'category' , params:{genre: category.genre}}"> <li style="text-decoration: none;" id="{{category.genre}}" @click="clickCategory(category.genre)">{{category.genre}}</li></router-link>
        </ul>
    </div>
</template>

<script>
import GenreComponent from "@/components/CategoryComponent.vue";

import axios from "axios";
import {onActivated} from "vue";

export default {
    components: {GenreComponent},
    data(){
        return{
            show:false,
            categories:'',
            genres:'',
            resultGenre:'',
        }

    },
    mounted() {
        this.getBooks()
    },


    methods: {
        getBooks() {
            axios.get('/api/categories')
                .then(res => {
                    this.categories = res.data
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        clickCategory(genre){
            this.$store.commit('SET_GENRE', genre);

        },
    },

}
</script>

<style scoped>
li {
    margin-left: 50px;
    font-size: 25px;
    cursor: pointer;
    transition: transform 500ms ease;
    color: black;
    text-decoration: none !important;
}

.router-link-active,
.router-link-exact-active {
    text-decoration: none !important;
}

li:hover {
    transform: scale(1.1) translateX(70px) translateY(-1px);
}
</style>
