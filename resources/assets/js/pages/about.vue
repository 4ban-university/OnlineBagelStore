<template>
  <div>
    <div class="text-center">
      <div class="title mb-4">
        {{ title }}
      </div>
      <div>
        <h1 class="mt-5">{{ $t('about_us') }}</h1>
        <p class="lead">{{ $t('about_info') }}</p>
        <p>{{ $t('for_more_info') }}, <router-link to="/contacts">{{ $t('contact_us_page') }}</router-link>.</p>
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
