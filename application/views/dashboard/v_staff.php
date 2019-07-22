<?php
if ($rataSKP['rata'] >= 91) {
    $ket = 'Sangat Baik';
} elseif ($rataSKP['rata'] >= 76) {
    $ket = 'Baik';
} elseif ($rataSKP['rata'] >= 61) {
    $ket = 'Cukup';
} elseif ($rataSKP['rata'] >= 51) {
    $ket = 'Kurang';
} else {
    $ket = 'Buruk';
}
?>
<style>
    .breadcrumb a {
        color:#002a80 !important;
    }
</style>
<script type="text/javascript">
    $(function () {
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },

            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des',
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            }, dataLabels: {
                enabled: true,
                rotation: 0,
                color: '#000000',
                backgroundColor: '#FFFFFF',
                align: 'center',
                x: 4,
                y: 0,
                style: {
                    fontSize: '10px',
                    fontFamily: 'Verdana, sans-serif'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            }, credits: {
                enabled: false
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0, dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [{
                    name: 'SKP', color: '#0066FF',
                    data: [<?= $data_skp ?>]

                }, {
                    name: 'Tugas Tambahan', color: '#FF0000',
                    data: [<?= $data_tugas ?>]

                }, {
                    name: 'Non SKP', color: '#007d3d',
                    data: [<?= $data_prod ?>]

                }]
        });
    });

    Highcharts.chart('container2', {

        chart: {
            type: 'gauge',
            plotBackgroundColor: null,
            plotBackgroundImage: null,
            plotBorderWidth: 0,
            plotShadow: false
        },

        title: {
            text: ''
        }, credits: {
            enabled: false
        },

        pane: {
            startAngle: -90,
            endAngle: 90,
            background: [{
                    backgroundColor: {
                        linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                        stops: [
                            [0, '#FFF'],
                            [1, '#333']
                        ]
                    },
                    borderWidth: 0, shape: 'arc',
                    outerRadius: '109%'
                }, {
                    backgroundColor: {
                        linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                        stops: [
                            [0, '#333'],
                            [1, '#FFF']
                        ]
                    },
                    borderWidth: 1, shape: 'arc',
                    outerRadius: '107%'
                }, {
                    shape: 'arc', borderWidth: 1
                }, {
                    backgroundColor: '#DDD',
                    borderWidth: 0, shape: 'arc',
                    outerRadius: '105%',
                    innerRadius: '103%'
                }]
        },

        // the value axis
        yAxis: {
            min: 0,
            max: 100,
            innerRadius: '75%',
            minorTickInterval: 'auto',
            minorTickWidth: 1,
            minorTickLength: 10,
            minorTickPosition: 'inside',
            minorTickColor: '#666',

            tickPixelInterval: 30,
            tickWidth: 5,
            tickPosition: 'inside',
            tickLength: 10,
            tickColor: '#666',
            labels: {
                step: 2,
                rotation: 'auto'
            },
            title: {
                text: '<?= $ket ?>'
            },
            plotBands: [{
                    from: 0,
                    to: 50,
                    color: '#b70100', text: "tes" // green
                }, {
                    from: 51,
                    to: 60,
                    color: '#e3861c' // yellow
                }, {
                    from: 61,
                    to: 75,
                    color: '#fcf157' // red
                }, {
                    from: 76,
                    to: 90,
                    color: '#49c259' // red
                }, {
                    from: 91,
                    to: 100,
                    color: '#007237' // red
                }]
        },

        series: [{
                name: 'Nilai',
                data: [<?= number_format($rataSKP['rata'],2) ?>],
                tooltip: {
                    valueSuffix: ''
                }
            }]

    });
</script>
<div style="height:200px;">
    <ol class="breadcrumb bc-2" style="margin-top:-30px;">
        <li>
            <a href="javascript:void(0">
                <i class="glyphicon glyphicon-home"></i>
                Dashboard
            </a>
        </li>
        <li><a href="javascript:void(0)">User</a></li>
    </ol>
    <div class="row" style="padding-bottom:-200px;">
        <div class="col-md-6" style="text-align: center;font-weight: bold;">
            JANUARI - DESEMBER <?= date('Y') ?>
            <div id="container" style="min-width: 310px; height: 250px; margin: 0 auto;margin-left:120px;"></div>
        </div>
        <div class="col-md-6" style="text-align: center;font-weight: bold;margin-bottom: -200px;">
            RATA-RATA KUALITAS TAHUN <?= date('Y') ?>
            <div id="container2" style="min-width: 310px; height:450px; margin: 0 auto"></div>
        </div>
    </div>
</div>