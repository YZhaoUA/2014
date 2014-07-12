<?php
session_start();

include('config_include/connect.php');

if (isset($_GET['TokenID'])) {
    echo $_GET['TokenID'];
}

$closeit = date('Y-m-d');

if ($closeit > '2015-05-12') 
    {
    header('Location: closed.php');
} else {
    
//    //----HQ----login gvid vid billing_info user_password 
//    //----HQ----login logic is useless here
//    $login = filter_input(INPUT_POST, 'login');
//
//    $gvid = filter_input(INPUT_POST, 'gvid');
    $sid = filter_input(INPUT_POST, 'sid');

//    $billing_info = filter_input(INPUT_POST, 'billing_info');
//    $user_password = filter_input(INPUT_POST, 'user_password');

    /*
      $login = $_POST['login'];

      $gvid = $_GET['gvid'];
      $vid = $_POST['vid'];

      $billing_info = $_POST['billing_info'];
      $user_password = $_POST['user_password'];
     */
//    if ($login == "yes") {
//        $login_email = $_POST['login_email'];
//        $login_password = $_POST['login_password'];
//
//        $selectstmt = "select * from $tablesponsor where user_password = '$user_password'";
//        $finduser = mysql_query($selectstmt) or die("Refresh select query failed: " . mysql_error() . ". <BR><BR>The statement is: " . $selectstmt);
//
//        $num = mysql_num_rows($finduser);
//        if ($num == 1) {
//            $ref = mysql_fetch_assoc($finduser);
//            while (list ($key, $val) = each($ref)) {
//                $$key = $val;
//            }
//
//            // until payment is worked out totalpaid will be set to zero
//            if (!$totalpaid) {
//                $totalpaid = 0;
//            }
//
//
//            $msg = "<h1>Thank you, your information has been loaded into the form.</h1>";
//            $msg2 = "<h2>NOTE:  You are able to make changes to your registration form but please be aware that there is a $50 charge administered if we are required to provide refunds as a result of your changes.</h2>";
//        } else {
//            $msg = "<h2 class='red' align='right'>There was an error with your email or password. Please try again.</h2>";
//        }
//    }

    if (isset($sid) && $sid != "") {
        $selectstmt = "select * from $tablesponsor where sid = $sid";
        $finduser = mysql_query($selectstmt) or die("Refresh select query failed: " . mysql_error() . ". <BR><BR>The statement is: " . $selectstmt);

        $num = mysql_num_rows($finduser);
        if ($num == 1) {
            $ref = mysql_fetch_assoc($finduser);
            while (list ($key, $val) = each($ref)) {
                $$key = $val;
            }

            // until payment is worked out totalpaid will be set to zero
            if (!isset($totalpaid)) {
                $totalpaid = 0;
            }
        }

        //----HQ----table detail seems useless for sponsor, it just here for visitor use
//        $details = "select * from $tabledetailname where vid = '$vid'";
//        $deresult = mysql_query($details) or die("The collection of old detail records statement failed with error: " . mysql_error() . $details);
//
//        while ($deline = mysql_fetch_array($deresult)) {
//            if (substr($deline['funccode'], 0, 2) == 'TU') {
//                if (substr($deline['funccode'], -1) >= 4) {
//                    $tutorialB = $deline['funccode'];
//                    //echo "<p>tutorial b is: $tutorialB</p>";
//                } else {
//                    $tutorialA = $deline['funccode'];
//                    //	echo "<p>tutorial a is: $tutorialA</p>";
//                }
//            } else if ($deline['funccode'] == 'AMZWLK') {
//                $amazing = "Yes";
//            } else {
//                ${substr($deline['funccode'], 0, 2)} = $deline['funccode'];
//                //echo "<p>".substr($deline['funccode'],0,2)." is: ".${substr($deline['funccode'],0,2)}."</p>";
//            }
//        }
        
        //----HQ----promotion code works for visitor only.
        // bring back our promo code
//        if (isset($_POST['promoCode'])) {
//            $promoCode = $_POST['promoCode'];
//        }
    }
    
    if (/*$login != "Yes" && */(!isset($sid) && $sid == "")) {
        // not being passed to the page, kill any open sessions
        session_destroy();
        session_start();
    }
}
//	while (list ($key, $val) = each ($_SESSION))
//	{
//	//  if ($val){
//		$$key = $val;
//		echo $key.": ".$$key."<br>";
//	//	}
//	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Banff/2015 Pipeline Workshop Sponsor Registration</title>
        <link href="css/asmebanffstyles.css" rel="stylesheet" type="text/css">
        <script>
<?php
if (isset($sid) && $sid != "") {
    echo "var sidloaded = true;";
} else {
    echo "var sidloaded = false; ";
}
?>
        </script>
        <script type="text/javascript" src="jquery/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="jquery/jquery.limit-1.2.source.js"></script>
        <script type="text/javascript" src="jquery/colorbox/jquery.colorbox-min.js"></script>
        <script type="text/javascript" src="js/regForm.php"></script>
        <link href="jquery/colorbox/colorbox.css" rel="stylesheet" type="text/css">
        <link href="css/regform.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="wrapper">
            <?php include('includes/header.php'); ?>
            <div id="content">                
                <h3>April 13 – 16, 2015 at
                    The Banff Centre, 
                Banff, Alberta, Canada</h3>
<!--		<p class="red"><strong>Pre-registration will not be available after Monday, April 1, 2013 and you will have to register on-site at the workshop. </strong></p>
    <p class="red"><strong> On-Site Registrations Will Be On A Space-Available Basis Only</strong></p> -->
                <div id="processResponse"> </div>
                <div id="processingHolder" style="display: none; float:left;">
                    <h3>Please wait . . . <br>
                        <img src="images/ajax-loader.gif" title="Loader" alt="Loader" /></h3>
                </div>
                <form name="registration" id="registration" method="post" action="">
                    <div id="registerInfo" <?php
                    if (isset($sid) && $sid != "") {
                        echo "style=\"display:none;\"";
                    }
                    ?>>
                             <?php include('includes/regForm.php'); ?>
                        <p>
                            <!--//////////////////////////////////////////////////////////////////////////////////////////////////////-->

                            <input name="continuebutton2" type="button" class="transformButtonStyle" id="continuebutton2" value="Continue" style="width:auto;margin:0px;">
                        </p>
                        </p>
                    </div>
                </form>
                <div id="conditions">
                    <p class="makeitsmall"><strong>Security and confidentiality of your personal information.</strong> <br>
                        On line registration for the workshop sponsorship is done using a secure server. You may submit sensitive data 
                        (e.g., credit card numbers) to this site with the assurance that all information sent, if in an SSL session, is 
                        encrypted, protecting against disclosure to third parties. All credit card information is processed using the 
                        Beanstream Payment Gateway for enhanced security. Please note that ASME International and Banff/2015 Pipeline Workshop does not sell 
                        attendee lists or disclose contact information to third parties.</p>
                </div>
            </div>
            <div id="footer">&nbsp;
            </div>
<!-- missing a closing div here:        </div>-->
        </div>
    </body>
</html>
