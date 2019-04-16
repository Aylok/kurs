<section class="main-block">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <form method="post" action="index.php">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <div class="form-group">
                                <label for="R1">Радиус образующего сопла(м)</label>
                                <input type="number" class="form-control" id="R1" name="R1" step="0.0000000001" value="<?=$_POST["R1"]?>">
                            </div>
                            <div class="form-group">
                                <label for="R2">Критический радиус(м)</label>
                                <input type="number" class="form-control" id="R2" name="R2" step="0.0000000001" value="<?=$_POST["R2"]?>">
                            </div>
                            <div class="form-group">
                                <label for="ALPHA">Угол наклона(градусы)</label>
                                <input type="number" class="form-control" id="ALPHA" name="ALPHA" step="1" value="<?=$_POST["ALPHA"]?>">
                            </div>
                            <div class="form-group">
                                <label for="N">Длина сопла(калибр)</label>
                                <input type="number" class="form-control" id="N" name="N" step="0.0000000001" value="<?=$_POST["N"]?>">
                            </div>
                            <div class="form-group">
                                <label for="H">Шаг расчета</label>
                                <input type="number" class="form-control" id="H" name="H" step="0.01" value="<?=$_POST["H"]?>">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6">
                            <div class="form-group">
                                <label for="K">Показатель адиабаты</label>
                                <input type="number" class="form-control" id="K" name="K" step="0.01" value="<?=$_POST["K"]?>">
                            </div>

                            <div class="form-group">
                                <label for="P">Давление торможения(Пa)</label>
                                <input type="number" class="form-control" id="P" name="P" step="0.0000000001" value="<?=$_POST["P"]?>">
                            </div>
                            <div class="form-group">
                                <label for="R">Газовая постоянная</label>
                                <input type="number" class="form-control" id="R" name="R" step="0.01" value="<?=$_POST["R"]?>">
                            </div>
                            <div class="form-group">
                                <label for="T">Температура торможения(К)</label>
                                <input type="number" class="form-control" id="T" name="T" step="0.01" value="<?=$_POST["T"]?>">
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
</section>
