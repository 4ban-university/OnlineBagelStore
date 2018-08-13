<template>
    <div>
        <div class="text-center">
            <div class="title mb-4">
                {{ title }}
            </div>
            <div>
                <h1 class="mt-5">{{ $t('contact_us') }}</h1>
                <p>{{ $t('contact_us_email') }} <a href="mailto:ieat@poupa.fr">ieat@poupa.fr</a></p>
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
