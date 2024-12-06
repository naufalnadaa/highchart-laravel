document.addEventListener('DOMContentLoaded', function () {
    let chartContainer = Highcharts.chart('bar-chart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Dasawisma Detail'
        },
        subtitle: {
            text: 'Jakarta Timur'
        },
        xAxis: {
            categories: [],
            crosshair: true,
            accessibility: {
                description: 'Cities'
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
        series: [{
            name: 'Jumlah Data',
            data: []
        }]
    });

    // Fetch data and update chart
    function updateChart() {
        let url = '/bar-chart';

        fetch(url)
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Error: ' + response.statusText);
                }
            })
            .then(result => {
                const { filtered_data, total_data } = result;

                // Extract categories and data
                const categories = filtered_data.map(item => item.nama_kota);
                const data = filtered_data.map(item => parseInt(item.total, 10));

                // Update chart categories and series data
                chartContainer.xAxis[0].setCategories(categories);
                chartContainer.series[0].setData(data);

                // Update chart title with total data
                chartContainer.setTitle(
                    { text: 'Dasawisma Detail' },
                    { text: `Total: ${total_data}` }
                );
            })
            .catch(error => {
                console.error('Error fetching chart data:', error);
            });
    }

    // Call the function to update chart on load
    updateChart();
});