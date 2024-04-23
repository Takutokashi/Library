<template>
    <div class="darkening">
    </div>
    <div class="create">
        <h2 ref="head">Авторизация</h2>
        <!-- Показывается при нажатие на регистрацию    -->
        <div class="register-input" v-if="showRegistration">
            <div class="input">
                <label>Имя</label>
                <input placeholder="Имя" v-model="name">
            </div>
            <div class="input">
                <label>Фамилия</label>
                <input placeholder="Фамилия" v-model="surname">
            </div>
        </div>
        <!--        -->
        <div class="auth-container">
            <div class="input">
                <label>Адрес почты</label>
                <input placeholder="example@mail.ru" id="email" v-model="email">
            </div>
            <div class="input">
                <label>Пароль</label>
                <div class="password-input">
                    <input type="password"  ref="passwordInput" placeholder="пароль" id="password" v-model="password">
                    <span class="icon openEye" @click="clickShowPass" :class="showPassword ? 'active' : ''"></span>
                </div>
            </div>
            <button  ref="loginButton" type="submit" class="btn btn-primary" @click="createNewUser">Войти</button>
        </div>
        <div class="register-link">
            <a ref="registerLink" href="#" @click.prevent="clickRegistr">Регистрация</a>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data(){
        return{
            active: 'auth',
            showRegistration: false,
            authOrReg: 'authorization',   //отслеживание на какой странице юзер
            showPassword: false,
            statusAuth: null,
            users: '',
            remember_token: 'noToken',
            role: 'user',
            roleAdmin: '',
            access_token: '',

            name: '',
            surname: '',

            email: '',
            password: '',
        }
    },
    methods:{
        clickRegistr() {                                                    //изменение надписей
            this.showRegistration = !this.showRegistration;
            if (this.showRegistration) {
                this.$refs.head.textContent = "Регистрация";                            //шапка
                this.$refs.loginButton.textContent = "Зарегистрироваться";             //кнопка
                this.$refs.registerLink.textContent = "Уже зарегистрированы?";        //ссылка
                this.authOrReg = 'registration';                                     //юзер на странице регистрации
            } else {
                this.$refs.head.textContent = "Авторизация";                       //шапка
                this.$refs.loginButton.textContent = "Войти";                     //кнопка
                this.$refs.registerLink.textContent = "Регистрация";             //ссылка
                this.authOrReg = 'authorization';                              //юзер на странице авторизации
            }
        },

        clickShowPass() {                                       //скрывать и показывать пароль
            this.showPassword = !this.showPassword;
            if (this.showPassword) {
                this.$refs.passwordInput.type = "text";
            } else {
                this.$refs.passwordInput.type = "password";
            }
        },

        async createNewUser(){                //Добавление нового юзера
            if (this.authOrReg === 'registration')
                axios.post('/api/createUser' , {
                    name: this.name,
                    surname:this.surname,
                    email:this.email,
                    password:this.password,
                    remember_token: this.remember_token,
                    role: this.role,
                })
                    .then(res => {
                        console.log('пришло' + res.data)
                        if (res.data === 0){
                            alert('Пользователь с таким email уже зарегистрирован')
                        }
                        else{
                            alert('Вы успешно зарегистрированы!')
                        }
                    })
                    .catch(function (error) {
                        alert('Пользователь с таким email уже зарегистрирован')
                    })
            if (this.authOrReg === 'authorization')
                await axios.get('/sanctum/csrf-cookie').then(response => {

                    axios.post('/login', {
                        email: this.email,
                        password: this.password })
                        .then(res => {
                            console.log(res.status)
                            if (res.status === 204){
                                    axios.get('/api/user', {          //узнать имя юзера
                                        headers: {'Authorization': 'Bearer ' + this.access_token} })
                                        .then(response => {
                                            localStorage.setItem('x_xsrf_token', response.config.headers['X-XSRF-TOKEN']);
                                            localStorage.setItem('status', true);
                                            localStorage.setItem('id', response.data.id);
                                            localStorage.setItem('role', response.data.role);
                                            if (response.data.role === 'admin')
                                            {
                                                alert('Привет '+ response.data.name);
                                                window.location.href = '/#/admin';

                                            }
                                            else if (response.data.role ==='librarian'){
                                                alert('Привет '+ response.data.name);
                                                window.location.href = '/#/librarian';
                                            }
                                            else{
                                                alert('Привет '+ response.data.name);
                                                window.location.href = '/#/home';
                                                location.reload();
                                            }
                                            this.statusAuth = true;
                                            this.$store.commit('SET_STATUS_AUTH', this.statusAuth);         //запись в Vuex статус авторизации, true/ false
                                        })
                                        .catch(error => {
                                            console.log(error);
                                        })
                           }
                            if (res.status === 200){
                                localStorage.removeItem('x_xsrf_token');

                            }
                        })
                        .catch(error => {
                            console.log(error.response)
                            if (error.response.status === 422){
                                alert('Не правильный email или пароль');
                            }
                        })
                })
        },
    }
}
</script>

<style scoped>
.register-input {
    margin-top: 20px;
}
div.darkening{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 2;
    background: -webkit-linear-gradient(145deg, #213483,#a575ff);
    background: linear-gradient(145deg, #213483,#a575ff);
}
div.create{
    z-index: 3;
    position: absolute;
    margin-left: 35%;
    margin-right: auto;
    margin-top: 100px;
    width: 500px;
    height: 500px;
    border-radius: 15px;
    justify-content: center;
    align-items: center;
    background: #34495e;
}
h2{
    text-align: center;
    color: #009eff;
}
input{
    border-radius: 5px;
    margin-left: 10px;
    width: 480px;

}
div.input{
    margin-bottom: 10px;
}
button{
    margin-top: 20px;
    margin-left: 140px;
    width: 200px;
    height: auto;
}
a {
    padding-top: 500px;
    margin-left: 200px;
    cursor: pointer;
}
label{
    color: #009eff;
    font-size: 20px;
    padding: 5px 1px 1px 15px;
}
.register-link {
    text-align: center;
    margin-top: 20px;
    margin-left: -210px;
}
.register-link a {
    color: #009eff;
    text-decoration: none;
    font-size: 20px;
    padding: 5px 10px;
    border-radius: 5px;
    transition: all 0.3s ease;
}
.register-link a:hover {
    background-color: #f5f5f5;
}
.password-input {
    position: relative;
}
.password-input .icon {
    position: absolute;
    right: 25px;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    background-size: cover;
    cursor: pointer;
    opacity: 0.5;
    background-image: url("/resources/icon/openEye.svg");
}
.password-input .icon.active {
    opacity: 1;
}
</style>
