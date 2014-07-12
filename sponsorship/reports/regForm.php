<!-- // Mike Zhao, REMOVE -->

<?php
session_start();

include('../config_include/connect.php');

if (isset($_GET['TokenID'])) {
    echo $_GET['TokenID'];
}

$closeit = date('Y-m-d');

if ($closeit > '2015-05-12') {
    header('Location: closed.php');
} else {

    $login = $_POST['login'];

    $gvid = $_GET['gvid'];
    $vid = $_POST['vid'];

    $billing_info = $_POST['billing_info'];
    $user_password = $_POST['user_password'];

    if ($login == "yes") {
        $login_email = $_POST['login_email'];
        $login_password = $_POST['login_password'];

        $selectstmt = "select * from $tablesponsor where user_password = '$user_password'";
        $finduser = mysql_query($selectstmt) or die("Refresh select query failed: " . mysql_error() . ". <BR><BR>The statement is: " . $selectstmt);

        $num = mysql_num_rows($finduser);
        if ($num == 1) {
            $ref = mysql_fetch_assoc($finduser);
            while (list ($key, $val) = each($ref)) {
                $$key = $val;
            }

            // until payment is worked out totalpaid will be set to zero
            if (!$totalpaid) {
                $totalpaid = 0;
            }

//				$selected[sal][$row[sal]]="selected";
//				$selected[ss][$row[level]]="selected";
//				$selected[type][$row[type]]="selected";
//				$selected[interest1][$row[interest1]]="selected";
//				$selected[interest2][$row[interest2]]="selected";
//				$selected[interest3][$row[interest3]]="selected";

            $msg = "<h1>Thank you, your information has been loaded into the form.</h1>";
            $msg2 = "<h2>NOTE:  You are able to make changes to your registration form but please be aware that there is a $50 charge administered if we are required to provide refunds as a result of your changes.</h2>";
        } else {
            $msg = "<h2 class='red' align='right'>There was an error with your email or password. Please try again.</h2>";
        }
    }


    if (isset($vid) && $vid != "") {
        $selectstmt = "select * from $tablesponsor where vid = $vid";
        $finduser = mysql_query($selectstmt) or die("Refresh select query failed: " . mysql_error() . ". <BR><BR>The statement is: " . $selectstmt);

        $num = mysql_num_rows($finduser);
        if ($num == 1) {
            $ref = mysql_fetch_assoc($finduser);
            while (list ($key, $val) = each($ref)) {
                $$key = $val;
                //echo $key.": ".$$key."<br>";
            }


            // until payment is worked out totalpaid will be set to zero
            if (!isset($totalpaid)) {
                $totalpaid = 0;
            }
        }

        $details = "select * from $tabledetailname where vid = '$vid'";
        $deresult = mysql_query($details) or die("The collection of old detail records statement failed with error: " . mysql_error() . $details);

        while ($deline = mysql_fetch_array($deresult)) {
            if (substr($deline['funccode'], 0, 2) == 'TU') {
                if (substr($deline['funccode'], -1) >= 4) {
                    $tutorialB = $deline['funccode'];
                    //echo "<p>tutorial b is: $tutorialB</p>";
                } else {
                    $tutorialA = $deline['funccode'];
                    //	echo "<p>tutorial a is: $tutorialA</p>";
                }
            } else if ($deline['funccode'] == 'AMZWLK') {
                $amazing = "Yes";
            } else {
                ${substr($deline['funccode'], 0, 2)} = $deline['funccode'];
                //echo "<p>".substr($deline['funccode'],0,2)." is: ".${substr($deline['funccode'],0,2)}."</p>";
            }
        }

        $promo = "select promoCode from $tablepromo where invoiceSponsor='$vid'";
        $promores = mysql_query($promo);
        $pr = mysql_fetch_array($promores);
        $promoCode = $pr['promoCode'];
    } /* else {
      //include('../includes/formPosts.php');
      //				while (list ($key, $val) = each ($_POST))
      //				{
      //					$$key = $val;
      //				}
      } */
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Banff/2013 Pipeline Workshop Sponsor Registration</title>
        <link href="../css/asmebanffstyles.css" rel="stylesheet" type="text/css">
        <script>
<?php
if (isset($vid) && $vid != "") {
    echo "var sidloaded = true;";
} else {
    echo "var sidloaded = false; ";
}
?>
        </script>
        <script type="text/javascript" src="../jquery/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="../jquery/colorbox/jquery.colorbox-min.js"></script>
        <script type="text/javascript" src="js/regForm.php"></script>
        <link href="../jquery/colorbox/colorbox.css" rel="stylesheet" type="text/css">
        <link href="../css/regform.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="wrapper">
            <?php include('../includes/header.php'); ?>
            <div id="content">
                <div id="regarea">
                    <p><a href="index.php">Back to reports index</a></p>
                    <h3>April 13 – 16, 2015 at
                        The Banff Centre, 
                        Banff, Alberta, Canada</h3>
                    <div id="processResponse"> </div>
                    <div id="processingHolder" style="display: none; float:left;">
                        <h3>Please wait . . . <br>
                            <img src="../images/ajax-loader.gif" title="Loader" alt="Loader" /></h3>
                    </div>
                    <form name="registration" id="registration" method="post" action="">
                        <div id="registerInfo" <?php
                        if (isset($vid) && $vid != "") {
                            echo "style=\"display:none;\"";
                        }
                        ?>>
                            <div class="formBlock">
                                <p class="leftCol required">Required Fields *</p>
                            </div>
                            <div id="registrantInfo" class="formBlock" style="clear:left; width:100%;">
                                <h2>Step 1. Registrant Information</h2>
                                <div class="leftCol notRequired" style="width:20%;">
                                    <p>
                                        <select name="sal" id="sal" class="noreqfield">
                                            <option value="">Salutation</option>
                                            <option value="Mr." <?php
                                            if ($sal == 'MR.') {
                                                echo "selected";
                                            }
                                            ?> >Mr.</option>
                                            <option value="Dr." <?php
                                            if ($sal == 'DR.') {
                                                echo "selected";
                                            }
                                            ?> >Dr.</option>
                                            <option value="Ms." <?php
                                            if ($sal == 'MS.') {
                                                echo "selected";
                                            }
                                            ?> >Ms.</option>
                                            <option value="Mrs." <?php
                                            if ($sal == 'MRS.') {
                                                echo "selected";
                                            }
                                            ?>>Mrs.</option>
                                            <option value="Miss" <?php
                                            if ($sal == 'MISS.') {
                                                echo "selected";
                                            }
                                            ?>>Miss.</option>
                                        </select>
                                    </p>
                                </div>
                                <div style="clear:left;"></div>
                                <div class="leftCol required" style="width:40%;">
                                    <p>First Name
                                        * </p>
                                    <p>
                                        <input name="fname" type="text" class="reqfield" id="fname" value="<?php
                                        if (isset($fname)) {
                                            echo $fname;
                                        }
                                        ?>" />
                                    </p>
                                </div>
                                <div class="leftCol required" style="width:40%;">
                                    <p>Last Name
                                        * (Maximum 23 characters)</p>
                                    <p>
                                        <input name="lname" type="text" class="reqfield" id="lname" value="<?php
                                        if (isset($lname)) {
                                            echo $lname;
                                        }
                                        ?>" maxlength="23"/>
                                    </p>
                                </div>
                                <div style="clear:left;"></div>
                                <div class="leftCol required" style="width:auto; margin-left:50px;">
                                    <p><strong>First name as you would like it to display on Badge</strong> * (max. 17 characters)</p>
                                    <p>
                                        <input name="nickname" type="text" class="reqfield" id="nickname" value="<?php
                                        if (isset($nickname)) {
                                            echo $nickname;
                                        }
                                        ?>" size="40" maxlength="17" style="width:auto;"/>
                                    </p>
                                </div>
                                <div class="leftCol notRequired" style="width:40%;">
                                    <p>Company Name (Maximum 50 characters)</p>
                                    <p>
                                        <input name="company" type="text" id="company" value="<?php
                                        if (isset($company)) {
                                            echo $company;
                                        }
                                        ?>" maxlength="50"  class="noreqfield"/>
                                    </p>
                                </div>
                                <div class="leftCol notRequired" style="width:40%;">
                                    <p>Job Title</p>
                                    <p>
                                        <input name="title" type="text" id="title" value="<?php
                                        if (isset($title)) {
                                            echo $title;
                                        }
                                        ?>" maxlength="50" class="noreqfield" />
                                    </p>
                                </div>
                                <div style="clear:left;"></div>
                                <div class="leftCol required" style="width:92%;">
                                    <p>Address
                                        * </p>
                                    <p>
                                        <input name="address1" type="text" id="address1"  value="<?php
                                        if (isset($address1)) {
                                            echo $address1;
                                        }
                                        ?>" class="reqfield"/>
                                    </p>
                                </div>
                                <div class="leftCol notRequired" style="width:92%;">
                                    <p>Address 2 </p>
                                    <p>
                                        <input name="address2" type="text" id="address2"  value="<?php
                                        if (isset($address2)) {
                                            echo $address2;
                                        }
                                        ?>"  class="noreqfield"/>
                                    </p>
                                </div>
                                <div style="clear:left;"></div>
                                <div class="leftCol required" style="width:50%;">
                                    <p>City
                                        * </p>
                                    <p>
                                        <input name="city" type="text" class="reqfield" id="city" value="<?php
                                        if (isset($city)) {
                                            echo $city;
                                        }
                                        ?>" />
                                    </p>
                                </div>
                                <div class="leftCol notRequired" style="width:30%;">
                                    <p>State/Province</p>
                                    <p>
                                        <input name="state" type="text" id="state" value="<?php
                                        if (isset($state)) {
                                            echo $state;
                                        }
                                        ?>"  class="noreqfield"/>
                                    </p>
                                </div>
                                <div class="leftCol required" style="clear:left;">
                                    <p>Country
                                        * </p>
                                    <p>
                                        <?php
                                        $countries = "select * from $tableCountriesNew";
                                        $countriesResult = mysql_query($countries) or die(mysql_error() . "<br>$countries");
                                        ?>
                                        <select name="country" id="country" class="reqfield" style="width:auto;">
                                            <option value="" <?php
                                            if (!(strcmp("", "$country"))) {
                                                echo "selected=\"selected\"";
                                            }
                                            ?>>Select a Country</option>
                                                    <?php while ($count = mysql_fetch_array($countriesResult)) { ?>
                                                <option value="<?php echo $count['CountryCode']; ?>" <?php
                                                if (!(strcmp($count['CountryCode'], "$country"))) {
                                                    echo "selected=\"selected\"";
                                                }
                                                ?>><?php echo $count['CountryName']; ?></option>
                                                    <?php } ?>
                                        </select>
                                    </p>
                                </div>
                                <div class="leftCol required">
                                    <p>Zip/Postal Code
                                        * </p>
                                    <p>
                                        <input name="zip" type="text" class="reqfield" id="zip" style="width:auto;" value="<?php
                                        if (isset($zip)) {
                                            echo $zip;
                                        }
                                        ?>" size="16"/>
                                    </p>
                                </div>
                                <div style="clear:left;"></div>
                                <div class="leftCol required" style="width:30%">
                                    <p>Phone Number (include area code)
                                        * </p>
                                    <p>
                                        <input name="phone" type="text" class="reqfield" id="phone" value="<?php
                                        if (isset($phone)) {
                                            echo $phone;
                                        }
                                        ?>"/>
                                    </p>
                                </div>
                                <div class="leftCol notRequired" style="width:30%">
                                    <p>Fax Number (include area code) </p>
                                    <p>
                                        <input name="fax" type="text" id="fax" value="<?php
                                        if (isset($fax)) {
                                            echo $fax;
                                        }
                                        ?>" class="noreqfield"/>
                                    </p>
                                </div>
                                <div style="clear:left;"></div>
                                <div class="leftCol required" style="width:92%;">
                                    <p>Email
                                        * </p>
                                    <p>
                                        <input name="user_password" type="hidden" id="user_password" value="<?php
                                        if (isset($user_password)) {
                                            echo $user_password;
                                        }
                                        ?>">
                                        <input name="email" type="text" class="reqfield" id="email" value="<?php
                                        if (isset($email)) {
                                            echo $email;
                                        }
                                        ?>" />
                                    </p>
                                </div>
                                <div style="clear:left;"></div>
                            </div>
                            <div id="billing" class="formBlock" style="width:100%;">
                                <h4 id="schedule">
                                    <label>
                                        <input <?php
                                        if (!(strcmp("$billing", "Yes"))) {
                                            echo "checked=\"checked\"";
                                        }
                                        ?> name="billing_check" type="checkbox" id="billing_check"  value="Yes">
                                        <strong>This registration is to be billed to a different contact.</strong> <br>
                                        <em style="font-size:90%;">Billing contacts will also receive a copy of the invoice as well as the purchase receipt if paying by credit card.</em> </label>
                                </h4>
                                <div id="billingInfo" <?php
                                if (!isset($billing) || $billing == "") {
                                    echo "style=\"display:none;\"";
                                }
                                ?>>
                                    <h3>Billing Information</h3>
                                    <div class="leftCol notRequired" style="width:20%;">
                                        <p>
                                            <select name="billing_sal" id="billing_sal" class="noreqfield">
                                                <option value="">Salutation</option>
                                                <option value="Mr." <?php
                                                if ($billing_sal == 'MR.') {
                                                    echo "selected";
                                                }
                                                ?> >Mr.</option>
                                                <option value="Dr." <?php
                                                if ($billing_sal == 'DR.') {
                                                    echo "selected";
                                                }
                                                ?> >Dr.</option>
                                                <option value="Ms." <?php
                                                if ($billing_sal == 'MS.') {
                                                    echo "selected";
                                                }
                                                ?> >Ms.</option>
                                                <option value="Mrs." <?php
                                                if ($billing_sal == 'MRS.') {
                                                    echo "selected";
                                                }
                                                ?>>Mrs.</option>
                                                <option value="Miss" <?php
                                                if ($billing_sal == 'MISS.') {
                                                    echo "selected";
                                                }
                                                ?>>Miss.</option>
                                            </select>
                                        </p>
                                    </div>
                                    <div style="clear:left;"></div>
                                    <div class="leftCol required" style="width:40%;">
                                        <p>First Name
                                            * </p>
                                        <p>
                                            <input name="billing_fname" type="text" class="reqfield" id="billing_fname" value="<?php
                                            if (isset($billing_fname)) {
                                                echo $billing_fname;
                                            }
                                            ?>" />
                                        </p>
                                    </div>
                                    <div class="leftCol required" style="width:40%;">
                                        <p>Last Name
                                            * </p>
                                        <p>
                                            <input name="billing_lname" type="text" class="reqfield" id="billing_lname" value="<?php
                                            if (isset($billing_lname)) {
                                                echo $billing_lname;
                                            }
                                            ?>"/>
                                        </p>
                                    </div>
                                    <div style="clear:left;"></div>
                                    <div class="leftCol notRequired" style="width:40%;">
                                        <p>Company Name</p>
                                        <p>
                                            <input name="billing_company" type="text" id="billing_company" value="<?php
                                            if (isset($billing_company)) {
                                                echo $billing_company;
                                            }
                                            ?>" maxlength="50" class="noreqfield" />
                                        </p>
                                    </div>
                                    <div class="leftCol notRequired" style="width:40%;">
                                        <p>Job Title</p>
                                        <p>
                                            <input name="billing_title" type="text" id="billing_title" value="<?php
                                            if (isset($billing_title)) {
                                                echo $billing_title;
                                            }
                                            ?>" maxlength="50" class="noreqfield" />
                                        </p>
                                    </div>
                                    <div style="clear:left;"></div>
                                    <div class="leftCol required" style="width:92%;">
                                        <p>Address
                                            * </p>
                                        <p>
                                            <input name="billing_address1" type="text" id="billing_address1"  value="<?php
                                            if (isset($billing_address1)) {
                                                echo $billing_address1;
                                            }
                                            ?>" class="reqfield"/>
                                        </p>
                                    </div>
                                    <div class="leftCol notRequired" style="width:92%;">
                                        <p>Address 2 </p>
                                        <p>
                                            <input name="billing_address2" type="text" id="billing_address2"  value="<?php
                                            if (isset($billing_address2)) {
                                                echo $billing_address2;
                                            }
                                            ?>" class="noreqfield" />
                                        </p>
                                    </div>
                                    <div style="clear:left;"></div>
                                    <div class="leftCol required" style="width:50%;">
                                        <p>City
                                            * </p>
                                        <p>
                                            <input name="billing_city" type="text" class="reqfield" id="billing_city" value="<?php
                                            if (isset($billing_city)) {
                                                echo $billing_city;
                                            }
                                            ?>" />
                                        </p>
                                    </div>
                                    <div class="leftCol notRequired" style="width:30%;">
                                        <p>Province </p>
                                        <p>
                                            <input name="billing_state" type="text" id="billing_state" value="<?php
                                            if (isset($billing_state)) {
                                                echo $billing_state;
                                            }
                                            ?>" class="noreqfield" />
                                        </p>
                                    </div>
                                    <div class="leftCol required" style="clear:left;">
                                        <p>Country
                                            * </p>
                                        <p>
                                            <?php
                                            $countries = "select * from $tableCountriesNew";
                                            $countriesResult = mysql_query($countries) or die(mysql_error() . "<br>$countries");
                                            ?>
                                            <select name="billing_country" id="billing_country" class="reqfield" style="width:auto;">
                                                <option value="" <?php
                                                if (!(strcmp("", "$billing_country"))) {
                                                    echo "selected=\"selected\"";
                                                }
                                                ?>>Select a Country</option>
                                                        <?php while ($count = mysql_fetch_array($countriesResult)) { ?>
                                                    <option value="<?php echo $count['CountryCode']; ?>" <?php
                                                    if (!(strcmp($count['CountryCode'], "$billing_country"))) {
                                                        echo "selected=\"selected\"";
                                                    }
                                                    ?>><?php echo $count['CountryName']; ?></option>
                                                        <?php } ?>
                                            </select>
                                        </p>
                                    </div>
                                    <div class="leftCol required">
                                        <p>Zip/Postal Code
                                            * </p>
                                        <p>
                                            <input name="billing_zip" type="text" class="reqfield" id="billing_zip" style="width:auto;" value="<?php
                                            if (isset($billing_zip)) {
                                                echo $billing_zip;
                                            }
                                            ?>" size="16"/>
                                        </p>
                                    </div>
                                    <div style="clear:left;"></div>
                                    <div class="leftCol required" style="width:30%">
                                        <p>Phone Number (include area code)
                                            * </p>
                                        <p>
                                            <input name="billing_phone" type="text" class="reqfield" id="billing_phone" value="<?php
                                            if (isset($billing_phone)) {
                                                echo $billing_phone;
                                            }
                                            ?>"/>
                                        </p>
                                    </div>
                                    <div class="leftCol notRequired" style="width:30%">
                                        <p>Fax Number (include area code)
                                            * </p>
                                        <p>
                                            <input name="billing_fax" type="text" id="billing_fax" value="<?php
                                            if (isset($billing_fax)) {
                                                echo $billing_fax;
                                            }
                                            ?>" class="noreqfield"/>
                                        </p>
                                    </div>
                                    <div style="clear:left;"></div>
                                    <div class="leftCol required" style="width:92%;">
                                        <p>Email
                                            * </p>
                                        <p>
                                            <input name="billing_email" type="text" class="reqfield" id="billing_email" value="<?php
                                            if (isset($billing_email)) {
                                                echo $billing_email;
                                            }
                                            ?>" />
                                        </p>
                                    </div>
                                    <div style="clear:left;"></div>
                                </div>
                            </div>
                            <p>
                                <input name="continuebutton" type="button" class="transformButtonStyle" id="<?php
                                if (!isset($vid) || $vid == "") {
                                    echo "continuebutton";
                                } else {
                                    echo "savechanges";
                                }
                                ?>" value="<?php
                                       if (!isset($vid) || $vid == "") {
                                           echo "Continue";
                                       } else {
                                           echo "Save Changes";
                                       }
                                       ?>" style="width:auto;">
                            </p>
                        </div>
                        <div id="registrantSummary" class="formBlock" <?php
                        if (!isset($vid) || $vid == "") {
                            echo "style=\"display:block;\"";
                        }
                        ?>>
                            <div id="registrantFields" class="leftCol summaries" style="width:40%;">
                                <h3>Registrant Information</h3>
                                <p id="regName">Name</p>
                                <p id="regCompany">company</p>
                                <p id="regAddress">address<br />
                                    city, province<br />
                                    country&nbsp;&nbsp;Postal</p>
                                <p id="regEmail">email</p>
                                <p id="regPhone">phone</p>
                            </div>
                            <div id="billingFields" class="leftCol summaries" style="width:40%;">
                                <h3>Billing Information</h3>
                                <p id="billName">Name</p>
                                <p id="billCompany">company</p>
                                <p id="billAddress">address<br />
                                    city, province<br />
                                    country&nbsp;&nbsp;Postal</p>
                                <p id="billEmail">email</p>
                                <p id="billPhone">phone</p>
                            </div>
                            <div style="clear:both;"></div>
                            <input name="makeChanges" type="button" class="transformButtonStyle" id="<?php
                            if (!isset($vid) || $vid == "") {
                                echo "makeChanges";
                            } else {
                                echo "editRegistrant";
                            }
                            ?>" value="<?php
                                   if (!isset($vid) || $vid == "") {
                                       echo "Make Changes";
                                   } else {
                                       echo "Edit Registrant";
                                   }
                                   ?>" style="width:auto;">
                        </div>
                        <div id="registrationType" class="formBlock" <?php
                        if (!isset($vid) || $vid == "") {
                            echo "style=\"display:none;\"";
                        }
                        ?>>
                            <input name="totalcharged" id="totalcharged" type="hidden" value="<?php echo $totalcharged; ?>">
                            <input type="hidden" name="totalpaid"  value="<?php echo $totalpaid; ?>">
                            <input type="hidden" name="totaldue"   value="<?php echo $totaldue; ?>">
                            <input type="hidden" name="vid" value="<?php echo $vid; ?>">
                            </td>
                            <h2 id="step2">Step 2. Choose your registration category. <?php echo $funcccode; ?></h2>
                            <div id="full" class="selectType leftCol required" style="width:45%">
                                <h3>Full Registration — Cost $200.00</h3>
                                <div class="notRequired">
                                    <p>
                                        <label>
                                            <input <?php
                                            if (!(strcmp("$funccode", "FULL"))) {
                                                echo "checked=\"checked\"";
                                            }
                                            ?> type="radio" name="regType" class="regType" value="FULL">
                                            Full Registration (includes all lunches)</label>
                                    </p>
                                </div>
                                <p>&nbsp;</p>
                            </div>
                            <div id="oneDay" class="selectType leftCol required" style="width:45%">
                                <h3>One Day Registration — Cost $60.00</h3>
                                <div class="notRequired">
                                    <p>Choose a day (includes lunch)</p>
                                    <p>
                                        <label>
                                            <input <?php
                                            if (!(strcmp("$funccode", "MON"))) {
                                                echo "checked=\"checked\"";
                                            }
                                            ?> type="radio" name="regType" class="regType"  value="MON">
                                            Monday</label>
                                        <label>
                                            <input <?php
                                            if (!(strcmp("$funccode", "TUE"))) {
                                                echo "checked=\"checked\"";
                                            }
                                            ?> type="radio" name="regType" class="regType"  value="TUE">
                                            Tuesday</label>
                                        <label>
                                            <input <?php
                                            if (!(strcmp("$funccode", "WED"))) {
                                                echo "checked=\"checked\"";
                                            }
                                            ?> type="radio" name="regType" class="regType"  value="WED">
                                            Wednesday</label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="registrationCategories" id="schedule" style="clear:left; <?php
                        if (!isset($vid) || $vid == "") {
                            echo "display:none;";
                        }
                        ?>">
                                 <?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// find and set session caps
//						$query = "SELECT d.funccode, d.vid, c.cap, n.vid, n.reg_status, COUNT(d.funccode) FROM $tabledetailname c, $tablesponsor n, $conference c WHERE c.funccode=d.funccode and d.vid=n.vid AND n.reg_status='' GROUP BY d.funccode ORDER BY d.funccode"; 
//						echo $query;
                                 $query = "select c.cap, d.funccode, count(d.funccode) from $conference c, $tabledetailname d, $tablesponsor n where d.funccode=c.funccode and d.vid=n.vid AND n.reg_status='' group by d.funccode order by d.funccode";
//						//$query = "SELECT funccode, COUNT(funccode) FROM $tabledetailname where funccode like 'TU%' GROUP BY funccode"; 
//							//echo $query;			 
                                 $result = mysql_query($query) or die(mysql_error());
//						$n = mysql_num_rows($result);
////						
//						while ($row = mysql_fetch_array($result)){
//							echo "<p>".$row['funccode']."cap: ".$row['cap']." sold: ".$row['funccode'].": ".$row['count(d.funccode)']."</p>";
//						}
// Print out result
                                 while ($row = mysql_fetch_array($result)) {
                                     ${"S-" . $row['funccode']} = $row['count(d.funccode)']; // get our total sessions sold
                                     ${"C-" . $row['funccode']} = $row['cap']; // find our session caps
                                     ${$row['funccode'] . "status"} = "";
                                     ${$row['funccode'] . "message"} = "";
                                     ${$row['funccode'] . "class"} = "";

                                     //$session = substr($row['funccode'],0,2);
                                     // find which 
                                     if (substr($row['funccode'], 0, 2) == 'TU') {
                                         if (substr($row['funccode'], -1) >= 4) {
                                             //$session = "tutorialB";
                                             if ($row['funccode'] != $tutorialB && ${"S-" . $row['funccode']} >= ${"C-" . $row['funccode']}) {
                                                 ${$row['funccode'] . "status"} = "disabled=\"true\"";
                                                 ${$row['funccode'] . "class"} = "class=\"full\"";
                                                 ${$row['funccode'] . "message"} = " <b class=\"full\">FULL</b><br>";
                                             }
                                         } else {
                                             //$session = "tutorialA";
                                             if ($row['funccode'] != $tutorialA && ${"S-" . $row['funccode']} >= ${"C-" . $row['funccode']}) {
                                                 ${$row['funccode'] . "status"} = "disabled=\"true\"";
                                                 ${$row['funccode'] . "class"} = "class=\"full\"";
                                                 ${$row['funccode'] . "message"} = " <b class=\"full\">FULL</b><br>";
                                             }
                                         }
                                     } else if ($row['funccode'] == 'AMZWLK') {
                                         //$session = "amazing";
                                         if (!isset($amazing) && ${"S-" . $row['funccode']} >= ${"C-" . $row['funccode']}) {
                                             ${$row['funccode'] . "message"} = " <b class=\"full\">FULL</b><br>";
                                             ${$row['funccode'] . "class"} = "class=\"full\"";
                                             ${$row['funccode'] . "status"} = "disabled=\"true\"";
                                         }
                                     } else {
                                         $session = substr($row['funccode'], 0, 2);
                                         if ($row['funccode'] != ${$session} && ${"S-" . $row['funccode']} >= ${"C-" . $row['funccode']}) {
                                             ${$row['funccode'] . "status"} = "disabled=\"true\"";
                                             ${$row['funccode'] . "class"} = "class=\"full\"";
                                             ${$row['funccode'] . "message"} = " <b class=\"full\">FULL</b><br />";
                                         }
                                     }
                                     //echo "<p>".$row['funccode']." sold: ".${"S-".$row['funccode']}." cap: ".${"C-".$row['funccode']}." :: ".$row['funccode']." status: ".${$row['funccode']."status"}."/".${$row['funccode']."message"}."</p>";
                                 }


//					for($a=1;$a<=19;$a++){
//						if($a<10){ $b = "0".$a; } else { $b = $a; }
//						if(!$billing_info) { 
//							if(${"TU".$b} == 1) { 
//								${"TU".$b."status"} = "checked"; 
//							} 
//						} else { 
//							if($tutorials=="TU".$b) { 
//								${"TU".$b."status"} = "checked"; 
//							}
//							if($amtutorials=="TU".$b) { 
//								${"TU".$b."status"} = "checked"; 
//							}
//							if($pmtutorials=="TU".$b) { 
//								${"TU".$b."status"} = "checked"; 
//							}
//							if($wedtutorials=="TU".$b) { 
//								${"TU".$b."status"} = "checked"; 
//							}
//						} 
//						if(${"TU".$b."status"} != "checked" && ${"TTU".$b} >= ${"TTU".$b."cap"}){ 
//							${"TU".$b."status"} = 'disabled="true"'; 
//							${"TU".$b."message"} = '<strong class="red">FULL</strong>'; 
//						}
//					}
                                 ?>



                            <h2>Step 3. Choose your sessions.</h2>
                            <div  id="MON" class="sponCategory" style="clear:left;">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <th colspan="4" align="left"><h1 align="center">Monday, April 8 — Tutorials</h1></th>
                                    </tr>
                                    <tr>
                                        <th width="2%" rowspan="7" align="left"><h2>&nbsp;</h2></th>
                                        <th width="48%" align="left" class="times" id="tutorialA">09:00 - 12:00</th>
                                        <th width="48%" align="left" class="times" id="tutorialB">13:30 - 16:30</th>
                                        <th width="2%" rowspan="7" align="left"><h2>&nbsp;</h2></th>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center" valign="middle" class="scheduleItem"><p>
                                                <label style="text-align:center;" <?php echo $TU1class; ?>><?php echo $TU1message; ?>
                                                    <input <?php
                                                    if (!(strcmp("$tutorialA", "TU1"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> type="radio" class="tutorials sessionButtons" name="tutorialA" id="TU1" value="TU1" style="float:none;" <?php echo $TU1status; ?>>
                                                    Tutorial 1: Fundamentals for Junior Professionals</label> 
                                            </p></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="middle" class="scheduleItem"><p>
                                                <?php echo $TU2message; ?><label <?php echo $TU2class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$tutorialA", "TU2"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> type="radio" class="tutorials sessionButtons" name="tutorialA" id="TU2" value="TU2" <?php echo $TU2status; ?>>
                                                    Tutorial 2: Pipeline Integrity Management </label>
                                            </p></td>
                                        <td align="left" valign="middle" class="scheduleItem"><p>
                                                <?php echo $TU4message; ?><label <?php echo $TU4class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$tutorialB", "TU4"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> type="radio" class="tutorials sessionButtons" name="tutorialB" id="TU4" value="TU4" <?php echo $TU4status; ?>>
                                                    Tutorial 4: Human Factors 101</label>
                                            </p></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="middle" class="scheduleItem"><p>
                                                <?php echo $TU3message; ?><label <?php echo $TU3class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$tutorialA", "TU3"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> type="radio" class="tutorials sessionButtons" name="tutorialA" id="TU3" value="TU3" <?php echo $TU3status; ?>>
                                                    Tutorial 3: Integrity First Program </label>
                                            </p></td>
                                        <td align="left" valign="middle" class="scheduleItem"><p>
                                                <?php echo $TU5message; ?><label <?php echo $TU5class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$tutorialB", "TU5"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> type="radio" class="tutorials sessionButtons" name="tutorialB" id="TU5" value="TU5" <?php echo $TU5status; ?>>
                                                    Tutorial 5: Tethered Tool Inspection: Do's and Don'ts</label>
                                            </p></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle" class="scheduleItem"><p>
                                                <?php echo $TU6message; ?><label <?php echo $TU6class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$tutorialB", "TU6"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> type="radio" class=" tutorials sessionButtons" name="tutorialB" id="TU6" value="TU6" <?php echo $TU6status; ?>>
                                                    Tutorial 6: GIS Spatial Database Management Systems for Pipelines </label>
                                            </p></td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" align="left" valign="middle" class="times">18:00</th>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="left" valign="middle" class="scheduleItemNonSelect"><h3>
                                                <?php echo $AMZWLKmessage; ?><label <?php echo $AMZWLKclass; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$amazing", "Yes"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="amazing" type="checkbox" id="amazing" value="Yes" <?php echo $AMZWLKstatus; ?>>
                                                    &nbsp;&nbsp;I would you like to attend The Amazing Walk Downhill into Banff for Dinner</label>
                                            </h3>
                                            <h3 style="clear:left;"><strong>Cost: $30</strong></h3>
                                            <p>Explore the town of Banff in a local version of the Amazing Race. Participants will pair up in teams and walk (or stroll) to a series of check points collecting information about the history of Banff along the way. Dress appropriately for the weather and bring your sense of fun and adventure.</p>
                                            <p>In case of inclement weather, we will proceed directly to the final check point for dinner.</p></td>
                                    </tr>
                                    <tr>
                                        <th colspan="4" align="left" class="times">&nbsp;</th>
                                    </tr>
                                </table>
                            </div>
                            <div id="TUE" class="sponCategory">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <th colspan="5" align="left"><h1 align="center">Tuesday, April 9 — Workshops</h1></th>
                                    </tr>
                                    <tr>
                                        <th  rowspan=2 align="left" class="times"><h2>Working Groups</h2></th>
                                        <th class="times" >&nbsp;</th>
                                        <th class="times" id="SA"><h2><strong> Session A </strong></h2></th>
                                        <th class="times" id="SB"><h2><strong> Session B </strong></h2></th>
                                        <th class="times" id="SC"><h2><strong> Session C </strong></h2></th>
                                    </tr>
                                    <tr>
                                        <th class="times" ><strong> 8:30 </strong></th>
                                        <th class="times" ><strong> 10:30 </strong></th>
                                        <th class="times" ><strong> 1:30 </strong></th>
                                        <th class="times" ><strong> 3:30 </strong></th>
                                    </tr>
                                    <tr>
                                        <th width="20%" align="left" valign="top"><p><strong class="workgroup">
                                                    <span class="number">1:</span>
                                                    Issues for Managers </strong></p></th>
                                        <td width="20%" >&nbsp;</td>
                                        <td width="20%" class="scheduleItem" ><p >
                                                <?php echo $SAWG01message; ?><label <?php echo $SAWG01class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SA", "SAWG01"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SA" class="sessionButtons" type="radio" id="SAWG01" value="SAWG01" <?php echo $SAWG01status; ?>>
                                                    Hot Topics </label>
                                            </p></td>
                                        <td width="20%"><p>&nbsp; </p></td>
                                        <td width="20%" class="scheduleItem" ><p>
                                                <?php echo $SCWG01message; ?><label <?php echo $SCWG01class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SC", "SCWG01"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SC" type="radio" id="SCWG01" class="sessionButtons" value="SCWG01" <?php echo $SCWG01status; ?>>
                                                    Lifecycle Pipeline Integrity Management – Implementation and Execution</label>
                                            </p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">2:</span>
                                                    Regulatory &amp; Standards Developments  </strong></p></th>
                                        <td >&nbsp;</td>
                                        <td class="scheduleItem" ><p>
                                                <?php echo $SAWG02message; ?><label <?php echo $SAWG02class; ?> >
                                                    <input <?php
                                                    if (!(strcmp("$SA", "SAWG02"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SA" class="sessionButtons" type="radio" id="SAWG02" value="SAWG02" <?php echo $SAWG02status; ?>>
                                                    Small Operators: Challenges Meeting Regulations</label>
                                            </p></td>
                                        <td class="scheduleItem" ><p>
                                                <?php echo $SBWG02message; ?><label <?php echo $SBWG02class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SB", "SBWG02"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SB" type="radio" class="sessionButtons" id="SBWG02" value="SBWG02" <?php echo $SBWG02status; ?>>
                                                    Upstream Issues / Alberta Pipelines Review </label>
                                            </p></td>
                                        <td><p>&nbsp; </p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">3:</span>
                                                    Upstream Pipelines:  Inspection, Corrosion,
                                                    &amp; Integrity Management </strong></p></th>
                                        <td>&nbsp;</td>
                                        <td><p>&nbsp; </p></td>
                                        <td><p>&nbsp; </p></td>
                                        <td class="scheduleItem" ><p>
                                                <?php echo $SCWG03message; ?><label <?php echo $SCWG03class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SC", "SCWG03"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SC" type="radio" class="sessionButtons" id="SCWG03" value="SCWG03" <?php echo $SCWG03status; ?>>
                                                    Technical &amp; Regulatory Updates Since 2011 </label>
                                            </p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">4:</span>
                                                    Asset Management – Aging Infrastructure </strong></p></th>
                                        <td>&nbsp;</td>
                                        <td><p>&nbsp; </p></td>
                                        <td class="scheduleItem" ><p>
                                                <?php echo $SBWG04message; ?><label <?php echo $SBWG04class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SB", "SBWG04"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SB" type="radio" class="sessionButtons" id="SBWG04" value="SBWG04" <?php echo $SBWG04status; ?>>
                                                    Uncovering the Issues—Scientific Proof or Public Perception </label>
                                            </p></td>
                                        <td><p>&nbsp; </p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">5:</span>
                                                    Environmental Assisted Cracking  </strong></p></th>
                                        <td>&nbsp;</td>
                                        <td><p>&nbsp; </p></td>
                                        <td><p>&nbsp; </p></td>
                                        <td><p>&nbsp; </p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">6:</span>
                                                    Human Factors </strong></p></th>
                                        <td>&nbsp;</td>
                                        <td class="scheduleItem"><p >
                                                <?php echo $SAWG06message; ?><label <?php echo $SAWG06class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SA", "SAWG06"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SA" class="sessionButtons" type="radio" id="SAWG06" value="SAWG06" <?php echo $SAWG06status; ?>>
                                                    Tools &amp; Techniques for Evaluating HF </label>
                                            </p></td>
                                        <td><p>&nbsp; </p></td>
                                        <td class="scheduleItem"><p >
                                                <?php echo $SCWG06message; ?><label <?php echo $SCWG06class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SC", "SCWG06"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SC" type="radio" class="sessionButtons" id="SCWG06" value="SCWG06" <?php echo $SCWG06status; ?>>
                                                    Implementing HF in an Organization </label>
                                            </p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">7:</span>
                                                    Pipeline Risk Management </strong></p></th>
                                        <td>&nbsp;</td>
                                        <td><p>&nbsp; </p></td>
                                        <td class="scheduleItem" ><p>
                                                <?php echo $SBWG07message; ?><label <?php echo $SBWG07class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SB", "SBWG07"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SB" type="radio" class="sessionButtons" id="SBWG07" value="SBWG07" <?php echo $SBWG07status; ?>>
                                                    Potential Risk Management Changes in CSA Standards </label>
                                            </p></td>
                                        <td><p>&nbsp; </p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">8:</span>
                                                    Inspection Tools &amp; NDE </strong></p></th>
                                        <td >&nbsp;</td>
                                        <td class="scheduleItem" ><p>
                                                <?php echo $SAWG08message; ?><label <?php echo $SAWG08class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SA", "SAWG08"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SA" class="sessionButtons" type="radio" id="SAWG08" value="SAWG08" <?php echo $SAWG08status; ?>>
                                                    Digging for Accuracy </label>
                                            </p></td>
                                        <td class="scheduleItem" ><p>
                                                <?php echo $SBWG08message; ?><label <?php echo $SBWG08class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SB", "SBWG08"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SB" type="radio" class="sessionButtons" id="SBWG08" value="SBWG08" <?php echo $SBWG08status; ?>>
                                                    Results &amp; Discussion </label>
                                            </p></td>
                                        <td><p>&nbsp; </p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">9:</span>
                                                    External Corrosion &amp; Coatings</strong></p></th>
                                        <td>&nbsp;</td>
                                        <td><p>&nbsp; </p></td>
                                        <td><p>&nbsp; </p></td>
                                        <td class="scheduleItem" ><p>
                                                <?php echo $SCWG09message; ?><label <?php echo $SCWG09class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SC", "SCWG09"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SC" type="radio" class="sessionButtons" id="SCWG09" value="SCWG09" <?php echo $SCWG09status; ?>>
                                                    Training &amp; Certification of Workers </label>
                                            </p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">10:</span>
                                                    Internal Corrosion </strong></p></th>
                                        <td >&nbsp;</td>
                                        <td class="scheduleItem" ><p >
                                                <?php echo $SAWG10message; ?><label <?php echo $SAWG10class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SA", "SAWG10"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SA" class="sessionButtons" type="radio" id="SAWG10" value="SAWG10" <?php echo $SAWG10status; ?>>
                                                    Crude Oil Perceptions vs Reality </label>
                                            </p></td>
                                        <td class="scheduleItem" ><p >
                                                <?php echo $SBWG10message; ?><label <?php echo $SBWG10class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SB", "SBWG10"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SB" type="radio" class="sessionButtons" id="SBWG10" value="SBWG10" <?php echo $SBWG10status; ?>>
                                                    Crude Corrosivity </label>
                                            </p></td>
                                        <td><p>&nbsp; </p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">11:</span>
                                                    Managing Geotechnical Hazards </strong></p></th>
                                        <td>&nbsp;</td>
                                        <td><p>&nbsp; </p></td>
                                        <td><p>&nbsp; </p></td>
                                        <td><p>&nbsp; </p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">12:</span>
                                                    Emergency Preparedness &amp; Response </strong></p></th>
                                        <td>&nbsp;</td>
                                        <td><p>&nbsp; </p></td>
                                        <td><p>&nbsp; </p></td>
                                        <td class="scheduleItem" ><p>
                                                <?php echo $SCWG12message; ?><label <?php echo $SCWG12class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SC", "SCWG12"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SC" type="radio" class="sessionButtons" id="SCWG12" value="SCWG12" <?php echo $SCWG12status; ?>>
                                                    Public Perception &amp; Implication of New Regulation </label>
                                            </p></td>
                                    </tr>
                                    <tr>
                                        <th colspan="5" class="times">&nbsp;</th>
                                    </tr>
                                </table>
                            </div>
                            <div id="WED" class="sponCategory">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <th colspan="5"><h1  align="center">Wednesday, April 10 — Workshops</h1></th>
                                    </tr>
                                    <tr>
                                        <th rowspan="2" align="left" class="times"><h2>Working Group</h2></th>
                                        <th class="times" id="SD"><h2 ><strong> Session D </strong></h2></th>
                                        <th class="times" id="SE"><h2><strong> Session E </strong></h2></th>
                                        <th class="times" id="SF"><h2><strong> Session F </strong></h2></th>
                                        <th class="times" id="SG"><h2><strong> Session G </strong></h2></th>
                                    </tr>
                                    <tr>
                                        <th class="times" ><strong> 8:30 </strong></th>
                                        <th class="times" ><strong> 10:30 </strong></th>
                                        <th class="times" ><strong> 1:30 </strong></th>
                                        <th class="times" ><strong> 3:30 </strong></th>
                                    </tr>
                                    <tr>
                                        <th width="20%" align="left" valign="top"><p><strong class="workgroup">
                                                    <span class="number">1:</span>
                                                    Issues for Managers </strong></p></th>
                                        <td width="20%"><p>&nbsp; </p></td>
                                        <td width="20%"><p>&nbsp; </p></td>
                                        <td width="20%"><p>&nbsp; </p></td>
                                        <td width="20%"><p>&nbsp; </p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">2:</span>
                                                    Regulatory &amp; Standards Developments  </strong></p></th>
                                        <td><p>&nbsp; </p></td>
                                        <td class="" ><p>&nbsp;</p></td>
                                        <td class="" ><p>&nbsp;</p></td>
                                        <td><p>&nbsp; </p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">3:</span>
                                                    Upstream Pipelines:  Inspection, Corrosion,
                                                    &amp; Integrity Management </strong></p></th>
                                        <td class="scheduleItem" ><p>
                                                <?php echo $SDWG03message; ?><label <?php echo $SDWG03class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SD", "SDWG03"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SD" type="radio" class="sessionButtons" id="SDWG03" value="SDWG03" <?php echo $SGWG03status; ?>>
                                                    Non–Metallics </label>
                                            </p></td>
                                        <td class="scheduleItem" ><p >
                                                <?php echo $SEWG03message; ?><label <?php echo $SEWG03class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SE", "SEWG03"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SE" type="radio" class="sessionButtons" id="SEWG03" value="SEWG03" <?php echo $SEWG03status; ?>>
                                                    Management of Pipeline Water Crossings </label>
                                            </p></td>
                                        <td class="scheduleItem" ><p>
                                                <?php echo $SFWG03message; ?><label <?php echo $SFWG03class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SF", "SFWG03"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SF" type="radio" class="sessionButtons" id="SFWG03" value="SFWG03" <?php echo $SFWG03status; ?>>
                                                    Integrity Management—International &amp; Canadian Perspective </label>
                                            </p></td>
                                        <td><p>&nbsp; </p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">4:</span>
                                                    Asset Management – Aging Infrastructure </strong></p></th>
                                        <td class="scheduleItem" ><p > <?php echo $SDWG04message; ?>
                                                <label <?php echo $SDWG04class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SD", "SDWG04"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SD" type="radio" class="sessionButtons" id="SDWG04" value="SDWG04" <?php echo $SDWG04status; ?>>
                                                    Urban Sprawl / Damage Prevention </label>
                                            </p></td>
                                        <td  >&nbsp;</td>
                                        <td><p>&nbsp; </p></td>
                                        <td class="scheduleItem" ><p >
                                                <?php echo $SGWG04message; ?><label <?php echo $SGWG04class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SG", "SGWG04"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SG" type="radio" class="sessionButtons" id="SGWG04" value="SGWG04" <?php echo $SGWG04status; ?>>
                                                    Integrity Management—Work Smarter not Harder? </label>
                                            </p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">5:</span>
                                                    Environmental Assisted Cracking  </strong></p></th>
                                        <td class="scheduleItem" ><p>
                                                <?php echo $SDWG05message; ?><label <?php echo $SDWG05class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SD", "SDWG05"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SD" type="radio" class="sessionButtons" id="SDWG05" value="SDWG05" <?php echo $SDWG05status; ?>>
                                                    EMAT
                                                    &amp; UT ILI – Status Report </label>
                                            </p></td>
                                        <td><p>&nbsp; </p>
                                            <p>&nbsp; </p></td>
                                        <td class="scheduleItem" ><p>
                                                <?php echo $SFWG05message; ?><label <?php echo $SFWG05class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SF", "SFWG05"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SF" type="radio" class="sessionButtons" id="SFWG05" value="SFWG05" <?php echo $SFWG05status; ?>>
                                                    SCC
                                                    JIP2 Update </label>
                                            </p></td>
                                        <td class="scheduleItem" ><p>
                                                <?php echo $SGWG05message; ?><label <?php echo $SGWG05class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SG", "SGWG05"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SG" type="radio" class="sessionButtons" id="SGWG05" value="SGWG05" <?php echo $SGWG05status; ?>>
                                                    SCC
                                                    Management—SCCDA </label>
                                            </p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">6:</span>
                                                    Human Factors </strong></p></th>
                                        <td><p>&nbsp; </p></td>
                                        <td><p>&nbsp; </p></td>
                                        <td><p>&nbsp; </p></td>
                                        <td><p>&nbsp; </p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">7:</span>
                                                    Pipeline Risk Management </strong></p></th>
                                        <td><p>&nbsp; </p></td>
                                        <td class="scheduleItem"><p>
                                                <?php echo $SEWG07message; ?><label <?php echo $SEWG07class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SE", "SEWG07"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SE" type="radio" class="sessionButtons" id="SEWG07" value="SEWG07" <?php echo $SEWG07status; ?>>
                                                    Better Consequence Representation </label>
                                            </p></td>
                                        <td class="scheduleItem" ><p >
                                                <?php echo $SFWG07message; ?><label <?php echo $SFWG07class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SF", "SFWG07"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SF" type="radio" class="sessionButtons" id="SFWG07" value="SFWG07" <?php echo $SFWG07status; ?>>
                                                    Incorporating consequence into integrity management </label>
                                            </p></td>
                                        <td><p>&nbsp; </p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">8:</span>
                                                    Inspection Tools &amp; NDE </strong></p></th>
                                        <td >&nbsp;</td>
                                        <td class="scheduleItem" ><p> <?php echo $SEWG08message; ?>
                                                <label <?php echo $SEWG08class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SE", "SEWG08"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SE" type="radio" class="sessionButtons" id="SEWG08" value="SEWG08" <?php echo $SEWG08status; ?>>
                                                    Dealing with Outliers </label>
                                            </p></td>
                                        <td><p>&nbsp; </p></td>
                                        <td><p>&nbsp; </p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">9:</span>
                                                    External Corrosion &amp; Coatings</strong></p></th>
                                        <td class="scheduleItem"><p >
                                                <?php echo $SDWG09message; ?><label <?php echo $SDWG09class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SD", "SDWG09"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SD" type="radio" class="sessionButtons" id="SDWG09" value="SDWG09" <?php echo $SDWG09status; ?>>
                                                    CP Design &amp; Facility Construction </label>
                                            </p></td>
                                        <td><p>&nbsp; </p></td>
                                        <td class="scheduleItem" ><p>
                                                <?php echo $SFWG09message; ?><label <?php echo $SFWG09class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SF", "SFWG09"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SF" type="radio" class="sessionButtons" id="SFWG09" value="SFWG09" <?php echo $SFWG09status; ?>>
                                                    Insitu Coating Assessments </label>
                                            </p></td>
                                        <td><p>&nbsp; </p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">10:</span>
                                                    Internal Corrosion </strong></p></th>
                                        <td><p>&nbsp; </p></td>
                                        <td><p>&nbsp; </p></td>
                                        <td class="scheduleItem"><p>
                                                <?php echo $SFWG10message; ?><label <?php echo $SFWG10class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SF", "SFWG10"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SF" type="radio" class="sessionButtons" id="SFWG10" value="SFWG10" <?php echo $SFWG10status; ?>>
                                                    Condensate &amp; Refined Products Issues </label>
                                            </p></td>
                                        <td class="" ><p >&nbsp;</p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">11:</span>
                                                    Managing Geotechnical Hazards </strong></p></th>
                                        <td class="scheduleItem" ><p>
                                                <?php echo $SDWG11message; ?><label <?php echo $SDWG11class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SD", "SDWG11"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SD" type="radio" class="sessionButtons" id="SDWG11" value="SDWG11" <?php echo $SDWG11status; ?>>
                                                    Geohazard Assessment for Proposed Projects </label>
                                            </p></td>
                                        <td class="scheduleItem" ><p>
                                                <?php echo $SEWG11message; ?><label <?php echo $SEWG11class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SE", "SEWG11"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SE" type="radio" class="sessionButtons" id="SEWG11" value="SEWG11" <?php echo $SEWG11status; ?>>
                                                    Geohazard Integrity Management for Operating Assets </label>
                                            </p></td>
                                        <td><p>&nbsp; </p></td>
                                        <td><p>&nbsp; </p></td>
                                    </tr>
                                    <tr>
                                        <th align="left" valign="top" ><p><strong class="workgroup">
                                                    <span class="number">12:</span>
                                                    Emergency Preparedness &amp; Response </strong></p></th>
                                        <td><p>&nbsp; </p></td>
                                        <td class="scheduleItem" ><p>
                                                <?php echo $SEWG12message; ?><label <?php echo $SEWG12class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SE", "SEWG12"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SE" type="radio" class="sessionButtons" id="SEWG12" value="SEWG12" <?php echo $SEWG12status; ?>>
                                                    Harmonization of Response </label>
                                            </p></td>
                                        <td><p>&nbsp; </p></td>
                                        <td class="scheduleItem" ><p>
                                                <?php echo $SGWG12message; ?><label <?php echo $SGWG12class; ?>>
                                                    <input <?php
                                                    if (!(strcmp("$SG", "SGWG12"))) {
                                                        echo "checked=\"checked\"";
                                                    }
                                                    ?> name="SG" type="radio" class="sessionButtons" id="SGWG12" value="SGWG12" <?php echo $SGWG12status; ?>>
                                                    Integrity &amp; Emergency Management </label>
                                            </p></td>
                                    </tr>
                                    <tr>
                                        <th colspan="5" class="times">&nbsp;</th>
                                    </tr>
                                </table>
                            </div>
                            <div id="thursday" class="sponCategory">
                                <table width="750" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <th colspan="5" align="left"><h1 align="center">Thursday, April 11 (included in your registration)</h1></th>
                                    </tr>
                                    <tr>
                                        <th width="120" class="times" >8:45 – 10:00</th>
                                        <th width="120" class="times" >10:00 – 10:15</th>
                                        <th width="120" class="times">10:15 – 11:30</th>
                                        <th width="120" class="times" >11:30 – 12:00</th>
                                        <th width="120" class="times" >12:00</th>
                                    </tr>
                                    <tr>
                                        <td width="120" class="scheduleItemNonSelect" ><strong>Plenary Session – Co-chairs’ Reports and Discussion</strong></td>
                                        <td width="120" class="scheduleItemNonSelect" ><strong>Break/Networking</strong></td>
                                        <td width="120" class="scheduleItemNonSelect" ><strong>General Discussion Session</strong></td>
                                        <td width="120" class="scheduleItemNonSelect" ><strong>Workshop Wrap-up</strong></td>
                                        <td width="120" class="scheduleItemNonSelect" >Lunch</td>
                                    </tr>
                                    <tr>
                                        <th colspan="5" class="times" >&nbsp;</th>
                                    </tr>
                                </table>
                            </div>
                            <?php
// start a session to check on page 2
                            $_SESSION['registrationStep'] = 1;
                            ?>
                            <p>
                                <!--//////////////////////////////////////////////////////////////////////////////////////////////////////-->
                            <div id="billing" class="formBlock" style="padding:10px 10px 0px 10px; margin: 0px 0px 10px 0px;">
                                <div id="displayCost">Total Cost: $
                                    <span id="costAmount">200.00</span>
                                </div>
                                <div class="leftCol required" style="width:50%;">
                                    <h3 style="float:none;">Do you have a Promotional Code?</h3>
                                    <p>Promotional Code</p>
                                    <p>
                                        <label>
                                            <input name="promoCode" type="text" id="promoCode" value="<?php echo $promoCode; ?>">
                                        </label>
                                    </p>
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                            <!--//////////////////////////////////////////////////////////////////////////////////////////////////////-->

                            <input name="continuebutton2" type="button" class="transformButtonStyle" id="continuebutton2" value="Continue" style="width:auto;margin:0px;">
                            </p>
                        </div>
                    </form>
                </div>
            </div>
            <div id="footer">&nbsp;
            </div>
        </div>
    </body>
</html>
