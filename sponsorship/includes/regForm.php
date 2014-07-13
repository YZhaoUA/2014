<?php
$availMondayAm = TRUE;
$availMondayPm = TRUE;
$availTuesdayAm = TRUE;
$availTuesdayPm = TRUE;
$availWednesdayAm = TRUE;
$availWednesdayPm = TRUE;

//$selectStmt = "select sid from $tablesponsor where sponcode = 'CBTU' and `totaldue`=0";
//$selectStmt = "select sid from $tablesponsor where sponcode = 'CBMA' and reg_status = ''";
$selectStmt = "select sid from $tablesponsor where sponcode = 'CBMA' and reg_status = '' and (`totaldue`=0 or paytype='MAIL')";
$selectresult = mysql_query($selectStmt) or die("Picking SID Query failed : " . mysql_error() . "<BR><BR>The statement being executed is: " . $selectStmt);
if (mysql_num_rows($selectresult) > 0) {
    $availMondayAm = FALSE;
}
$selectStmt = "select sid from $tablesponsor where sponcode = 'CBMP' and reg_status = '' and (`totaldue`=0 or paytype='MAIL')";
$selectresult = mysql_query($selectStmt) or die("Picking SID Query failed : " . mysql_error() . "<BR><BR>The statement being executed is: " . $selectStmt);
if (mysql_num_rows($selectresult) > 0) {
    $availMondayPm = FALSE;
} else $availMondayPm = FALSE;

$selectStmt = "select sid from $tablesponsor where sponcode = 'CBTA' and reg_status = '' and (`totaldue`=0 or paytype='MAIL')";
$selectresult = mysql_query($selectStmt) or die("Picking SID Query failed : " . mysql_error() . "<BR><BR>The statement being executed is: " . $selectStmt);
if (mysql_num_rows($selectresult) > 0) {
    $availTuesdayAm = FALSE;
}
$selectStmt = "select sid from $tablesponsor where sponcode = 'CBTP' and reg_status = '' and (`totaldue`=0 or paytype='MAIL')";
$selectresult = mysql_query($selectStmt) or die("Picking SID Query failed : " . mysql_error() . "<BR><BR>The statement being executed is: " . $selectStmt);
if (mysql_num_rows($selectresult) > 0) {
    $availTuesdayPm = FALSE;
} else $availTuesdayPm = FALSE;

$selectStmt = "select sid from $tablesponsor where sponcode = 'CBWA' and reg_status = '' and (`totaldue`=0 or paytype='MAIL')";
$selectresult = mysql_query($selectStmt) or die("Picking SID Query failed : " . mysql_error() . "<BR><BR>The statement being executed is: " . $selectStmt);
if (mysql_num_rows($selectresult) > 0) {
    $availWednesdayAm = FALSE;
}
$selectStmt = "select sid from $tablesponsor where sponcode = 'CBWP' and reg_status = '' and (`totaldue`=0 or paytype='MAIL')";
$selectresult = mysql_query($selectStmt) or die("Picking SID Query failed : " . mysql_error() . "<BR><BR>The statement being executed is: " . $selectStmt);
if (mysql_num_rows($selectresult) > 0) {
    $availWednesdayPm = FALSE;
} else $availWednesdayPm = FALSE;

?>

<div class="formBlock">
    <p class="leftCol required">Required Fields *</p>
</div>
<div id="registrantInfo" class="formBlock" style="clear:left; width:100%;">
    <h2>Step 1. Contact Information</h2>
    <!--
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
    -->
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

    <div class="leftCol required" style="width:92%;">
        <p>Company Name (Maximum 50 characters)*</p>
        <p>
            <input name="company" type="text" class="reqfield" id="company" value="<?php
            if (isset($company)) {
                echo $company;
            }
            ?>" maxlength="50"/>
        </p>
    </div>
    <div style="clear:left;"></div>

    <div class="leftCol notRequired" style="width:92%;">
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

    <div class="leftCol required" style="width:40%;">
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
    <div class="leftCol notRequired" style="width:40%;">
        <p>State/Province</p>
        <p>
            <input name="state" type="text" id="state" value="<?php
            if (isset($state)) {
                echo $state;
            }
            ?>"  class="noreqfield"/>
        </p>
    </div>

    <div class="leftCol required" style="clear:left;width:40%;">
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
    <div class="leftCol required" style="width:40%;">
        <p>Zip/Postal Code
            * </p>
        <p>
            <input name="zip" type="text" class="reqfield" id="zip"  value="<?php
            if (isset($zip)) {
                echo $zip;
            }
            ?>" size="16"/>
        </p>
    </div>
    <div style="clear:left;"></div>

    <div class="leftCol required" style="width:40%">
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
    <div class="leftCol notRequired" style="width:40%">
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

    <div class="leftCol required" style="width:40%;">
        <p>Email
            * </p>
        <p>
            <!----HQ---- no user_password in database -->
            <!--
            <input name="user_password" type="hidden" id="user_password" value="<?php
            if (isset($user_password)) {
                echo $user_password;
            }
            ?>">
            -->
            <input name="email" type="text" class="reqfield" id="email" value="<?php
            if (isset($email)) {
                echo $email;
            }
            ?>" />
        </p>
    </div>
    <div class="leftCol required" style="width:40%;">
        <p>Confirm Email
            * </p>
        <p>
            <input name="confirmemail" type="text" class="reqfield" id="confirmemail" value="<?php
            if (isset($email)) {
                echo $email;
            }
            ?>" />
        </p>
    </div>
    <div style="clear:left;"></div>
