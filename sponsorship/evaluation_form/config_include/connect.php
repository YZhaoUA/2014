<?php

//============================================================
// batch replace copyright
//============================================================
//============================================================
//  Main include doc
//=============================================
//error_reporting(0);
error_reporting( error_reporting() & ~E_NOTICE );

// Declare Section

$username = 'banffpipeline';
$password = '8hLvxnVByHTzxwHn';
$hostname = 'localhost';
$databaseName = 'banffpipeline';

$tableeval = '2013evaluationForm';
$tableexhibit = '2013exibitorEvaluationForm';


// CONNECT TO THE DATABASE
$link = mysql_connect($hostname, $username, $password);
if (!$link) {
    die('Could not connect to database with error : ' . mysql_error());
}
$db = mysql_select_db($databaseName, $link) or die("Connection made. But database '$databaseName' was not found.");
mysql_set_charset('utf8', $link);
?>