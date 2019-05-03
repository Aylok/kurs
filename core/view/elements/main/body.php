<section class="main-block">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <form method="post" action="index.php">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <div class="form-group">
                                <label for="R1">Радиус образующего сопла(м)</label>
                                <input type="number" class="form-control" id="R1" name="R1" step="0.0000000001" value="<?=$inputDataArray["R1"]?>">
                            </div>
                            <div class="form-group">
                                <label for="R2">Критический радиус(м)</label>
                                <input type="number" class="form-control" id="R2" name="R2" step="0.0000000001" value="<?=$inputDataArray["R2"]?>">
                            </div>
                            <div class="form-group">
                                <label for="ALPHA">Угол наклона(градусы)</label>
                                <input type="number" class="form-control" id="ALPHA" name="ALPHA" step="1" value="<?=$inputDataArray["ALPHA"]?>">
                            </div>
                            <div class="form-group">
                                <label for="N">Длина сопла(калибр)</label>
                                <input type="number" class="form-control" id="N" name="N" step="0.0000000001" value="<?=$inputDataArray["N"]?>">
                            </div>
                            <div class="form-group">
                                <label for="H">Шаг расчета</label>
                                <input type="number" class="form-control" id="H" name="H" step="0.01" value="<?=$inputDataArray["H"]?>">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6">
                            <div class="form-group">
                                <label for="K">Показатель адиабаты</label>
                                <input type="number" class="form-control" id="K" name="K" step="0.01" value="<?=$inputDataArray["K"]?>">
                            </div>

                            <div class="form-group">
                                <label for="P">Давление торможения(Пa)</label>
                                <input type="number" class="form-control" id="P" name="P" step="0.0000000001" value="<?=$inputDataArray["P"]?>">
                            </div>
                            <div class="form-group">
                                <label for="R">Газовая постоянная</label>
                                <input type="number" class="form-control" id="R" name="R" step="0.01" value="<?=$inputDataArray["R"]?>">
                            </div>
                            <div class="form-group">
                                <label for="T">Температура торможения(К)</label>
                                <input type="number" class="form-control" id="T" name="T" step="0.01" value="<?=$inputDataArray["T"]?>">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Расчет</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-10">
                <div class="chart-container">
                    <canvas id="structure" height="800" width="1023"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            window.chartColors = {
                red: 'rgb(255, 0, 0)',
                orange: 'rgb(255, 165, 64)',
                yellow: 'rgb(255, 205, 86)',
                green: 'rgb(75, 192, 192)',
                blue: 'rgb(54, 162, 235)',
                purple: 'rgb(153, 102, 255)',
                grey: 'rgb(231,233,237)'
            };
            var structure = document.getElementById("structure");
            var structureChart = new Chart(structure, {
                type: 'scatter',
                data: {
                    datasets: [
                        <?foreach ($result as $data){?>
                            {
                            label: "<?=$data["NAME"]?>",
                            pointRadius: 0,
                            backgroundColor: window.chartColors.<?=$data["COLOR"]?>,
                            borderColor: window.chartColors.<?=$data["COLOR"]?>,
                            data: [
                                <?foreach ($data["DATA"]["X"] as $key => $value) {?>
                                {
                                    x: <?=$value?>,
                                    y: <?=$data["DATA"]["Y"][$key] ?>
                                },
                                <?} ?>
                            ],
                            fill: false,
                            showLine: true,
                            scaleStartValue:0,
                            scaleStepWidth:1,
                            },
                        <?}?>
                        ]
                },
                options: {

                    responsive: true,
                    aspectRatio: 1,

                    scales: {
                        xAxes: [{
                            type: 'linear',
                            position: 'bottom',
                            ticks: {
                                min:0,
                                max:<?=$maxXY["X"]?>,
                                stepSize: 0.1,
                                //fixedStepSize: 1,
                            }
                        }],
                        yAxes: [{
                            stacked: true,
                            type: 'linear',
                            ticks: {
                                min:0,
                                max:<?=$maxXY["Y"]?>,
                                stepSize: 0.1,
                                //fixedStepSize: 1,
                            }
                        }]
                    }
                }
            });
        });
    </script>
</section>