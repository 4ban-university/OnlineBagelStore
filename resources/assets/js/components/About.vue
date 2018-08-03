<template>
  <b-container fluid>
    <Navbar/>
    <h1 class="mt-5">About us</h1>
    <p class="lead">We are selling bagels since 2018.</p>
    <p>For more information please <router-link to="/contacts">contact</router-link> us.</p>
  </b-container>
</template>

<script>
// @ is an alias to /src
import Navbar from './Navbar.vue'

export default {
  components: {
    Navbar
  }
}
</script>
