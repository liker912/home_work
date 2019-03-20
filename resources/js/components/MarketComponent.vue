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
                axios.get('/api/markets');
            }
        },

        mounted() {
            this.getMarkets();

            window.Echo.channel('marketChannel').listen('MarketsSent', (response) => {
                this.$store.commit('setMarkets', response.markets);

                if (!this.$store.state.currentMarket) {
                    this.$store.commit('setCurrentMarket', this.markets[0]);
                }

                console.log("currentMarket", this.$store.state.currentMarket);
            });
        }
    }
</script>

<style>
    select{
        font-size: 16px;
    }
</style>
