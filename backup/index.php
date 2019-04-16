<?
function p($ar){
	echo "<pre>";
	print_r($ar);
	echo "</pre>";
}
//p($_POST);
//Число Маха через отношение площадей 
function ksi($x,$r,$r2,$k){
	return (M_PI*$r*$r)/(M_PI*$r2*$r2) - sqrt(pow((2/($k+1))*(1+(($k-1)/2)*$x*$x),($k+1)/(2*($k-1)))/$x);
}

//Давление
function pressure($p,$m,$k,$pr=0){
	if($pr) 
		$tempValue = 1/pow((1+($k-1)/2*$m*$m),($k/($k-1)));
	else 
		$tempValue = $p/pow((1+($k-1)/2*$m*$m),($k/($k-1)));
	return $tempValue;	
}
//Температура
function temperature($t,$m,$k,$pr=0){
	if($pr) 
		$tempValue = 1/(1+($k-1)/2*$m*$m);
	else 
		$tempValue = $t/(1+($k-1)/2*$m*$m);
	return $tempValue;	
}
//Плотность через начальное и Мах
function densityWithMach($ro,$m,$k,$pr=0){
	if($pr) 
		$tempValue = 1/pow((1+($k-1)/2*$m*$m),(1/($k-1)));
	else 
		$tempValue = $ro/pow((1+($k-1)/2*$m*$m),(1/($k-1)));
	return $tempValue;
}
//Скорость потока
function speed($t,$m,$r,$k,$pr=0){
	if($pr)	
		$tempValue = $m*sqrt($k*$r*$t);
	else 
		$tempValue = $m*sqrt($k*$r*$t);
	return $tempValue;
}
//Функция поиска числа Маха через метод половинного деления
function findMach($a,$b,$r,$r2,$k){
	$e=0.0001;
	while(abs($a-$b)>$e){
		$c=($a+$b)/2;
		if (ksi($a,$r,$r2,$k)*ksi($c,$r,$r2,$k)<=0){
			$b=$c;
		}else{
			$a=$c;
		}
	}
	$x=($a+$b)/2;
	return $x;
}


