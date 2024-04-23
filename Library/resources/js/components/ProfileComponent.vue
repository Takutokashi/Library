<template>
    <div class="darkening" @click="clickClose" v-if="show">
    </div>
    <div class="create" v-if="show">
        <h1>Профиль</h1>
        <div  class="btn-group-vertical" role="group" id="button-container">
            <button @click="myBooking" type="button" class="btn btn-primary left">Мои Бронирования</button>
            <button @click="Exit" type="button" class="btn btn-primary left">Выйти</button>
        </div>
        <div>
            <div v-if="openBooking">
                <div>
                    <h3>Вы забронировали книгу: {{this.allData[0]}}</h3>
                    <h4>Код для получения: {{this.allData[1]}}</h4>
                </div>
            </div>
            <div v-if="openExit">
                <div>
                    <h3>Вы действительно хотите выйти из аккаунта?</h3>
                    <button type="button" class="btn btn-light exit" @click="logout" >Выйти</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data: () => ({
        show: true,
        allData:[],
        idUser: '',
        openBooking: '',
        openExit: '',
        idBooks: '',
        titleBook: '',
        code: '',
    }),
    methods:{
        clickClose() {
            this.show = !this.show;
            window.location.href = '/#/home';
            location.reload();

        },
        myBooking(){
            this.openExit = false;
            this.openBooking =!this.openBooking;
            this.idUser = Number(localStorage.getItem('id'));
            console.log(this.idUser)
            axios.get('/api/getBooking/' + this.idUser)
                .then(res => {                                          //получаем id забронированной книги
                    this.allData = res.data;
                    console.log(this.allData[0])
                    console.log(this.allData[1])
                })
        },

        Exit(){
            this.openBooking = false;
            this.openExit =!this.openExit;
        },
        logout(){
            axios.post('/logout')
                .then(res => {
                    localStorage.removeItem('x_xsrf_token');
                    localStorage.removeItem('status');
                    localStorage.removeItem('id');
                    localStorage.removeItem('role');
                    alert('Вы вышли из аккаунта');
                    window.location.href = '/#/home';
                    location.reload();
                })
        },
    },
}
</script>

<style scoped>
div.darkening{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #000;
    opacity: 0.6;
    z-index: 2;

}
div.create{
    z-index: 3;
    position: absolute;
    margin-left: 30%;
    margin-right: auto;
    margin-top: auto;
    width: 700px;
    height: 500px;
    border-radius: 15px;
    justify-content: center;
    align-items: center;
    background: -webkit-linear-gradient(145deg, #213483,#a575ff);
    background: linear-gradient(145deg, #213483,#a575ff);
    color: white;
}
h1{
    text-align: center;
}
h3{
    margin-left: 130px;
    margin-top: -400px;
}
h4{
    margin-left: 130px;

}
div.btn-group-vertical{
    margin-top: 10px;
    height: 400px;
    width: 130px;
    background: transparent;
}
button.btn-primary.left{
    outline: none;
    border: 0;
    background: transparent;
}
button.btn-light.exit{
    margin-top: 50px;
    margin-left: 300px;
    width: 150px;
}
</style>
