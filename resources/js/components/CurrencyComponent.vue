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
        data: function () {
            return {
                currencies: [],
                markets: []
            }
        },

        methods: {
            getCurrencies: function () {
                axios.get('/api/currencies');
            }
        },

        mounted() {
            this.getCurrencies();

            window.Echo.channel('currencyChannel').listen('CurrenciesSent', (response) => {
                this.currencies = response.currencies;
            });
        }
    }
</script>

<style>
    select{
        font-size: 16px;
    }
</style>
