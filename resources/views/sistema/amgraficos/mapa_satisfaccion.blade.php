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
            height: 97vh;
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
<script src="{{ URL::to('assets/js/libs/hcharts/maps/code/highmaps.js') }}"></script>
<script>
    $(function () {


        mapData = {!! $datos[0] !!};
        dataMap= {!! $datos[1] !!};
        label  = {!! $datos[2] !!};

        Highcharts.mapChart('container', {
            title : {
                text : 'Mapa de Satisfacción Comercial (Estados)'
            },
            subtitle : {
                text : '{!! $datos[5] !!} {!! 'al '.$datos[6] !!}  {!! $datos[3]  !!} {!! $datos[4] !!}'
            },

            mapNavigation: {
                enabled: true,
                buttonOptions: {
                    verticalAlign: 'top'
                }
            },
            legend: {
                title: {
                    text: 'Cantidad Distribuida:'
                },
                align: 'left',
                verticalAlign: 'bottom',
                floating: true,
                labelFormatter: function () {

                    var f=Highcharts.numberFormat(this.from,0, ',', '.');
                    if(typeof(this.to) === "undefined"){
                        var t='o Más'
                    }
                    else{
                        var t=Highcharts.numberFormat(this.to,0, ',', '.') ;
                    }

                    return (f) + ' - ' + (t);
                },
                layout: 'vertical',
                valueDecimals: 0,
                backgroundColor: 'rgba(255,255,255,0.9)',
                padding: 12,
                itemMarginTop: 0,
                itemMarginBottom: 0,
                symbolRadius: 0,
                symbolHeight: 14,
                symbolWidth: 24
            },

            colorAxis: {
                dataClasses: label
            },
            series:[{
                animation: { duration: 1000},
                data: mapData,
                mapData: dataMap,
                joinBy: ['id', 'id']
            }]
        });





    })
</script>
</body>
</html>