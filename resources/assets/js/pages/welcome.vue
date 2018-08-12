<template>
  <div>
    <div class="text-center">
      <Menu/>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Menu from "../components/Menu";

export default {
    components: {Menu},
    metaInfo () {
    return { title: this.$t('welcome') }
  },

  data: () => ({
    title: window.config.appName
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  })
}
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}
</style>
