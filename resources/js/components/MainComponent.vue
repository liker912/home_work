<template>
    <div class="container-fluid">
        <div class="row justify-content-center mb-3">
            <market-component></market-component>
            <currency-component></currency-component>
        </div>
        <div class="row justify-content-center">
            <result-component v-if="market && currency"></result-component>
        </div>
    </div>
</template>

<script>
    export default {
        name: "MainComponent",

        data: function () {
            return {
                currentMarket: null,
                currentCurrency: null
            }
        },

        computed: {
            market: {
                set: function (currentMarket) {
                    this.currentMarket = currentMarket;
                },
                get: function () {
                    return this.currentMarket;
                },
            },

            currency: {
                set: function (currentCurrency) {
                    return this.currentCurrency = currentCurrency;
                },

                get: function () {
                    return this.currentCurrency;
                }
            }
        },

        mounted() {
            this.$store.watch(
                () => {
                    return this.$store.state.currentMarket // could also put a Getter here
                },
                (newValue) => {
                    this.market = newValue;
                });

            this.$store.watch(
                () => {
                    return this.$store.state.currentCurrency // could also put a Getter here
                },
                (newValue) => {
                    this.currency = newValue;
                })
        }
    }
</script>

<style>
    body {
        padding: 5%;
    }
</style>