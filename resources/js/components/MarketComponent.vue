<template>
    <div class="col-md-4">
        <select class="form-control">f
            <option v-for="market in markets" :value="market.id">{{market.name}}</option>
        </select>
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
                        this.$store.commit('setCurrentMarket', this.markets[0]);
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
