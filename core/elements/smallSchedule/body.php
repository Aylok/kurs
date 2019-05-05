<?php
if (empty($elParams["COLOR"]))
    $elParams["COLOR"] = "green";
$result = array(
    "NAME" => $elParams["title"],
    "CODE" => $elParams["CODE"],
    "X" => $elParams["X"],
    "COLOR" => $elParams["COLOR"],
    "LABEL_STRING_X" => $elParams["LABEL_STRING_X"],
    "LABEL_STRING_Y" => $elParams["LABEL_STRING_Y"],
    "DATA" => $elData
);

system::renderElement("smallSchedule", array("result" => $result),true);