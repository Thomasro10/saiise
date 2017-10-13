
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/js/libs/hcharts/maps/code/css/highcharts.css') }}" />
    <link rel="stylesheet" href="{{ URL::to('assets/js/libs/amcharts/plugins/export/export.css') }}" type="text/css" media="all" />
    <style>
        /* #container{
             width: 100%;
             height: 90vh;
          /* min-height: 200px;
             max-height: 600px;
            margin: 0 auto;
        }*/

        #charts {
            width: 100%;
            height: 90vh;
            position: relative;
            margin: 0 auto;
            font-size: 8px;
        }

        .chartdiv {
            width: 100%;
            height: 90vh;
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>

</head>
<body>
{{-- dd($result) --}}
<div id="container"></div>
<div id="charts">
    <div id="chart1" class="chartdiv"></div>
    <div id="chart2" class="chartdiv"></div>
    <div id="chart3" class="chartdiv"></div>
    <div id="chart4" class="chartdiv"></div>
</div>

<script src="{{ URL::to('assets/js/libs/amcharts/amcharts.js') }}"></script>
<script src="{{ URL::to('assets/js/libs/amcharts/pie.js') }}"></script>

<script src="{{ URL::to('assets/js/libs/amcharts/plugins/responsive/responsive.min.js') }}"></script>
<script src="{{ URL::to('assets/js/libs/amcharts/plugins/export/export.min.js') }}"></script>
<script src="{{ URL::to('assets/js/libs/amcharts/themes/light.js') }}"></script>

<script>
    /**
     * Plugin: Manipulate z-index of the chart
     */
    AmCharts.addInitHandler(function(chart) {

        // init holder for nested charts
        if (AmCharts.nestedChartHolder === undefined)
            AmCharts.nestedChartHolder = {};

        if (chart.bringToFront === true) {
            chart.addListener("init", function(event) {
                // chart inited
                var chart = event.chart;
                var div = chart.div;
                var parent = div.parentNode;

                // add to holder
                if (AmCharts.nestedChartHolder[parent] === undefined)
                    AmCharts.nestedChartHolder[parent] = [];
                AmCharts.nestedChartHolder[parent].push(chart);

                // add mouse mouve event
                chart.div.addEventListener('mousemove', function() {

                    // calculate current radius
                    var x = Math.abs(chart.mouseX - (chart.realWidth / 2));
                    var y = Math.abs(chart.mouseY - (chart.realHeight / 2));
                    var r = Math.sqrt(x*x + y*y);

                    // check which chart smallest chart still matches this radius
                    var smallChart;
                    var smallRadius;
                    for(var i = 0; i < AmCharts.nestedChartHolder[parent].length; i++) {
                        var checkChart = AmCharts.nestedChartHolder[parent][i];

                        if((checkChart.radiusReal < r) || (smallRadius < checkChart.radiusReal)) {
                            checkChart.div.style.zIndex = 1;
                        }
                        else {
                            if (smallChart !== undefined)
                                smallChart.div.style.zIndex = 1;
                            checkChart.div.style.zIndex = 2;
                            smallChart = checkChart;
                            smallRadius = checkChart.radiusReal;
                        }

                    }
                }, false);
            });
        }

    }, ["pie"]);

    /**
     * Create the charts
     */
    /*AmCharts.makeChart("chart1", {
        "type": "pie",
        "bringToFront": true,
        "dataProvider": [{
            "title": "$",
            "value": 100,
            "color": "#090E0F"
        }],
        "startDuration": 0,
        "pullOutRadius": 0,
        "color": "#fff",
        "fontSize": 14,
        "titleField": "title",
        "valueField": "value",
        "colorField": "color",
        "labelRadius": -25,
        "labelColor": "#fff",
        "radius": 25,
        "innerRadius": 0,
        "labelText": "[[title]]",
        "balloonText": "[[title]]: [[value]]"
    });*/

    AmCharts.makeChart("chart2", {
        "type": "pie",
        "bringToFront": true,
        "creditsPosition":"bottom-right",
        "dataProvider": [ {!!  implode(" , ",$result[0]['des']) !!}],
        "startDuration": 0.3,
        "pullOutRadius": 4,
        "pulledField": "pulled",
        "titles": [{
            "text": "{!! $result[2]['ttlo'] !!}",
            "size": 12
        }, {
            "text": "{!! $result[1]['titulo'] !!}",
            "bold": false,
            "size": 10
        }],

        "color": "#fff",
        "fontSize": 14,
        "titleField": "name",
        "valueField": "y",
        "colorField": "color",
        "labelRadius": -50,
        "labelColor": "#fff",
        "radius": 120,
        "innerRadius": 27,
       /* "outlineAlpha": 1,*/
        "outlineThickness": 1,

        "hoverAlpha": 0.8,
        "depth3D": 15,
        "angle": 5,

        "labelText": "[[title]]: [[value]]",
        "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
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
                    "radius": 50,
                    "innerRadius": 13,
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
                    "radius": 50,
                    "innerRadius": 13,
                }
            }
        ]

    }
    });

    AmCharts.makeChart("chart3", {
        "type": "pie",
        "creditsPosition":"bottom-right",
        "bringToFront": true,
        "dataProvider": [
            {!!  implode(" , ",$result[5]['impo']) !!},
            {!!  implode(" , ",$result[4]['nac']) !!},
    ],
        "startDuration": 0.3,
        "pullOutRadius": 5,
        "titles": [{
            "text": "{!! $result[2]['ttlo'] !!}",
            "size": 12
        }, {
            "text": "{!! $result[1]['titulo'] !!}",
            "bold": false,
            "size": 10
        }],
        "pulledField": "pulled",
        "color": "color",
        "fontSize": 14,
        "titleField": "name",
        "valueField": "y",
        "colorField": "color",
        "labelRadius": 55,
        "labelColor": "color",
        "radius": 195,
        "innerRadius": 142,

        "hoverAlpha": 0.8,
        "depth3D": 15,
        "angle": 5,
        /*
        "outlineAlpha": 1,*/
        "outlineThickness": 1,
        "labelText": "[[title]]: [[value]]",
        "balloonText": "[[title]]: [[value]]",
        "export": {
            "enabled": true
        },
        "responsive": {
            "enabled": true,
            "rules": [
                {
                    "maxWidth": 500,
                    "overrides": {
                        "legend": {
                            "enabled": false
                        },
                        'labelsEnabled' : false,
                        "depth3D": 10,
                        "radius": 87,
                        "innerRadius": 61,
                    }
                }, {
                    "maxHeight": 500,
                    "overrides": {
                        "legend": {
                            "enabled": false
                        },
                        'labelsEnabled' : false,
                        "depth3D": 10,
                        "radius": 87,
                        "innerRadius": 61,
                    }
                }
            ]

        }
    });

   /* AmCharts.makeChart("chart4", {
        "type": "pie",
        "bringToFront": true,
        "dataProvider": [{
            "title": "Design",
            "value": 5.5,
            "color": "#BA3233"
        }, {
            "title": "P&P",
            "value": 5.5,
            "color": "#BA3233"
        }, {
            "title": "Magazines",
            "value": 11,
            "color": "#BA3233"
        }, {
            "title": "Outdoor",
            "value": 3.66,
            "color": "#BA3233"
        }, {
            "title": "Promo",
            "value": 3.66,
            "color": "#BA3233"
        }, {
            "title": "Endorsement",
            "value": 3.66,
            "color": "#BA3233"
        }, {
            "title": "Maintenance",
            "value": 8.25,
            "color": "#624B6A"
        }, {
            "title": "Acquisition",
            "value": 8.25,
            "color": "#624B6A"
        }, {
            "title": "Raw",
            "value": 5.5,
            "color": "#624B6A"
        }, {
            "title": "Recycling",
            "value": 5.5,
            "color": "#624B6A"
        }, {
            "title": "Logistics",
            "value": 5.5,
            "color": "#624B6A"
        }, {
            "title": "LAB1",
            "value": 3.3,
            "color": "#6179C0"
        }, {
            "title": "LAB2",
            "value": 3.3,
            "color": "#6179C0"
        }, {
            "title": "LAB3",
            "value": 3.3,
            "color": "#6179C0"
        }, {
            "title": "Supply",
            "value": 3.3,
            "color": "#6179C0"
        }, {
            "title": "Disposal",
            "value": 3.3,
            "color": "#6179C0"
        }, {
            "title": "Application",
            "value": 5.5,
            "color": "#6179C0"
        }, {
            "title": "Acquisition",
            "value": 5.5,
            "color": "#6179C0"
        }, {
            "title": "Settlement",
            "value": 5.5,
            "color": "#6179C0"
        }],
        "startDuration": 1,
        "pullOutRadius": 0,
        "color": "#fff",
        "fontSize": 8,
        "titleField": "title",
        "valueField": "value",
        "colorField": "color",
        "labelRadius": -27,
        "labelColor": "#fff",
        "radius": 190,
        "innerRadius": 137,
        "outlineAlpha": 1,
        "outlineThickness": 4,
        "labelText": "[[title]]",
        "balloonText": "[[title]]: [[value]]",
        "allLabels": [{
            "text": "ACME Inc. Spending Chart",
            "bold": true,
            "size": 18,
            "color": "#404040",
            "x": 0,
            "align": "center",
            "y": 20
        }]
    });*/
    {{-- /*var chart = AmCharts.makeChart( "container", {
        "type": "pie",
        "theme": "light",
        "creditsPosition":"bottom-right",
        "labelRadius": 55,
        "gradientRatio": [0.8,0], //[-0.4, -0.4, -0.4, -0.4, -0.4, -0.4, 0, 0.1, 0.2, 0.1, 0, -0.2, -0.5]
        "outlineColor": "",
        "decimalSeparator": ",",
        "thousandsSeparator": ".",
        "startDuration":0.3,
        "titles": [{
            "text": "@if(empty($result[2]['ttlo'])) GRÁFICO EMPRESAS @else {{ $result[2]['ttlo'] }}  @endif"
        }, {
            "text": "{!! $result[1]['titulo'] !!}",
            "bold": false
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
                        "legend": {
                            "enabled": false
                        },
                        'labelsEnabled' : false,
                        "depth3D": 10,
                    }
                }, {
                    "maxHeight": 500,
                    "overrides": {
                        "legend": {
                            "enabled": false
                        },
                        'labelsEnabled' : false,
                        "depth3D": 10,
                    }
                }
            ]

        }
    } );*/--}}

</script>
</body>
</html>