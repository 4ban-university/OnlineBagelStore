<template>
  <div class="row" v-else>
    <div v-if="loading">
      <b-alert class="mx-auto" style="width: 100%;" show variant="info">{{ $t('loading') }} ...</b-alert>
    </div>
    <div class="col-md-3" v-else v-for="bagel of bagels" v-bind:key="bagel.id">
      <b-card no-body
              :img-src="bagel.image ||'https://canadatwoway.com/wp-content/uploads/2017/11/No_Image_Available.jpg'"
              img-alt="Image"
              img-top
              class="mb-1 mt-1"
              border-variant="secondary">
        <b-card-body>
          <b-link :to="{ name: 'bagel', params: { id: bagel.id }}">
            <h4 class="card-title">{{ bagel.title }}</h4>
            <h6 class="card-subtitle">{{ bagel.description }}</h6>
          </b-link>
        </b-card-body>
        <div slot="footer">
          <small class="text-muted" align="right">Calories: {{bagel.calories}}</small>
          <b-btn size="sm" style="float: right" variant="warning" @click='addToCart(bagel)' v-on:click="toast(bagel.title)">{{ $t('add') }}</b-btn>
        </div>
      </b-card>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'Menu',
  computed: mapGetters({
      products: 'allProducts',
      length: 'getNumberOfProducts'
  }),
  methods: {
    ...mapActions([
        'addToCart',
        'updateProducts'
    ]),
    toast: function(title) {
      this.$toasted.show(`${title} ${this.$t('add_to_cart')}`);
    }
  },
  data () {
    return {
      bagels: [],
      loading: ''
    }
  },
  created () {
    axios.get(`/api/bagels`)
      .then(response => {
        this.bagels = response.data.data;
        this.updateProducts(response.data.data);
      })
  }
}
</script>

<style lang="css" scoped>
  .card-img-top {
    height: 180px;
  }
  .card-body {
    height: 100px;
  }
</style>