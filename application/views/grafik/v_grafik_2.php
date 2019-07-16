
<script type="text/javascript">
    $(function () {
       Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: '<?=$judul?>'
    },

    xAxis: {
        categories: [
            'Auditor',
            'Assesor',
            'Analis'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: ''
        }
    },dataLabels: {
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
        name: 'Jumlah',color: '#0066FF',
        data: [<?=$jumlah['jumlah_auditor'].','.$jumlah['jumlah_assesor'].','.$jumlah['jumlah_analis']?>]

    }, {
        name: 'Kebutuhan', color: '#FF0000',
        data: [<?=$kebutuhan['kebutuhan_auditor'].','.$kebutuhan['kebutuhan_assesor'].','.$kebutuhan['kebutuhan_analis']?>]

    }]
});
    });

</script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>