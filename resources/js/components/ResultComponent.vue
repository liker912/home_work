<template>
    <div class="col-md-12 h-100">
        <div class="row justify-content-center h-100">
            <div class="col-md-6" v-if="results">
                <table class="table table-striped w-100 h-100">
                    <thead>
                    <th>Crypto</th>
                    <th>Value</th>
                    <th>Currency</th>
                    </thead>
                    <tbody>
                    <tr v-for="result in results.result.values">
                        <td>{{result.crypto_currency_code}}</td>
                        <td>{{result.price_value}}</td>
                        <td>{{results.result.currency_from}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <canvas id="myChart" width="200" height="200"></canvas>
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

                var ctx = document.getElementById('myChart');
                var leabels = [];
                var datas = [];

                this.results.result.values.forEach((data) => {
                    leabels.push(data.crypto_currency_code);
                    datas.push(data.price_value);
                });
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: leabels,
                        datasets: [{
                            label: 'from ' + this.market.name + ' for ' + this.currency.code,
                            data: datas,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });

            });
        }
    }
</script>

<style scoped>

</style>