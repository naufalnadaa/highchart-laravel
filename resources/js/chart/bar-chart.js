document.addEventListener('DOMContentLoaded', function () {
    let chartContainer = Highcharts.chart('bar-chart', {
        chart: {
            type: 'column'
        },
        xAxis: {
            categories: [],
            crosshair: true,
            accessibility: {
                description: 'Kecamatan'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Total'
            }
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [
            {
                name: '',
                data: [],
            },
        ]
    });

    function updateChart(kotaId) {
        let url = `/bar-chart?kota_id=${kotaId}`;
    
        fetch(url)
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Error: ' + response.statusText);
                }
            })
    }
    // Listen for custom event from pie chart
    document.addEventListener('pieChartClicked', function (event) {
        const { kota_id } = event.detail;
    
        const chartResult = document.getElementById('chart-result');
        // chartResult.hidden = false;
    
        updateChart(kota_id); // Pass kota_id to updateChart
    });
});