if(isset($_POST)){

	if(empty($_POST["R1"])){
		$Error.="Не ввели радиус образующего сопла";
	}
	if(empty($_POST["R2"])){
		$Error.="Не ввели критический радиус";
	}
	if(empty($_POST["ALPHA"])){
		$Error.="Не задали угол";
	}
	if(empty($_POST["N"])){
		$Error.="Не задали длину сопла";
	}
		if(empty($_POST["H"])){
		$Error.="Не задали шаг расчета";
	}

	if(empty($Error)){
		$r1 = $_POST["R1"]; //образующий радиус
		$r2 = $_POST["R2"]; //критический радиус
		$alpha = deg2rad($_POST["ALPHA"]); //угол наклона
		$n = $_POST["N"]; //длина сопла в калибрах
		$ak= $_POST["K"];

		$P = $_POST["P"];
		$T = $_POST["T"];
		$R = $_POST["R"];
		//Давление начальное
		$ro0 = $P/($R*$T);

		//точка касания первой окружности и второй 
		$k = $r1*sqrt(1 - (4*$r2*$r2) / ( ($r1+$r2)* ($r1+$r2) ) );

		//координаты центра второй окружности
		$x0 = sqrt( ($r1*$r1) + (2*$r1*$r2) - (3*$r2*$r2) ); 
		$y0 = 2*$r2;
		
		//координаты точки начала касательной 
		$l = $x0 + $r2 * sin($alpha);
		$b = ($r2 * ( 2 * tan($alpha) - sin($alpha))) / tan($alpha);
		
		//длина от 0 до конца сопла
		$d = $x0 + $n*$r2;

		$h = $_POST["H"];; 
		$x=0;
		//координаты точек окружности первой 
		while($x<$k) {
    		$y = sqrt($r1*$r1 - $x*$x);
			$arrData[] = array("x"=>$x,"y"=>$y);
			$x = $x + $h;
		}
		//координаты точек окружности Rкр от 270 градусов до точки касательной
		while($x<$l) {
    		$y = $y0 - sqrt($r2*$r2 - ($x-$x0)*($x-$x0));
    		$arrData[] = array("x"=>$x,"y"=>$y);
    		$x = $x + $h;
		}
		//находим координаты точек касательной
		while($x<$d){
			$y = tan($alpha) * ($x-$l) + $b;
			$arrData[] = array("x"=>$x,"y"=>$y);
			$x = $x + $h;
		}
		//считаем число Маха, температуру, давление и плотность 
		foreach ($arrData as $key => $data) {				
			if($data["x"]>$x0){
				$arrData[$key]["MACH"] = findMach(1,10,$data["y"],$r2,$ak);
				$arrData[$key]["TEMP"] = temperature($T,$arrData[$key]["MACH"],$ak,0);
				$arrData[$key]["DAV"] = pressure($P,$arrData[$key]["MACH"],$ak,0);
				$arrData[$key]["RO"] = densityWithMach($ro0,$arrData[$key]["MACH"],$ak,0);
				$arrData[$key]["TEMPWT"] = temperature($T,$arrData[$key]["MACH"],$ak,1);
				$arrData[$key]["DAVWT"] = pressure($P,$arrData[$key]["MACH"],$ak,1);
				$arrData[$key]["ROWT"] = densityWithMach($ro0,$arrData[$key]["MACH"],$ak,1);
				$arrData[$key]["SPEED"] = speed($arrData[$key]["TEMP"],$arrData[$key]["MACH"],$R,$ak,1);
				$tempArray["TEMP"][] = $arrData[$key]["TEMPWT"];
				$tempArray["DAV"][] = $arrData[$key]["DAVWT"];
				$tempArray["RO"][] = $arrData[$key]["ROWT"];
			}elseif ($data["x"]<$x0){
				$arrData[$key]["MACH"] = findMach(0,1,$data["y"],$r2,$ak);
				$arrData[$key]["TEMP"] = temperature($T,$arrData[$key]["MACH"],$ak);
				$arrData[$key]["DAV"] = pressure($P,$arrData[$key]["MACH"],$ak);
				$arrData[$key]["RO"] = densityWithMach($ro0,$arrData[$key]["MACH"],$ak);
				$arrData[$key]["TEMPWT"] = temperature($T,$arrData[$key]["MACH"],$ak,1);
				$arrData[$key]["DAVWT"] = pressure($P,$arrData[$key]["MACH"],$ak,1);
				$arrData[$key]["ROWT"] = densityWithMach($ro0,$arrData[$key]["MACH"],$ak,1);
				$arrData[$key]["SPEED"] = speed($arrData[$key]["TEMP"],$arrData[$key]["MACH"],$R,$ak,1);
				$tempArray["TEMP"][] = $arrData[$key]["TEMPWT"];
				$tempArray["DAV"][] = $arrData[$key]["DAVWT"];
				$tempArray["RO"][] = $arrData[$key]["ROWT"];
			}
		}

		$temp1 = max($tempArray["TEMP"]);
		$temp2 = max($tempArray["DAV"]);
		$temp3 = max($tempArray["RO"]);
		$temp = max($temp1,$temp2,$temp3);
		$maxYX = array("Y"=>$temp,"X"=>$d);
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
	<style>	
		.chart-container {
			position: relative;
			margin: auto;
			height: 100%;
			width: auto;
		}
		.chart{
			margin-bottom: 25px;
		}
		#structure {
		    display: block;
		    width: 950px !important;
		    height: 800px !important;
		}
	</style>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
</head>
<body>
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





<div class="row">
	<div class="chart col-md-6 col-sm-12">
		<canvas id="temp"></canvas>
	</div>
	<div class="chart col-md-6 col-sm-12">
		<canvas id="ro"></canvas>
	</div>
	<div class="chart col-md-6 col-sm-12">
		<canvas id="dav"></canvas>
	</div>
	<div class="chart col-md-6 col-sm-12">
		<canvas id="mach"></canvas>
	</div>
	<div class="chart col-md-6 col-sm-12">
		<canvas id="speed"></canvas>
	</div>
</div>	
<script>
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
var temp = document.getElementById("temp");
var ro = document.getElementById("ro");
var dav = document.getElementById("dav");
var mach = document.getElementById("mach");
var speed = document.getElementById("speed");

var structureChart = new Chart(structure, {
    type: 'scatter',
    data: {
        datasets: [{
        	label: "Профиль сопла Лаваля",
        	pointRadius: 0,
      		backgroundColor: window.chartColors.blue,
      		borderColor: window.chartColors.blue, 
            data: [
					<?foreach ($arrData as $value) {?>
						{
						    x: <?=$value["x"]?>,
						    y: <?=$value["y"]?>
						},	
					<?} ?> 
			],
			fill: false,
			showLine: true,
			scaleStartValue:0,
            scaleStepWidth:1,
        },{
        	label: "T(M)",
        	pointRadius: 0,
      		backgroundColor: window.chartColors.red,
      		borderColor: window.chartColors.red, 
            data: [
					<?foreach ($arrData as $value) {?>
						{
						    x: <?=$value["x"]?>,
						    y: <?=$value["TEMPWT"]?>
						},	
					<?} ?> 
			],
			fill: false,
			showLine: true,
			scaleStartValue:0,
            scaleStepWidth:1,        	
        },{
        	label: "E(M)",
        	pointRadius: 0,
      		backgroundColor: window.chartColors.yellow,
      		borderColor: window.chartColors.yellow, 
            data: [
					<?foreach ($arrData as $value) {?>
						{
						    x: <?=$value["x"]?>,
						    y: <?=$value["ROWT"]?>
						},	
					<?} ?> 
			],
			fill: false,
			showLine: true,
			scaleStartValue:0,
            scaleStepWidth:1,        	
        },{
        	label: "PI(M)",
        	pointRadius: 0,
      		backgroundColor: window.chartColors.orange,
      		borderColor: window.chartColors.orange, 
            data: [
					<?foreach ($arrData as $value) {?>
						{
						    x: <?=$value["x"]?>,
						    y: <?=$value["DAVWT"]?>
						},	
					<?} ?> 
			],
			fill: false,
			showLine: true,       	
			scaleStartValue:0,
            scaleStepWidth:1,
        }]
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
			    	max:<?=$maxYX["X"]?>,
			      	stepSize: 0.1, 
			      	//fixedStepSize: 1, 
			    } 
            }],
            yAxes: [{
                stacked: true,
                type: 'linear',
			    ticks: {  
			    	min:0,
			    	max:<?=$maxYX["Y"]?>,
			      	stepSize: 0.1, 
			      	//fixedStepSize: 1, 
			    } 
            }]
        }
    }
});

