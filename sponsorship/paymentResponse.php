<?php
session_start();
$closeit = date('Y-m-d');

if (!isset($_SESSION['registrationStep'])) {
    header('Location: error.php');
    die();
} else if ($closeit > '2015-05-12') {
    header('Location: closed.php');
    die();
} else {
    include ('config_include/connect.php');
    include('config_include/eventVariables.php');
    include('config_include/gatewayConfig.php');
    include ('mimemail.inc');
    ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <link href="css/asmebanffstyles.css" rel="stylesheet" type="text/css">
            <script type="text/javascript" src="jquery/jquery-1.7.1.min.js"></script>
            <script type="text/javascript" src="jquery/colorbox/jquery.colorbox-min.js"></script>
            <script type="text/javascript" src="js/regForm.php"></script>
            <link href="jquery/colorbox/colorbox.css" rel="stylesheet" type="text/css">
            <link href="css/regform.css" rel="stylesheet" type="text/css">
            <script language="JavaScript" type="text/JavaScript">

                function checkPay(form) { 
                //alert('test');
                if(document.murapay.payOpt.value=="CC"){ 
                document.murapay.action="<?php echo $beanstreamTransactionAddress; ?>";
                //document.murapay.enctype="multipart/form-data";
                //document.murapay.encoding="multipart/form-data";
                } else {
                document.murapay.enctype="multipart/form-data";
                document.murapay.encoding="multipart/form-data";
                
                document.murapay.action='paymentResponse.php';
                if(document.murapay.payOpt.value=="cancel") {
                document.murapay.action="cancelRegistration.php";
                } else if(document.murapay.payOpt.value=="LOGOUT"){
                document.murapay.action="logout.php";
                } else if(document.murapay.payOpt.value==""){
                document.murapay.action="payment.php";
                }
                
                }
                //alert(document.murapay.action);
                return true; 
                }
                <!-- Begin
                function NewWindow(mypage, myname, w, h, scroll) {
                var winl = (screen.width - w) / 2;
                var wint = (screen.height - h) / 2;
                winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+scroll+',resizable'
                win = window.open(mypage, myname, winprops)
                if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }
                }
                //  End -->

            </script>
        </head>
        <body>
            <div id="wrapper">
                <?php include('includes/header.php'); ?>
                <div id="content">
                    <?php
//echo "<p>original BS response<br>";
                    $q = explode("&", $_SERVER["QUERY_STRING"]);
                    //echo "<p>";
                    foreach ($q as $qi) {
                        if ($qi != "") {
                            $qa = explode("=", $qi);
                            list ($key, $val) = $qa;
                            if ($val)
                                $$key = urldecode($val);
                            // echo $key.": ".$$key."<br>";
                        }
                    }
                    //echo "=============================================</p>";

                    reset($_POST);
                    while (list ($key, $val) = each($_POST)) {
                        if ($val) {
                            $$key = $val;
                            //echo $key.": ".$$key."<br>";
                        }
                    }

                    if (isset($cardType) && $cardType != "") {
                        $payOpt = $cardType;
                    } 
//                    else if (isset($promoCode) && $promoCode != "") {
//                        $payOpt = "PROMO";
//                    }
                    //echo "</p>";