</div>
<p>
    <input name="continuebutton" type="button" class="transformButtonStyle" id="<?php
    if (!isset($sid) || $sid == "") {
        echo "continuebutton";
    } else {
        echo "savechanges";
    }
    ?>" value="<?php
           if (!isset($sid) || $sid == "") {
               echo "Continue";
           } else {
               echo "Save Changes";
           }
           ?>" style="width:auto;">
</p>


</div>


<div id="registrantSummary" class="formBlock" <?php
if (!isset($sid) || $sid == "") {
    echo "style=\"display:none;\"";
}
?>>
    <div id="registrantFields" class="leftCol summaries" style="width:40%;">
        <h3>Contact / Billing Information</h3>
        <p id="regName">Name</p>
        <p id="regCompany">company</p>
        <p id="regAddress">address<br />
            city, province<br />
            country&nbsp;&nbsp;Postal</p>
        <p id="regEmail">email</p>
        <p id="regPhone">phone</p>
    </div>
    <!--                                            <div id="billingFields" class="leftCol summaries" style="width:40%;">
                                                                <h3>Billing Information</h3>
                                                                <p id="billName">Name</p>
                                                                <p id="billCompany">company</p>
                                                                <p id="billAddress">address<br />
                                                                                city, province<br />
                                                                                country&nbsp;&nbsp;Postal</p>
                                                                <p id="billEmail">email</p>
                                                                <p id="billPhone">phone</p>
                                                </div>  -->
    <div style="clear:both;"></div>
    
    <input name="makeChanges" type="button" class="transformButtonStyle" id="<?php
    if (!isset($sid) || $sid == "") {
        echo "makeChanges";
    } else {
        echo "editRegistrant";
    }
    ?>" value="<?php
           if (!isset($sid) || $sid == "") {
               echo "Make Changes";
           } else {
               echo "Edit Registrant";
           }
           ?>" style="width:auto;">
</div>
<div id="registrationType" class="formBlock" <?php
if (!isset($sid) || $sid == "") {
    echo "style=\"display:none;\"";
}
?>>
    <input name="totalcharged" id="totalcharged" type="hidden" value="<?php echo $totalcharged; ?>">
    <input type="hidden" name="totalpaid"  value="<?php echo $totalpaid; ?>">
    <input type="hidden" name="totaldue"   value="<?php echo $totaldue; ?>">

    <input type="hidden" name="sid" value="<?php echo $sid; ?>">
<!--    
    </td>
-->

    <h2 id="step2">Step 2. Choose Sponsorship Category</h2>
    <div id="patron" class="selectType leftCol required" style="width:28%">
        <h3>Patron</h3>
        <div class="notRequired">
            <p>
                <label>
                    <input <?php
                    if (!(strcmp("$sponcode", "PTRN"))) {
                        echo "checked=\"checked\"";
                    }
                    ?> type="radio" name="regType" class="regType" value="PTRN">
                    $5000+ <br>
                    (includes 3 complimentary registrations)</label>
            </p>
            
            <div  id="PTRN_AlwaysHidden" class="sponCategory" style="display:none">
                <div id="billing" >
                    <p>
                        <br>
                        <label>
                            <!--checked="checked"-->
                            <input <?php
                                if ($totalcharged == 5000) {
                                    echo "checked=\"checked\"";
                                }
                            ?> class="sessionButtons" id="choicePTRN"  type="radio" name='radioPatron'  value="defaultPatron">
                            $5000
                        </label>
                        <br>
                        <label>
                            <input  <?php
                                if ($totalcharged > 5000) {
                                    echo "checked=\"checked\"";
                                }
                            ?>  class="sessionButtons"  id="choicePTRM"  type="radio" name='radioPatron'  value="customPatron">
                            Other Amount: <br>
                        </label>
                        <label>
                            &nbsp&nbsp;&nbsp; $ <input name="patronAmount" type="text" class="reqfield" id="patronAmount" style="width:100px" value=" <?php if ($totalcharged > 5000) echo trim(intval($totalcharged));?>">
                        </label>
                    </p>
                </div>
            </div>
        </div>
        <p>&nbsp;</p>
    </div>
    <div id="sponsor" class="selectType leftCol required" style="width:28%">
        <h3>Sponsor</h3>
        <div class="notRequired">
            <p>
                <label>
                    <input <?php
                    if (!(strcmp("$sponcode", "SPNS"))) {
                        echo "checked=\"checked\"";
                    }
                    ?> type="radio" name="regType" class="regType"  value="SPNS">
                    $3000 <br>
                    (includes 2 complimentary registrations)</label>
            </p>
        </div>
        
        <div id="SPNS" class="sponCategory" style="display:none">
            <!--                   Here is the form sponsor-->
        </div>
        <p>&nbsp;</p>
    </div>
    <div id="coffeebreak" class="selectType leftCol required" style="width:28%">
        <h3>Coffee Break</h3>
        <div class="notRequired">
            <p>
                <label>
                    <input <?php
                        if (!(strcmp(substr($sponcode, 0, 2), "CB"))) {
                            echo "checked=\"checked\"";
                        }
                    ?> type="radio" name="regType" class="regType"  value="CBRK">
                    $2500 <br>
                    (includes 2 complimentary registrations)</label>
            </p>

            <div id="CBRK" class="sponCategory" style="display:none;">
                <div id="billing" style="margin:10px 0px;">
                    <p>Choose a Day: <br> (each spot includes both the morning and afternoon coffee breaks for the given day)</p>
							<hr style="margin-top: 15px;">
