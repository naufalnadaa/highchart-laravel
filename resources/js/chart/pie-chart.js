document.addEventListener('DOMContentLoaded', function () {
    let chartContainer = Highcharts.chart('pie-chart', {
        chart: {
            type: 'pie',
            custom: { totalData: 0 }, // Tambahkan custom property untuk menyimpan total
            events: {
                render() {
                    const chart = this,
                        series = chart.series[0];
                    let customLabel = chart.options.chart.custom.label;

                    if (!customLabel) {
                        customLabel = chart.options.chart.custom.label =
                            chart.renderer.label(
                                'Total<br/><strong>0</strong>'
                            )
                                .css({
                                    color: '#000',
                                    textAnchor: 'middle'
                                })
                                .add();
                    }

                    // Update total dynamically
                    const totalData = chart.options.chart.custom.totalData || 0;
                    customLabel.attr({
                        text: `Total<br/><strong>${totalData}</strong>` // Update total
                    });

                    const x = series.center[0] + chart.plotLeft,
                        y = series.center[1] + chart.plotTop - (customLabel.attr('height') / 2);

                    customLabel.attr({ x, y });

                    customLabel.css({
                        fontSize: `${series.center[2] / 12}px`
                    });
                }
            }
        },
        title: { text: 'Total Data Dasawisma' },
        subtitle: { text: 'Berdasarkan Kota' },
        tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.0f}%</b>' },
        legend: { enabled: false },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: <b>{point.percentage:.0f}%<b>'
                }
            }
        },
        series: [{
            name: '',
            colorByPoint: true,
            innerSize: '75%',
            data: []
        }]
    });


    updateChart();

    function updateChart() {
        let url = '/pie-chart';

        console.log('Fetching data from:', url);

        fetch(url)
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
            })
            .then(result => {
                const { total_data, filtered_data } = result;

                // Update total in chart options
                if (chartContainer) {
                    chartContainer.options.chart.custom.totalData = total_data;
                }

                let titleText = 'Data Dasawisma';
                let subtitleText = 'Berdasarkan filter wilayah';

                if (chartContainer) {
                    chartContainer.setTitle({ text: titleText }, { text: subtitleText });
                }

                // Format data for chart (convert total to numbers)
                const chartData = filtered_data.map(item => ({
                    name: item.nama_kota || item.nama_kecamatan || item.nama_kelurahan,
                    y: parseInt(item.total, 10) // Ensure total is a number
                }));

                // Update chart data
                if (chartContainer && chartContainer.series[0]) {
                    chartContainer.series[0].setData(chartData);
                }
            })
            .catch(error => {
                console.error('Error fetching chart data:', error);
            });
    }
});