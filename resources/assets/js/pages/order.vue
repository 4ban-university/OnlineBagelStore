<template>
    <div class="container">
        <h1 class="title">{{ $t('your_order') }}</h1>
        <div v-if="loading">
            <b-alert class="mx-auto" style="width: 100%;" show variant="info">{{ $t('loading') }}...</b-alert>
        </div>
        <div>
            <b-container fluid class="bv-example-row">
                <b-row>
                    <b-col>{{ $t('order_id') }}</b-col>
                    <b-col>{{ this.order.id }}</b-col>
                </b-row>
                <b-row>
                    <b-col>{{ $t('date') }}</b-col>
                    <b-col>{{ this.order.created_at }}</b-col>
                </b-row>
                <b-row>
                    <b-col>{{ $t('price') }}</b-col>
                    <b-col>${{ this.order.price }}</b-col>
                </b-row>
                <b-row>
                    <b-col>{{ $t('order_type') }}</b-col>
                    <b-col>{{ this.order.pickup ? $t('pickup') : $t('delivery') }}</b-col>
                </b-row>
                <b-row>
                    <b-col>{{ $t('status') }}</b-col>
                    <b-col>{{ (this.order.status === 0) ? $t('paid') : $t('in_progress') }}</b-col>
                </b-row>
                <b-row>
                    <b-col>{{ $t('bagels') }}</b-col>
                    <b-col>
                        <div v-for="item of this.order.items" v-bind:key="item.id">
                            {{ item.amount }}x {{ item.product.title }}
                            <div v-if="item.toppings.length">
                                {{ $t('topping') }}:
                                <template v-for="(element, index) in item.toppings">
                                    <span>{{element.topping.title}}</span><span v-if="index + 1 < item.toppings">, </span>
                                </template>
                            </div>
                        </div>
                    </b-col>
                </b-row>
            </b-container>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import { mapActions, mapGetters } from 'vuex'
    export default {
        metaInfo () {
            return { title: 'Bagel' }
        },

        data: () => ({
            title: '',
            order: '',
            loading: ''
        }),

        computed: mapGetters({
            length: 'getNumberOfProducts'
        }),

        methods: {
            ...mapActions([
                'addToCart',
                'updateProducts'
            ])
        },

        created () {
            axios.get('/api/order/' + this.$route.params.id)
                .then(response => {
                    this.order = response.data.data;
                })
        }
    }
</script>