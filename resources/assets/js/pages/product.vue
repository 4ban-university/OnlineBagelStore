<template>
    <div class="container">
        <div v-if="loading">
            <b-alert class="mx-auto" style="width: 100%;" show variant="info">{{ $t('loading') }}...</b-alert>
        </div>
        <div class="mx-auto" style="width: 35rem">
            <b-card no-body
                :img-src="item.image"
                img-alt="Image"
                img-top>
                <h4 slot="header">{{ $t('bagel.' + item.id + '.title') }}</h4>
                <b-list-group flush>
                    <b-list-group-item>{{ $t('bagel.' + item.id + '.description')}}</b-list-group-item>
                    <b-list-group-item>{{ $t('calories') }}: {{ item.calories }}</b-list-group-item>
                    <b-list-group-item>{{ $t('price') }}: {{ item.price }}</b-list-group-item>
                    <b-list-group-item><b-btn size="sm" style="float: right" variant="warning" @click='addToCart(item)'
                                          v-on:click="toast($t('bagel.' + item.id + '.title'))">{{ $t('add') }}</b-btn></b-list-group-item>
                </b-list-group>
    </b-card>
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
            item: '',
            loading: ''
        }),

        computed: mapGetters({
            length: 'getNumberOfProducts'
        }),

        methods: {
            ...mapActions([
                'addToCart',
                'updateProducts'
            ]),
            toast: function(title) {
                this.$toasted.show(`${title} ${this.$t('add_to_cart')}`);
            }
        },

        created () {
            axios.get('/api/product/' + this.$route.params.id)
                .then(response => {
                    this.item = response.data.data;
                })
        }
    }
</script>