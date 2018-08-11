<template>
    <div class="container">
        <div v-if="loading">
            <b-alert class="mx-auto" style="width: 100%;" show variant="info">{{ $t('loading') }}...</b-alert>
        </div>
        <div>
            <b-img alt="img" center :src="item.image"/>
            <b-list-group class="mt-1">
                <b-list-group-item active>{{item.title}}</b-list-group-item>
                <b-list-group-item>{{item.description}}</b-list-group-item>
                <b-list-group-item>{{ $t('calories') }}: {{item.calories}}</b-list-group-item>
                <b-list-group-item><b-btn size="sm" style="float: right" variant="warning" @click='addToCart(item)'
                                          v-on:click="toast(item.title)">{{ $t('add') }}</b-btn></b-list-group-item>
            </b-list-group>
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