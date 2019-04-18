<?
    //вызов функции на проверку входных данных
    if(empty($elData) && !isset($elData["R1"])){
        require_once "defaultValue.php";
        $error = false;
    }else{
        $inputDataArray = system::errorHandler($elData);
    }
    //расчет
    $dataArray = calculation::calc($inputDataArray);
    $temp1 = max($tempArray["TEMP"]);
    $temp2 = max($tempArray["DAV"]);
    $temp3 = max($tempArray["RO"]);
    $temp = max($temp1,$temp2,$temp3);
    $maxYX = $dataArray["maxYX"];
    unset($dataArray["maxYX"]);
require $_SERVER['DOCUMENT_ROOT'].'/core/view/elements/main/body.php';
require $_SERVER['DOCUMENT_ROOT'].'/core/view/elements/main/script.js';
require $_SERVER['DOCUMENT_ROOT'].'/core/view/elements/main/style.css';
?>


