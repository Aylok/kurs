<?php

/**
 * Class system
 */
class system
{
    //private $renderContent;
    /**
     * @param $ar
     * @param bool $type
     */
    public function p($ar, $type = false)
    {
        echo "<pre>";
        if (!$type)
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
    public function incEl($elName = "", $elParams = array(), $elData = array())
    {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/core/elements/' . $elName . '/body.php')) {
            require $_SERVER['DOCUMENT_ROOT'] . '/core/elements/' . $elName . '/body.php';
        } else {
            return "Element not specified";
        }
    }

    public function errorHandler($fromUser = array(), $defaultValue = array())
    {
        $errorString ='';
        $errorArray = array();
        $errorArray["ERROR"] = false;
        foreach ($fromUser as $key => $value){
            if(!isset($value) || empty($value)){
                $errorString.= 'Не установлено значение для <span class="error_title">'.$defaultValue["DESCRIPTION"][$key].'</span>!<br>';
            }
        }
        if(!empty($errorString)){
            $errorArray["ERROR"] = true;
        }
        $errorArray["errorString"] = '<h1>ОШИБКА!!!</h1>'.$errorString;
        return $errorArray;
    }

    public function renderElement($elTmpl, $params = array(), $echo = false)
    {
        //self::p($params);
        extract($params);
        ob_start();
        if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/core/view/elements/' . $elTmpl . '/body_before.php') && $onlyBefore){
            include $_SERVER['DOCUMENT_ROOT'] . '/core/view/elements/' . $elTmpl . '/body_before.php';
        }
        if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/core/view/elements/' . $elTmpl . '/body.php')){
            include  $_SERVER['DOCUMENT_ROOT'] . '/core/view/elements/' . $elTmpl . '/body.php';
        }
        if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/core/view/elements/' . $elTmpl . '/body_after.php') && $onlyAfter){
            include $_SERVER['DOCUMENT_ROOT'] . '/core/view/elements/' . $elTmpl . '/body_after.php';
        }
        if ($echo) {
            echo ob_get_clean();
        }
    }
}