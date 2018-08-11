import Vue from 'vue'
import store from '~/store'
import VueI18n from 'vue-i18n'
import { Validator } from 'vee-validate';

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
    const messages = await import(/* webpackChunkName: "lang-[request]" */ `~/lang/${locale}`)
    i18n.setLocaleMessage(locale, messages)

    import(`vee-validate/dist/locale/${locale}.js`).then(localeName => {
        Validator.localize(locale, localeName)
    });
  }

  if (i18n.locale !== locale) {
    i18n.locale = locale
    Validator.localize(locale)
  }
}

(async function () {
  await loadMessages(store.getters['lang/locale'])
})()

export default i18n
