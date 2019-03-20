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
        data: function () {
            return {
                markets: []
            }
        },

        methods: {
            getCurrencies: function () {
                axios.get('/api/markets');
            }
        },

        mounted() {
            this.getCurrencies();

            window.Echo.channel('marketChannel').listen('MarketsSent', (response) => {
                this.markets = response.markets;
            });
        }
    }
</script>

<style>
    select{
        font-size: 16px;
    }
</style>
