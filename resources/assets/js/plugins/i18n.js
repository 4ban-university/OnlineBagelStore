import Vue from 'vue'
import store from '~/store'
import VueI18n from 'vue-i18n'
import { Validator } from 'vee-validate'
import axios from 'axios'

Vue.use(VueI18n)

const i18n = new VueI18n({
  locale: 'en',
  messages: {}
})

/**
 * @param {String} locale
 */
export async function loadMessages (locale) {
  if (Object.keys(i18n.getLocaleMessage(locale)).length === 0) {
      console.log('first import')
    await import(/* webpackChunkName: "lang-[request]" */ `~/lang/${locale}`).then(messages => {
        axios.get(`/api/locale/${locale}`)
            .then(response => {
                let additionalMessages = response.data
                let finalMessages = Object.assign(messages, additionalMessages);
                i18n.setLocaleMessage(locale, finalMessages)
                i18n.locale = locale
            })
    })

    import(`vee-validate/dist/locale/${locale}.js`).then(localeName => {
        Validator.localize(locale, localeName)
    });
  } else {
      i18n.locale = locale
      Validator.localize(locale)
  }
}

(async function () {
  await loadMessages(store.getters['lang/locale'])
})()

export default i18n
