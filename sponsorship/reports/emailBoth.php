<?php

// ----------------------------------------------------------------
// Written for IPC by Heidi at id associates
// On: Good Friday April 14th, right before the bike trip :D
// Why: This form draws the invoice and emails it to the user
// ----------------------------------------------------------------
include ('../config_include/connect.php');
include ('../config_include/eventVariables.php');
include ('../mimemail.inc');

$sid = $_POST['sid'];
$paytype = $_POST['paytype'];

//if ($paytype == 'CC'){
//include '../../2010test/reports/emailbodyCC.php';
//} else {
$thepath = "../";
require ('../emailbody.php');
//}

include ('thankyou_email.php');
?>