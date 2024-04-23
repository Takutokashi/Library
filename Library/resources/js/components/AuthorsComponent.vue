<template>
<div>
    <h2>Авторы</h2>
    <div v-for="book in books" key="book">
        <ul>
            <router-link :to="{name: 'author' , params:{author: book.author}}"> <li style="text-decoration: none;" id="{{book.author}}" @click="clickAuthor(book.author)">{{book.author}}</li></router-link>
        </ul>
    </div>
</div>
</template>

<script>
export default {
    data(){
        return{
            books:'',

        }
    },

    mounted() {
    this.getAuthor()
    },

    methods:{
        getAuthor(){
            axios.get('/api/getAuthors')
                .then(res =>{
                  this.books = res.data;
                })
                .catch(error =>{
                    console.log(error)
                })
        },
        clickAuthor(author){
            this.$store.commit('SET_AUTHOR', author);
            console.log(author)
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

li:hover {
    transform: scale(1.1) translateX(70px) translateY(-1px);
}
</style>
