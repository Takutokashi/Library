<template>
<div>
    <h1>ПАНЕЛЬ БИБЛИОТЕКАРЯ</h1>
    <div class="btn-group" role="group" aria-label="Базовая группа переключателей радио">
        <input type="radio" class="btn-check" name="btnradio" id="editBooks" autocomplete="off" checked @click="showTable = true; showInput = false; getBook = false">
        <label class="btn btn-outline-primary" for="editBooks">Редактирование книг</label>

        <input type="radio" class="btn-check" name="btnradio" id="issueBook" autocomplete="off" @click="showTable = false; showInput = true; getBook = false">
        <label class="btn btn-outline-primary" for="issueBook">Выдать книгу</label>

        <input type="radio" class="btn-check" name="btnradio" id="getBook" autocomplete="off" @click="showTable = false; showInput = false; getBook = true">
        <label class="btn btn-outline-primary" for="getBook">Получить книгу</label>
    </div>


    <div class="table" v-if="showTable">

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Название</th>
                <th scope="col">Автор</th>
                <th scope="col">Категория</th>
                <th scope="col">Краткое описание</th>
                <th scope="col">Описание</th>
                <th scope="col">Ссылка на фото</th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="book in books" :key="book.id">
                <td>{{book.title}}</td>
                <td>{{book.author}}</td>
                <td>{{book.genre}}</td>
                <td>{{book.shortDescription}}</td>
                <td>{{book.description}}</td>
                <td>{{book.picture}}</td>
                <td>
                    <button class="btn btn-danger" @click="deleteBook(book.id)" >Удалить</button>
                </td>
            </tr>

            <tr>
                <td><input class="form-control" type="text" v-model="newBook.title"></td>
                <td><input class="form-control" type="text" v-model="newBook.author"></td>
                <td><input class="form-control" type="text" v-model="newBook.genre"></td>
                <td><input class="form-control" type="text" v-model="newBook.shortDescription"></td>
                <td><input class="form-control" type="text" v-model="newBook.description"></td>
                <td><input class="form-control" type="text" v-model="newBook.picture"></td>
                <td>
                    <button class="btn btn-success" @click="createBook(newBook)">Добавить</button>
                </td>
            </tr>

            </tbody>
        </table>
    </div>


    <div v-if="showInput" class="code">
        <h3>Выдать книгу</h3>
        <label>Код получения</label>
        <input class="form-control code" type="text" placeholder="код получения" v-model="code">
        <button class="btn btn-success" @click="issueBook(code)" >Выдать книгу</button>

        <div v-if="showModal">
            <h3>Название книги: {{resultIssue[0]}}</h3>
            <h3>Имя пользователя: {{resultIssue[1]}}</h3>
            <button class="btn btn-primary" @click="closeResult" >Книга выдана</button>
        </div>
    </div>


    <div v-if="getBook" class="code">
            <h3>Получить книгу</h3>
            <label>Название книги</label>
            <input class="form-control code" type="text" placeholder="Название книги" v-model="titleGetBook">
            <button class="btn btn-success" @click="getUserBook(titleGetBook)">Получить книгу</button>

    </div>
</div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            books: '',
            showTable: true,
            showInput: false,
            getBook: false,
            editMode: false,
            resultIssue: '',
            showModal: false,
            newBook: {
                title: '',
                author: '',
                genre: '',
                shortDescription: '',
                description: '',
                picture: '',
            },
        }
    },

    mounted() {
    this.getBooks();
        },

    methods:{
        getBooks(){
            axios.get('/api/book/getBooks')
                .then(res =>{
                    this.books = res.data;
                })
                .catch(error =>{
                    console.log(error)
                })
        },

        toggleEditMode() {
            this.editMode = !this.editMode;
        },

        deleteBook(id){
            axios.post('/api/book/deleteBook/' + id)
                .then(res => {
                    alert('Книга удалена')
                    location.reload();
                })
                .catch(error => {
                    console.log(error)
                })
        },

        createBook(newBook){
            axios.post('/api/book/createBook' , {
                title: newBook.title,
                author:newBook.author,
                genre:newBook.genre,
                shortDescription:newBook.shortDescription,
                description: newBook.description,
                picture: newBook.picture,
            })
                .then(res => {
                    alert('Книга добавлена');
                    location.reload();
                })
                .catch(function (error) {
                    console.log(error);
                })
        },

        issueBook(code){
            axios.get('/api/book/issueBook/' + code)
                .then(res =>{
                    this.resultIssue = res.data;
                    console.log(this.resultIssue)
                    this.showModal = true;
                    this.showModal = true;
                    this.showModal = true;
                    console.log(this.showModal)
                })
                .catch(error =>{
                    alert('код не верный');
                })
        },

        closeResult(){
            this.showModal = false;
            axios.patch('/api/book/changeStatus/' + this.resultIssue[2],{
                status: 'У пользователя'
            })
                .then(res =>{
                    console.log(res)
                })
                .catch(error =>{
                    console.log(error)
                })
        },

        getUserBook(titleGetBook){
            axios.post('/api/book/getUserBook/' + titleGetBook)
                .then(res =>{
                    console.log(res)
                    alert('Книга возвращена');
                })
                .catch(error =>{
                    console.log(error)
                })
        },

    },

}
</script>

<style scoped>
div.table{
    margin-top: 20px;
}
div.right{
    position: absolute;
    right: 310px;
    top: 70px;
}
div.code{
    margin-left: 30px;
}
input.form-control.code{
    margin-top: 10px;
    margin-bottom: 10px;
    width: 200px;
}
h1{
    margin-left: 20px;
}
div.btn-group{
    margin-left: 20px;
}
</style>

