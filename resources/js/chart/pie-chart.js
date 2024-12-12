document.addEventListener('DOMContentLoaded', function () {
    let chartContainer = Highcharts.chart('pie-chart', {
        chart: {
            type: 'pie',
            custom: { totalData: 0 },
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

                    const totalData = chart.options.chart.custom.totalData || 0;
                    customLabel.attr({
                        text: `Total<br/><strong>${totalData}</strong>`
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
                },
                point: {
                    events: {
                        click: function () {
                            const clickedKotaId = this.kota_id;

                            // Trigger custom event
                            document.dispatchEvent(
                                new CustomEvent('pieChartClicked', {
                                    detail: { kota_id: clickedKotaId }
                                })
                            );
                        }
                    }
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

                if (chartContainer) {
                    chartContainer.options.chart.custom.totalData = total_data;
                }

                let titleText = 'Data Dasawisma';
                let subtitleText = 'Berdasarkan filter wilayah';

                if (chartContainer) {
                    chartContainer.setTitle({ text: titleText }, { text: subtitleText });
                }

                // **Konversi data dan tambahkan kota_id**
                const chartData = filtered_data.map(item => ({
                    name: item.nama_kota || 'Unknown',
                    y: parseInt(item.total, 10), // Pastikan total adalah angka
                    kota_id: item.kota_id // Tambahkan kota_id
                }));

                // Perbarui data series
                if (chartContainer && chartContainer.series[0]) {
                    chartContainer.series[0].setData(chartData);
                }
            })
            .catch(error => {
                console.error('Error fetching chart data:', error);
            });
    }

    let activeBarChartKotaId = null;
    let barChartInstance = null;

    document.addEventListener('pieChartClicked', function (event) {
        const { kota_id } = event.detail;

        if (activeBarChartKotaId === kota_id) {
            // Sembunyikan bar chart jika data yang sama diklik
            hideBarChart();
            activeBarChartKotaId = null;
        } else {
            // Tampilkan bar chart jika data baru diklik
            showBarChart(kota_id);
            activeBarChartKotaId = kota_id;
        }
    });

    updateChart();

    // Tampilkan bar chart berdasarkan kota_id yang dipilih
    function showBarChart(kotaId) {
        let url = `/bar-chart?kota_id=${kotaId}`;
        const barChartContainer = document.getElementById('bar-chart');
        barChartContainer.style.display = 'block';

        if (barChartInstance) {
            barChartInstance.destroy(); 
        }

        fetch(url)
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Error: ' + response.statusText);
                }
            })
            .then(result => {
                const { filtered_data, total_data, nama_kota } = result;

                const categories = filtered_data.map(item => item.nama_kecamatan || 'Unknown');
                const data = filtered_data.map(item => parseInt(item.total, 10));

                barChartInstance = Highcharts.chart('bar-chart', {
                    chart: {
                        type: 'column'
                    },
                    xAxis: { categories },
                    yAxis: { title: { text: 'Jumlah' } },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.y}</b>'
                    },
                    series: [
                        {
                            name: nama_kota,
                            data
                        }
                    ]
                });

                if (barChartInstance) {
                    barChartInstance.setTitle(
                        { text: `${nama_kota} Detail` },
                        { text: `Total: ${total_data}` }
                    );
                }

                console.log('Bar chart ditampilkan untuk kota_id:', kotaId);
            })
            .catch(error => {
                console.error('Error fetching data for bar chart:', error);
            });
    }

    function hideBarChart() {
        const barChartContainer = document.getElementById('bar-chart');
        barChartContainer.style.display = 'none';

        if (barChartInstance) {
            barChartInstance.destroy();
            barChartInstance = null;
        }
        console.log('Bar chart disembunyikan.');
    }
});