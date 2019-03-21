<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <select>
                        <option v-for="market in markets" :value="market.id">{{market.name}}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "MarketComponent",

        computed: {
            markets: function () {
                return this.$store.state.markets;
            }
        },

        methods: {
            getMarkets: function () {
                axios.get('/api/markets')
                    .then((response) => {
                        this.$store.commit('setMarkets', response.data.data);
                        this.$store.commit('setCurrentMarket', this.currencies[0]);
                    })
                    .catch((error) => {

                    })
            }
        },

        mounted() {
            this.getMarkets();

            window.Echo.channel('marketChannel').listen('MarketsSent', (response) => {
                this.$store.commit('setMarkets', response.markets);
            });
        }
    }
</script>

<style>
    select {
        font-size: 16px;
    }
</style>
