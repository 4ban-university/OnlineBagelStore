<template>
  <form v-on:submit.prevent="orderPush">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Your name</label>
          <input type="text" class="form-control" v-model="orderBody.name"/>
        </div>
      </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Address</label>
            <textarea cols="5" rows="5" class="form-control col-md-6" v-model="orderBody.address"></textarea>
          </div>
        </div>
      </div><br />
      <div class="form-group">
        <button class="btn btn-primary">Ok</button>
      </div>
  </form>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Order',
  components: {},
  props: {
    item: String
  },
  data () {
    return {
      toppings: [],
      orderBody:{},
      errors: [],
      errored: false,
    }
  },
  created () {
    axios.get(`http://localhost:3000/api/toppings`)
      .then(response => {
        this.toppings = response.data
      })
      .catch(e => {
        this.errors.push(e)
        this.errored = true
      })
  },
  methods:{
    orderPush () {
      axios.post(`http://localhost:3000/api/orders`, {body: this.orderBody})
        .then(response => {})
        .catch(e => {
          this.errors.push(e)
          this.errored = true
      })
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
