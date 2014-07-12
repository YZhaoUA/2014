<?php

session_start();
include('../config_include/connect.php');

function setJsonFail($p_message) {
    $return['error'] = true;
    $return['msg'] = $p_message;
    echo json_encode($return, true);
}

function setJson($p_id, $p_first, $p_last, $p_company, $p_email) {
    $return['error'] = false;
    $return['id'] = $p_id;
    $return['first'] = $p_first;
    $return['last'] = $p_last;
    $return['company'] = $p_company;
    $return['email'] = $p_email;
    echo json_encode($return, true);
}

$test = "";
reset($_POST);
while (list ($key, $val) = each($_POST)) {
    //  if ($val){
    $$key = $val;
    //echo $key.": ".$$key."<br>";
    $test.="<p>$key: $val</p>";
}
$where = "";

$att = explode("|", ${$drawtype . "ids"});
$attL = sizeof($att) - 1;
if ($attL > 0) {
    $where = " where id!='' ";
}


for ($i = 0; $i < $attL; $i++) {
    $where .= " and id!='" . $att[$i] . "' ";
}

if ($drawtype == "exhibitor") {
    $table = $tableexhibit;
} else {
    $table = $tableeval;
}

$select = "select * from $table $where order by rand() limit 1";
$result = mysql_query($select) or die(setJsonFail("There was an error selecting a record. Please try again"));
$res = mysql_fetch_assoc($result);

sleep(1);
die(setJson($res['id'], $res['fname'], $res['lname'], $res['company'], $res['email']));
?>
