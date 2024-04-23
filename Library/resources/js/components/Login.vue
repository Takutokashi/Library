<template>
<div>
    <h1>LOGIN PAGE</h1>
</div>
<div>
    <input v-model="email" type="email" placeholder="email" class="form-control">
    <input v-model="password" type="password" placeholder="password" class="form-control">
    <button @click="login" class="btn btn-primary">Добавить</button>
</div>
</template>

<script>
 export default {
    data(){
        return{
            email: '',
            password: '',
        }
    },
    methods:{
        async  login(){
            await axios.get('/sanctum/csrf-cookie').then(response => {
            axios.post('/login', {
                email: this.email,
                password: this.password,
            })
                .then(res =>{
                    console.log(res)
                })
                .catch(error => {
                    console.log(error.response)
                })
            })
        },
    },

 }

</script>

<style scoped>

</style>
