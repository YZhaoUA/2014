<?php

//	reset ($_POST);
//	while (list ($key, $val) = each ($_POST))
//	{
//	  if ($val)
//		$$key = $val;
//		echo $key.": ".$$key."<br>";
//	}

$vid = $_POST['vid'];
$asmemember = $_POST['asmemember'];
$coopsociety = $_POST['coopsociety'];
$sal = $_POST['sal'];
$fname = $_POST['fname'];
$nickname = $_POST['nickname'];
$mname = $_POST['mname'];
$lname = $_POST['lname'];
$title = $_POST['title'];
$engineer = $_POST['engineer'];
$years_petro = $_POST['years_petro'];
$company = $_POST['company'];
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$zip = $_POST['zip'];
$phoneArea = $_POST['phoneArea'];
$phone = $_POST['phone'];
$faxArea = $_POST['faxArea'];
$fax = $_POST['fax'];
$interfax = $_POST['interfax'];
$email = $_POST['email'];
$user_password = $_POST['user_password'];
// billing info
$billing = $_POST['billing_check'];
$billing_sal = $_POST['billing_sal'];
$billing_fname = $_POST['billing_fname'];
$billing_lname = $_POST['billing_lname'];
$billing_title = $_POST['billing_title'];
$billing_company = $_POST['billing_company'];
$billing_address1 = $_POST['billing_address1'];
$billing_address2 = $_POST['billing_address2'];
$billing_city = $_POST['billing_city'];
$billing_state = $_POST['billing_state'];
$billing_country = $_POST['billing_country'];
$billing_zip = $_POST['billing_zip'];
$billing_phoneArea = $_POST['billing_phoneArea'];
$billing_phone = $_POST['billing_phone'];
$billing_faxArea = $_POST['billing_faxArea'];
$billing_fax = $_POST['billing_fax'];
$billing_interfax = $_POST['billing_interfax'];
$billing_email = $_POST['billing_email'];
//
$partnerfname = $_POST['partnerfname'];
$partnerlname = $_POST['partnerlname'];
$type = $_POST['type'];
$level = $_POST['level'];
$interest1 = $_POST['interest1'];
$interest2 = $_POST['interest2'];
$interest3 = $_POST['interest3'];
$funccode = $_POST['funccode'];

$topPriority = $_POST['topPriority'];
$secondPriority = $_POST['secondPriority'];
$thirdPriority = $_POST['thirdPriority'];
$paper_number = $_POST['paper_number'];


$totalpaid = $_POST['totalpaid'];
$totaldue = $_POST['totaldue'];
$totalcharged = $_POST['totalcharged'];
$datepaid = $_POST['datepaid'];

//debugging //echo " this number : " . substr($funccode,3,4);
//test to see if half day
if (substr($funccode, 3, 4) == 2) {
    $day = $_POST['holdDay'];
} else {
    $day = '';
}
$oneday = 'N';
if ($day) {
    $oneday = 'Y';
} else {
    $oneday = 'N';
}
$mainflag = $_POST['mainflag'];
$blanket = $_POST['blanket'];

$funccodetotal = $_POST['funccodetotal'];
$recptix = $_POST['recptix'];
$recptotal = $_POST['recptotal'];
$lunttix = $_POST['lunttix'];
$lunttotal = $_POST['lunttotal'];
$lunwtix = $_POST['lunwtix'];
$lunwtotal = $_POST['lunwtotal'];
$netwtix = $_POST['netwtix'];
$netwtotal = $_POST['netwtotal'];
$luthtix = $_POST['luthtix'];
$luthtotal = $_POST['luthtotal'];
$lunftix = $_POST['lunftix'];
$lunftotal = $_POST['lunftotal'];
$procnum = $_POST['procnum'];
$proctotal = $_POST['proctotal'];
$tixsubtotal = $_POST['tixsubtotal'];

$paper_numbers = $_POST['paper_numbers'];
$presenting = $_POST['presenting'];




