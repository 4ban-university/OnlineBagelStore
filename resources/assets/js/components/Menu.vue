<template>
  <div class="row" v-if="errored">
    <b-alert class="mx-auto" style="width: 100%;" show variant="danger" v-for="error of errors" v-bind:key="error">{{error.message}}</b-alert>
  </div>
  <div class="row" v-else>
    <div v-if="loading">
      <b-alert class="mx-auto" style="width: 100%;" show variant="info">Loading ...</b-alert>
    </div>
    <div class="col-md-3" v-else v-for="bagel of bagels" v-bind:key="bagel.id">
      <b-card :title=bagel.title
              :sub-title=bagel.description
              :img-src=bagel.image
              img-alt="Image"
              img-top
              class="mb-1 mt-1"
              border-variant="secondary">
        <div slot="footer">
          <small class="text-muted" align="right">Calories: {{bagel.calories}}</small>
          <b-btn size="sm" style="float: right" variant="warning" v-b-modal.modal-center v-on:click="item = bagel">Modal</b-btn>
          <td><button @click='addToCart(bagel)' class='button is-info'>Add to cart</button></td>
        </div>
      </b-card>
    </div>
    <Modal :item="item"/>
  </div>
</template>

<script>
import axios from 'axios'
import Modal from './Modal.vue'

import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'Menu',
  components: {
    Modal
  },
  computed: mapGetters({
      products: 'allProducts',
      length: 'getNumberOfProducts'
  }),
  methods: mapActions([
      'addToCart',
      'updateProducts'
  ]),
  data () {
    return {
      bagels: [],
      errors: [],
      errored: false,
      item: String,
      loading: ''
    }
  },
  created () {
    axios.get(`/api/bagels`)
      .then(response => {
        this.bagels = response.data.data;
        this.updateProducts(response.data.data);
      })
      .catch(e => {
        this.errors.push(e);
        this.errored = true
      })
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
