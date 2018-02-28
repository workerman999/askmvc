<?php
use yii\helpers\Html;

$id = $graph->objects[0]->id;
?>

<script type="text/javascript">

    //график уровня топлива мобильного объекта
    function requestData(id) {
        $.ajax({
            url: 'viewgraph',
            'dataType': 'json',
            'data' : {
                id : id,
            },
            success: function(point) {
                var series = chart.series[0],
                    shift = series.data.length > 100;

                chart.series[0].addPoint(point, true, shift);

                setTimeout(requestData(id), 1000);
            },
            cache: false
        });
    }

    $(document).ready(function() {
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
        var id = '<?= $id ?>';
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'fuel',
                type: 'spline',
                events: {
                    load: requestData(id)
                }
            },
            title: {
                text: 'График уровня топлива'
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 150,
                maxZoom: 80000
            },
            yAxis: {
                minPadding: 0.5,
                maxPadding: 0.5,
                title: {
                    text: 'Количество литров',
                    margin: 80
                }
            },
            series: [{
                name: 'Уровень топлива',
                data: []
            }]
        });


        //график скорости мобильного объекта
        Highcharts.chart('speed', {
                chart: {
                    type: 'gauge',
                    plotBackgroundColor: null,
                    plotBackgroundImage: null,
                    plotBorderWidth: 0,
                    plotShadow: false
                },

                title: {
                    text: 'Скорость движения'
                },

                pane: {
                    startAngle: -150,
                    endAngle: 150,
                    background: [{
                        backgroundColor: {
                            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                            stops: [
                                [0, '#FFF'],
                                [1, '#333']
                            ]
                        },
                        borderWidth: 0,
                        outerRadius: '109%'
                    }, {
                        backgroundColor: {
                            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                            stops: [
                                [0, '#333'],
                                [1, '#FFF']
                            ]
                        },
                        borderWidth: 1,
                        outerRadius: '107%'
                    }, {
                        // default background
                    }, {
                        backgroundColor: '#DDD',
                        borderWidth: 0,
                        outerRadius: '105%',
                        innerRadius: '103%'
                    }]
                },

                // the value axis
                yAxis: {
                    min: 0,
                    max: 200,

                    minorTickInterval: 'auto',
                    minorTickWidth: 1,
                    minorTickLength: 10,
                    minorTickPosition: 'inside',
                    minorTickColor: '#666',

                    tickPixelInterval: 30,
                    tickWidth: 2,
                    tickPosition: 'inside',
                    tickLength: 10,
                    tickColor: '#666',
                    labels: {
                        step: 2,
                        rotation: 'auto'
                    },
                    title: {
                        text: 'км/ч'
                    },
                    plotBands: [{
                        from: 0,
                        to: 120,
                        color: '#55BF3B' // green
                    }, {
                        from: 120,
                        to: 160,
                        color: '#DDDF0D' // yellow
                    }, {
                        from: 160,
                        to: 200,
                        color: '#DF5353' // red
                    }]
                },

                series: [{
                    name: 'Скорость',
                    data: [0],
                    tooltip: {
                        valueSuffix: ' kм/ч'
                    }
                }]

            },

            function (chart) {
                if (!chart.renderer.forExport) {
                    setInterval(function () {
                        $.ajax({
                            url: 'viewspeed',
                            'dataType': 'json',
                            'data' : {
                                id : id,
                            },
                            success: function(speed) {
                                var point = chart.series[0].points[0],
                                    newVal;
                                    point.y = Number(speed);

                                newVal = point.y;
                                point.update(newVal);
                            },
                            cache: false
                        });
                    }, 1000);
                }
            });

    });

</script>
<script src = "https://code.highcharts.com/highcharts.js"> </script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<h2><?= $graph->objects[0]->name ?></h2>
<div id = "fuel" style = "width: 100%; height: 400px;"></div>
<br>
<div id="speed" style="min-width: 310px; max-width: 400px; height: 300px; margin: 0 auto"></div>
<h4><?= Html::a('Назад', ['site/graph'], ['class' => 'btn btn-success']); ?></h4>