<template>
    <div class="col-md-4">
        <select class="form-control">
            <option v-for="currency in currencies" :value="currency.id">{{currency.code}}</option>
        </select>
    </div>
</template>

<script>
    export default {
        name: "CurrencyComponent",

        computed: {
            currencies: function () {
                return this.$store.state.currencies;
            }
        },

        methods: {
            getCurrencies: function () {
                axios.get('/api/currencies')
                    .then((response) => {
                        this.$store.commit('setCurrencies', response.data.data);
                        this.$store.commit('setCurrentCurrency', this.currencies[0]);
                    })
                    .catch((error) => {

                    })
            }
        },

        mounted() {
            this.getCurrencies();

            window.Echo.channel('currencyChannel')
                .listen('CurrenciesSent', (response) => {
                    this.$store.commit('setCurrencies', response.currencies);
                });
        }
    }
</script>

<style>
    select {
        font-size: 16px;
    }
</style>
