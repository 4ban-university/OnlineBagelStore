import Vue from 'vue'
import Vuex from 'vuex'
import * as types from './mutation-types'

Vue.use(Vuex)

// Load store modules dynamically.
const requireContext = require.context('./modules', false, /.*\.js$/)

const modules = requireContext.keys()
  .map(file =>
    [file.replace(/(^.\/)|(\.js$)/g, ''), requireContext(file)]
  )
  .reduce((modules, [name, module]) => {
    if (module.namespaced === undefined) {
      module.namespaced = true
    }

    return { ...modules, [name]: module }
  }, {})

const debug = process.env.NODE_ENV !== 'production'

// initial state
const state = {
    added: [],
    all: [],
    price: 0,
    reduction: 0,
    infoPageAlreadyLoaded: false,
    details: {
        name: '',
        lastname: '',
        email: '',
        phone: '+1',
        isPickup: true,
        street_name: '',
        postcode: '',
        city: 'Montreal',
        street_number: '',
        apartment: '',
        province: 'QC'
    },
    coupon: ''
}

function getCartProducts(state) {
    return state.added.map(({ id, quantity }) => {
        const product = state.all.find(p => p.id === id)

        return {
            id: product.id,
            price: product.price,
            type: product.type,
            quantity
        }
    })
}

// getters
const getters = {
    allProducts: state => state.all,
    getNumberOfProducts: state => (state.all) ? state.all.length : 0,
    cartProducts: state => {
        return getCartProducts(state)
    },
    price: state => state.price,
    coupon: state => state.coupon,
    details: state => state.details,
    infoPageAlreadyLoaded: state => state.infoPageAlreadyLoaded,
    toppings: (state) => (id) => {
        const product = state.added.find(p => p.id === id)
        return product.toppings
    }
}

// actions
const actions = {
    addToCart({ commit }, product){
        commit(types.ADD_TO_CART, {
            id: product.id,
        })
        commit(types.UPDATE_PRICE)
    },
    removeFromCart({ commit }, product){
        commit(types.REMOVE_FROM_CART, {
            id: product.id,
        })
        commit(types.UPDATE_PRICE)
    },
    addTopping({ commit }, [product_id, topping]){
        commit(types.ADD_TOPPING, {
            id: product_id,
            topping: topping,
        })
    },
    removeTopping({ commit }, [product_id, topping]){
        commit(types.REMOVE_TOPPING, {
            id: product_id,
            topping: topping,
        })
    },
    updateProducts({ commit }, products){
        commit(types.ADD_PRODUCTS, {
            products: products,
        })
    },
    updatePrice({ commit }){
        commit(types.UPDATE_PRICE)
    },
    applyReduction({ commit }, [reduction, coupon]){
        commit(types.ADD_REDUCTION, {
            reduction: reduction,
            coupon: coupon,
        })
        commit(types.UPDATE_PRICE)
    },
    infoPageLoaded({ commit }){
        commit(types.INFO_PAGE_LOADED)
    },
    saveForm({ commit }, form){
        commit(types.SAVE_FORM, {
            form: form
        })
    }
}

// mutations
const mutations = {
    [types.ADD_TO_CART] (state, { id }) {
        const record = state.added.find(p => p.id === id)

        if (!record) {
            state.added.push({
                id,
                quantity: 1,
                toppings: []
            })
        } else {
            record.quantity++
        }
    },
    [types.REMOVE_FROM_CART] (state, { id }) {
        const record = state.added.find(p => p.id === id)

        if (record) {
            record.quantity--
        }

        if (record.quantity === 0) {
            state.added = state.added.filter(p => p.id !== id)
        }
    },
    [types.ADD_PRODUCTS] (state, { products }) {
        state.all = []
        for (let i = 0; i < products.length; i++) {
            let product = {
                id: products[i].id,
                price: products[i].price,
                type: products[i].type
            }
            state.all.push(product)
        }
    },
    [types.ADD_TOPPING] (state, { id, topping }) {
        const product = state.added.find(p => p.id === id)
        product.toppings.push(topping)
    },
    [types.REMOVE_TOPPING] (state, { id, topping }) {
        const product = state.added.find(p => p.id === id)
        product.toppings = product.toppings.filter(t => t.code !== topping.code)
    },
    [types.ADD_REDUCTION] (state, { reduction, coupon }) {
        state.reduction = reduction
        state.coupon = coupon
    },
    [types.UPDATE_PRICE] (state) {
        let originalPrice = getCartProducts(state).reduce((total, p) => {
            return total + p.price * p.quantity
        }, 0)
        let num = Number(originalPrice - (state.reduction / 100) * originalPrice)
        state.price = num.toFixed(2)
    },
    [types.INFO_PAGE_LOADED] (state) {
        state.infoPageAlreadyLoaded = true
    },
    [types.SAVE_FORM] (state, { form }) {
        Object.keys(form).forEach(key => {
            state.details[key] = form[key]
        })
    }
}

// one store for entire application
export default new Vuex.Store({
    modules,
    state,
    strict: debug,
    getters,
    actions,
    mutations
})