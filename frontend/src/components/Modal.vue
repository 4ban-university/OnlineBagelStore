<template>
  <b-modal id="modal-center" size="lg" centered title="Add to cart">
        <!-- <b-alert  v-if="errored" class="mx-auto" style="width: 100%;" show variant="danger" v-for="error of errors" v-bind:key="error">{{error.message}}</b-alert> -->
        <img :src="item.image"/>
        <p class="my-4">{{item.title}}</p>
        <p class="my-4">{{item.description}}</p>
        <p class="my-4">Calories: {{item.calories}}</p>
        <hr>
        <ul v-for="topping of toppings" v-bind:key="topping">
          <li>{{topping.title}} {{topping.description}} {{topping.calories}} {{topping.allergyfree}}</li>
        </ul>
  </b-modal>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Modal',
  props: {
    item: String
  },
  data () {
    return {
      toppings: [],
      errors: [],
      errored: false
    }
  },
  created () {
    axios.get(`http://localhost:3000/toppings`)
      .then(response => {
        this.toppings = response.data
      })
      .catch(e => {
        this.errors.push(e)
        this.errored = true
      })
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
