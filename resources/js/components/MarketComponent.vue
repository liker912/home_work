<template>
    <div class="col-md-4">
        <select class="form-control" @change="onChange($event)">
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
            },

            currency: function () {
                return this.$store.state.currentCurrency;
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
                        swal({
                            title: "Error #" + error.code,
                            text: error.message,
                            icon: "error",

                        });
                    })
            },

            onChange(event) {
                axios.get(/api/ + event.target.value + '/' + this.currency.id)
                    .then(() => {
                        this.markets.forEach((data) => {
                            if (data.id === parseInt(event.target.value)) {
                                console.log("DDD");
                                this.$store.commit('setCurrentMarket', data);
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
