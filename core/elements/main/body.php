<?
    //вызов функции на проверку входных данных
    if (empty($elData) && !isset($elData["R1"])) {
        require_once "defaultValue.php";
        $error = false;
    } else {
        $inputDataArray = system::errorHandler($elData);
    }
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


    foreach ($elParams["otherEl"] as $el) {
        system::incEl(
            $elName = $el["elName"],
            $elParams = array(
                "outputData" => array(
                    "NAME" => $el["title"],
                    "X" => $el["X"],
                    "Y" => $el["Y"],
                    "COLOR" => $el["COLOR"]
                )
            ),
            $elData = array(
                "X" => $dataArray[$el["X"]],
                "Y" => $dataArray[$el["Y"]]
            )
        );
    }

    require $_SERVER['DOCUMENT_ROOT'] . '/core/view/elements/main/body.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/core/view/elements/main/script.js';
    require $_SERVER['DOCUMENT_ROOT'] . '/core/view/elements/main/style.css';





?>


