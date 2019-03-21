import Echo from "laravel-echo";

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Vuex = require('vuex');

Vue.use(Vuex);


/**
 * Vuex store
 */

const store = new Vuex.Store({
    state: {
        markets: [],
        currencies:[],
        currentMarket: null,
        currentCurrency: null,
        results: null,
    },

    mutations: {
        setMarkets(state, markets) {
            state.markets = markets;
        },

        setCurrencies(state, currencies) {
            state.currencies = currencies
        },

        setCurrentMarket(state, currentMarket) {
            state.currentMarket = currentMarket;
        },

        setCurrentCurrency(state, currentCurrency) {
            state.currentCurrency = currentCurrency;
        },

        setResults(state, results) {
            state.results = results;
        },
    },
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/CurrencyComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('currency-component', require('./components/CurrencyComponent.vue').default);
Vue.component('market-component', require('./components/MarketComponent.vue').default);
Vue.component('result-component', require('./components/ResultComponent.vue').default);
Vue.component('main-component', require('./components/MainComponent.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#currency-app',
    store,

    created() {
        window.Echo.channel('errorChannel').listen('ErrorSent', (errors) => {
            console.log('errorChanel', errors);
        })
    }
});

