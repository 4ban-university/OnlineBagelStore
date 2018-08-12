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
                        <td>{{ $t('bagel.' + p.id + '.title') }}</td>
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
                            <input v-model="form.coupon" v-validate="'required|alpha_num'" class="form-control mb-3" type="text" name="coupon">
                            <div class="mt-3 mb-3" v-if="couponValid">
                                <b-alert variant="success" show>{{couponValid}}</b-alert>
                            </div>
                            <div class="mt-3 mb-3" v-if="couponInValid">
                                <b-alert variant="danger" show>{{couponInValid}}</b-alert>
                            </div>
                            <v-button :loading="form.busy" type="success">{{ $t('update') }}</v-button>
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
    import Form from 'vform'
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
            couponValid: null,
            couponInValid: null,
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
                var coupon = this.form.coupon;
                if(coupon === ''){
                    // Invalid coupon
                    this.couponInValid = this.$t('coupon_invalid');
                    this.couponValid = null;
                    return;
                }
                await axios.get(`/api/coupon/` + coupon)
                    .then(response => {
                        if (response.data === 0) {
                            // Invalid
                            this.couponInValid = this.$t('coupon_invalid');
                            this.couponValid = null;
                        }
                        else {
                            // Valid
                            this.couponValid = this.$t('coupon_applied_1') + response.data + this.$t('coupon_applied_2');
                            this.couponInValid = null;
                        }
                        this.applyReduction([response.data, coupon])
                    })
                    .catch(() => {
                        this.couponInValid = this.$t('network_error');
                        this.couponValid = null;
                    })
            },
            updateCurrentToppings() {
                this.currentToppings = [];
                for (let i = 0; i < this.products.length; i++) {
                    let toppings = this.$store.getters.toppings(this.products[i].id)
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
                    for (let i = 0; i < response.data.data.length; i++) {
                        let topping = {
                            name: this.$t('topping.' + response.data.data[i].id + '.title'),
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