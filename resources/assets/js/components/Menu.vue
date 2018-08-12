<template>
  <div class="row" v-if="loading">
        <b-alert class="mx-auto" style="width: 100%;" show variant="info">{{ $t('loading') }} ...</b-alert>
  </div>
    <div v-else>
      <h3 class="text-left">{{ $t('our_bagels') }}</h3>
      <div class="row mt-4">
        <div class="col-md-4 mb-4" v-for="bagel of bagels" v-bind:key="bagel.id">
            <div class="items" v-bind:style="{ 'background-image': 'url(' + (bagel.image ||'https://canadatwoway.com/wp-content/uploads/2017/11/No_Image_Available.jpg') + ')' }">
              <router-link :to="{ name: 'bagel', params: { id: bagel.id }}">
                <p class="title pl-2">{{ $t('bagel.' + bagel.id + '.title') }}</p>
                <div class="description">
                  <p class="text text-left pl-2 pr-2 mb-2">{{ $t('bagel.' + bagel.id + '.description') }}</p>
                  <div class="row no-gutters">
                    <div class="col-6">
                      <p class="calories mb-2 pl-2">Calories :- {{ bagel.calories }}</p>
                    </div>
                    <div class="col-6">
                      <button @click.prevent="addToCart(bagel);toast($t('bagel.' + bagel.id + '.title'));">Add</button>
                    </div>
                  </div>
                </div>
              </router-link>
            </div>
        </div>
      </div>
      <h3 class="text-left mt-4">{{ $t('fancy_drink') }}</h3>
      <div class="row mt-4">
        <div class="col-md-4 mb-4" v-for="drink of drinks" v-bind:key="drink.id">
          <div class="items" v-bind:style="{ 'background-image': 'url(' + (drink.image ||'https://canadatwoway.com/wp-content/uploads/2017/11/No_Image_Available.jpg') + ')' }">
            <router-link :to="{ name: 'drink', params: { id: drink.id }}">
              <p class="title pl-2">{{ $t('drink.' + drink.id + '.title') }}</p>
              <div class="description">
                <p class="text text-left pl-2 pr-2 mb-2">{{ $t('drink.' + drink.id + '.description') }}</p>
                <div class="row no-gutters">
                  <div class="col-6">
                    <p class="calories mb-2 pl-2">Calories :- {{ drink.calories }}</p>
                  </div>
                  <div class="col-6">
                    <button @click='addToCart(drink)' v-on:click="toast($t('bagel.' + drink.id + '.title'))">Add</button>
                  </div>
                </div>
              </div>
            </router-link>
          </div>
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
  .items {
    position: relative;
    height: 250px;
    background: no-repeat center;
    background-size: cover;
    display: block;
    position: relative;
    z-index: 1;
    transition: opacity 150ms cubic-bezier(0.25, 0.46, 0.45, 0.94),-webkit-transform 300ms cubic-bezier(0.25, 0.46, 0.45, 0.94);
    transition: transform 300ms cubic-bezier(0.25, 0.46, 0.45, 0.94),opacity 150ms cubic-bezier(0.25, 0.46, 0.45, 0.94);
    transition: transform 300ms cubic-bezier(0.25, 0.46, 0.45, 0.94),opacity 150ms cubic-bezier(0.25, 0.46, 0.45, 0.94),-webkit-transform 300ms cubic-bezier(0.25, 0.46, 0.45, 0.94);
    -webkit-box-shadow: 0px 0px 27px -4px rgba(0,0,0,0.75);
    -moz-box-shadow: 0px 0px 27px -4px rgba(0,0,0,0.75);
    box-shadow: 0px 0px 27px -4px rgba(0,0,0,0.75);
  }
  .items a:hover {
    text-decoration: none;
  }
  .items .title {
    font-size: 27px;
    text-align: left;
    font-weight: 800;
    color: white;
    letter-spacing: 2px;
    background: linear-gradient(to top,rgba(255,255,255,0),rgba(0, 0, 0, 0.81));
  }
  .items .description {
    position: absolute;
    bottom: 0;
    width: 100%;
    background: linear-gradient(to bottom,rgba(255,255,255,0),rgba(0, 0, 0, 0.81));
  }
  .items .description .text {
    width: 100%;
    color: white;
    text-overflow: ellipsis;
    word-break: break-word;
    overflow: hidden;
    font-size: 15px;
    font-weight: 500;
    font-size: 20px;
  }
  .items .description .calories {
    font-size: 19px;
    color: white;
    font-weight: 800;
    letter-spacing: 1px;
    text-align: left;
  }
  .items .description button {
    width: 60px;
    outline: none;
    float: right;
    margin-right: 10px;
    background-color: white;
    display: inline-block;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    user-select: none;
    border: none;
    cursor: pointer;
  }
</style>