//trnApproved: 1
//trnId: 10000004
//messageId: 1
//messageText: Approved
//authCode: TEST
//responseType: T
//trnAmount: 425.00
//trnDate: 5/10/2012 12:02:42 PM
//trnOrderNumber: 7
//trnLanguage: eng
//trnCustomerName: Mike Powney
//trnEmailAddress: mike@idassociates.ab.ca
//trnPhoneNumber: 780-428-4343
//avsProcessed: 1
//avsId: N
//avsResult: 
//avsAddrMatch: 
//avsPostalMatch: 
//avsMessage: Street address and Postal/ZIP do not match.
//cvdId: 1
//cardType: VI
//trnType: P
//paymentMethod: CC
//ref1: 
//ref2: 
//ref3: 
//ref4: 
//ref5: 
                    $sid = substr($trnOrderNumber, 4);
                    $response = strtoupper($messageText);
                    $amount1 = $trnAmount;
                    $selectStmt = "SELECT * FROM $tablesponsor WHERE sid = '$sid'";
                    $selectresult = mysql_query($selectStmt) or die("Picking SID Query failed. Please screen print this message and send to heidi@idassocites.ab.ca : " . mysql_error() . "<BR><BR>The statement being executed is: " . $selectStmt);
                    $row = mysql_fetch_assoc($selectresult);
                    $myamt = $row['totalcharged'] . '.00';
                    $mysid = $row['sid']; //-- no vid, only sid
                    $invoicedate = date('Y-m-d');
                    $responseId = $trnId;
                    $datepaid = date('Y-m-d');
                    $timepaid = date('H:i');
                    $company = $row['company'];