//hidden
$tut1 = $_POST['tut1'];
$tut2 = $_POST['tut2'];
$tut3 = $_POST['tut3'];
$tut4 = $_POST['tut4'];

$mondayPNLcost = $_POST['mondayPNLcost'];
$wednesdayPNLcost = $_POST['wednesdayPNLcost'];


// end of hidden
// TU00 represents a radio button clear so disregard
$tutorials = $_POST['tutorials'];
if ($tutorials == 'TU00') {
    $tutorials = '';
    $tut1 = 0;
}
$amtutorials = $_POST['amtutorials'];
if ($amtutorials == 'TU00') {
    $amtutorials = '';
    $tut2 = 0;
}
$pmtutorials = $_POST['pmtutorials'];
if ($pmtutorials == 'TU00') {
    $pmtutorials = '';
    $tut3 = 0;
}
$wedtutorials = $_POST['wedtutorials'];
if ($wedtutorials == 'TU00') {
    $wedtutorials = '';
    $tut4 = 0;
}
$tutorialsubtotal = $_POST['tutorialsubtotal'];
// grandtotal = totalcharged in the db

$mondaypanelam = $_POST['mondaypanelam'];
$mondayPNLAMcost = $_POST['mondayPNLAMcost'];
$mondaypanelpm = $_POST['mondaypanelpm'];
$mondayPNLPMcost = $_POST['mondayPNLPMcost'];
$wednesdaypanel = $_POST['wednesdaypanel'];
$panelsubtotal = $_POST['panelsubtotal'];


$totalcharged = $_POST['totalcharged'];

// to Caps
if ($asmemember)
    $asmemember = strtoupper($asmemember);
if ($coopsociety)
    $coopsociety = strtoupper($coopsociety);
if ($sal)
    $sal = strtoupper($sal);
if (fname)
    $fname = strtoupper($fname);
//if(fname) $fname = strtoupper($fname);
if ($nickname)
    $nickname = strtoupper($nickname);
if ($mname)
    $mname = strtoupper($mname);
if ($lname)
    $lname = strtoupper($lname);
if ($title)
    $title = strtoupper($title);
if ($engineer)
    $engineer = strtoupper($engineer);
if ($company)
    $company = strtoupper($company);
if ($address1)
    $address1 = strtoupper($address1);
if ($address2)
    $address2 = strtoupper($address2);
if ($city)
    $city = strtoupper($city);
if ($state)
    $state = strtoupper($state);
if ($country)
    $country = strtoupper($country);
if ($zip)
    $zip = strtoupper($zip);
if ($partnerfname)
    $partnerfname = strtoupper($partnerfname);
if ($partnerlname)
    $partnerlname = strtoupper($partnerlname);
if ($type)
    $type = strtoupper($type);
//if ($interest1) $interest1 = strtoupper($interest1);
//if ($interest2) $interest2 = strtoupper($interest2);
//if ($interest3) $interest3 = strtoupper($interest3);

if ($billing_sal)
    $sal = strtoupper($sal);
if ($billing_fname)
    $billing_fname = strtoupper($billing_fname);
if ($billing_lname)
    $billing_lname = strtoupper($billing_lname);
if ($billing_title)
    $billing_title = strtoupper($billing_title);
if ($billing_company)
    $billing_company = strtoupper($billing_company);
if ($billing_address1)
    $billing_address1 = strtoupper($billing_address1);
if ($billing_address2)
    $billing_address2 = strtoupper($billing_address2);
if ($billing_city)
    $billing_city = strtoupper($billing_city);
if ($billing_state)
    $billing_state = strtoupper($billing_state);
if ($billing_country)
    $billing_country = strtoupper($billing_country);
if ($billing_zip)
    $billing_zip = strtoupper($billing_zip);


// Blanket code insert
$blanket = 'N';
if ($funccode == "MBR1" || $funccode == "AUP1" || $funccode == "CHM1" || $funccode == "CSC1" || $funccode == "NMB1") {
    $blanket = 'Y';
}
?>