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
            <tr v-for="p in products">
                <td>{{ p.name }}</td>
                <td>${{ p.price }}</td>
                <td><plusminsfield v-bind:value="p.quantity" :product="p"></plusminsfield></td>
            </tr>
            <tr>
                <td><b>Coupon:</b></td>
                <td>If you have a coupon, please enter its code here</td>
                <td>
                    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
                        <alert-success :form="form" :message="$t('password_updated')"/>
                        <input v-model="form.coupon" class="form-control" type="text" name="coupon">
                        <div v-if="errors.length">
                            <p v-for="error in errors">{{ error }}</p>
                        </div>
                        <has-error :form="form" field="coupon"/>
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
    import { mapActions, mapGetters } from 'vuex'
    import PlusMinusField from '../components/PlusMinusField.vue'

    export default {
        components: {
            'plusminsfield': PlusMinusField
        },
        data: () => ({
            form: new Form({
                coupon: ''
            }),
            'errors': []
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
            ]),
            checkout(){
                alert('Pay us $' + this.price)
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
            }
        },
        created () {
            this.updatePrice()
            this.form.coupon = this.coupon
        }
    }
</script>