//	$cvdId="3"; ///////////// uncomment to test cvd failure check

                    if (($trnApproved == 1 && $cvdId == 1 && $messageId == 1) || /*(isset($promoCode) && $promoCode != "") || */(isset($payOpt) && $payOpt === "MAIL")) {  //===========APPROVED //-- money order ??
                        // not generate promo codes for cheque option
                        if (!(isset($payOpt) && $payOpt === "MAIL")) {                        
                            $totaldue = $row['totaldue'] - $amount1;
                            $totalpaid = $row['totalpaid'] + $amount1;

                            $updatestmt = "UPDATE $tablesponsor SET invoicedate = '$invoicedate', totalpaid = '$totalpaid', totaldue = '$totaldue', paytype = '$payOpt', miraresponse = '$response', miraamt = '$amount1', datepaid = '$datepaid' WHERE sid = '$sid' ";
                            //echo "<p>$updatestmt</p>";
                            mysql_query($updatestmt) or die("The update statement failed to execute with error: " . mysql_error() . ". <BR><BR>The statement is: " . $updatestmt);

                            $sponcode = $row['sponcode'];
                        
                            if ($sponcode == 'PTRN') {
                                $coupons = 3;
                            } else {
                                $coupons = 2;
                            }
                            for ($i = 0; $i < $coupons; $i++) {
                                $uuid = substr(uniqid(), -6);
                                $promoCode = strtoupper($sponcode . $uuid);
                                $sponsorId = $row['sid'];
                                //$insertPromostmt = "INSERT INTO $tablepromo (promoCode,invoiceSponsor,dateCreated,timeCreated,enabled,company) values ('$promoCode','$sponsorId','$datepaid','$timepaid',1,'$sponcode')";
                                $insertPromostmt = "INSERT INTO $tablepromo (promoCode,invoiceSponsor,dateCreated,timeCreated,enabled,company,sponcode) values ('$promoCode','$sponsorId','$datepaid','$timepaid',1,'$company','$sponcode')";
                                mysql_query($insertPromostmt) or die("The update statement failed to execute with error: " . mysql_error() . ". <BR><BR>The statement is: " . $updatestmt);
                            }
                        } else { //----HQ---- if pay by cheque, keep paid zero.
                            $updatestmt = "UPDATE $tablesponsor SET invoicedate = '$invoicedate', paytype = '$payOpt', miraresponse = '', miraamt = 0 WHERE sid = '$sid' ";
                            mysql_query($updatestmt) or die("The update statement failed to execute with error: " . mysql_error() . ". <BR><BR>The statement is: " . $updatestmt);                        
                        }
                        ?>
                        <h1>Thank you, your registration was successful. </h1>
                        <BR>
                        <!----HQ---- show invoice -->
                        <?php
//                        $selectStmt = "SELECT * FROM $tablesponsor WHERE sid = '$sid'";
//                        $selectresult = mysql_query($selectStmt) or die("Picking SID Query failed. Please screen print this message and send to heidi@idassocites.ab.ca : " . mysql_error() . "<BR><BR>The statement being executed is: " . $selectStmt);
//                        $row00 = mysql_fetch_assoc($selectresult);
//
//                        $sid = $sid;
//                        $fname = $row00['fname'];
//                        $lname = $row00['lname'];
//                        $address1 = $row00['address1'];
//                        $address1 = $row00['address1'];
//                        $company = $row00['company'];
//                        $city = $row00['city'];
//                        $state = $row00['state'];
//                        $zip = $row00['zip'];
//                        $country = $row00['country'];
//                        $invoicedate = $row00['invoicedate'];
//                        $totalcharged = $row00['totalcharged'];
//                        $totalpaid = $row00['totalpaid'];
//                        $paytype = $row00['paytype'];
//                        $miraresponse = $row00['miraresponse'];
//                        $regstatus = $row00['reg_status'];
//                        $paytype = $row00['paytype'];
//                        $sponcode = $row00['sponcode'];
//
//                        $invoice_info = implode('', file('includes/invoice_template2.php'));
//                        // strip in registrant info, invoice # and date
//                        $invoice_info = str_replace("{sid}", $sid, $invoice_info);
//                        $date = convertDate(date('Y-m-d'));
//                        $invoice_info = str_replace("{date}", $date, $invoice_info);
//                        $invoice_info = str_replace("{fname}", $fname, $invoice_info);
//                        $invoice_info = str_replace("{lname}", $lname, $invoice_info);
//                        $invoice_info = str_replace("{company}", $company, $invoice_info);
//                        $full_address = $address1;
//                        if ($address2) {
//                            $full_address .= ", " . $address2;
//                        }
//                        $full_address .="<br>" . $city;
//                        if ($state) {
//                            $full_address .= ", " . $state;
//                        }
//                        $full_address .= ", " . $country . "&nbsp;&nbsp;" . $zip;
//                        $invoice_info = str_replace("{full_address}", $full_address, $invoice_info);
//                        $invoice_info = str_replace("{billing_info}", $billing_replace, $invoice_info);
//                        //////////////////////////////////////////////////////////////////////////////
//                        // strip in invoice details///////////////////////////////////////////////////
//                        if ($regstatus == "CANCELLED") {
//                            $invoice_info = str_replace("{special_notes}", "<p class='red'>THIS REGISTRATION HAS BEEN CANCELLED</p>", $invoice_info);
//                        } else if ($regstatus == "JUNK") {
//                            $invoice_info = str_replace("{special_notes}", "<p class='red'>THIS REGISTRATION HAS BEEN MARKED AS JUNK</p>", $invoice_info);
//                        } else {
//                            $invoice_info = str_replace("{special_notes}", "", $invoice_info);
//                        }
//                        $invoice_details = "";
//
//                        $funccost = number_format($totalcharged, 2);
//                        $invoice_details .= "<tr><td colspan=\"3\" align=\"left\">";
//                        if ($sponcode == "PTRN") {
//                            $invoice_details .= "<p><strong>Patron [$sponcode] (3 complementary workshop registrations)</strong></p></td><td align=\"right\">$funccost</td>";
//                        } else if ($sponcode == "SPNS") {
//                            $invoice_details .= "<p><strong>Sponsor [$sponcode] (2 complementary workshop registrations)</strong></p></td><td align=\"right\">$funccost</td>";
//                        } else {
//                            $invoice_details .= "<p><strong>Coffee Breaks [$sponcode] (2 complementary workshop registrations)</strong></p></td><td align=\"right\">$funccost</td>";
//                        }
//                        $invoice_details .= "</tr>";
//                        
//                        // add promo code in one new line
//                        $psel = "select * from $tablepromo where invoiceSponsor='$sid'";
//                        $pres = mysql_query($psel) or die("There was an error retrieving the promotion code" . mysql_error());
//                        $n = mysql_num_rows($pres);
//                        $invoice_details .= "<tr><td colspan='4'><hr /></td></tr>";
//                        $invoice_details .= "<tr><td align=\"left\" valign=\"top\" width=\"100\" class=\"dottheline\" colspan=\"4\">";
//                        if ($n == 0) { // no promotion code
//                            $invoice_details .= "<p><strong>The promotion codes will be generated when we receive your payment.</strong></p>";
//                        } else {
//                            $invoice_details .= "<p><strong>Promotion Codes: ";
//                            while($row = mysql_fetch_array($pres)){
//                                $promoCode = $row['promoCode'];
//                                $invoice_details .= "$promoCode ";
//                            }
//                            $invoice_details .= "</strong></p>";
//                        }
//                        $invoice_details .= "</td></tr>";
//                        
//
//                        $invoice_info = str_replace("{invoice_details}", $invoice_details, $invoice_info);
//                        ///////////////////////// end of invoice details //////////////////////////////////
//                        //////////////////////////////////////////////////////////////////////////////
//                        if ($totalcharged) {
//                            $totaldue = ($totalcharged + ($totalcharged * 0.05 * 0.00)) - $totalpaid;
//                        }
//                        $gstcharged = sprintf("%01.2f", $totalcharged * 0.05 * 0.00);
//                        $totalcharged = sprintf("%01.2f", $totalcharged);
//                        $invoice_info = str_replace("{totalcharged}", $totalcharged, $invoice_info);
//                        $invoice_info = str_replace("{gstcharged}", $gstcharged, $invoice_info);
//                        $totalpaid = sprintf("%01.2f", $totalpaid);
//
//////////////////////////////////////////////////////////////////////////////////////
////////////////////////// grab payment history //////////////////////////////////////		
//                        $paymenthist = "select * from $tablePaymentSponsor where sid='$sid' order by id asc";
//                        $paymenthistresult = mysql_query($paymenthist) or die("Query failed : " . mysql_error());
//
//                        $histnum = mysql_num_rows($paymenthistresult);
//                        $payment_line = '';
//                        if ($histnum == 0) {
//                            $payment_line .= '
//							<tr>
//								<td colspan="3" align="right">
//									<p><strong>Amount Paid:</strong></p>
//								</td>
//								<td align="right">
//									<p>' . $totalpaid . '</p>
//								</td>
//							</tr>';
//                        } else {
//                            while ($hist = mysql_fetch_array($paymenthistresult)) {
//                                if ($hist['pay_amount'] < 0) {
//                                    $payorrefund = '<strong>Refund Issued</strong> ';
//                                    $selectclass = ' class="red" ';
//                                    $special = '';
//                                } else if ($hist['transaction_type'] == 'CNCLFEE') {
//                                    $payorrefund = '<strong>Cancellation Fee</strong> ';
//                                    $selectclass = '';
//                                    $special = '<tr><td colspan="4" align="right"><em>Please note: When you receive your refund, the fee will already have been taken off the refund total</em></td></tr>';
//                                    $totaldue = $totaldue + 10;
//                                } else if ($hist['transaction_type'] == 'RFNDFEE') {
//                                    $payorrefund = '<strong>Refund Fee</strong>';
//                                    $selectclass = '';
//                                    $special = '<tr><td colspan="4" align="right"><em>Please note: When you receive your refund, the fee will already have been taken off the refund total</em></td></tr>';
//                                    $totaldue = $totaldue + 10;
//                                } else {
//                                    $payorrefund = '<strong>Payment Received</strong> ';
//                                    $selectclass = '';
//                                    $special = '';
//                                }
//
//                                $payment_line .= '
//									<tr>
//										<td colspan="3" align="right" valign="top"' . $selectclass . '>
//											<p>' . $payorrefund . ' ' . convertDate($hist['date_paid']) . ' (' . $hist['transaction_type'] . ' #' . $hist['response_id'] . '):</p>
//										</td>
//										<td align="right" valign="top"' . $selectclass . '>
//											<p>' . $hist['pay_amount'] . '</p>
//										</td>
//									</tr>' . $special;
//                            }
//                            $todaydate = date('Y-m-d');
//                        }
//                        $invoice_info = str_replace("{paymenthistory}", $payment_line, $invoice_info);
/////////////////////////end of payment history //////////////////////////////////////	
//
//                        if ($regstatus == 'CANCELLED') {
//                            $invoice_info = str_replace("{message_status}", "red", $invoice_info);
//                            $invoice_info = str_replace("{totaldue_message}", "<em>REGISTRATION CANCELLED</em>&nbsp;&nbsp;&nbsp; Total Owing:", $invoice_info);
//                            $invoice_info = str_replace("{refund_message}", "<h2 class='red'>THIS REGISTRATION HAS BEEN CANCELLED.</h2>", $invoice_info);
//                            $totaldue = '0.00';
//                        } else if ($totaldue >= 0) {
//                            $invoice_info = str_replace("{message_status}", "", $invoice_info);
//                            $invoice_info = str_replace("{totaldue_message}", "Total Owing:", $invoice_info);
//                            $invoice_info = str_replace("{refund_message}", "", $invoice_info);
//                        } else {
//                            $invoice_info = str_replace("{message_status}", "red", $invoice_info);
//                            $invoice_info = str_replace("{totaldue_message}", "Refund Due:", $invoice_info);
//                            $invoice_info = str_replace("{refund_message}", "<h2 class='red'>Changes in your registration have resulted in a refund. <br />Refunds are subject to a $10 processing fee.</h2>", $invoice_info);
//                        }
//                        $totaldue = sprintf("%01.2f", $totaldue);
//                        $invoice_info = str_replace("{totaldue}", $totaldue, $invoice_info);
//
//
//                        echo $invoice_info;
                        ?>
                        <!----HQ---- show invoice end -->
                        <h2><strong>An invoice was sent to your email address. </strong></h2>
                        <?php
                        //----HQ---- if not cheque / money order, create paymenthistory
                        if(!(isset($payOpt) && $payOpt === "MAIL")){
                            $insertstmt = "INSERT INTO $tablePaymentSponsor (sid, pay_amount, date_paid, time_paid, transaction_type, response, response_id) values ('$sid', '$amount1', '$datepaid', '$timepaid', 'CC', '$response', '$responseId')";
                            $insresult = mysql_query($insertstmt) or die("Insert Query failed due to this error: " . mysql_error() . ". <BR><BR>The query data is: " . $insertstmt);
                        ?>
                        <p>Your invoice will include your promotional codes for the complimentary workshop registrations. Please keep a copy of the emailed invoice in order to reference your promotional codes once the Banff/2015 Pipeline Workshop registration has opened.</p>
                        <?php } else{ ?>
                    <p>Your sponsorship request has been submitted, your promotional codes will be generated once we receive payment.</p>
                        <?php } ?>
                        <?php if (isset($_SESSION['login']) && $_SESSION['login']) { ?>
                    <h2>Your login session has been closed, if you wish to make additional changes you will need to log in.</h2>
                        <?php } ?>
                        <hr>
                        <p>&nbsp;</p>
                        <?php
                        //remove for option of cheque
                        //$payOpt = "CC";
                        include('emailbody.php');
                        //echo "<p>=======================================</p>";
                        // kill session
                        session_unset();
                        session_destroy();
                        //}
                    } else if ($trnApproved == 0 && $messageId == "16") { // duplicate transaction ID 
                        ?>
                        <h1>We're sorry. There has already been a payment processed against this invoice number.</h1>
                        <BR>
                        <p><strong>Please email support at <a href="mailto:support@idassociates.ab.ca">support@idassociates.ab.ca</a> and let us know you received a duplicate transaction error and quote invoice number <?php echo $trnOrderNumber; ?>.</strong></p>
                        <p>
                            <em><strong>You should receive a purchase receipt from the payment gateway. Once we have checked your invoice, you will receive further instructions or an updated invoice showing the correct payment information and banlance owing.</strong></em></p>
                        <?php if (isset($_SESSION['login']) && $_SESSION['login']) { ?>
                            <p><em><strong>Your login session has been closed, if you wish to make additional changes you will need to log in.</strong></em></p>
                        <?php } ?>
                        <hr>
                        <?php
                        // kill session
                        session_unset();
                        session_destroy();
                    } else if ($trnApproved == 1 && $cvdId != 1) {
                        /////////////////////////////////////////////////////////////////////////////
                        // cvd error on approval
                        /////////////////////////////////////////
                        // update with initial approval response
                        $totaldue = $row['totaldue'] - $amount1;
                        $totalpaid = $row['totalpaid'] + $amount1;
                        $updatestmt = "UPDATE $tablesponsor SET invoicedate = '$invoicedate', totalpaid = '$totalpaid', totaldue = '$totaldue', paytype = 'CC', miraresponse = '$response', miraamt = '$amount1', datepaid = '$datepaid' WHERE sid = '$sid'";
                        //echo "<p>$updatestmt</p>";
                        mysql_query($updatestmt) or die("The update statement failed to execute with error: " . mysql_error() . ". <BR><BR>The statement is: " . $updatestmt);
                        /////////////////////////////////////////
                        // insert initial approved payment into payment table

                        $pay = "INSERT INTO $tablePaymentSponsor (sid, pay_amount, date_paid, time_paid, transaction_type, response, response_id) values ('$sid', '$amount1', '$datepaid', '$timepaid', 'CC', '$response', '$responseId')";
                        //echo "<p>$insertstmt</p>";
                        $payresult = mysql_query($pay) or die("Insert Query failed due to this error: " . mysql_error() . ". <BR><BR>The query data is: " . $pay);

                        //////////////////////////////////////////////////////////////////////////////////////////////////////////
                        // CVD mismatch, cancel order and void transaction
                        //
									
									// start void process
                        // send changes to Beanstream
                        //$XPost = "serviceVersion=1.1";
                        $XPost = "requestType=BACKEND";
                        $XPost .= "&trnType=VP";
                        $XPost .= "&merchant_id=$beanstreamMerchantID";
                        $XPost .= "&trnOrderNumber=BPS-$sid";
                        $XPost .= "&trnAmount=$trnAmount";
                        $XPost .= "&adjId=$trnId";
                        //$XPost .= "&passCode=$beanstreamProfilePass";
                        $XPost .= "&username=$beanstreamVPusername";
                        $XPost .= "&password=$beanstreamVPpass";
                        $XPost .= "&responseFormat=XML";

                        //echo "<p>$XPost</p>";

                        $url = $beanstreamProfileTransactionAddress;
                        //echo "<p>url: $url</p>";

                        $ch = curl_init();    // initialize curl handle
                        curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
                        curl_setopt($ch, CURLOPT_TIMEOUT, 40); // times out after 40s
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $XPost); // add POST fields
                        $result = curl_exec($ch); // run the whole process
                        if (curl_errno($ch)) {
                            print curl_error($ch);
                        } else {
                            curl_close($ch);
                        }

                        //$VPtest = "VP var dump<br>";
                        $q = explode("&", $result);
                        foreach ($q as $qi) {
                            if ($qi != "") {
                                $qa = explode("=", $qi);
                                list ($key, $val) = $qa;
                                $$key = urldecode($val);
                                //$VPtest.= $key.": ".$$key."<br>";
                            }
                        }
                        $messageText = utf8_encode($messageText);
