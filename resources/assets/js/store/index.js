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
    all: []
}

// getters
const getters = {
    allProducts: state => state.all,
    getNumberOfProducts: state => (state.all) ? state.all.length : 0,
    cartProducts: state => {
        return state.added.map(({ id, quantity }) => {
            const product = state.all.find(p => p.id === id)

            return {
                name: product.title,
                price: product.price,
                quantity
            }
        })
    }
}

// actions
const actions = {
    addToCart({ commit }, product){
        commit(types.ADD_TO_CART, {
            id: product.id,
        })
    },
    updateProducts({ commit }, products){
        commit(types.ADD_PRODUCTS, {
            products: products,
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
                quantity: 1
            })
        } else {
            record.quantity++
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