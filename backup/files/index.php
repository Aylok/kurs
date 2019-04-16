<?
function p($ar){
	echo "<pre>";
	print_r($ar);
	echo "</pre>";
}
$mypswd = "93igefum";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<?if(md5($mypswd)==md5($_POST["pswd"])){
		$picList = glob("*.jpg");
		p($picList);?>
	<div class="container">
		<div class="row">
			<?foreach ($picList as  $value) {?>
				<div class="col-md-4 col-sm-2">
					<img src="<?=$value?>" alt="" style="width: 100%; height: auto;">
				</div>
			<?}?>
		</div>
	</div>
	
	<div class="fullscreen">
		<span class="fn-close"><i class="fas fa-times"></i></span>
		<div class="fn-item"><img src="<?=$picList[0]?>" class="fn-img" alt=""></div>
	</div>	

	<?}else{?>
	Пароль<br>
	<form action="index.php" method="post">
		<input name="pswd" type="password"><br>
		<input type="submit">
	</form>
	<?}?>
</body>
</html>