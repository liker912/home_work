<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table class="table-striped" v-if="results">
                    <thead>
                    <th>Crypto</th>
                    <th>Value</th>
                    </thead>
                    <tbody>
                    <tr v-for="result in results.result.values">
                        <td>{{result.crypto_currency_code}}</td>
                        <td>{{result.price_value}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ResultComponent",

        computed: {
            results: function () {
                return this.$store.state.results;
            },

            link: function () {
                return '/api/' + this.market.id + '/' + this.currency.id
            },

            market: function () {
                return this.$store.state.currentMarket;
            },

            currency: function () {
                return this.$store.state.currentCurrency;
            }
        },

        methods: {
            getResult: function () {
                axios.get(this.link);
            }
        },

        mounted() {
            this.getResult();
            window.Echo.channel('resultChannel').listen('ResultSent', (response) => {
                this.$store.commit('setResults', response);

            });
        }
    }
</script>

<style scoped>

</style>