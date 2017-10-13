<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/js/libs/hcharts/maps/code/css/highcharts.css') }}" />
    <style>
        #container{
            width: 100%;
            height: 100%;
            min-width: 550px ;
            min-height: 400px ;
            margin: 0 auto;
        }
    </style>

</head>
<body>
{{-- dd($result) --}}
<div id="container"></div>

<script src="{{ URL::to('assets/js/libs/jquery/jquery-1.11.2.min.js') }}"></script>
<script src="{{ URL::to('assets/js/libs/hcharts/maps/code/highcharts.js') }}"></script>
<script>
    $(function () {
        Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
            return {
                radialGradient: {
                    cx: 0.5,
                    cy: 0.3,
                    r: 0.7
                },
                stops: [
                    [0, color],
                    [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                ]
            };
        });

// Build the chart
        Highcharts.chart('container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'TOTAL DE {{ $result[3]->rubro }} DISTRIBUIDO POR PROVEEDOR A NIVEL NACIONAL {!! $result[1]['fecha'] !!}'
            },
            subtitle: {
                text: 'Total de comercios visitados <b>{!! $result[2]['cvi'] !!}</b>'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        //format: '<b>{point.name}</b>: {point.percentage:.1f} % '
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>:  '+ this.point.y+"  (<b>"+ this.percentage.toFixed(2) + ' %</b>)';
                        },

                    },
                    connectorColor: 'silver',
                    showInLegend: true
                }
            },
            series: [{
                name: 'Distribición',
                data: [{!!  implode(" , ",$result[0]['des']) !!}]
            }]
        });
    })
</script>
</body>
</html>