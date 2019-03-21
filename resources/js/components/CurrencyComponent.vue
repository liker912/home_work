<template>
    <div class="col-md-4">
        <select class="form-control" @change="onChange($event)">
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
            },

            market: function () {
                return this.$store.state.currentMarket;
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
                        swal({
                            title: "Error #" + error.code,
                            text: error.message,
                            icon: "error",

                        });
                    })
            },

            onChange: function (event) {
                axios.get(/api/ + this.market.id + '/' + event.target.value)
                    .then(() => {
                        this.currencies.forEach((data) => {
                            if (data.id === parseInt(event.target.value)) {
                                this.$store.commit('setCurrentCurrency', data);
                            }
                        });
                    })
                    .catch((error) => {
                        swal({
                            title: "Error #" + error.code,
                            text: error.message,
                            icon: "error",

                        });
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
