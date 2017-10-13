<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/js/libs/hcharts/maps/code/css/highcharts.css') }}" />
    <link rel="stylesheet" href="{{ URL::to('assets/js/libs/amcharts/plugins/export/export.css') }}" type="text/css" media="all" />
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

<script src="{{ URL::to('assets/js/libs/amcharts/amcharts.js') }}"></script>
<script src="{{ URL::to('assets/js/libs/amcharts/pie.js') }}"></script>

<script src="{{ URL::to('assets/js/libs/amcharts/plugins/responsive/responsive.min.js') }}"></script>
<script src="{{ URL::to('assets/js/libs/amcharts/plugins/export/export.min.js') }}"></script>
<script src="{{ URL::to('assets/js/libs/amcharts/themes/light.js') }}"></script>

<script>
    var chart = AmCharts.makeChart( "container", {
        "type": "pie",
        "theme": "light",
        "fontSize": 14,
        "creditsPosition":"bottom-right",
        "labelRadius": 55,
        "gradientRatio": [0.8,0], //[-0.4, -0.4, -0.4, -0.4, -0.4, -0.4, 0, 0.1, 0.2, 0.1, 0, -0.2, -0.5]
        "outlineColor": "",
        "decimalSeparator": ",",
        "thousandsSeparator": ".",
        "startDuration":0.3,
        "titles": [{
            "text": "@if(empty($result[2]['ttlo'])) GRÁFICO EMPRESAS @else {{ $result[2]['ttlo'] }}  @endif",
            "size": 14
        }, {
            "text": "{!! $result[1]['titulo'] !!}",
            "bold": false,
            "size": 12
        }],
        "dataProvider": [ {!!  implode(" , ",$result[0]['des']) !!} ],
        "colorField": "color",
        "labelColorField": "color",
        "balloon": {
            "fixedPosition": true
        },
        "hoverAlpha": 0.8,
        "labelText": "@if(!empty($result[3]['cnd'])) [[title]]: [[percents]]% @else [[title]]: [[value]]  @endif",
        "valueField": "y",
        "titleField": "name",
        "pulledField": "pulled",
        "outlineAlpha": 0.4,
        "depth3D": 25,
        "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
        "angle": 10,
        "export": {
            "enabled": true
        },
        "responsive": {
            "enabled": true,
            "rules": [
                {
                    "maxWidth": 500,
                    "overrides": {
                        "titles": [{
                            "size": 10
                        }, {
                            "size": 8
                        }],
                        "legend": {
                            "enabled": false
                        },
                        'labelsEnabled' : false,
                        "depth3D": 10,
                    }
                }, {
                    "maxHeight": 500,
                    "overrides": {
                        "titles": [{
                            "size": 10
                        }, {
                            "size": 8
                        }],
                        "legend": {
                            "enabled": false
                        },
                        'labelsEnabled' : false,
                        "depth3D": 10,
                    }
                }
            ]

        }
    } );
</script>
</body>
</html>