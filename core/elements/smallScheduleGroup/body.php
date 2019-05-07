<?php
foreach ($elParams as $key => $el) {
	if ($el["COLOR"]=="")
   		$el["COLOR"] = "green";

	$result["CHARTS"][$key] = array(
	    "NAME" => $el["title"],
	    "CODE" => $el["CODE"],
	    "X" => $el["X"],
	    "COLOR" => $el["COLOR"],
	    "LABEL_STRING_X" => $el["LABEL_STRING_X"],
	    "LABEL_STRING_Y" => $el["LABEL_STRING_Y"],
	    "DATA" => array(
        	"X" => $elData[$el["X"]],
            "Y" => $elData[$el["Y"]]
        )
	);
}
//system::p($result);
system::renderElement("smallScheduleGroup",array("result"=>$result), true);
