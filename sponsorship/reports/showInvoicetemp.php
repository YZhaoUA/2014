<?php include('../config_include/connect.php'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Banff/2013 Pipeline Workshop Sponsor Registration</title>
        <link href="../css/asmebanffstyles.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="../jquery/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="../jquery/colorbox/jquery.colorbox-min.js"></script>
        <script type="text/javascript" src="../js/regForm.php"></script>
        <script type="text/javascript">
            function CentreWindow(newpage, newname, cw, ch, scroll) {
                var centl = (screen.width - cw) / 2;
                var centt = (screen.height - ch) / 2;
                centprops = 'height=' + ch + ',width=' + cw + ',top=' + centt + ',left=' + centl + ',scrollbars=yes,resizable'
                centwin = window.open(newpage, newname, centprops)
                if (parseInt(navigator.appVersion) >= 4) {
                    centwin.window.focus();
                }
            }
        </script>
        <link href="../jquery/colorbox/colorbox.css" rel="stylesheet" type="text/css">
        <link href="../css/regform.css" rel="stylesheet" type="text/css">
        <link href="../css/reports.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="wrapper">
            <?php include('../includes/header.php'); ?>
            <div id="content">
                <div id="regarea">
                    <p>&nbsp;</p>
                    <?php
// -------------------------------------------------
// Written for IPC by Heidi at id associates
// On: The Tuesday after the May Long Weekend in 2006
// Why: This displays invoices
// -------------------------------------------------
//////////////////////////////////////////////////////
//////////// process a payment ///////////////////////

                    if (isset($_POST['processing'])) {
                        //echo "<p>process payment</p>";
                        $vid = $_POST['vid'];
                        $payment_type = $_POST['payment_type'];
                        $payment_total = $_POST['payment_total'] . '.00';
                        $payment_id = $_POST['payment_id'];
                        $refund_type = $_POST['refund_type'];
                        $today = date('Y-m-d');
                        $thetime = date('H:i');
                        $response = "APPROVED";
                        $totalpaid = $_POST['totalpaid'] . '.00';
                        $totalcharged = $_POST['totalcharged'] . '.00';
                        $invoicedate = date('Y-m-d');
                        $payment_marker = $payment_type;
                        $payment_invoice = $payment_type;

                        if ($payment_type == 'CANCELLED' || $payment_type == 'CANCELLEDNOFEE') {
                            $cancellation = ", reg_status='CANCELLED'";
                            $payment_marker = 'REFUND ' . $refund_type;
                            $payment_invoice = 'REFUND';
                            $fee = 'CNCLFEE';
                            //echo "<p>setup cancel with fee</p>";
                        } else if ($payment_type == 'REFUND' || $payment_type == 'REFUNDNOFEE') {
                            $cancellation = "";
                            $payment_marker = 'REFUND ' . $refund_type;
                            $payment_invoice = 'REFUND';
                            $fee = 'RFNDFEE';
                            //echo "<p>set up refund with fee</p>";
                        }
                        $insertstmt = "INSERT INTO $tablePaymentSponsor (vid, pay_amount, date_paid, time_paid, transaction_type, response, response_id) values ('$vid', '$payment_total', '$today', '$thetime', '$payment_marker', '$response', '$payment_id')";
                        $insresult = mysql_query($insertstmt) or die("Insert Query failed due to this error: " . mysql_error() . ". <BR><BR>The query data is: " . $insertstmt);
                        //echo "<p>insert payment record: $insertstmt</p>";

                        if ($payment_type === 'CANCELLED' || $payment_type === 'REFUND') {
                            $insertstmt2 = "INSERT INTO $tablePaymentSponsor (vid, pay_amount, date_paid, time_paid, transaction_type, response, response_id) values ('$vid', '10.00', '$today', '$thetime', '$fee', '$response', '$payment_id')";
                            $insresult2 = mysql_query($insertstmt2) or die("Insert Query failed due to this error: " . mysql_error() . ". <BR><BR>The query data is: " . $insertstmt2);
                            //echo "<p>insert fee record: $insertstmt2</p>";
                        }
                        // grab payment history
                        $payselect = "SELECT * from $tablePaymentSponsor where vid = '$vid'";
                        $payresult = mysql_query($payselect) or die("select query failed due to this error: " . mysql_error() . " . <br><br>The query data is: " . $payselect);
                        $adjust = 0;
                        $totals = 0;

                        while ($pays = mysql_fetch_array($payresult)) {
                            if ($pays['transaction_type'] == "CNCLFEE" || $pays['transaction_type'] == "RFNDFEE") {
                                $adjust = $adjust + $pays['pay_amount'];
                            }
                            $totals = $totals + $pays['pay_amount'];
                        }

                        // calculate invoice amounts
                        $newtotalpaid = $totals;

                        $newtotaldue = ($totalcharged + ($totalcharged * 0.05 * 0.00)) - $totals + $adjust;

                        $newtotalpaid = sprintf("%01.2f", $newtotalpaid);
                        $newtotalcharged = sprintf("%01.2f", $newtotalcharged);

                        //echo $payment_type.'<br>'.$payment_total.'<br>'.$payment_id.'<br>'.$today.'<br>'.$thetime.'<br>'.$response.'<br>'.$newtotalpaid.'<br>'.$newtotaldue;

                        $updatestmt = "UPDATE $tablesponsor SET invoicedate = '$invoicedate', totalpaid = '$newtotalpaid', totaldue = '$newtotaldue', paytype = '$payment_invoice', miraresponse = '$response', miraamt = '$payment_total', datepaid = '$today' " . $cancellation . " WHERE '$vid' = vid ";
                        mysql_query($updatestmt) or die("The update statement failed to execute with error: " . mysql_error() . ". <BR><BR>The statement is: " . $updatestmt);
                        //echo "<p>adjust new invoice totals: $updatestmt</p>";
                    }
//////////////////////////////////////////////
//////////////////////////////////////////////
////////// changing a registration ///////////
                    $insertArray = array();
                    $wgArray = array();
                    $wgcArray = array();
                    $commentArray = array();
                    reset($_POST);
                    //echo "<p>Post ///////////////////////////</p>";
                    while (list ($key, $val) = each($_POST)) {
                        //  if ($val){
                        $$key = $val;
                        //echo $key.": ".$$key."<br>";
                        if ((substr($$key, 0, 2) == "TU" || substr($$key, 2, 2) === "WG") && $val != "" && $key != "regType") {
                            array_push($insertArray, mysql_real_escape_string($$key));
                            //echo "<p>set A $key for insert</p>";
                        } else if ($key == "amazing" && $val != "") {
                            //echo "<p>set B $key for insert</p>";
                            array_push($insertArray, "AMZWLK");
                        } else if (substr($key, 0, 6) === "wgcomm") {
                            //only if there is a value
                            if ($val != "") {
                                array_push($commentArray, $val);
                            }
                        }
                        //	}
                    }


                    $insertArrayL = sizeof($insertArray);
                    $commentArrayL = sizeof($commentArray);

                    if (!isset($billing_check)) {
                        $billing = "No";
                    }
                    if (isset($regType) && $regType != "") {
                        $funccode = $regType;
                    } else {
                        $funccode = "";
                    }

                    if (isset($_POST['vid']) && !isset($_POST['processing'])) {
//include('../includes/formPosts.php');


                        $newone = '1';
                        if ($printBadge == 2) { // just print badge
                            //include ("../../2010test/reports/printBadge.php");
                        } else { // do update
                            $itWentOK = 0;
                            $holdid = $vid;
                            //if($totalpaid){
                            // grab payment history
                            $payselect = "SELECT * from $tablePaymentSponsor where vid = '$vid'";
                            $payresult = mysql_query($payselect) or die("select query failed due to this error: " . mysql_error() . " . <br><br>The query data is: " . $payselect);
                            $adjust = 0;
                            $totals = 0;

                            while ($pays = mysql_fetch_array($payresult)) {
                                if ($pays['transaction_type'] == "CNCLFEE" || $pays['transaction_type'] == "RFNDFEE") {
                                    $adjust = $adjust + $pays['pay_amount'];
                                }
                                $totals = $totals + $pays['pay_amount'];
                            }

                            // calculate invoice amounts
                            //$newtotalpaid = $totals;

                            $totaldue = ($totalcharged + ($totalcharged * 0.05 * 0.00)) - $totals + $adjust;

//		$newtotalpaid = sprintf("%01.2f",$newtotalpaid);
//		$newtotalcharged = sprintf("%01.2f",$newtotalcharged);
                            //$totaldue = $totalcharged - $totalpaid;
                            //}		
                            $invoicedate = date('Y-m-d');

                            $updatestmt = "UPDATE $tablesponsor SET sal = '" . mysql_real_escape_string($sal) . "', fname = '" . mysql_real_escape_string($fname) . "', lname = '" . mysql_real_escape_string($lname) . "', title = '" . mysql_real_escape_string($title) . "', nickname = '" . mysql_real_escape_string($nickname) . "', company = '" . mysql_real_escape_string($company) . "', businesstype = '" . mysql_real_escape_string($businesstype) . "', address1 = '" . mysql_real_escape_string($address1) . "', address2 = '" . mysql_real_escape_string($address2) . "', city = '" . mysql_real_escape_string($city) . "', state = '" . mysql_real_escape_string($state) . "', country = '" . mysql_real_escape_string($country) . "', zip = '" . mysql_real_escape_string($zip) . "', phone = '" . mysql_real_escape_string($phone) . "', fax = '" . mysql_real_escape_string($fax) . "', email = '" . mysql_real_escape_string($email) . "', user_password = '" . mysql_real_escape_string($user_password) . "', billing = '" . mysql_real_escape_string($billing_check) . "', billing_sal = '" . mysql_real_escape_string($billing_sal) . "', billing_fname = '" . mysql_real_escape_string($billing_fname) . "', billing_lname = '" . mysql_real_escape_string($billing_lname) . "', billing_company = '" . mysql_real_escape_string($billing_company) . "', billing_title = '" . mysql_real_escape_string($billing_title) . "', billing_address1 = '" . mysql_real_escape_string($billing_address1) . "', billing_address2 = '" . mysql_real_escape_string($billing_address2) . "', billing_city = '" . mysql_real_escape_string($billing_city) . "', billing_state = '" . mysql_real_escape_string($billing_state) . "', billing_country = '" . mysql_real_escape_string($billing_country) . "', billing_zip = '" . mysql_real_escape_string($billing_zip) . "', billing_phone = '" . mysql_real_escape_string($billing_phone) . "', billing_fax = '" . mysql_real_escape_string($billing_fax) . "', billing_email = '" . mysql_real_escape_string($billing_email) . "', funccode = '" . mysql_real_escape_string($funccode) . "', totalcharged = '" . mysql_real_escape_string($totalcharged) . "', totalpaid = '" . mysql_real_escape_string($totalpaid) . "', totaldue = '" . mysql_real_escape_string($totaldue) . "', invoicedate = '" . mysql_real_escape_string($invoicedate) . "' WHERE '$vid' = vid ";
                            mysql_query($updatestmt) or die("The main update statement failed to execute with error: " . mysql_error() . ". <BR><BR>The statement is: " . $updatestmt);
                            //echo "<p>$updatestmt</p>";

                            $selectDetails = "select * from $tabledetailname where vid = '$vid'";
                            $deresult = mysql_query($selectDetails) or die("The collection of old detail records statement failed with error: " . mysql_error());

                            $denum = mysql_num_rows($deresult);
                            while ($deline = mysql_fetch_array($deresult)) {
                                // insert old detail records in the hold detail table for safe keeping
                                $insertstmt = "INSERT INTO $holddetail (id, vid, funccode, funcid, charged, date_changed) values ('" . $deline['id'] . "','" . $deline['vid'] . "','" . $deline['funccode'] . "', '" . $deline['funcid'] . "', '" . $deline['charged'] . "', '" . date('Y-m-d') . "')";
                                mysql_query($insertstmt) or die("The holddetail statement failed to execute with error: " . mysql_error() . " the statement that failed was: " . $insertstmt);
                                // once they are safe in the hold detail table you can delete them
                                $id = $deline["id"];
                                $deletestmt = "delete from $tabledetailname where id = '$id'";
                                mysql_query($deletestmt) or die("The delete statement failed to execute with error: " . mysql_error() . "<BR<BR>The statement that failed was: " . $deletestmt);
                                // good news everyone
                                $itWentOK = 1;
                            } // while statement end
                            if ($denum == 0) {
                                $itWentOK = 1;
                            }
                            if ($itWentOK == 1) {
                                // insert new records
                                include('../includes/insertStmts.php');
                                $deletestmt = "delete from $tablecomments where invoice = '$vid'";
                                mysql_query($deletestmt) or die("The delete statement failed to execute with error: " . mysql_error() . "<BR<BR>The statement that failed was: " . $deletestmt);
                                include('../includes/commentStmts.php');
                            }
                            //decide what to print
                            $vid = $holdid;

//			if($printBadge == 1){
//				include ("../../2010test/reports/printBadge.php");
//			}
//			if($printInvoice == 1) {
//				include ("../../2010test/reports/printInvoice.php");
//			}
                        } // if printBadge == 3 then skip the update
// }
                    }

                    if (isset($_POST['print'])) {
                        echo "THIS IS STILL UNDER CONSTRUCTION - COMING SOON.";
                    } else { /////////////////// pull a record from invoice search
                        if ($_GET['vid']) {
                            $vid = $_GET['vid'];
                        }

                        $selectStmt = "SELECT * FROM $tablesponsor WHERE '$vid' = vid ";

                        $selectresult = mysql_query($selectStmt) or die("Picking VID Query failed : " . mysql_error() . "<BR><BR>The statement being executed is: " . $selectStmt);

                        $row = mysql_fetch_array($selectresult);

                        $fname = $row['fname'];
                        $lname = $row['lname'];
                        $address1 = $row['address1'];
                        $address1 = $row['address1'];
                        $company = $row['company'];
                        $city = $row['city'];
                        $state = $row['state'];
                        $zip = $row['zip'];
                        $country = $row['country'];
                        $billing_sal = $row['billing_sal'];
                        $billing_fname = $row['billing_fname'];
                        $billing_lname = $row['billing_lname'];
                        $billing_company = $row['billing_company'];
                        $billing_title = $row['billing_title'];
                        $billing_address1 = $row['billing_address1'];
                        $billing_address2 = $row['billing_address2'];
                        $billing_city = $row['billing_city'];
                        $billing_state = $row['billing_state'];
                        $billing_country = $row['billing_country'];
                        $billing_zip = $row['billing_zip'];
                        $billing_phone = $row['billing_phone'];
                        $billing_fax = $row['billing_fax'];
                        $billing_email = $row['billing_email'];
                        $invoicedate = $row['invoicedate'];
                        $oneday = $row['oneday'];
                        $day = $row['day'];
                        $totalcharged = $row['totalcharged'];
                        $totalpaid = $row['totalpaid'];
                        $paytype = $row['paytype'];
                        $miraresponse = $row['miraresponse'];
                        $regstatus = $row['reg_status'];
                        $paytype = $row['paytype'];
                        $funccode = $row['funccode'];

                        // check to see if they selected the amazing walk
                        $check = "select funccode, charged from $tabledetailname where funccode='AMZWLK' and vid='$vid'";
                        $checkres = mysql_query($check);
                        $checknum = mysql_num_rows($checkres);

                        if ($totalcharged < 60) {
                            $funccost = "0.00";
                        } else {
                            if ($checknum > 0) {
                                $funccost = number_format($totalcharged - 30, 2);
                                $amazing = "Yes";
                            } else {
                                $funccost = $totalcharged;
                            }
                        }
                        //include '../includes/formatReplace.php';

                        $strName = $fname . " " . $lname;


                        //////////////////////////////////////////////////////////////////////////////////
                        //////////////////////////////////////////////////////////////////////////////////
                        // promo code
                        if (!isset($promoCode)) {
                            $promo = "select promoCode from $tablepromo where invoiceSponsor='$vid'";
                            $promores = mysql_query($promo);
                            $pr = mysql_fetch_assoc($promores);
                            $promoCode = $pr['promoCode'];
                        }

                        if ($amazing == "Yes") {
                            $funccost = number_format($totalcharged - 30, 2);
                        } else {
                            $funccost = $totalcharged;
                        }

                        if (isset($promoCode) && $promoCode != "") {
                            // check if they need to pay for Amazing Walk
                            //echo "promo: $promoCode, vid:$vid";
                            if ($amazing == "Yes") {
                                $totalcharged = number_format($totalcharged - 200, 2);
                                $totaldue = number_format($totalcharged + ($totalcharged * 0.05 * 0.00), 2);
                                $funccost = "0.00";
                            } else {
                                $totaldue = "0.00";
                                $totalcharged = "0.00";
                                $funccost = "0.00";
                            }

                            $today = date('Y-m-d');

                            // sanitize our promo code
                            $promoCode = mysql_real_escape_string($promoCode);
                            // start processing promo code
                            $psel = "select * from $tablepromo where promoCode='$promoCode' order by id desc limit 1";
                            $pres = mysql_query($psel) or die("There was an error retrieving the promotion code" . mysql_error());
                            $n = mysql_num_rows($pres);
                            if ($n != 1) {
                                $promomessage = "<h2 class=\"red\">The Promotional Code was not valid.</h2><p class=\"red\"><strong>If you believe this is in error, click the Make Changes button below and re-enter your promotional code.<br />If you continue to have problems, contact support at <a href=\"mailto:support@idassociates.ab.ca?Subject=Banff/2013 Pipeline Workshop - Trouble with Promotional Code\">support@idassociates.ab.ca</a></strong>";
                            } else {
                                // code was found, start processing
                                $promo = mysql_fetch_array($pres);
                                $pid = $promo['id'];
                                $penable = $promo['enabled'];
                                $pinv = $promo['invoice'];

                                if (!$penable) { // not enabled
                                    $promomessage = "<h2>The promotion code is no longer valid.</h2><p>If you believe this is in error, click the Make Changes button below and re-enter your promotional code.</p>";
                                } else if ($pin != "" && $pinv != $vid) { // already redeemed
                                    // code was used by some one else
                                    $promomessage = "<h2>This Promotional Code has already been redeemed.</h2><p>If you received multiple Promotional Codes, you can click the Make Changes button below and enter a new Promotional Code.</p><p>If you continue to have trouble, contact support at <a href=\"mailto:support@idassociates.ab.ca?Subject=Banff/2013 Pipeline Workshop - Trouble with Promotional Code\">support@idassociates.ab.ca</a></p>";
                                } else if ($pinv == "" && $penable) { // code is good and hasn't been used yet
                                    // hasn't been used, process promo code
                                    // update promo record and mark with the invoice number
                                    $pupdate = "update $tablepromo set invoiceSponsor='$vid' where id='$pid'";
                                    $pupres = mysql_query($pupdate) or die("There was an error updating the promotion code." . mysql_error());

                                    // update registrant information to zero out total charged and total due
                                    $vupdate = "update $tablesponsor set totalcharged='$totalcharged', totaldue='$totaldue', datepaid='$today', paytype='PROMO' where vid='$vid'";
                                    $vupres = mysql_query($vupdate) or die("There was an error updating the registrant record with the promotional code. " . mysql_error());

                                    // insert a record into the payment table to track redeemed promo codes
                                    $purupdate = "insert into $tablePaymentSponsor (vid, pay_amount, date_paid, time_paid, transaction_type, response, response_id)
													values
													('$vid', '0.00', '$today', '', 'PROMO', 'APPROVED', '$promoCode')";
                                    $purupres = mysql_query($purupdate) or die("There was an error inserting the promotional code into the payment records. " . mysql_error());

                                    $promomessage = "<h2>Your Promotional Code has been successfully processed.</h2><p class=\"red\"><strong>Please note that this does not complete your registration. You must finish the process by clicking the send invoice button at the bottom of your registration summary.</strong></p>";
                                } else if ($pinv == $vid) { // they have already used the promo code
                                    // make sure we don't reset their total owing
                                    // update registrant information to zero out total charged and total due
                                    $vupdate = "update $tablesponsor set totalcharged='$totalcharged', totaldue='$totaldue', datepaid='$today', paytype='PROMO' where vid='$vid'";
                                    $vupres = mysql_query($vupdate) or die("There was an error updating the registrant record with the promotional code. " . mysql_error());

                                    $promomessage = "<h2>Your Promotional Code has been successfully processed.</h2><p class=\"red\"><strong>Please note that this doesn not complete your registration. You must finish the process by clicking the send invoice button at the bottom of your registration summary.</strong></p>";
                                }
                            }
                        }
                        //////////////////////////////////////////////////////////////////////////////////
                        //////////////////////////////////////////////////////////////////////////////////
                        ?>
                        <form method='post' action='' name='invoice' ENCTYPE='multipart/form-data' >
                            <p>
                                <input type='hidden' name='vid' value='<?php
                                if ($vid) {
                                    echo $vid;
                                }
                                ?>'>
                                <input type='hidden' name='promoCode' value='<?php echo $promoCode; ?>'>
                            </p>
                            <h2>&nbsp;</h2>
                            <p>
                                <?php
                                $invoice_info = implode('', file('../includes/invoice_template2.php'));
                                // strip in registrant info, invoice # and date
                                $invoice_info = str_replace("{vid}", $vid, $invoice_info);
                                $date = convertDate(date('Y-m-d'));
                                $invoice_info = str_replace("{date}", $date, $invoice_info);
                                $invoice_info = str_replace("{fname}", $fname, $invoice_info);
                                $invoice_info = str_replace("{lname}", $lname, $invoice_info);
                                $invoice_info = str_replace("{company}", $company, $invoice_info);
                                $full_address = $address1;
                                if ($address2) {
                                    $full_address .= ", " . $address2;
                                }
                                $full_address .="<br>" . $city;
                                if ($state) {
                                    $full_address .= ", " . $state;
                                }
                                $full_address .= ", " . $country . "&nbsp;&nbsp;" . $zip;
                                $invoice_info = str_replace("{full_address}", $full_address, $invoice_info);
                                // strip in billing info if any
                                if ($billing_email != "") {
                                    $billing_replace = '<tr>
																<td width="80" align="left" valign="top" nowrap >
																	<p><strong>Bill To:</strong> </p>
																</td><td colspan="3"><p>';
                                    if ($billing_fname != "") {
                                        $billing_replace .= $billing_fname . " " . $billing_lname . "<br>";
                                    }
                                    $billing_replace .= $billing_company . "<br>";
                                    $billing_replace .= $billing_address1;
                                    if ($billing_address2) {
                                        $billing_replace .= ", " . $billing_address2;
                                    }
                                    $billing_replace .= "<br>" . $billing_city;
                                    if ($billing_state) {
                                        $billing_replace .=", " . $billing_state;
                                    }
                                    $billing_replace .= ", " . $billing_country . "&nbsp;&nbsp;" . $billing_zip;
                                    $billing_replace .="</p></td></tr>";
                                } else {
                                    $billing_replace = "";
                                }
                                $invoice_info = str_replace("{billing_info}", $billing_replace, $invoice_info);
                                //////////////////////////////////////////////////////////////////////////////
                                // strip in invoice details///////////////////////////////////////////////////
                                if ($regstatus == "CANCELLED") {
                                    $invoice_info = str_replace("{special_notes}", "<p class='red'>THIS REGISTRATION HAS BEEN CANCELLED</p>", $invoice_info);
                                } else if ($regstatus == "JUNK") {
                                    $invoice_info = str_replace("{special_notes}", "<p class='red'>THIS REGISTRATION HAS BEEN MARKED AS JUNK</p>", $invoice_info);
                                } else {
                                    $invoice_info = str_replace("{special_notes}", "", $invoice_info);
                                }
                                $invoice_details = "";
                                $details = "select c.*, d.funccode as dfunccode from $conference c, $tabledetailname d where d.funcid=c.id and d.vid='$vid' order by c.date, c.startTime asc";
                                $deresult = mysql_query($details) or die("Query failed : " . mysql_error());

                                $monday = array();
                                $tuesday = array();
                                $wednesday = array();

                                while ($deline = mysql_fetch_array($deresult)) {
                                    if ($deline['date'] == "2013-04-08") {
                                        array_push($monday, $deline);
                                    } else if ($deline['date'] == "2013-04-09") {
                                        array_push($tuesday, $deline);
                                    } else if ($deline['date'] == "2013-04-10") {
                                        array_push($wednesday, $deline);
                                    }
                                }
                                $mondayL = sizeof($monday);
                                $tuesdayL = sizeof($tuesday);
                                $wednesdayL = sizeof($wednesday);
                                $invoice_details .= "<tr><td colspan=\"3\" align=\"left\">";
                                if ($funccode == "FULL") {
                                    $invoice_details .= "<p><strong>Full Registration (includes all lunches)</strong></p></td><td align=\"right\">$funccost</td>";
                                } else {
                                    $invoice_details .= "<p><strong>One Day Registration (includes lunch)</strong></p></td><td align=\"right\">$funccost</td>";
                                }
                                $invoice_details .= "</tr>";
                                //echo "<tr><td>".$mondayL."  ".$confticksL."  ".$conftutsL."</td></tr>";
                                if ($mondayL > 0) {
                                    $invoice_details .= "<tr><td colspan='4'><hr /></td></tr>";
                                    $invoice_details .= "<tr><td colspan='4'><p><strong>Monday, " . convertDate($monday[0]['date']) . "</strong></p></td></tr>";
                                    for ($a = 0; $a < $mondayL; $a++) {
                                        $invoice_details .= "<tr><td align=\"left\" valign=\"top\" width=\"100\" class=\"dottheline\"><p>[" . $monday[$a]['funccode'] . "]</p></td><td colspan=\"2\" align=\"left\" valign=\"top\" class=\"dottheline\"><p> " . $monday[$a]['funcdescr'];
                                        if ($monday[$a]['funccost'] == "--") {
                                            $thecost = "--";
                                        } else {
                                            $thecost = number_format($monday[$a]['funccost'], 2);
                                        }
                                        $invoice_details .= "</p></td> <td align='right' class=\"dottheline\"><p>$thecost</p></td></tr>";
                                        if ($monday[$a]['funccode'] != $monday[$a]['dfunccode']) {
                                            $invoice_details .= "<tr><td class=\"red\" colspan=\"4\"><p>Please note that this session has changed since you registered. The day presented here is the most up to date.</p></td></tr>";
                                        }
                                    }
                                    $invoice_details .= "<tr><td align=\"left\" valign=\"top\" width=\"100\"><p></p></td><td colspan=\"2\" align=\"left\" valign=\"top\"><p>Lunch</p></td> <td align='right'><p>--</p></td></tr>";
                                }
                                if ($tuesdayL > 0) {
                                    $invoice_details .= "<tr><td colspan='4'><hr /></td></tr>";
                                    $invoice_details .= "<tr><td colspan='4'><p><strong>Tuesday, " . convertDate($tuesday[0]['date']) . "</strong></p></td></tr>";
                                    for ($a = 0; $a < $tuesdayL; $a++) {

                                        $invoice_details .= "<tr><td align=\"left\" valign=\"top\" width=\"100\" class=\"dottheline\"><p>[" . $tuesday[$a]['funccode'] . "]</p></td><td colspan=\"2\" align=\"left\" valign=\"top\" class=\"dottheline\"><p> " . $tuesday[$a]['funcdescr'] . "</p>";
                                        if ($tuesday[$a]['funccost'] == "--") {
                                            $thecost = "--";
                                        } else {
                                            $thecost = number_format($tuesday[$a]['funccost'], 2);
                                        }
                                        if ($tuesday[$a]['funccode'] != $tuesday[$a]['dfunccode']) {
                                            $invoice_details .= "<p class=\"red\">Please note that the session [" . $tuesday[$a]['dfunccode'] . "] has changed to [" . $tuesday[$a]['funccode'] . "] since you registered. The session presented here is the most up to date.</p>";
                                        }
                                        $invoice_details .= "</td>  <td align='right' class=\"dottheline\"><p>$thecost</p></td></tr>";
                                    }
                                    $invoice_details .= "<tr><td align=\"left\" valign=\"top\" width=\"100\"><p>&nbsp;</p></td><td colspan=\"2\" align=\"left\" valign=\"top\"><p>Lunch</p></td> <td align='right'><p>--</p></td></tr>";
                                }
                                if ($wednesdayL > 0) {
                                    $invoice_details .= "<tr><td colspan='4'><hr /></td></tr>";
                                    $invoice_details .= "<tr><td colspan='4'><p><strong>Wednesday, " . convertDate($wednesday[0]['date']) . "</strong></p></td></tr>";
                                    for ($a = 0; $a < $wednesdayL; $a++) {

                                        $invoice_details .= "<tr><td align=\"left\" valign=\"top\" width=\"100\" class=\"dottheline\"><p>[" . $wednesday[$a]['funccode'] . "]</p></td><td colspan=\"2\" align=\"left\" valign=\"top\" class=\"dottheline\"><p> " . $wednesday[$a]['funcdescr'] . "</p>";
                                        if ($wednesday[$a]['funccost'] == "--") {
                                            $thecost = "--";
                                        } else {
                                            $thecost = number_format($wednesday[$a]['funccost'], 2);
                                        }
                                        if ($wednesday[$a]['funccode'] != $wednesday[$a]['dfunccode']) {
                                            $invoice_details .= "<p class=\"red\">Please note that the session [" . $wednesday[$a]['dfunccode'] . "] has changed to [" . $wednesday[$a]['funccode'] . "] since you registered. The session presented here is the most up to date.</p>";
                                        }
                                        $invoice_details .= "</td>  <td align='right' class=\"dottheline\"><p>$thecost</p></td></tr>";
                                    }
                                    $invoice_details .= "<tr><td align=\"left\" valign=\"top\" width=\"100\"><p>&nbsp;</p></td><td colspan=\"2\" align=\"left\" valign=\"top\"><p>Lunch</p></td> <td align='right'><p>--</p></td></tr>";
                                }
                                if ($funccode == "FULL") {
                                    $invoice_details .= "<tr><td colspan='4'><hr /></td></tr>";
                                    $invoice_details .= "<tr><td colspan='4'><p><strong>Thursday, April 11</strong></p></td></tr>";
                                    $invoice_details .= "<tr><td width=\"100\" class=\"dottheline\">&nbsp;</td><td colspan=\"2\" class=\"dottheline\"><p>Working Group Co-Chair Reports and Summaries</p></td>  <td align='right' class=\"dottheline\"><p>--</p></td></tr>";
                                    $invoice_details .= "<tr><td width=\"100\" class=\"dottheline\">&nbsp;</td><td colspan=\"2\" class=\"dottheline\"><p>Coffee Break/Networking</p></td>  <td align='right' class=\"dottheline\"><p>--</p></td></tr>";
                                    $invoice_details .= "<tr><td width=\"100\" class=\"dottheline\">&nbsp;</td><td colspan=\"2\" class=\"dottheline\"><p>Open Forum Discussion</p></td>  <td align='right' class=\"dottheline\"><p>--</p></td></tr>";
                                    $invoice_details .= "<tr><td width=\"100\" class=\"dottheline\">&nbsp;</td><td colspan=\"2\" class=\"dottheline\"><p>Lunch</p></td>  <td align='right' class=\"dottheline\"><p>--</p></td></tr>";
                                }
                                $invoice_info = str_replace("{invoice_details}", $invoice_details, $invoice_info);
                                ///////////////////////// end of invoice details //////////////////////////////////
                                //////////////////////////////////////////////////////////////////////////////
                                if ($totalcharged) {
                                    $totaldue = ($totalcharged + ($totalcharged * 0.05 * 0.00)) - $totalpaid;
                                }
                                $gstcharged = sprintf("%01.2f", $totalcharged * 0.05 * 0.00);
                                $totalcharged = sprintf("%01.2f", $totalcharged);
                                $invoice_info = str_replace("{totalcharged}", $totalcharged, $invoice_info);
                                $invoice_info = str_replace("{gstcharged}", $gstcharged, $invoice_info);
                                $totalpaid = sprintf("%01.2f", $totalpaid);


////////////////////////////////////////////////////////////////////////////////////
//////////////////////// grab payment history //////////////////////////////////////		
                                $paymenthist = "select * from $tablePaymentSponsor where vid='$vid' order by id asc";
                                $paymenthistresult = mysql_query($paymenthist) or die("Query failed : " . mysql_error());

                                $histnum = mysql_numrows($paymenthistresult);
                                $payment_line = '';
                                if ($histnum == 0) {
                                    $payment_line .= '
							<tr>
								<td colspan="3" align="right">
									<p><strong>Amount Paid:</strong></p>
								</td>
								<td align="right">
									<p>' . $totalpaid . '</p>
								</td>
							</tr>';
                                } else {
                                    while ($hist = mysql_fetch_array($paymenthistresult)) {
                                        if ($hist['pay_amount'] < 0) {
                                            $payorrefund = '<strong>Refund Issued</strong> ';
                                            $selectclass = ' class="red" ';
                                            $special = '';
                                        } else if ($hist['transaction_type'] == 'CNCLFEE') {
                                            $payorrefund = '<strong>Cancellation Fee</strong> ';
                                            $selectclass = '';
                                            $special = '<tr><td colspan="4" align="right"><em>Please note: When you receive your refund, the fee will already have been taken off the refund total</em></td></tr>';
                                            $totaldue = $totaldue + 10;
                                        } else if ($hist['transaction_type'] == 'RFNDFEE') {
                                            $payorrefund = '<strong>Refund Fee</strong>';
                                            $selectclass = '';
                                            $special = '<tr><td colspan="4" align="right"><em>Please note: When you receive your refund, the fee will already have been taken off the refund total</em></td></tr>';
                                            $totaldue = $totaldue + 10;
                                        } else {
                                            $payorrefund = '<strong>Payment Received</strong> ';
                                            $selectclass = '';
                                            $special = '';
                                        }
                                        $payment_line .= '
									<tr>
										<td colspan="3" align="right" valign="top"' . $selectclass . '>
											<p>' . $payorrefund . ' ' . convertDate($hist['date_paid']) . ' (' . $hist['transaction_type'] . ' #' . $hist['response_id'] . ' ' . $hist['response'] . '):</p>
										</td>
										<td align="right" valign="top"' . $selectclass . '>
											<p>' . $hist['pay_amount'] . '</p>
										</td>
									</tr>' . $special;
                                    }
                                    $todaydate = date('Y-m-d');

                                    $payment_line .='
								<tr>
									<td colspan="3" align="right">
										<h3>Payments Received as of ' . convertDate($todaydate) . ':</h3>
									</td>
									<td align="right">
										<h3>' . $totalpaid . '</h3>
									</td>
								</tr>';
                                }
                                $invoice_info = str_replace("{paymenthistory}", $payment_line, $invoice_info);
///////////////////////end of payment history //////////////////////////////////////	

                                if ($regstatus == 'CANCELLED') {
                                    $invoice_info = str_replace("{message_status}", "red", $invoice_info);
                                    $invoice_info = str_replace("{totaldue_message}", "<em>REGISTRATION CANCELLED</em>&nbsp;&nbsp;&nbsp; Total Owing:", $invoice_info);
                                    $invoice_info = str_replace("{refund_message}", "<h2 class='red'>THIS REGISTRATION HAS BEEN CANCELLED.</h2>", $invoice_info);
                                    $totaldue = '0.00';
                                } else if ($totaldue >= 0) {
                                    $invoice_info = str_replace("{message_status}", "", $invoice_info);
                                    $invoice_info = str_replace("{totaldue_message}", "Total Owing:", $invoice_info);
                                    $invoice_info = str_replace("{refund_message}", "", $invoice_info);
                                } else {
                                    $invoice_info = str_replace("{message_status}", "red", $invoice_info);
                                    $invoice_info = str_replace("{totaldue_message}", "Refund Due:", $invoice_info);
                                    $invoice_info = str_replace("{refund_message}", "<h2 class='red'>Changes in your registration have resulted in a refund. <br />Refunds are subject to a $10 processing fee.</h2>", $invoice_info);
                                }
                                $totaldue = sprintf("%01.2f", $totaldue);
                                $invoice_info = str_replace("{totaldue}", $totaldue, $invoice_info);

                                echo $invoice_info;
                                ?>
                            </p>
                            <h2>&nbsp;</h2>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                        </form>
                        <?php
                        mysql_close($link);
                    }
                    ?>
                </div>
            </div>
            <div id="footer">
                <p>&nbsp;</p>
            </div>
        </div>
    </body>
</html>
