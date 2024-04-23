<template>
    <div>
        <h1>GET PAGE</h1>
    </div>
</template>

<script>
export default {
data(){
  return{

  }
},
    mounted() {
    this.getData()
    },
    methods:{
    getData(){
        axios.get('/api/get')
            .then(res => {
                console.log(res);
            })
            .catch(error => {
                console.log(error.response)
            })
    },
    },
}
</script>

<style scoped>

</style>
