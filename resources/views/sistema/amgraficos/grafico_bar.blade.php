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

<script src="{{ URL::to('assets/js/libs/jquery/jquery-1.11.2.min.js') }}"></script>
<script src="{{ URL::to('assets/js/libs/amcharts/amcharts.js') }}"></script>
<script src="{{ URL::to('assets/js/libs/amcharts/serial.js') }}"></script>

<script src="{{ URL::to('assets/js/libs/amcharts/plugins/responsive/responsive.min.js') }}"></script>
<script src="{{ URL::to('assets/js/libs/amcharts/plugins/export/export.min.js') }}"></script>
<script src="{{ URL::to('assets/js/libs/amcharts/themes/light.js') }}"></script>

<!-- Chart code -->
<script>
    var chart = AmCharts.makeChart("container", {
        /*"prefixesOfBigNumbers" : [{number:1e+3,prefix:"m"},{number:1e+6,prefix:"M"},{number:1e+9,prefix:"MM"},{number:1e+12,prefix:"B"},{number:1e+15,prefix:"P"},{number:1e+18,prefix:"E"},{number:1e+21,prefix:"Z"},{number:1e+24,prefix:"Y"}],
        "usePrefixes" : true,*/
        @if(!empty($result[3]['type']))
        "creditsPosition":"bottom-right",
        @else
        "creditsPosition":"top-right",
        @endif
        "decimalSeparator": ",",
        "thousandsSeparator": ".",
        "fontSize": 14,

        "theme": "light",
        "type": "serial",
        "startEffect" : 'bounce',
        "startDuration":0.3,
        "outlineColor": "",
        "allLabels": [{
            "text": "{{ $result[2]['titulo'] }} {{ $result[4]['ttlo'] }}",
            "align": "center",
            "bold": true,
            "size": 16,
            "y": 10
        }],

        "marginTop": 50,
        "dataProvider": [
            {!!  implode(" , ",$result[0]['des']) !!}
        ],
        "graphs": [{
            "labelText": "[[value]]",
            @if(!empty($result[3]['type']))
            "labelPosition": "right",
            "color": "#000",
            @else
            "labelPosition": "top",
            "color": "#000",
            @endif

            "balloonText": "[[category]] : [[value]]",
            "fillColorsField": "color",
            "fillAlphas": 0.8,
            "lineAlpha": 0.1,
            "title": "Income",
            "type": "column",
            "valueField": "cantidad",
            @if(empty($result[3]['type']))
            "fixedColumnWidth": 125
            @endif
        }],
        @if(!empty($result[3]['type']))
        "depth3D": 15,
        @else
        "depth3D": 45,
        @endif
        "angle": 25.13,
        @if(!empty($result[3]['type']))
        {!! $result[3]['type'] !!}
        @endif
        "categoryField": "tipo",
        "categoryAxis": {
            "gridPosition": "start",
            "fillAlpha": 0.05,
            "position": "left",
            @if(!empty($result[3]['type']))
            "fontSize": 14,
            @endif
            "gridCount" : {{ count($result[0]['des']) }},
            "autoGridCount" : false,
            "labelFunction": function(valueText, serialDataItem, categoryAxis) {
                if (valueText.length > 30)
                    return valueText.substring(0, 30) + '...';
                else
                    return valueText;
            }
        },
        "valueAxes": [ {
            "title": "",
            "minimum": 0
        } ],
        "export": {
            "enabled": true
        },
        "responsive": {
            "enabled": true,
            //"addDefaultRules": false,
            "rules": [
                {
                    "maxWidth": 500,
                    "overrides": {
                        "allLabels": [{
                            "size": 8
                        }],
                        "categoryAxis": {
                            "labelsEnabled": false
                        },
                        @if(!empty($result[3]['type']))
                        "depth3D": 5,
                        @else
                        "depth3D": 15,
                        @endif

                        "valueAxes": {
                            "labelsEnabled": false
                        },
                        "graphs": [{
                           "labelText": "",
                           @if(empty($result[3]['type']))
                           "fixedColumnWidth": 65
                           @endif
                        }]
                    }
                },
                {
                    "maxHeight": 500,
                    "overrides": {
                        "allLabels": [{
                            "size": 8
                        }],
                        "categoryAxis": {
                            "labelsEnabled": false
                        },
                        @if(!empty($result[3]['type']))
                        "depth3D": 5,
                        @else
                        "depth3D": 15,
                        @endif
                        "valueAxes": {
                            "labelsEnabled": false
                        },
                        "graphs": [{
                            "labelText": "",
                            @if(empty($result[3]['type']))
                            "fixedColumnWidth": 65
                            @endif
                        }]
                    }
                }
            ]
        }
    });
</script>

</body>
</html>