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
            const open = this.data.map(item => item.open)
            const close = this.data.map(item => item.close)
            const labels = this.data.map(item => new Date(item.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }))
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Open Price',
                            data: open,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Close Price',
                            data: close,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }
                    ],
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