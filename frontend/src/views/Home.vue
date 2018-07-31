<template>
  <div class="container-fluid">
    <Menu msg="Bagels menu"/>
  </div>
</template>

<script>
// @ is an alias to /src
import Menu from '@/components/Menu.vue'

export default {
  name: 'home',
  components: {
    Menu
  }
}
</script>
