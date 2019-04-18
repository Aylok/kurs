<?php

class system
{
    public function p($ar,$type=false){
        echo "<pre>";
        if(!$type)
                print_r($ar);
            else
                var_dump($ar);
        echo "</pre>";
    }
    public function incEl($elName = "", $elData= array()){
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