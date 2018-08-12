<template>
  <div class="row" v-if="loading">
        <b-alert class="mx-auto" style="width: 100%;" show variant="info">{{ $t('loading') }} ...</b-alert>
  </div>
    <div v-else>
      <h3>{{ $t('our_bagels') }}</h3>
      <div class="row">
        <div class="col-md-3" v-for="bagel of bagels" v-bind:key="bagel.id">
          <b-card no-body
                  :img-src="bagel.image ||'https://canadatwoway.com/wp-content/uploads/2017/11/No_Image_Available.jpg'"
                  img-alt="Image"
                  img-top
                  class="mb-1 mt-1"
                  border-variant="secondary">
            <b-card-body>
              <b-link :to="{ name: 'bagel', params: { id: bagel.id }}">
                <h4 class="card-title">{{ $t('bagel.' + bagel.id + '.title') }}</h4>
                <h6 class="card-subtitle">{{ $t('bagel.' + bagel.id + '.description') }}</h6>
              </b-link>
            </b-card-body>
            <div slot="footer">
              <small class="text-muted" align="right">Calories: {{ bagel.calories }}</small>
              <b-btn size="sm" style="float: right" variant="warning" @click='addToCart(bagel)' v-on:click="toast($t('bagel.' + bagel.id + '.title'))">{{ $t('add') }}</b-btn>
            </div>
          </b-card>
        </div>
      </div>
      <h3>{{ $t('fancy_drink') }}</h3>
      <div class="row">
        <div class="col-md-3" v-for="drink of drinks" v-bind:key="drink.id">
          <b-card no-body
                  :img-src="drink.image ||'https://canadatwoway.com/wp-content/uploads/2017/11/No_Image_Available.jpg'"
                  img-alt="Image"
                  img-top
                  class="mb-1 mt-1"
                  border-variant="secondary">
            <b-card-body>
              <b-link :to="{ name: 'drink', params: { id: drink.id }}">
                <h4 class="card-title">{{ $t('bagel.' + drink.id + '.title') }}</h4>
                <h6 class="card-subtitle">{{ $t('bagel.' + drink.id + '.description') }}</h6>
              </b-link>
            </b-card-body>
            <div slot="footer">
              <small class="text-muted" align="right">Calories: {{ drink.calories }}</small>
              <b-btn size="sm" style="float: right" variant="warning" @click='addToCart(drink)' v-on:click="toast($t('bagel.' + drink.id + '.title'))">{{ $t('add') }}</b-btn>
            </div>
          </b-card>
        </div>
      </div>
    </div>
</template>

<script>
import axios from 'axios'
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'Menu',
  computed: mapGetters({
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
      products: [],
      bagels: [],
      drinks: [],
      loading: ''
    }
  },
  created () {
    axios.get(`/api/products`)
      .then(response => {
        this.products = response.data.data;
        this.bagels = this.products.filter(b => b.type === 1)
        this.drinks = this.products.filter(b => b.type !== 1)
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