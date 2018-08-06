<template>
    <div class="cart">
        <h1 class="title">Your Cart</h1>
        <p v-show="!products.length">
            <i>Your cart is empty!</i>
            <router-link to="/">Go shopping</router-link>
        </p>
        <table class="table is-striped" v-show="products.length">
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Price</td>
                    <td>Quantity</td>
                </tr>
            </thead>
            <tbody>
                <template v-for="p in products">
                    <tr>
                        <td>{{ p.name }}</td>
                        <td>${{ p.price }}</td>
                        <td><plusminsfield v-bind:value="p.quantity" :product="p"></plusminsfield></td>
                    </tr>
                    <tr>
                        <td><b>Toppings:</b></td>
                        <td>
                            <multiselect :value="currentToppings.find(element => element.product_id === p.id).toppings"
                                         placeholder="Select one topping or more"
                                         label="name" track-by="code" :options="toppingsAvailable" :multiple="true" :id="p.id"
                                         @select="selectTag" @remove="removeTag"></multiselect>
                        </td>
                        <td></td>
                    </tr>
                </template>
                <tr>
                    <td><b>Coupon:</b></td>
                    <td>If you have a coupon, please enter its code here</td>
                    <td>
                        <form @submit.prevent="update" @keydown="form.onKeydown($event)">
                            <input v-model="form.coupon" class="form-control" type="text" name="coupon">
                            <div v-if="errors.length">
                                <p v-for="error in errors">{{ error }}</p>
                            </div>
                            <v-button :loading="form.busy" type="success">{{ $t('update') }}</v-button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td><b>Total:</b></td>
                    <td></td>
                    <td><b>${{ this.price }}</b></td>
                </tr>
            </tbody>

        </table>
        <p><button v-show="products.length" class='button is-primary' @click='checkout'>Checkout</button></p>
    </div>
</template>

<script>
    import axios from 'axios'
    import Form from 'vform'
    import Multiselect from 'vue-multiselect'
    import { mapActions, mapGetters } from 'vuex'
    import PlusMinusField from '../components/PlusMinusField.vue'

    export default {
        components: {
            'plusminsfield': PlusMinusField,
            'multiselect': Multiselect,
        },
        metaInfo () {
            return { title: this.$t('cart') }
        },
        data: () => ({
            form: new Form({
                coupon: ''
            }),
            'errors': [],
            value: [
                { name: 'Javascript', code: 'js' }
            ],
            toppingsAvailable: [],
            currentToppings: []
        }),
        computed: {
            ...mapGetters({
                products: 'cartProducts',
                price: 'price',
                coupon: 'coupon',
                authenticated: 'auth/check'
            }),
        },
        methods: {
            ...mapActions([
                'updatePrice',
                'applyReduction',
                'addTopping',
                'removeTopping',
            ]),
            checkout(){
                alert('Pay us $' + this.price)
            },
            selectTag(selectedOption, productId) {
                this.addTopping([productId, selectedOption])
                this.updateCurrentToppings()
            },
            removeTag(selectedOption, productId) {
                this.removeTopping([productId, selectedOption])
                this.updateCurrentToppings()
            },
            async update () {
                this.errors = []
                var coupon = this.form.coupon
                await axios.get(`/api/coupon/` + coupon)
                    .then(response => {
                        if (response.data === 0) {
                            // Invalid
                            this.errors.push('Coupon invalid');
                        }
                        else {
                            // Valid
                            this.errors.push('Reduction of '+response.data+'% applied');
                        }
                        this.applyReduction([response.data, coupon])
                    })
                    .catch(e => {
                        this.errors.push('Network error');
                    })
            },
            updateCurrentToppings() {
                this.currentToppings = [];
                for (var i = 0; i < this.products.length; i++) {
                    var toppings = this.$store.getters.toppings(this.products[i].id)
                    this.currentToppings.push(
                        {
                            product_id: this.products[i].id,
                            toppings: toppings
                        }
                    )
                }
            }
        },
        created () {
            this.updatePrice()
            this.form.coupon = this.coupon
            axios.get(`/api/toppings`)
                .then(response => {
                    for (var i = 0; i < response.data.data.length; i++) {
                        var topping = {
                            name: response.data.data[i].title,
                            code: response.data.data[i].id,
                        }
                        this.toppingsAvailable.push(topping)
                    }
                })
            this.updateCurrentToppings()
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>