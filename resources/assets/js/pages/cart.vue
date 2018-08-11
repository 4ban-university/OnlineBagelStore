<template>
    <div class="cart">
        <h1 class="title">{{ $t('your_cart') }}</h1>
        <p v-show="!products.length">
            <i>{{ $t('empty_cart') }}</i>
            <router-link to="/">{{ $t('go_shopping') }}</router-link>
        </p>
        <table class="table is-striped" v-show="products.length">
            <thead>
                <tr>
                    <td>{{ $t('name') }}</td>
                    <td>{{ $t('price') }}</td>
                    <td>{{ $t('quantity') }}</td>
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
                        <td></td>
                        <td v-if="p.type === 1">
                            <multiselect :value="currentToppings.find(element => element.product_id === p.id).toppings"
                                         :placeholder="$t('select_topping')"
                                         label="name" track-by="code" :options="toppingsAvailable" :multiple="true" :id="p.id"
                                         @select="selectTag" @remove="removeTag"></multiselect>
                        </td>
                        <td></td>
                    </tr>
                </template>
                <tr>
                    <td><b>{{ $t('coupon') }}:</b></td>
                    <td>{{ $t('coupon_info') }}</td>
                    <td>
                        <form @submit.prevent="applyCoupon">
                            <input v-model="formCoupon" v-validate="'required|alpha_num'" class="form-control" type="text" name="coupon">
                            <span>
                                <p>{{ errors.first('coupon') }}</p>
                            </span>
                            <span v-if="couponStatus.length">
                                <p v-for="error in couponStatus">{{ error }}</p>
                            </span>
                            <v-button type="success">{{ $t('update') }}</v-button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td><b>{{ $t('total') }}:</b></td>
                    <td></td>
                    <td><b>${{ this.price }}</b></td>
                </tr>
            </tbody>

        </table>
        <p>
            <router-link v-show="products.length" :to="{ name: 'details' }" tag="button" class="btn btn-success">{{ $t('order_info') }}</router-link>
        </p>
    </div>
</template>

<script>
    import axios from 'axios'
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
            formCoupon: '',
            couponStatus: [],
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
            selectTag(selectedOption, productId) {
                this.addTopping([productId, selectedOption])
                this.updateCurrentToppings()
            },
            removeTag(selectedOption, productId) {
                this.removeTopping([productId, selectedOption])
                this.updateCurrentToppings()
            },
            async applyCoupon () {
                let parent = this
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        parent.couponStatus = []
                        let coupon = parent.formCoupon
                        axios.get(`/api/coupon/` + coupon)
                            .then(response => {
                                if (response.data === 0) {
                                    // Invalid
                                    parent.couponStatus.push('Coupon invalid');
                                }
                                else {
                                    // Valid
                                    parent.couponStatus.push(parent.$t('coupon_applied_1') + response.data + parent.$t('coupon_applied_2'));
                                }
                                parent.applyReduction([response.data, coupon])
                            })
                            .catch(() => {
                                parent.couponStatus.push(parent.$t('network_error'));
                            })
                    }
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
            this.formCoupon = this.coupon
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