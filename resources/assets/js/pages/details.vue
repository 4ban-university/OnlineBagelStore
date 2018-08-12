<template>
  <div>
    <h1 class="title">{{ $t('your_cart') }}</h1>
    <p v-show="!products.length">
      <i>{{ $t('empty_cart') }}</i>
      <router-link to="/">{{ $t('go_shopping') }}</router-link>
    </p>
    <card :title="$t('details')" v-show="products.length">
      <form @submit.prevent="">
        <!-- Name -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
          <div class="col-md-7">
            <input v-model="form.name" class="form-control" v-validate="'required|alpha'" type="text" name="name" :data-vv-as="$t('name')">
            <span>{{ errors.first('name') }}</span>
          </div>
        </div>

        <!-- Last Name -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('lastname') }}</label>
          <div class="col-md-7">
            <input v-model="form.lastname" class="form-control" v-validate="'required|alpha'" type="text" name="lastname" :data-vv-as="$t('lastname')">
            <span>{{ errors.first('lastname') }}</span>
          </div>
        </div>

        <!-- Email -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
          <div class="col-md-7">
            <input v-model="form.email" v-validate="'required|email'" name="email" type="text" class="form-control" :data-vv-as="$t('email')">
            <span>{{ errors.first('email') }}</span>
          </div>
        </div>

        <!-- Phone -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('phone') }}</label>
          <div class="col-md-7">
            <input v-model="form.phone" v-validate="'required|phoneNumber'" class="form-control" type="text" name="phone" :data-vv-as="$t('phone')">
            <span>{{ errors.first('phone') }}</span>
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

        <!-- Street number -->
        <div class="form-group row" v-if="!form.isPickup">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('number') }}</label>
          <div class="col-md-7">
            <input v-model="form.street_number" class="form-control"  v-validate="'required|numeric'" type="text" name="street_number" :data-vv-as="$t('number')">
            <span>{{ errors.first('street_number') }}</span>
          </div>
        </div>

        <!-- Street name -->
        <div class="form-group row" v-if="!form.isPickup">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('street') }}</label>
          <div class="col-md-7">
            <input v-model="form.street_name" class="form-control" v-validate="'required|alpha_spaces'" type="text" name="street_name" :data-vv-as="$t('street')">
            <span>{{ errors.first('street_name') }}</span>
          </div>
        </div>

        <!-- Apartment number -->
        <div class="form-group row" v-if="!form.isPickup">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('apartment') }}</label>
          <div class="col-md-7">
            <input v-model="form.apartment" class="form-control" v-validate="'numeric'" type="text" name="apartment" :data-vv-as="$t('apartment')">
            <span>{{ errors.first('apartment') }}</span>
          </div>
        </div>

        <!-- Postal code -->
        <div class="form-group row" v-if="!form.isPickup">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('postcode') }}</label>
          <div class="col-md-7">
            <input type="text" name="postcode" v-model="form.postcode"
                   v-validate="{ required: true, regex: /^[ABCEGHJKLMNPRSTVXY][0-9][ABCEGHJKLMNPRSTVWXYZ] ?[0-9][ABCEGHJKLMNPRSTVWXYZ][0-9]$/i }"
                   class="form-control" :data-vv-as="$t('postcode')">
            <span>{{ errors.first('postcode') }}</span>
          </div>
        </div>

        <!-- City -->
        <div class="form-group row" v-if="!form.isPickup">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('city') }}</label>
          <div class="col-md-7">
            <input v-model="form.city" class="form-control" v-validate="'required|alpha'" type="text" name="city" :data-vv-as="$t('city')">
            <span>{{ errors.first('city') }}</span>
          </div>
        </div>

        <!-- Province -->
        <div class="form-group row" v-if="!form.isPickup">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('province') }}</label>
          <div class="col-md-7">
            <b-form-select v-model="form.province" class="mb-3" v-validate="'required|alpha'" name="province" :data-vv-as="$t('province')">
              <option value="QC" selected>Québec</option>
              <option value="ON">Ontario</option>
            </b-form-select>
            <span>{{ errors.first('province') }}</span>
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

    export default {
        metaInfo () {
            return { title: this.$t('details') }
        },

        data: () => ({
            title: '',
            form: {
                name: '',
                lastname: '',
                phone: '+1',
                isPickup: true,
                postcode: '',
                street_name: '',
                street_number: '',
                city: 'Montreal',
                province: 'QC',
                apartment: '',
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
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        // eslint-disable-next-line
                        this.saveForm(this.form)
                        this.$router.push({ name: 'payment' })
                        return;
                    }
                })
            }
        }
    }
</script>