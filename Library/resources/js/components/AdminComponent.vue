<template>
    <div>
        <div class="right">
            <button class="btn btn-primary" @click="toggleEditMode" v-if="!editMode">Редактировать</button>
            <button class="btn btn-primary" @click="toggleEditMode" v-else>Завершить редактирование</button>
        </div>
        <h1>ADMIN PANEL</h1>
        <div class="table">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Имя</th>
                    <th scope="col">Фамилия</th>
                    <th scope="col">Email</th>
                    <th scope="col">Пароль</th>
                    <th scope="col">Роль</th>
                    <th scope="col">Действие</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users" :key="user.id" v-if="!editMode">
                    <td>{{user.id}}</td>
                    <td>{{user.name}}</td>
                    <td>{{user.surname}}</td>
                    <td>{{user.email}}</td>
                    <td></td>
                    <td>{{user.role}}</td>
                    <td>
                        <button class="btn btn-danger" @click="deleteUser(user.id)">Удалить</button>
                    </td>
                </tr>

                <tr v-for="user in users" :key="user.id" v-else>
                    <td>{{ user.id }}</td>
                    <td><input class="form-control" type="text" v-model="user.name"></td>
                    <td><input class="form-control" type="text" v-model="user.surname"></td>
                    <td><input class="form-control" type="text" v-model="user.email"></td>
                    <td><input class="form-control" type="text" v-model="user.password"></td>
                    <td><input class="form-control" type="text" v-model="user.role"></td>
                    <td>
                        <button class="btn btn-success" @click="updateUser(user.id, user.name, user.surname, user.email, user.password, user.role)">Сохранить</button>
                    </td>
                </tr>
                <tr v-if="editMode">
                    <td></td>
                    <td><input class="form-control" type="text" v-model="newUser.name"></td>
                    <td><input class="form-control" type="text" v-model="newUser.surname"></td>
                    <td><input class="form-control" type="text" v-model="newUser.email"></td>
                    <td><input class="form-control" type="text" v-model="newUser.password"></td>
                    <td><input class="form-control" type="text" v-model="newUser.role"></td>
                    <td>
                        <button class="btn btn-success" @click="createUser(newUser)">Добавить</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            users: null,
            editMode: false,
            newUser: {
                id: '',
                name: '',
                surname: '',
                email: '',
                password: '',
                remember_token: 'noToken',
            }

        }
    },
    mounted() {
        this.getUsers()
    },

    methods: {
        getUsers(){
            axios.get('/api/getUsers')
                .then(res => {
                    this.users = res.data;
                    this.users.sort((a, b) => a.id - b.id);
                })
                .catch(error => {
                    console.log(error)
                })
        },

        toggleEditMode() {
            this.editMode = !this.editMode;
        },

        deleteUser(id) {
            axios.post('/api/deleteUser/' + id)
                .then(res => {
                    alert('Пользователь удален')
                    location.reload();
                })
                .catch(error => {
                    console.log(error)
                })
        },
        updateUser(id, name, surname, email, password, role){
            console.log(id, name, surname, email, password, role, this.remember_token)
          axios.patch('/api/updateUser/' + id, {
              id: id,
              name: name,
              surname: surname,
              email: email,
              password: password,
              role: role })
              .then(res =>{
                  console.log(res.data);
                  alert('Пользователь обновлен');
                  location.reload();
              })
              .catch(error =>{
                  console.log(error)
              })
        },

        createUser(newUser){
            axios.post('/api/createNewUser' , {
                name: newUser.name,
                surname:newUser.surname,
                email:newUser.email,
                password:newUser.password,
                remember_token: 'noToken',
                role: newUser.role,
            })
                .then(res => {
                    if (res.data === 0){
                        alert('Пользователь с таким email уже зарегистрирован')
                    }
                    else{
                        alert('Пользователь успешно добавлен!')
                        location.reload();
                    }
                })
                .catch(function (error) {
                    alert('Пользователь с таким email уже зарегистрирован')
                })
        },
    }
}
</script>

<style scoped>
div.table{
    margin-top: 30px;
}
div.right{
    position: absolute;
    right: 310px;
    top: 70px;
}
</style>
