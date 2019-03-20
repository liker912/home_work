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
                console.log(this.$store.state.markets);
            });
        }
    }
</script>

<style>
    select{
        font-size: 16px;
    }
</style>
