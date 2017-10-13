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

        Highcharts.setOptions({
            colors: [{!! substr($result[2], 0, -1) !!}]
        });


        Highcharts.chart('container', {

            title: {
                text: 'Produccion {!! $result[4] !!}',
                x: -20
            },

            subtitle: {
                text: 'A nivel nacional ({!! $result[3] !!})',
                x: -20
            },
            xAxis: {
                categories: [{!! join($result[1]['cat'], ',') !!}],
                labels: {
                    rotation: -90,
                    align: 'right',
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
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
                        valueSuffix: ''
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
            },
            series: [{!! implode(" , ",$result[0]['series']) !!}]

        });

    })
</script>
</body>
</html>