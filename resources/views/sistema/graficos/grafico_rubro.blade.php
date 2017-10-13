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
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Monitoreo {{ $result[7]->rubro }} ({{ $result[8] }}) {!! $result[5]['fecha'] !!}'
            },
            subtitle: {
                text: 'Total de comercios visitados <b>{!! $result[6]['cvi'] !!}</b>'
            },
            xAxis: {
                categories: [ '{!!  implode("' , '",$result[0]['cat']) !!}' ],
                crosshair: true,
                labels: {
                    rotation: -65,
                    align: 'right',
                    style: {
                        fontSize: '8px',
                        fontFamily: 'Arial, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Cantidad '
                },
                labels: {
                    formatter: function(){
                        if (this.value > 999999) {
                            return (Math.abs(this.value) / 1000000) + ' MM';
                        }
                        else{
                            if (this.value >999 ) {
                                return (Math.abs(this.value) / 1000) + ' M';
                            }
                            else{
                                return this.value
                            }
                        }
                    }
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Recibido',
                data: [{!!  implode(" , ",$result[1]['rec']) !!}]

            }, {
                name: 'Disponible',
                data: [{!!  implode(" , ",$result[2]['dis']) !!}]

            }, {
                name: 'Venta detal',
                data: [{!!  implode(" , ",$result[3]['vde']) !!}]

            }, {
                name: 'Venta mayor',
                data: [{!!  implode(" , ",$result[4]['vma']) !!}]

            }]
        });
    })
</script>
</body>
</html>