<!--                        <p>Monday</p>-->
							<div class="floatLeft"><p><label><?php if ($availMondayAm): ?>
                                <input <?php
                                if (!(strcmp("$sponcode", "CBMA"))) {
                                    echo "checked=\"checked\"";
                                }
                                ?>  type="radio" class="tutorials sessionButtons" name="tutorialB" id="choiceCBMA" value="CBMA">
                                <?php else: ?>
                                (Filled)
                            <?php endif; ?>
                            Monday
                        </label></p>
                        </div>
							<div class="floatRight" style="display: none">
                        <p><label><?php if ($availMondayPm): ?>
                                <input <?php
                                if (!(strcmp("$sponcode", "CBMP"))) {
                                    echo "checked=\"checked\"";
                                }
                                ?>  type="radio" class="tutorials sessionButtons" name="tutorialB" id="choiceCBMP" value="CBMP">
                                <?php else: ?>
                                (Filled)
                            <?php endif; ?>
                            PM
                        </label></p></div>
						<div class="clearBoth"></div>
						<hr style="margin-top: 15px;">
<!--						<p>Tuesday</p>-->
                       <div class="floatLeft"><p> <label>
                            <?php if ($availTuesdayAm): ?>
                                <input <?php
                                if (!(strcmp("$sponcode", "CBTA"))) {
                                    echo "checked=\"checked\"";
                                }
                                ?>  type="radio" class="tutorials sessionButtons" name="tutorialB" id="choiceCBTA" value="CBTA">
                                <?php else: ?>
                                (Filled)
                            <?php endif; ?>
                            Tuesday
                        </label>
                        </p></div>
							<div class="floatRight" style="display: none">
							<p>
                        <label>
                            <?php if ($availTuesdayPm): ?>
                                <input <?php
                                if (!(strcmp("$sponcode", "CBTP"))) {
                                    echo "checked=\"checked\"";
                                }
                                ?>  type="radio" class="tutorials sessionButtons" name="tutorialB" id="choiceCBTP" value="CBTP">
                                <?php else: ?>
                                (Filled)
                            <?php endif; ?>
                            PM
                        </label>
                        </p>
						</div>
						<div class="clearBoth"></div>
							<hr style="margin-top: 15px;">
<!--							<p>Wednesday</p>-->
							<div class="floatLeft">
							<p>
                        <label>
                            <?php if ($availWednesdayAm): ?>
                                <input <?php
                                if (!(strcmp("$sponcode", "CBWA"))) {
                                    echo "checked=\"checked\"";
                                }
                                ?> type="radio" class="tutorials sessionButtons" name="tutorialB" id="choiceCBWA" value="CBWA">
                                <?php else: ?>
                                (Filled)
                            <?php endif; ?>
                            Wednesday
                        </label>
                        </p>
						</div>
						<div class="floatRight" style="display: none">
						<p>
                        <label>
                            <?php if ($availWednesdayPm): ?>
                                <input <?php
                                if (!(strcmp("$sponcode", "CBWP"))) {
                                    echo "checked=\"checked\"";
                                }
                                ?> type="radio" class="tutorials sessionButtons" name="tutorialB" id="choiceCBWP" value="CBWP">
                                <?php else: ?>
                                (Filled)
                            <?php endif; ?>
                            PM
                        </label>
                        </p>
						</div>
 						<div class="clearBoth"></div>
               </div>
            </div>
        </div>
        <p>&nbsp;</p>
    </div>


</div>
<div class="registrationCategories" id="schedule" 
     style="clear:left; <?php if (!isset($sid) || $sid == "") {echo "display:none;";}?>">
<?php
    // start a session to check on page 2
    $_SESSION['registrationStep'] = 1;
?>
    <div id="billing" class="formBlock" style="padding:10px 10px 0px 10px; margin: 0px 0px 10px 0px;">
        <div id="displayCost">
            <p>
                <span class="priceDisp" id="costAmount">--</span>
                <strong>Total Cost: </strong></p>
        </div>
        <div style="clear:both;"></div>
    </div>
