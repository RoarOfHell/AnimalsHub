<?php

function NormalizeDate($date) : string {
    try {
        $dateConverted = new DateTime($date);
        $currentDate = new DateTime();


        $day = $dateConverted->format("d");
        $month = $dateConverted->format("m");
        $year = $dateConverted->format("Y");

        $result = $day . ' ' . GetMonthAtId((int)$month - 1);

        if($currentDate->format("Y") != $year){
            $result .= ' ' . $year;
        }
        else if($currentDate->format("Y") == $year && $currentDate->format("d") == $day && $currentDate->format("m") == $month){
            $result = $dateConverted->format("H:i:s");
        }
        else if($currentDate->format("Y") == $year && (int)$currentDate->format("d")-1 == (int)$day && $currentDate->format("m") == $month){
            $result = 'Вчера';
        }
        else if($currentDate->format("Y") == $year && (int)$currentDate->format("d")-1 != (int)$day && $currentDate->format("m") == $month){
            $result .= ' ' . $dateConverted->format("H:i:s");
        }


       

        return $result;
    } catch (\Throwable $th) {
        return $th->getMessage();
    }
}

function GetMonthAtId($id) : string {
    $monthNames = [
        "Января", "Февраля", "Марта",
        "Апреля", "Мая", "Июня",
        "Июля", "Августа", "Сентября",
        "Октября", "Ноября", "Декабря"
    ];

    return $monthNames[$id];
}