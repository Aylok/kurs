<?
    //вызов функции на проверку входных данных
    if(empty($elData) && !isset($elData["R1"])){
        require_once "defaultValue.php";
        $error = false;
    }
    //расчет
    system::p($dataArray);
    calculation::calc($dataArray);
require $_SERVER['DOCUMENT_ROOT'].'/core/view/elements/main/body.php';
require $_SERVER['DOCUMENT_ROOT'].'/core/view/elements/main/script.js';
require $_SERVER['DOCUMENT_ROOT'].'/core/view/elements/main/style.css';
?>


