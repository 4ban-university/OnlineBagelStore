<template>
    <div class="container">
        <div v-if="loading">
            <b-alert class="mx-auto" style="width: 100%;" show variant="info">{{ $t('loading') }}</b-alert>
        </div>
        <div>
            <b-img alt="img" center :src="bagel.image"/>
            <b-list-group class="mt-1">
                <b-list-group-item active>{{bagel.title}}</b-list-group-item>
                <b-list-group-item>{{bagel.description}}</b-list-group-item>
                <b-list-group-item>{{ $t('calories') }}: {{bagel.calories}}</b-list-group-item>
            </b-list-group>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        metaInfo () {
            return { title: 'Bagel' }
        },

        data: () => ({
            title: '',
            bagel: '',
            loading: ''
        }),

        created () {
            axios.get('/api/bagel/' + this.$route.params.id)
                .then(response => {
                    this.bagel = response.data.data;
                })
                .catch(e => {
                    this.errors.push(e);
                    this.errored = true
                })
        }
    }
</script>