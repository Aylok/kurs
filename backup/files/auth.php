<?session_start();
$mypswd = "93igefum"; 
echo $_POST["pswd"];
if(md5($mypswd)==md5($_POST["pswd"])){
	$_SESSION["Login"] = true; 
	header("Location: index.php");
}
?>