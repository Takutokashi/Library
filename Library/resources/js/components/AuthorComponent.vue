<template>
    <form style="margin-left:50px; margin-top: 20px; display: inline-block;" v-for="author in authors" :key="author">
        <div id="{{author.id}}">
            <div class="card">
                <img :src="author.picture" class="card-img-top" alt="" width="600" height="300">
                <div class="card-body" >
                    <h5 class="card-title">{{author.title}}</h5>
                    <p class="card-text">{{author.shortDescription}}</p>
                    <h4 v-if="author.booking === true">Забронировано</h4>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" :data-bs-target="'#modal' + author.id" >Узнать подробнее</button>
                    <div class="modal fade" :id="'modal' + author.id" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" :id="author.id">{{author.title}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" :id="author.id">
                                    <h5 :id="author.id">Автор: {{author.author}}</h5>
                                    <p :id="author.id">Описание: {{author.description}}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                    <button type="button" class="btn btn-primary" @click="booking(author.id , author.booking)">{{ author.booking ? 'Снять бронирование' : 'Забронировать' }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import axios from "axios";

export default {
    data(){
        return{
            books: [],
            author: '',
            authors:'',
            showModal: false,
            status_auth: null,
            userIdStorage: '',
            userIdBooking: '',
        }
    },

    mounted() {
      this.getAuthor()
    },
    methods:{
        getAuthor(){
            this.author = this.$store.getters.AUTHOR;
            console.log(this.author)
            axios.get('/api/getAuthor/' + this.author)
                .then(res =>{
                    this.authors = res.data;
                    console.log(this.authors)
                })
        },
        booking(id, booking) {
            {
                if (!booking) {
                    axios.patch('/api/booking/' + id, {                    //добавить в бд книг
                        "booking": true,
                    }) .then(response => {
                        console.log('true' + response)
                        const bookedBook = this.authors.find(author => author.id === id);
                        if (bookedBook) {
                            bookedBook.booking = !bookedBook.booking;
                        }
                    })

                    {
                        const code = Math.floor(1000 + Math.random() * 9000);    //генерация кода для получения книги
                        const idUser = localStorage.getItem('id');
                        this.idUser = Number(idUser);
                        axios.post('/api/booking', {                              //добавить бд бронирований
                            'idBook': id,
                            'idUser': this.idUser,
                            'code': code,
                            'status': 'забронировано',
                        })
                    }
                } else {
                    axios.get('/api/bookUserId/' + id)
                        .then(res => {
                            this.userIdBooking = Number(res.data);
                            this.userIdStorage = Number(parseInt(localStorage.getItem('id')));
                            if (this.userIdBooking === this.userIdStorage){
                                axios.patch('/api/booking/' + id, {                        //удаление из бд книг
                                    "booking": false,
                                }) .then(response => {
                                    const bookedBook = this.authors.find(author => author.id === id);
                                    if (bookedBook) {
                                        bookedBook.booking = !bookedBook.booking;
                                    }
                                    axios.post('/api/deleteBooking',{                    // снять бронирование
                                        idBook: id,
                                    })
                                        .then(res => {
                                            console.log(res)
                                        })
                                        .catch(error => {
                                            console.log(error)
                                        });
                                })
                            }
                            else {
                                alert('Вы не можете отменить бронирование этого товара, потому что вы его не заказывали');
                            }
                        })
                }
            }
        },

    },

}
</script>

<style scoped>
form{
    margin-left:50px;
    margin-top: 20px;
    display: inline-block;
}
div.card{
    width: 18rem;
    margin-left: 60px;
    margin-bottom: 30px;
}
</style>
