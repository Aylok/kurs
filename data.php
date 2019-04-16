<?php require($_SERVER["DOCUMENT_ROOT"].'/core/header_before.php');

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
}