<template>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <title>TakutoLibrary</title>
    </head>
    <body>
    <div class="container">
        <div class="row">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <router-link to="/home" class="navbar-brand" >TakutoLibrary</router-link>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <router-link to="/categories" class="nav-link active" aria-current="page">Категории</router-link>
                            </li>

                            <li class="nav-item">
                                <router-link to="/authors" class="nav-link active" aria-current="page">Авторы</router-link>
                            </li>

                        </ul>
                        <form method="post" class="d-flex">
                            <button id="myButton" type="button" class="btn btn-primary" data-bs-toggle="dropdown" aria-expanded="false" @click="clickTest(buttonText)">{{buttonText}}</button>

                        </form>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <div>
    </div>
    <router-view></router-view>
    </body>
    </html>
</template>

<script>

 import ProfileComponent from "@/components/ProfileComponent.vue";
 import { mapState } from 'vuex';

export default {
    components: {ProfileComponent},
    data() {
        return {
            initialStatus: localStorage.getItem("status") || null,
            buttonText: this.initialStatus ? "Logout" : "Login",
        }
    },

    computed: {
        buttonText() {
            return this.initialStatus ? "Logout" : "Login";
        }
    },

    watch: {
        initialStatus(newVal) {
            localStorage.setItem("status", newVal);
        }
    },

    created() {
        window.addEventListener("storage", this.handleStorageChange);
    },
    beforeDestroy() {
        window.removeEventListener("storage", this.handleStorageChange);
    },


    methods: {

        handleStorageChange(event) {
            if (event.key === "status") {
                this.initialStatus = event.newValue === 'true';
            }
        },

            clickTest(buttonText) {
                if (buttonText === 'Login') {
                    console.log('Login')
                    this.$router.push('/authorization');
                }
                if (buttonText === 'Logout') {
                    console.log('Logout')
                     this.$router.push('/profile');
                }

            }
        },
}
</script>
<style scoped>
button.btn-primary{
    margin-left: 20px;
}

</style>

