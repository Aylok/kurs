<?php require($_SERVER["DOCUMENT_ROOT"] . '/core/header.php'); ?>

<? system::incEl(
    "main",
    array(
        "otherEl" => array(
            "elName" => "smallScheduleGroup",
            "elements" => array(
                1 => array(
                    "elName" => "smallSchedule",
                    "title" => "Число Маха",
                    "CODE" => "mach",
                    "Y" => "MACH",
                    "X" => "X",
                    "LABEL_STRING_Y" => "",
                    "LABEL_STRING_X" => "м",
                    "COLOR" => "green"
                ),
                2 => array(
                    "elName" => "smallSchedule",
                    "title" => "Скорость",
                    "CODE" => "speed",
                    "Y" => "SPEED",
                    "X" => "X",
                    "LABEL_STRING_Y" => "м/с",
                    "LABEL_STRING_X" => "м",
                    "COLOR" => ""
                ),
                3 => array(
                    "elName" => "smallSchedule",
                    "title" => "Температура",
                    "CODE" => "temperature",
                    "Y" => "TEMPERATURE",
                    "X" => "X",
                    "LABEL_STRING_Y" => "K",
                    "LABEL_STRING_X" => "м",
                    "COLOR" => "red"
                ),
                4 => array(
                    "elName" => "smallSchedule",
                    "title" => "Плотность",
                    "CODE" => "density",
                    "Y" => "DENSITY",
                    "X" => "X",
                    "LABEL_STRING_Y" => "кг/м³",
                    "LABEL_STRING_X" => "м",
                    "COLOR" => "yellow"
                ),
                5 => array(
                    "elName" => "smallSchedule",
                    "title" => "Давление",
                    "CODE" => "presure",
                    "Y" => "PRESSURE",
                    "X" => "X",
                    "LABEL_STRING_Y" => "ПА",
                    "LABEL_STRING_X" => "м",
                    "COLOR" => "orange"
                )
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