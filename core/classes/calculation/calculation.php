<?php

class calculation
{
    //Число Маха через отношение площадей
    public function ksi($x,$r,$r2,$k){
        echo $x." - ".$r." - ".$r2." - ".$k."<br>";
        return (M_PI*$r*$r)/(M_PI*$r2*$r2) - sqrt(pow((2/($k+1))*(1+(($k-1)/2)*$x*$x),($k+1)/(2*($k-1)))/$x);
    }
    //Давление
    public function pressure($p,$m,$k,$pr=0){
        if($pr)
            $tempValue = 1/pow((1+($k-1)/2*$m*$m),($k/($k-1)));
        else
            $tempValue = $p/pow((1+($k-1)/2*$m*$m),($k/($k-1)));
        return $tempValue;
    }
    //Температура
    public function temperature($t,$m,$k,$pr=0){
        if($pr)
            $tempValue = 1/(1+($k-1)/2*$m*$m);
        else
            $tempValue = $t/(1+($k-1)/2*$m*$m);
        return $tempValue;
    }
    //Плотность через начальное и Мах
    public function densityWithMach($ro,$m,$k,$pr=0){
        if($pr)
            $tempValue = 1/pow((1+($k-1)/2*$m*$m),(1/($k-1)));
        else
            $tempValue = $ro/pow((1+($k-1)/2*$m*$m),(1/($k-1)));
        return $tempValue;
    }
    //Скорость потока
    public function speed($t,$m,$r,$k,$pr=0){
        if($pr)
            $tempValue = $m*sqrt($k*$r*$t);
        else
            $tempValue = $m*sqrt($k*$r*$t);
        return $tempValue;
    }
    //Функция поиска числа Маха через метод половинного деления
    public function findMachHalfDivision($a,$b,$r,$r2,$k){
        $e=0.0001;
        while(abs($a-$b)>$e){
            $c=($a+$b)/2;
            if (self::ksi($a,$r,$r2,$k)*self::ksi($c,$r,$r2,$k)<=0){
                $b=$c;
            }else{
                $a=$c;
            }
        }
        $x=($a+$b)/2;
        return $x;
    }

    public function calc($arrData = array()){
        $arData = array();

        $r1 = $arrData["R1"]; //образующий радиус
        $r2 = $arrData["R2"]; //критический радиус
        $alpha = deg2rad($arrData["ALPHA"]); //угол наклона
        $n = $arrData["N"]; //длина сопла в калибрах
        $ak= $arrData["K"];
        $h = $arrData["H"];//шаг расчета
        $P = $arrData["P"];
        $T = $arrData["T"];
        $R = $arrData["R"];
        $ro0 = $P/($R*$T);

        //точка касания первой окружности и второй
        $k = $r1*sqrt(1 - (4*$r2*$r2) / ( ($r1+$r2)* ($r1+$r2) ) );

        //координаты центра второй окружности
        $x0 = sqrt( ($r1*$r1) + (2*$r1*$r2) - (3*$r2*$r2) );
        $y0 = 2*$r2;

        //координаты точки начала касательной
        $l = $x0 + $r2 * sin($alpha);
        $b = ($r2 * ( 2 * tan($alpha) - sin($alpha))) / tan($alpha);

        //длина от 0 до конца сопла
        $d = $x0 + $n*$r2;

        $x=0;
        //координаты точек окружности первой
        while($x<$k) {
            $y = sqrt($r1*$r1 - $x*$x);
            $arData[] = array("x"=>$x,"y"=>$y);
            $x = $x + $h;
        }
        //координаты точек окружности Rкр от 270 градусов до точки касательной
        while($x<$l) {
            $y = $y0 - sqrt($r2*$r2 - ($x-$x0)*($x-$x0));
            $arData[] = array("x"=>$x,"y"=>$y);
            $x = $x + $h;
        }
        //находим координаты точек касательной
        while($x<$d) {
            $y = tan($alpha) * ($x - $l) + $b;
            $arData[] = array("x" => $x, "y" => $y);
            $x = $x + $h;
        }


        //считаем число Маха, температуру, давление и плотность
        foreach ($arData as $key => $data) {
            if($data["x"]>$x0){
                $arData[$key]["MACH"] = self::findMachHalfDivision(1,10,$data["y"],$r2,$ak);
                $arData[$key]["TEMP"] = self::temperature($T,$arData[$key]["MACH"],$ak,0);
                $arData[$key]["DAV"] = self::pressure($P,$arData[$key]["MACH"],$ak,0);
                $arData[$key]["RO"] = self::densityWithMach($ro0,$arData[$key]["MACH"],$ak,0);
                $arData[$key]["TEMPWT"] = self::temperature($T,$arData[$key]["MACH"],$ak,1);
                $arData[$key]["DAVWT"] = self::pressure($P,$arData[$key]["MACH"],$ak,1);
                $arData[$key]["ROWT"] = self::densityWithMach($ro0,$arData[$key]["MACH"],$ak,1);
                $arData[$key]["SPEED"] = self::speed($arData[$key]["TEMP"],$arData[$key]["MACH"],$R,$ak,1);
                $tempArray["TEMP"][] = $arData[$key]["TEMPWT"];
                $tempArray["DAV"][] = $arData[$key]["DAVWT"];
                $tempArray["RO"][] = $arData[$key]["ROWT"];
            }elseif ($data["x"]<$x0){
                $arData[$key]["MACH"] = self::findMachHalfDivision(0,1,$data["y"],$r2,$ak);
                $arData[$key]["TEMP"] = self::temperature($T,$arData[$key]["MACH"],$ak);
                $arData[$key]["DAV"] = self::pressure($P,$arData[$key]["MACH"],$ak);
                $arData[$key]["RO"] = self::densityWithMach($ro0,$arData[$key]["MACH"],$ak);
                $arData[$key]["TEMPWT"] = self::temperature($T,$arData[$key]["MACH"],$ak,1);
                $arData[$key]["DAVWT"] = self::pressure($P,$arData[$key]["MACH"],$ak,1);
                $arData[$key]["ROWT"] = self::densityWithMach($ro0,$arData[$key]["MACH"],$ak,1);
                $arData[$key]["SPEED"] = self::speed($arData[$key]["TEMP"],$arData[$key]["MACH"],$R,$ak,1);
                $tempArray["TEMP"][] = $arData[$key]["TEMPWT"];
                $tempArray["DAV"][] = $arData[$key]["DAVWT"];
                $tempArray["RO"][] = $arData[$key]["ROWT"];
            }
        }
        return $arData;
    }
}