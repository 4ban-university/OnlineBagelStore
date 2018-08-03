<template>
  <div>
    <div class="text-center">
      <div class="title mb-4">
        {{ title }}
        <h1 class="mt-5">About us</h1>
        <p class="lead">We are selling bagels since 2018.</p>
        <p>For more information please <router-link to="/contacts">contact</router-link> us.</p>
      </div>
    </div>
  </div>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        metaInfo () {
            return { title: this.$t('about') }
        },

        data: () => ({
            title: ''
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

  .title {
    font-size: 85px;
  }
</style>
