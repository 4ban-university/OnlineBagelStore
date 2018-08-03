<template>
    <div>
        <div class="text-center">
            <div class="title mb-4">
                {{ title }}
                <h1 class="mt-5">Contact us</h1>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        metaInfo () {
            return { title: this.$t('contact') }
        },

        data: () => ({
            title: ''
        }),

        computed: mapGetters({
            authenticated: 'auth/check'
        })
    }
</script>

<style scoped>
    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }

    .title {
        font-size: 85px;
    }
</style>
