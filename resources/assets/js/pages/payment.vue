<template>
  <div>
    <h1 class="title">{{ $t('payment') }}</h1>
    <p v-show="!products.length">
      <i>{{ $t('empty_cart') }}</i>
      <router-link to="/">{{ $t('go_shopping') }}</router-link>
    </p>
    <card :title="$t('payment')" v-show="products.length">
      <form @submit.prevent="">

        <!-- Name -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
          <div class="col-md-7">
            <input v-model="form.name" class="form-control" v-validate="'required|alpha'" type="text" name="name" :data-vv-as="$t('name')">
            <span>{{ errors.first('name') }}</span>
          </div>
        </div>

        <!-- CC Number -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('cc_number') }}</label>
          <div class="col-md-7">
            <input v-model="form.cc_number" class="form-control" v-validate="'required|credit_card'" type="text" name="cc_number" :data-vv-as="$t('cc_number')">
            <span>{{ errors.first('cc_number') }}</span>
          </div>
        </div>

        <!-- Expiration month -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('expiration_month') }}</label>
          <div class="col-md-7">
            <input v-model="form.expiration_month" class="form-control" v-validate="'required|digits:2|between:1,12'" type="text" name="expiration_month" :data-vv-as="$t('expiration_month')">
            <span>{{ errors.first('expiration_month') }}</span>
          </div>
        </div>

        <!-- Expiration year -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('expiration_year') }}</label>
          <div class="col-md-7">
            <input v-model="form.expiration_year" class="form-control" v-validate="'required|digits:4|min_value:2018'" type="text" name="expiration_year" :data-vv-as="$t('expiration_year')">
            <span>{{ errors.first('expiration_year') }}</span>
          </div>
        </div>

        <!-- CVV -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('cvv') }}</label>
          <div class="col-md-7">
            <input v-model="form.cvv" class="form-control" v-validate="'required|digits:3'" type="text" name="cvv" :data-vv-as="$t('cvv')">
            <span>{{ errors.first('cvv') }}</span>
          </div>
        </div>

        <!-- Price -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('price') }}</label>
          <div class="col-md-7">
            <span>{{ this.price }}</span>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="form-group row">
          <div class="col-md-9 ml-md-auto">
            <b-button v-on:click="sendOrder" type="success">{{ $t('submit') }}</b-button>
          </div>
        </div>
      </form>
    </card>
  </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'
    import axios from 'axios'

    export default {
        metaInfo () {
            return { title: this.$t('payment') }
        },

        data: () => ({
            title: '',
            form: {
                name: '',
                cc_number: '',
                cvv: '',
                expiration_month: '',
                expiration_year: ''
            }
        }),

        computed: mapGetters({
            authenticated: 'auth/check',
            user: 'auth/user',
            products: 'cartProducts',
            price: 'price',
            details: 'details',
            infoPageAlreadyLoaded: 'infoPageAlreadyLoaded'
        }),

        methods: {
            ...mapActions([
                'infoPageLoaded',
                'saveForm'
            ]),
            sendOrder () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let order = {
                            customer: this.details.customer,
                            price: this.price,
                            street_number: this.details.street_number,
                            street_name: this.details.street_name,
                            apartment: this.details.apartment,
                            postcode: this.details.postcode,
                            province: this.details.province,
                            items: []
                        }

                        for (let i = 0; i < this.products.length; i++) {
                            let product = {
                                product_id: this.products[i].id,
                                amount: this.products[i].quantity,
                                toppings: []
                            }
                            for (let j = 0; j < this.products.toppings.length; i++) {
                                let topping = {
                                    topping_id: this.products[i].toppings[j].code,
                                    amount: this.products[i].quantity,
                                }
                                product.toppings.push(topping)
                            }
                            order.items.push(product)
                        }

                        axios.post('/user', order)
                            .then(function (response) {
                                console.log(response);
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                        /**
                         {
                          "customer": "Sequi.",
                          "promotion": "Eum est.",
                          "price": 6.37,
                          "street_number": "3886",
                          "street_name": "Rue Ethel",
                          "apartment": "",
                          "postcode": "H4G1S3",
                          "payment_option": 1,
                          "province": "QC",
                          "items": [
                              {
                                  "product_id": 20,
                                  "amount": 3,
                                  "toppings": [
                                          {
                                              "topping_id": 4
                                          },
                                          {
                                              "topping_id": 1
                                          }
                                  ]
                              },
                                      {
                                  "bagel_id": 1,
                                  "amount": 5,
                                  "toppings": [
                                          {
                                              "topping_id": 2
                                          },
                                          {
                                              "topping_id": 1
                                          }
                                  ]
                              }
                          ]
                      }
                         */
                        // todo: POST to backend using this.details
                        return;
                    }
                })
            }
        }
    }
</script>