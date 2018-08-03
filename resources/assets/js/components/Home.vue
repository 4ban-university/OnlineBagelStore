<template>
  <b-container fluid>
    <Navbar/>
    <Menu/>
  </b-container>
</template>

<script>
// @ is an alias to /src
import Navbar from './Navbar.vue'
import Menu from './Menu.vue'

export default {
  name: 'home',
  components: {
    Navbar,
    Menu
  }
}
</script>
