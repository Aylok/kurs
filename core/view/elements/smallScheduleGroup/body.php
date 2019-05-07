<sectiom class="smallChartGroup">
<div class="container-fluid">
        <div class="row">
            <?foreach($result["CHARTS"] as $chart){?>
                <div class="chart col-md-6 col-sm-12">
                    <canvas id="<?=$chart["CODE"]?>"></canvas>
                </div>

                <script>
                    $(document).ready(function () {
                        var <?=$chart["CODE"]?> =
                        document.getElementById("<?=$chart["CODE"]?>");
                        var <?=$chart["CODE"]?>_Chart = new Chart(<?=$chart["CODE"]?>, {
                            type: 'scatter',
                            data: {
                                datasets: [{
                                    pointRadius: 0,
                                    label: "<?=$chart["NAME"]?>",
                                    backgroundColor: window.chartColors.<?=$chart["COLOR"]?>,
                                    borderColor: window.chartColors.<?=$chart["COLOR"]?>,
                                    data: [
                                        <?foreach ($chart["DATA"]["X"] as $key => $value) {?>
                                        {
                                            x: <?=$value?>,
                                            y: <?=$chart["DATA"]["Y"][$key]?>
                                        },
                                        <?} ?>
                                    ],
                                    fill: false,
                                    showLine: true
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    xAxes: [{
                                        type: 'linear',
                                        position: 'bottom',
                                        scaleLabel: {
                                            display: true,
                                            labelString: '<?=$chart["LABEL_STRING_X"]?>'
                                        },
                                    }],
                                    yAxes: [{
                                        stacked: true,
                                        type: 'linear',
                                        <?if(!empty($chart["LABEL_STRING_Y"])){?>
                                        scaleLabel: {
                                            display: true,
                                            labelString: '<?=$chart["LABEL_STRING_Y"]?>'
                                        },
                                        <?}?>
                                    }]
                                }
                            }
                        });
                    });
                </script>
        <?}?>
        </div>
    </div>    
</sectiom>
