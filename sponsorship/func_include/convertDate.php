<?php

//============================================================
// batch replace copyright
//============================================================

function convertDateLong($d, $t) {
    $datePieces = explode("-", $d);
    $dateYear = $datePieces[0];
    $dateMonth = $datePieces[1];
    $dateDay = $datePieces[2];

    $ttt = date("Y-m-d", mktime(0, 0, 0, $dateMonth, $dateDay + $t, $dateYear));

    $datePieces = explode("-", $ttt);
    $dateYear = $datePieces[0];
    $dateMonth = $datePieces[1];
    $dateDay = $datePieces[2];
    $timestamp = mktime(0, 0, 0, $dateMonth, $dateDay, $dateYear);
    $dayOfWeek = strftime("%A", $timestamp);
    $month = strftime("%B", mktime(0, 0, 0, $dateMonth + 1, 0, 0));

    $dateString = $dayOfWeek . ", " . $month . " " . $dateDay . ", " . $dateYear;


    //for french conversion	
    if (isset($_SESSION['langPref']) && $_SESSION['langPref'] == "FR") {
        if ($month == "January") {
            $month = 'janvier';
        }
        if ($month == "February") {
            $month = 'février';
        }
        if ($month == "March") {
            $month = 'mars';
        }
        if ($month == "April") {
            $month = 'avril';
        }
        if ($month == "May") {
            $month = 'mai';
        }
        if ($month == "June") {
            $month = 'juin';
        }
        if ($month == "July") {
            $month = 'juillet';
        }
        if ($month == "August") {
            $month = 'août';
        }
        if ($month == "September") {
            $month = 'septembre';
        }
        if ($month == "October") {
            $month = 'octobre';
        }
        if ($month == "November") {
            $month = 'novembre';
        }
        if ($month == "December") {
            $month = 'décembre';
        }

        if ($dayOfWeek == "Sunday") {
            $dayOfWeek = "lundi";
        }
        if ($dayOfWeek == "Monday") {
            $dayOfWeek = "mardi";
        }
        if ($dayOfWeek == "Tuesday") {
            $dayOfWeek = "mercredi";
        }
        if ($dayOfWeek == "Wednesday") {
            $dayOfWeek = "jeudi";
        }
        if ($dayOfWeek == "Thusday") {
            $dayOfWeek = "vendredi";
        }
        if ($dayOfWeek == "Friday") {
            $dayOfWeek = "samedi";
        }
        if ($dayOfWeek == "Saturday") {
            $dayOfWeek = "dimanche";
        }

        $dateString = $dateDay . " " . $month . " " . $dateYear;
    }

    return $dateString;
}

function convertDateShort($d, $t) {
    $datePieces = explode("-", $d);
    $dateYear = $datePieces[0];
    $dateMonth = $datePieces[1];
    $dateDay = $datePieces[2];

    $ttt = date("Y-m-d", mktime(0, 0, 0, $dateMonth, $dateDay + $t, $dateYear));

    $datePieces = explode("-", $ttt);
    $dateYear = $datePieces[0];
    $dateMonth = $datePieces[1];
    $dateDay = $datePieces[2];
    $timestamp = mktime(0, 0, 0, $dateMonth, $dateDay, $dateYear);
    $dayOfWeek = strftime("%a", $timestamp);
    $month = strftime("%b", mktime(0, 0, 0, $dateMonth + 1, 0, 0));
    $dateString = $dayOfWeek . ", " . $month . " " . $dateDay;

// for french conversion	
    if (isset($_SESSION['langPref']) && $_SESSION['langPref'] == "FR") {
        if ($month == "Jan") {
            $month = 'janv';
        }
        if ($month == "Feb") {
            $month = 'févr';
        }
        if ($month == "Mar") {
            $month = 'mars';
        }
        if ($month == "Apr") {
            $month = 'avril';
        }
        if ($month == "May") {
            $month = 'mai';
        }
        if ($month == "Jun") {
            $month = 'juin';
        }
        if ($month == "Jul") {
            $month = 'juil';
        }
        if ($month == "Aug") {
            $month = 'août';
        }
        if ($month == "Sep") {
            $month = 'sept';
        }
        if ($month == "Oct") {
            $month = 'oct';
        }
        if ($month == "Nov") {
            $month = 'nov';
        }
        if ($month == "Dec") {
            $month = 'déc';
        }

        if ($dayOfWeek == "Sun") {
            $dayOfWeek = "lun";
        }
        if ($dayOfWeek == "Mon") {
            $dayOfWeek = "mar";
        }
        if ($dayOfWeek == "Tue") {
            $dayOfWeek = "mer";
        }
        if ($dayOfWeek == "Wed") {
            $dayOfWeek = "jeu";
        }
        if ($dayOfWeek == "Thu") {
            $dayOfWeek = "ven";
        }
        if ($dayOfWeek == "Fri") {
            $dayOfWeek = "sam";
        }
        if ($dayOfWeek == "Sat") {
            $dayOfWeek = "dim";
        }
        $dateString = $dayOfWeek . ", " . $dateDay . " " . $month;
    }
    return $dateString;
}

?>