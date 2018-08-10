<template>
  <div>
    <h1 class="title">{{ $t('your_cart') }}</h1>
    <p v-show="!products.length">
      <i>{{ $t('empty_cart') }}</i>
      <router-link to="/"></router-link>
    </p>
    <card :title="$t('details')" v-show="products.length">
      <form @submit.prevent="" @keydown="form.onKeydown($event)">
        <alert-success :form="form" :message="$t('info_updated')"/>

        <!-- Name -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
          <div class="col-md-7">
            <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
            <has-error :form="form" field="name"/>
          </div>
        </div>

        <!-- Name -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('lastname') }}</label>
          <div class="col-md-7">
            <input v-model="form.lastname" :class="{ 'is-invalid': form.errors.has('lastname') }" class="form-control" type="text" name="lastname">
            <has-error :form="form" field="lastname"/>
          </div>
        </div>

        <!-- Email -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
          <div class="col-md-7">
            <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
            <has-error :form="form" field="email" />
          </div>
        </div>

        <!-- Phone -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('phone') }}</label>
          <div class="col-md-7">
            <input v-model="form.phone" :class="{ 'is-invalid': form.errors.has('phone') }" class="form-control" type="text" name="phone">
            <has-error :form="form" field="phone" />
          </div>
        </div>

        <!-- Pickup/Delivery -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('pickup') }}</label>
          <div class="col-md-7">
            <b-button-group size="lg">
              <b-button v-on:click="isPickup = !isPickup" :pressed="isPickup" variant="primary">{{ $t('pickup') }}</b-button>
              <b-button v-on:click="isPickup = !isPickup" :pressed="!isPickup" variant="primary">{{ $t('delivery') }}</b-button>
            </b-button-group>
          </div>
        </div>

        <!-- Street name -->
        <div class="form-group row" v-if="!isPickup">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('street') }}</label>
          <div class="col-md-7">
            <input v-model="form.street" :class="{ 'is-invalid': form.errors.has('street') }" class="form-control" type="text" name="street">
            <has-error :form="form" field="street" />
          </div>
        </div>

        <!-- Postal code -->
        <div class="form-group row" v-if="!isPickup">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('postal_code') }}</label>
          <div class="col-md-7">
            <input v-model="form.postal_code" :class="{ 'is-invalid': form.errors.has('street') }" class="form-control" type="text" name="postal_code">
            <has-error :form="form" field="postal_code" />
          </div>
        </div>

        <!-- City -->
        <div class="form-group row" v-if="!isPickup">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('city') }}</label>
          <div class="col-md-7">
            <input v-model="form.city" :class="{ 'is-invalid': form.errors.has('city') }" class="form-control" type="text" name="city">
            <has-error :form="form" field="city" />
          </div>
        </div>

        <!-- Province -->
        <div class="form-group row" v-if="!isPickup">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('province') }}</label>
          <div class="col-md-7">
            <input v-model="form.province" :class="{ 'is-invalid': form.errors.has('province') }" class="form-control" type="text" name="province">
            <has-error :form="form" field="province" />
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
    import Form from 'vform'
    import { mapGetters } from 'vuex'

    export default {
        metaInfo () {
            return { title: this.$t('details') }
        },

        data: () => ({
            title: '',
            form: new Form({
                name: '',
                email: ''
            }),
            isPickup: true
        }),

        created () {
            // Fill the form with user data.
            this.form.keys().forEach(key => {
                if (this.user && this.user[key]) {
                    this.form[key] = this.user[key]
                }
            })
        },

        computed: mapGetters({
            authenticated: 'auth/check',
            user: 'auth/user',
            products: 'cartProducts'
        }),

        methods: {
            async sendOrder () {
                console.log('sendOrder')
            }
        }
    }
</script>