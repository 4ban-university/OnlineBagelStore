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
    coupon: ''
}

function getCartProducts(state) {
    return state.added.map(({ id, quantity }) => {
        const product = state.all.find(p => p.id === id)

        return {
            id: product.id,
            name: product.title,
            price: product.price,
            calories: product.calories,
            description: product.description,
            image: product.image,
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
    coupon: state => state.coupon
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
}

// mutations
const mutations = {
    [types.ADD_TO_CART] (state, { id }) {
        const record = state.added.find(p => p.id === id)

        if (!record) {
            state.added.push({
                id,
                quantity: 1
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
        for (var i = 0; i < products.length; i++) {
            var product = {
                id: products[i].id,
                title: products[i].title,
                price: products[i].price,
                calories: products[i].calories,
                description: products[i].description,
                image: products[i].image
            }
            state.all.push(product)
        }
    },
    [types.ADD_REDUCTION] (state, { reduction, coupon }) {
        state.reduction = reduction
        state.coupon = coupon
    },
    [types.UPDATE_PRICE] (state) {
        var originalPrice = getCartProducts(state).reduce((total, p) => {
            return total + p.price * p.quantity
        }, 0)
        var num = Number(originalPrice - (state.reduction / 100) * originalPrice)
        state.price = num.toFixed(2)
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