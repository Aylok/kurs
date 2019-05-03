<?php

/**
 * Class system
 */
class system
{
    /**
     * @param $ar
     * @param bool $type
     */
    public function p($ar, $type=false){
        echo "<pre>";
        if(!$type)
                print_r($ar);
            else
                var_dump($ar);
        echo "</pre>";
    }

    /**
     * @param string $elName
     * @param array $elData
     * @return string
     */
    public function incEl($elName = "", $elParams = array(), $elData= array()){
        if(!empty($elName)){
            require_once $_SERVER['DOCUMENT_ROOT'].'/core/elements/'.$elName.'/body.php';
        }else{
            return "Element name not specified";
        }
    }
    public function errorHandler($data){
        return $data;
    }
}