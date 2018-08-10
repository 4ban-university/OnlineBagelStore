<template>
  <div>
    <h1 class="title">{{ $t('your_cart') }}</h1>
    <p v-show="!products.length">
      <i>{{ $t('empty_cart') }}</i>
      <router-link to="/"></router-link>
    </p>
    <card :title="$t('details')" v-show="products.length">
      <form @submit.prevent="">
        <!-- Name -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
          <div class="col-md-7">
            <input v-model="form.name" class="form-control" type="text" name="name">
          </div>
        </div>

        <!-- Name -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('lastname') }}</label>
          <div class="col-md-7">
            <input v-model="form.lastname" class="form-control" type="text" name="lastname">
          </div>
        </div>

        <!-- Email -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
          <div class="col-md-7">
            <input v-model="form.email" v-validate="'required|email'" name="email" type="text" class="form-control">
            <span>{{ errors.first('email') }}</span>
          </div>
        </div>

        <!-- Phone -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('phone') }}</label>
          <div class="col-md-7">
            <input v-model="form.phone" class="form-control" type="text" name="phone">
          </div>
        </div>

        <!-- Pickup/Delivery -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('pickup') }}</label>
          <div class="col-md-7">
            <b-button-group size="lg">
              <b-button v-on:click="form.isPickup = !form.isPickup" :pressed="form.isPickup" variant="primary">{{ $t('pickup') }}</b-button>
              <b-button v-on:click="form.isPickup = !form.isPickup" :pressed="!form.isPickup" variant="primary">{{ $t('delivery') }}</b-button>
            </b-button-group>
          </div>
        </div>

        <!-- Street name -->
        <div class="form-group row" v-if="!form.isPickup">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('street') }}</label>
          <div class="col-md-7">
            <input v-model="form.street" class="form-control" type="text" name="street">
          </div>
        </div>

        <!-- Postal code -->
        <div class="form-group row" v-if="!form.isPickup">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('postal_code') }}</label>
          <div class="col-md-7">
            <input v-model="form.postal_code" class="form-control" type="text" name="postal_code">
          </div>
        </div>

        <!-- City -->
        <div class="form-group row" v-if="!form.isPickup">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('city') }}</label>
          <div class="col-md-7">
            <input v-model="form.city" class="form-control" type="text" name="city">
          </div>
        </div>

        <!-- Province -->
        <div class="form-group row" v-if="!form.isPickup">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('province') }}</label>
          <div class="col-md-7">
            <input v-model="form.province" class="form-control" type="text" name="province">
          </div>
        </div>

        <!-- Submit Button -->
        <div class="form-group row">
          <div class="col-md-9 ml-md-auto">
            <button :loading="form.busy" v-on:click="sendOrder" type="success">{{ $t('submit') }}</button>
          </div>
        </div>
      </form>
    </card>
  </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'

    export default {
        metaInfo () {
            return { title: this.$t('details') }
        },

        data: () => ({
            title: '',
            form: {
                name: '',
                lastname: '',
                phone: '',
                isPickup: '',
                postal_code: '',
                street: '',
                city: '',
                province: '',
                email: ''
            }
        }),

        created () {
            // Fill the form with user data.
            if (!this.infoPageAlreadyLoaded) {
                this.infoPageLoaded()
                Object.keys(this.form).forEach(key => {
                    if (this.user && this.user[key]) {
                        this.form[key] = this.user[key]
                    }
                })
            } else {
                Object.keys(this.form).forEach(key => {
                    this.form[key] = this.details[key]
                })
            }
        },

        computed: mapGetters({
            authenticated: 'auth/check',
            user: 'auth/user',
            products: 'cartProducts',
            details: 'details',
            infoPageAlreadyLoaded: 'infoPageAlreadyLoaded'
        }),

        methods: {
            ...mapActions([
                'infoPageLoaded',
                'saveForm'
            ]),
            sendOrder () {
                this.saveForm(this.form)
            }
        }
    }
</script>