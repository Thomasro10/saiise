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
            height: 90vh;
           /* min-height: 200px;
            max-height: 600px;*/
            margin: 0 auto;
        }
    </style>

</head>
<body>
{{-- dd($result) --}}
<div id="container"></div>

<script src="{{ URL::to('assets/js/libs/jquery/jquery-1.11.2.min.js') }}"></script>
<script src="{{ URL::to('assets/js/libs/hcharts/maps/code/highcharts.js') }}"></script>
<script src="{{ URL::to('assets/js/libs/hcharts/maps/code/highcharts-3d.js') }}"></script>
<script src="{{ URL::to('assets/js/libs/hcharts/maps/code/modules/exporting.js') }}"></script>
<!--<script src="{{ URL::to('assets/js/libs/hcharts/maps/code/themes/grid-light.js') }}"></script>-->
<script>
    $(function () {
        /*Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
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
        });*/

// Build the chart
        Highcharts.chart('container', {
            chart: {
               /* plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,*/
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0
                }
            },
            title: {
                text: '@if(empty($result[2]['ttlo'])) GRÁFICO EMPRESAS @else {{ $result[2]['ttlo'] }}  @endif',
                style: {
                    fontSize: '12px',
                    fontWeight: 'bold'
                }
            },
            subtitle: {
                text: '<b>{!! $result[1]['titulo'] !!}</b>'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})'
            },
            /*legend:{
               align: 'right',
                verticalAlign:'middle',
                 width: 200,
                itemWidth: 50
            },*/
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    depth: 25,
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        //format: '<b>{point.name}</b>: {point.percentage:.1f} % '
                        @if($result[1]['titulo'] == 'FINANCIAMIENTO' || $result[1]['titulo'] == 'RECURSOS FINANCIEROS' )
                        format: '{point.y:,.2f}',
                        @else
                        format: '{point.y:,.0f}',
                        @endif
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>:  '+ this.point.y+"  (<b>"+ this.percentage.toFixed(2) + ' %</b>)';
                        },

                    },
                    connectorColor: 'silver',
                    showInLegend: true
                },
                series: {
                    colorByPoint: true
                }
            },
            series: [{
                name: 'Distribición',
                data: [{!!  implode(" , ",$result[0]['des']) !!}]
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        plotOptions: {
                            pie: {
                                dataLabels: {
                                    enabled: false
                                },
                                showInLegend: false,
                                size: 150
                            }
                        }
                    }
                }]
            }
        });

        Highcharts.setOptions(Highcharts.theme);
    })
</script>
</body>
</html>