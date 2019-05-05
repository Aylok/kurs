<?php
//system::p($elData);
//system::render("smallScheduleGroup",array("onlyBefore" => true));
foreach ($elParams as $el) {
    system::incEl(
        $el["elName"],
        $el,
        array(
            "X" => $elData[$el["X"]],
            "Y" => $elData[$el["Y"]]
        )
    );
}

//system::render("smallScheduleGroup",array("onlyAfter" => true));
