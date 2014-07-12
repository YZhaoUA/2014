<?php

session_start();
include('../config_include/connect.php');

function setJson($p_error, $p_form, $p_message, $p_instructions) {
    $return['error'] = $p_error;
    $return['showForm'] = $p_form;
    $return['msg'] = $p_message;
    $return['instructions'] = $p_instructions;
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
//setJson(true,true,$test,""); die();
if (isset($question2)) {
    $q2L = sizeof($question2);
    $question2compiled = '';
    for ($a = 0; $a < $q2L; $a++) {
        $question2compiled.=$question2[$a] . "\n";
    }
    if (isset($question2other)) {
        $question2compiled.=" (" . $question2other . ")";
    }
    $question2 = $question2compiled;
} else {
    $question2 = "";
}
if (isset($question3)) {
    if (isset($question3other2)) {
        $question3 .= " (" . $question3other2 . ")";
    }
    if (isset($question3other4)) {
        $question3 .= " (" . $question3other4 . ")";
    }
} else {
    $question3 = "";
}
//echo $test;  die();
//die(setJson(true,true,"$test","test"));
sleep(1);

//setJson(true,false, "test","test");
//die();

if (isset($_SESSION['tempSessCheckoutId']) && $_SESSION['tempSessCheckoutId'] != "") {
    $checkoutId = $_SESSION['tempSessCheckoutId'];

    $veristring = $checkoutId;
    // create a salt from the string
    $verisalt = substr($veristring, 0, 1) . substr($veristring, round((strlen($veristring) - 1) / 2), 1) . substr($veristring, 9, 1);
    // hash the value to pass through Ajax
    $verihash = sha1($veristring . $verisalt);

    $passedId = $_POST['checkoutId'];
    //setJson(true,true,$test.$verihash." = ".$passedId,""); die();
    if ($verihash === $passedId) {
        // check if they've already entered
        $select = "select lname, email from $tableexhibit where lname='" . mysql_real_escape_string($lname) . "' and email='" . mysql_real_escape_string($email) . "' order by lname desc limit 1";
        $result = mysql_query($select) or die(setJson(true, true, "There was an error processing the form</h1><p>If you wish to try again, please refresh your browser window.</p>", ""));
        $num = mysql_num_rows($result);
        if ($num === 1) {
            die(setJson(false, false, "<h1>We're sorry.</h1>", "<p><strong>Our records indicate you've already filled in an evaluation form. Thank you for taking the time to complete the evaluation.</strong></p>"));
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //start processing form ////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $insert = "insert into $tableexhibit
			(question1, question2, question3, question4objectives, question4achieved, question4comments, question5, question5tutorials, question5a, question5b, question5comments, question5future, question6, question6workgroups, question6a, question6b, question6comments, question7, question8, question9, question10, question11, question12, question13, fname, lname, company, email )
			values
			('" . mysql_real_escape_string($question1) . "', '" . mysql_real_escape_string($question2) . "', '" . mysql_real_escape_string($question3) . "', '" . mysql_real_escape_string($question4objectives) . "', '" . mysql_real_escape_string($question4achieved) . "', '" . mysql_real_escape_string($question4comments) . "', '" . mysql_real_escape_string($question5) . "', '" . mysql_real_escape_string($question5tutorials) . "', '" . mysql_real_escape_string($question5a) . "', '" . mysql_real_escape_string($question5b) . "', '" . mysql_real_escape_string($question5comments) . "', '" . mysql_real_escape_string($question5commentsfuture) . "','" . mysql_real_escape_string($question6) . "', '" . mysql_real_escape_string($question6workgroups) . "', '" . mysql_real_escape_string($question6a) . "', '" . mysql_real_escape_string($question6b) . "', '" . mysql_real_escape_string($question6comments) . "', '" . mysql_real_escape_string($question7) . "', '" . mysql_real_escape_string($question8) . "', '" . mysql_real_escape_string($question9) . "', '" . mysql_real_escape_string($question10) . "', '" . mysql_real_escape_string($question11) . "', '" . mysql_real_escape_string($question12) . "', '" . mysql_real_escape_string($question13) . "', '" . mysql_real_escape_string($fname) . "', '" . mysql_real_escape_string($lname) . "', '" . mysql_real_escape_string($company) . "', '" . mysql_real_escape_string($email) . "'  )
			";
        $result = mysql_query($insert) or die(setJson(true, true, "<h1>There was an error processing the form.</h1><p>" . mysql_error() . "</p>$insert", ""));

        setJson(false, false, "<h1>Thank you.</h1>", "<p>Your evaluation form has been successfully sent. Thank you for taking the time to provide us your feedback.</p>");

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // end form processing
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    } else {
        setJson(true, true, "<h1>There was an error processing the form.</h1><p>If you wish to try again, please refresh your browser window.</p>", "");
        die();
    }
} else {
    header("Location: ../error.php");
}
?>
