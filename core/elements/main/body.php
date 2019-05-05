<?
    //вызов функции на проверку входных данных
    if (empty($elData) && !isset($elData["R1"])) {
        require_once "defaultValue.php";
        $error = false;
    } else {
        require_once "defaultValue.php";
        $error = system::errorHandler($elData, $inputDataArray);
        $inputDataArray = $elData;
    }
    if (!$error["ERROR"]) {
        //расчет
        $dataArray = calculation::calc($inputDataArray);
        //максимуму по Х и У
        $maxXY = $dataArray["maxYX"];

        foreach ($elParams["outputData"] as $key => $el) {
            $result[$el["Y"]] = array(
                "NAME" => $el["NAME"],
                "X" => $el["X"],
                "COLOR" => $el["COLOR"],
                "DATA" => array()
            );
        }

        foreach ($result as $key => $data) {
            $result[$key]["DATA"]["X"] = $dataArray["X"];
            $result[$key]["DATA"]["Y"] = $dataArray[$key];
        }

        system::renderElement("main", array("result" => $result, "inputDataArray" => $inputDataArray, "maxXY" => $maxXY), false);
        if(isset($elParams["otherEl"])){
//            foreach ($elParams["otherEl"] as $el) {
//                //system::p($el);
//                system::incEl(
//                    $el["elName"],
//                    $el,
//                    array(
//                        "X" => $dataArray[$el["X"]],
//                        "Y" => $dataArray[$el["Y"]]
//                    )
//                );
//            }
            system::incEl("smallScheduleGroup",$elParams["otherEl"], $dataArray);
        }
    } else {
        system::renderElement("main", array("error" => $error, "inputDataArray" => $inputDataArray), true);
    }



