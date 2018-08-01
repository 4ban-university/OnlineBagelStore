<template>
  <b-modal id="modal-center" 
           size="lg" 
           title="Add to cart"
           header-bg-variant="warning">
        <b-img alt="img" center :src="item.image"/>
        <b-list-group class="mt-1">
          <b-list-group-item active>{{item.title}}</b-list-group-item>
          <b-list-group-item>{{item.description}}</b-list-group-item>
          <b-list-group-item>Calories: {{item.calories}}</b-list-group-item>
        </b-list-group>
        <Order/>
  </b-modal>
</template>

<script>
import Order from '@/components/Order.vue'

export default {
  name: 'Modal',
  components: {
    Order
  },
  props: {
    item: {}
  },
  data () {
    return {}
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