//										echo "<p>$VPtest</p>";
//										echo "<p>message text: $messageText</p>";
                        $voidAmount = 0 - $trnAmount;

                        if ($trnApproved == 1) {
                            $responseValue = "VOIDED";
                        } else {
                            $responseValue = "VOID ERROR: PLEASE INVESTIGATE";
                        }
                        // update table to show 0 charged and mark record as voided
                        //$updateorder = "update $tablesponsor set response='$responseValue', responseCode='$messageId', totalCharged='0.00', responseId='$trnId', ccType='$cardType', responseDate='$today', responseTime='$curTime' where oid='$oid'";
                        $updateorder = "UPDATE $tablesponsor SET invoicedate = '$invoicedate', totalpaid = totalpaid+$voidAmount, totaldue = totaldue-$voidAmount, paytype = 'VP', miraresponse = '$responseValue', miraamt = '$trnAmount', datepaid = '$datepaid', reg_status='CANCELLED' WHERE sid = '$sid' ";
                        $orderresult = mysql_query($updateorder) or die("<h2>There was an error updating the purchase response.</h2>" . mysql_error() . "<p>$updateorder</p>");


                        $up = "INSERT INTO $tablePaymentSponsor (sid, pay_amount, date_paid, time_paid, transaction_type, response, response_id) values 
																	('$sid', '$voidAmount', '$datepaid', '$timepaid', 'VP', '$responseValue', '$trnId')";
                        $res = mysql_query($up);
                        // update purchase table to mark certificates as voided
                        //////////////////////////////////////////////////////////////////////////////////////////////////////////
                        //////////////////////////////////////////////////////////////////////////////////////////////////////////
                        ?>
                        <h1>There was a problem verifying your card CVD number. Your transaction has been voided.</h1>
                        <p>Since the CVD cannot be verified, you will not be able to continue with the transaction. If you wish to register, you will need to start over.</p>
                        <p><em><strong class="red">Please note:</strong> If you continue receiving this error, the CVD verification for this card cannot be established at this time and you will need to use a different credit card.
                            </em></p>
                        <hr />									
                        <?php
                        session_unset();
                        session_destroy();


                        /////////////////////////////////////////////////////////////////////////////
                        /////////////////////////////////////////////////////////////////////////////
                    } else {  //===========DECLINED and CANCELLED
                        $_SESSION['registrationStep'] = 3;

                        $updatestmt = "UPDATE $tablesponsor SET miraresponse = '$response', miraamt = 0, paytype = 'MAIL' WHERE sid = '$sid' ";
                        mysql_query($updatestmt) or die("The update statement failed to execute with error: " . mysql_error() . ". <BR><BR>The statement is: " . $updatestmt);
                        while (list ($key, $val) = each($row)) {
                            if ($val)
                                $$key = $val;
                        }
                        $miraemail = $email;
                        ?>
                        <h2>Your transaction was either CANCELED or DECLINED.
                            <?php if (isset($miraresponse)) { ?>
                                <br>
                                The payment gateway returned a response of
                                <?php
                                echo $miraresponse;
                            }
                            ?>
                        </h2>
                        <form method="post" name="murapay">
                            <input name="payOpt" type="hidden" id="payOpt">
                            <TABLE align="center" WIDTH="90%" BORDER="0" CELLSPACING="3" CELLPADDING="10">
                                    <tr>
                                        <td width="50%" valign="top" align="left">
                                            <input type='hidden' name='sid' value='<?php echo $sid; ?>'>
                                            <input type='hidden' name='email' value='<?php echo $email; ?>'>
                                            <!--input type='hidden' name='billing_email' value='<?php echo $billing_email; ?>'-->
                                            <input type='hidden' name='totaldue' value='<?php echo $totaldue; ?>'>
                                            <input type="hidden" name="trnOrderNumber" value="BPS-<?php echo $sid; ?>">
                                            <input type="hidden" name="ordName" value="<?php echo $fname, " ", $lname; ?>">
                                            <input type="hidden" name="trnAmount" value="<?php printf("%.2f", $totaldue); ?>">
                                            <input type="hidden" name="trnReturnCard" value="<?php echo 1; ?>">
                                            <input type="hidden" name="ordPhoneNumber" value="<?php echo $phoneArea, " ", $phone; ?>">
                                            <input type="hidden" name="ordAddress1" value="<?php echo $address1; ?>">
                                            <input type="hidden" name="ordAddress2" value="<?php echo $address2; ?>">
                                            <input type="hidden" name="ordCity" value="<?php echo $city; ?>">
                                            <input type="hidden" name="ordProvince" value="<?php echo $state; ?>">
                                            <input type="hidden" name="ordCountry" value="<?php echo $country; ?>">
                                            <input type="hidden" name="ordPostalCode" value="<?php echo $zip; ?>">
                                            <input type="hidden" name="ordEmailAddress" value="<?php echo $email; ?>">
                                            <input type="hidden" name="errorPage" value="<?php echo $beanstreamReturnAddress; ?>">
                                            <input type="hidden" name="approvedPage" value="<?php echo $beanstreamReturnAddress; ?>">
                                            <input type="hidden" name="declinedPage" value="<?php echo $beanstreamReturnAddress; ?>">
                            <?php
                            if (!isset($_SESSION['payAttempts'])) {
                                $_SESSION['payAttempts'] = 3;
                            } else {
                                $_SESSION['payAttempts'] --;
                            }
                            if ($_SESSION['payAttempts'] > 0) {
                                ?>
                                            <h1>You can retry the process by selecting the Retry Process button below:</h1>
                                            <p><b>Credit Card Payment Form</b><br>
                                                <br>
                                                <b>IMPORTANT: This process requires your pop-up blocker be disabled.</b><br>
                                                <br>
                                                The Amount to be processed is: $<?php printf("%.2f", $totaldue); ?></p>
                                            <input type="hidden" name="Amount1" value='<?php printf("%.2f", $totaldue); ?>'>
                                            <p>
                                                <input name="button2" type="button" class="transformButtonStyle" ONCLICK='document.murapay.payOpt.value = "CC";
                                                                    if (checkPay(this.form))
                                                                        document.murapay.submit();
                                                                    return false;' value="Retry Process">
                                                <input name="paymentByChequeButton" type="button" class="transformButtonStyle" ONCLICK='document.murapay.payOpt.value = "MAIL";
                                                if (checkPay(this.form))
                                                    document.murapay.submit();
                                                return false;' value="Pay by Cheque/Money Order">
                                            </p>
                                            <p><strong><em>You will be able to retry <?php echo $_SESSION['payAttempts']; ?> more time(s).</em></strong></p>
                                            <p>&nbsp;</p>
                                            <p>
                                                <input name='backbutton2' type='submit' class="transformButtonStyle" id="backbutton2"  onClick='document.murapay.payOpt.value = "cancel";
                                                                    if (checkPay(this.form))
                                                                        document.murapay.submit();
                                                                    return false;' value='Cancel Registration' />
                                                       <?php if (isset($_SESSION['login']) && $_SESSION['login']) { ?>
                                                    <input name='logout' type='submit' class="transformButtonStyle" id="logout" style="margin-left:10px;"  onClick='document.murapay.payOpt.value = "LOGOUT";
                                                                            if (checkPay(this.form))
                                                                                document.murapay.submit();
                                                                            return false;' value='Log Out' />
                                                       <?php } ?>
                                            </p></td>
                                    </tr>
                                </table>
                            <?php } else {
                                ?>
                                            <h1>You have been declined 4 times. </h1>
                                            <p><strong>For security reasons you will not be able to continue with payment by credit card at this time.</strong></p>
                                            <p><em><strong>If you wish to try again, please wait at least 2 hours and contact your credit card issuer to make sure they have not put a block on the credit card.</strong></em></p>
                                            <p>&nbsp;&nbsp;
                                            <input name="paymentByChequeButton" type="button" class="transformButtonStyle" ONCLICK='document.murapay.payOpt.value = "MAIL";
                                                            if (checkPay(this.form))
                                                                document.murapay.submit();
                                                            return false;' value="Pay by Cheque/Money Order">
                                             </p></td>
                                    </tr>
                                </table>
                                    <?php
                                    //session_unset();
                                    //session_destroy();
                                }
                                ?>
                        </form>
                        <?php
                    }

                    if (is_resource($link)) {
                        mysql_close($link);
                    }
                    ?>
                </div>
                <div id="footer">
                    <p>&nbsp;</p>
                </div>
            </div>
        </body>
    </html>
<?php } ?>
