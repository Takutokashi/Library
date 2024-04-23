<template>
<div>
    <h1>INDEX PAGE</h1>
    <router-link to="/get"> Get </router-link>
    <router-link to="/user/login"> login </router-link>
    <router-link to="/user/registration"> registration </router-link>
    <router-view></router-view>
</div>
</template>

<script>
export default {
    data(){
        return{

        }
    },
    methods:{

    },
}

</script>

<style scoped>

</style>
