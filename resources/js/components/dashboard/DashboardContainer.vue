<template>
  <div>
      <h1>this is the dashboard container</h1>
      <h1>{{hamza}}</h1>
  </div>
</template>

<script>
export default {
computed : {
    hamza(){
        return this.$store.getters['currentUser/hamza'];
    }
},
created(){
    console.log(this.hamza);
}
}
</script>

<style>

</style>