<?php require($_SERVER["DOCUMENT_ROOT"] . '/core/header.php'); ?>

<? system::incEl(
    "main",
    array(
        "otherEl" => array(
            1 => array(
                "elName" => "smallSchedule",
                "title" => "Speed",
                "Y" => "SPEED",
                "X" => "X",
                "COLOR" => ""
            ),
            2 => array(
                "elName" => "smallSchedule",
                "title" => "Speed",
                "Y" => "SPEED",
                "X" => "X",
                "COLOR" => ""
            ),
            3 => array(
                "elName" => "smallSchedule",
                "title" => "Speed",
                "Y" => "SPEED",
                "X" => "X",
                "COLOR" => ""
            )
        ),
        "outputData" => array(
            array(
                "NAME" => "Профиль сопла Лаваля",
                "X" => "X",
                "Y" => "Y",
                "COLOR" => "blue"
            ),
             array(
                "NAME" => "T(M)",
                "X" => "X",
                "Y" => "TEMPERATURE_WITHOUT",
                 "COLOR" => "red"
            ),
            array(
                "NAME" => "E(M)",
                "X" => "X",
                "Y" => "PRESSURE_WITHOUT",
                "COLOR" => "yellow"
            ),
            array(
                "NAME" => "PI(M)",
                "X" => "X",
                "Y" => "DENSITY_WITHOUT",
                "COLOR" => "orange"
            ),
        )
    ),
    $_POST); ?>

<?php require($_SERVER["DOCUMENT_ROOT"] . '/core/footer.php'); ?>