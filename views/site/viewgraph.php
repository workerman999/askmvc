<?php
use yii\helpers\Html;

$id = $graph->objects[0]->id;
?>

<script type="text/javascript">

    function requestData(id) {
        console.log(id);
        $.ajax({
            url: 'viewgraph',
            'dataType': 'json',
            'data' : {
                id : id,
            },
            success: function(point) {
                var series = chart.series[0],
                    shift = series.data.length > 30;

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
    });
</script>
<script src = "https://code.highcharts.com/highcharts.js"> </script>
<h2><?= $graph->objects[0]->name ?></h2>

<div id = "fuel" style = "width: 100%; height: 400px;"></div>
<h4><?= Html::a('Назад', ['site/graph'], ['class' => 'btn btn-success']); ?></h4>