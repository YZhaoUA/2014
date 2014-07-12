<?php

//============================================================
// batch replace copyright
//============================================================
//============================================================
//  Main include doc
//=============================================
//error_reporting(0);
error_reporting( error_reporting() & ~E_NOTICE );
function convertDate($d) {
    $datePieces = explode("-", $d);
    $dateYear = $datePieces[0];
    $dateMonth = $datePieces[1];
    $dateDay = $datePieces[2];
    $timestamp = mktime(0, 0, 0, $dateMonth, $dateDay, $dateYear);
    $dayOfWeek = strftime("%A", $timestamp);
    $month = strftime("%B", mktime(0, 0, 0, $dateMonth + 1, 0, 0));

    //$dateString = $dayOfWeek . ", " . $month . " " . $dateDay . ", " . $dateYear; 
    $dateString = $month . " " . $dateDay . ", " . $dateYear;
    return $dateString;
}

// Declare Section

$username = 'banffpipeline';
$password = '8hLvxnVByHTzxwHn';
$hostname = 'localhost';
$databaseName = 'banffpipeline';

$tablename = '2015visitor'; // for workshop registrants
$tablesponsor = '2015sponsor'; // for sponsorship sign up
$tabledetailname = '2015confDetail'; // holds workshop information
$holddetail = '2015holdDetail'; // stores changes to workshop registration
$conference = '2015conferenceNew'; // holds all workshop information
$tableIP = '2015ipTrack'; // stores login attempts
$tablePayment = '2015paymentHistory'; // payments on workshop registration
$tablePaymentSponsor = '2015paymentSponsorship'; // sponsorship payments
$tableCountries = 'countryList'; // old country list
$tableCountriesNew = 'asmeCountryList'; // new country list
$tableprofile = '2015visitorProfile'; // login profiles
$tablepromo = '2015promo'; // promotional codes
$tablecomments = '2015comments'; // comments table
$tablegroups = '2015workGroups'; // list of workgroups
// CONNECT TO THE DATABASE
$link = mysql_connect($hostname, $username, $password);
if (!$link) {
    die('Could not connect to database with error : ' . mysql_error());
}
$db = mysql_select_db($databaseName, $link) or die("Connection made. But database '$databaseName' was not found.");

mysql_set_charset('utf8', $link);

//0.00 = 0.00; // 1.00;
?>