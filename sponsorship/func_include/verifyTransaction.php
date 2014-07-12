<?php

//============================================================
// batch replace copyright
//============================================================
//============================================================

include('../include/connect.php');

$checkun = $_GET['ta'];
$checkpw = $_GET['ti'];



//$beanstreamVPusername = "C0rusSh0pAcC35S";
//$beanstreamVPpass = "Sh0pC0rusM0ntr3a";

if (md5($beanstreamVPusername) == $checkun && md5($beanstreamVPpass) == $checkpw) {
    echo $beanstreamVPusername . "." . $beanstreamVPpass;
} else {
    echo "false";
}
?>