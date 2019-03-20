<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <select>
                        <option v-for="currency in currencies" :value="currency.id">{{currency.code}}</option>
                    </select>
                </div>
            </div>
        </div>
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
                axios.get('/api/currencies');
            }
        },

        mounted() {
            this.getCurrencies();
            
            window.Echo.channel('currencyChannel')
                .listen('CurrenciesSent', (response) => {
                    this.$store.commit('setCurrencies', response.currencies);
                    console.log(this.$store.state.currencies)

                    if (!this.$store.state.currentCurrency) {
                        this.$store.commit('setCurrentCurrency', this.currencies[0]);
                    }

                    console.log("currentCurrency", this.$store.state.currentCurrency);
                });
        }
    }
</script>

<style>
    select {
        font-size: 16px;
    }
</style>
