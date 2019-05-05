<div class="chart col-md-6 col-sm-12">
    <canvas id="<?=$result["CODE"]?>"></canvas>
</div>

<script>
    $(document).ready(function () {
        var <?=$result["CODE"]?> =
        document.getElementById("<?=$result["CODE"]?>");
        var <?=$result["CODE"]?>_Chart = new Chart(<?=$result["CODE"]?>, {
            type: 'scatter',
            data: {
                datasets: [{
                    pointRadius: 0,
                    label: "<?=$result["NAME"]?>",
                    backgroundColor: window.chartColors.<?=$result["COLOR"]?>,
                    borderColor: window.chartColors.<?=$result["COLOR"]?>,
                    data: [
                        <?foreach ($result["DATA"]["X"] as $key => $value) {?>
                        {
                            x: <?=$value?>,
                            y: <?=$result["DATA"]["Y"][$key]?>
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
                            labelString: '<?=$result["LABEL_STRING_X"]?>'
                        },
                    }],
                    yAxes: [{
                        stacked: true,
                        type: 'linear',
                        <?if(!empty($result["LABEL_STRING_Y"])){?>
                        scaleLabel: {
                            display: true,
                            labelString: '<?=$result["LABEL_STRING_Y"]?>'
                        },
                        <?}?>
                    }]
                }
            }
        });
    });
</script>
