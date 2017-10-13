
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

        Highcharts.chart('container', {
            chart: {
                type: '{{ $result[3]['type'] }}',
                options3d: {
                    enabled: true,
                    @if($result[3]['type'] == 'column')
                    alpha: 12,
                    beta: 15,
                    @else
                    alpha: 2,
                    beta: 5,
                    @endif
                    depth: 80
                }
            },
            title: {
                text: ' {{ $result[2]['titulo'] }}',
                style: {
                    fontSize: '12px',
                    fontWeight: 'bold'
                }
            },
            xAxis: {
                categories: [
                        @for($i = 0; $i < count($result[1]['cat']); $i++)
                          '{{ $result[1]['cat'][$i]  }}',
                        @endfor
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Cantidad'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y} </b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                @if($result[3]['type'] == 'column')
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    depth: 25,
                    dataLabels: {
                        enabled: true,
                    }
                },
                @else
                bar: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    depth: 25,
                    dataLabels: {
                        enabled: true,
                        x: 30
                    }
                },
                @endif
                series: {
                    colorByPoint: true
                }
            },
            series: [{ name : 'EMPRESAS', data : [{!!  implode(" , ",$result[0]['des']) !!}] }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500//,
                       // maxHeight: 300
                    },
                    chartOptions: {
                        /*legend: {
                            align: 'center',
                            verticalAlign: 'bottom',
                            layout: 'horizontal'
                        },*/
                        legend: {
                            enabled: false
                        },
                        yAxis: {
                            labels: {
                                align: 'left',
                                x: 0,
                                y: -5
                            },
                            title: {
                                text: null
                            }
                        },
                        xAxis: {
                            categories: [''],
                            title: {
                                text: null
                            },
                            labels: {
                                enabled:false,
                                y : 20, rotation: -45, align: 'right'
                            }

                        },
                        subtitle: {
                            text: null
                        },
                        credits: {
                            enabled: false
                        },
                        @if($result[3]['type'] == 'column')
                        plotOptions: {
                            column: {
                                dataLabels: {
                                    enabled: false
                                }
                            }
                        }
                        @else
                        plotOptions: {
                            bar: {
                                dataLabels: {
                                    enabled: false
                                }
                            }
                        }
                        @endif
                    }
                }]
            }
        });
    })
</script>
</body>
</html>