var machChart = new Chart(mach, {
    type: 'scatter',
    data: {
        datasets: [{
        	pointRadius: 0,
        	label: "Число Маха",
      		backgroundColor: window.chartColors.green,
      		borderColor: window.chartColors.green, 
            data: [
					<?foreach ($arrData as $value) {?>
						{
						    x: <?=$value["x"]?>,
						    y: <?=$value["MACH"]?>
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
					labelString: 'м'
				},
            }],
            yAxes: [{
                stacked: true,
                type: 'linear',
            }]
        }
    }
});

var speedChart = new Chart(speed, {
    type: 'scatter',
    data: {
        datasets: [{
    		pointRadius: 0,        	
        	label: "Скорость",
      		backgroundColor: window.chartColors.green,
      		borderColor: window.chartColors.green, 
            data: [
					<?foreach ($arrData as $value) {?>
						{
						    x: <?=$value["x"]?>,
						    y: <?=$value["SPEED"]?>
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
					labelString: 'м'
				},
            }],
            yAxes: [{
                stacked: true,
                type: 'linear',
				scaleLabel: {
					display: true,
					labelString: 'м/с'
				},
            }]
        }
    }
});

var tempChart = new Chart(temp, {
    type: 'scatter',
    data: {
        datasets: [{
        	pointRadius: 0,
        	label: "Температура",
      		backgroundColor: window.chartColors.red,
      		borderColor: window.chartColors.red, 
            data: [
					<?foreach ($arrData as $value) {?>
						{
						    x: <?=$value["x"]?>,
						    y: <?=$value["TEMP"]?>
						},	
					<?} ?> 
			],
			fill: false,
			showLine: true
        }]
    },
    options: {
        scales: {
            xAxes: [{
                type: 'linear',
                position: 'bottom',
				scaleLabel: {
					display: true,
					labelString: 'м'
				},
            }],
            yAxes: [{
				scaleLabel: {
					display: true,
					labelString: 'K'
				},
                stacked: true,

            }]
        }
    }
});

var roChart = new Chart(ro, {
    type: 'scatter',
    data: {
        datasets: [{
        	pointRadius: 0,
        	label: "Плотность",
     		backgroundColor: window.chartColors.yellow,
      		borderColor: window.chartColors.yellow, 
            data: [
					<?foreach ($arrData as $value) {?>
						{
						    x: <?=$value["x"]?>,
						    y: <?=$value["RO"]?>
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
					labelString: 'м'
				},
            }],
            yAxes: [{
				scaleLabel: {
					display: true,
					labelString: 'кг/м³'
				},            	
                stacked: true,

            }]
        }
    }
});

var davChart = new Chart(dav, {
    type: 'scatter',
    data: {
        datasets: [{
        	pointRadius: 0,
        	label: "Давление", 
     		backgroundColor: window.chartColors.orange,
      		borderColor: window.chartColors.orange,     
            data: [
					<?foreach ($arrData as $value) {?>
						{
						    x: <?=$value["x"]?>,
						    y: <?=$value["DAV"]?>
						},	
					<?} ?> 
			],
			fill: false,
			showLine: true
        }]
    },
    options: {
        scales: {
            xAxes: [{
                type: 'linear',
                position: 'bottom',
				scaleLabel: {
					display: true,
					labelString: 'м'
				},
            }],
            yAxes: [{
				scaleLabel: {
					display: true,
					labelString: 'ПА'
				},
                stacked: true,

            }]
        }
    }
});
</script>
</body>
</html>




