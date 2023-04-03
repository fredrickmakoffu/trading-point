<template>
    <div>
        <canvas id="chart1"></canvas>
    </div>
</template>

<script>
export default {
    name: 'ChartComponent',
    props: {
        data: {
            required: true,
            type: Array
        }
    },
    mounted() {
        this.createChart()
    },
    methods: {
        createChart() {
            const ctx = document.getElementById('chart1').getContext('2d')

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                    datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                    y: {
                        beginAtZero: true
                    }
                    }
                }
            });
        }
    }
}
</script>