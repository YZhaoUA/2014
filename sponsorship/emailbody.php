<?php

//include 'includes/connectScript.php';
//include 'mimemail.inc';
if (!$sid) {
    echo "Problem with sending invoice, no id available.";
} else {
    $holdid = $sid;
    //if($asme){ $sid = $asme; } 
    $selectStmt = "select * from $tablesponsor WHERE sid = '$sid' ";
    $finduser = mysql_query($selectStmt) or die("The main select statement failed to execute with error: " . mysql_error() . ". <BR><BR>The statement is: " . $selectStmt);
    $sid = $holdid;
}
$strName = mysql_result($finduser, 0, "fname") . " " . mysql_result($finduser, 0, "lname");
$sal = mysql_result($finduser, 0, "sal");
$fname = mysql_result($finduser, 0, "fname");
$lname = mysql_result($finduser, 0, "lname");
$company = mysql_result($finduser, 0, "company");
$title = mysql_result($finduser, 0, "title");
$address1 = mysql_result($finduser, 0, "address1");
$address2 = mysql_result($finduser, 0, "address2");
$city = mysql_result($finduser, 0, "city");
$state = mysql_result($finduser, 0, "state");
$country = mysql_result($finduser, 0, "country");
$zip = mysql_result($finduser, 0, "zip");
$email = mysql_result($finduser, 0, "email");
//$billing = mysql_result($finduser,0,"billing");
//$billing_sal = mysql_result($finduser,0,"billing_sal");
//$billing_fname = mysql_result($finduser,0,"billing_fname");
//$billing_lname = mysql_result($finduser,0,"billing_lname");
//$billing_company = mysql_result($finduser,0,"billing_company");
//$billing_title = mysql_result($finduser,0,"billing_title");
//$billing_address1 = mysql_result($finduser,0,"billing_address1");
//$billing_address2 = mysql_result($finduser,0,"billing_address2");
//$billing_city = mysql_result($finduser,0,"billing_city");
//$billing_state = mysql_result($finduser,0,"billing_state");
//$billing_country = mysql_result($finduser,0,"billing_country");
//$billing_zip = mysql_result($finduser,0,"billing_zip");
//$billing_email = mysql_result($finduser,0,"billing_email");
$totalcharged = mysql_result($finduser, 0, "totalcharged");
$totalpaid = mysql_result($finduser, 0, "totalpaid");
$totaldue = mysql_result($finduser, 0, "totaldue");
$datepaid = mysql_result($finduser, 0, "datepaid");
$paytype = mysql_result($finduser, 0, "paytype");
$regstatus = mysql_result($finduser,0,"reg_status");
$sponcode = mysql_result($finduser, 0, "sponcode");

// check to see if they selected the amazing walk
//$check = "select funccode, charged from $tabledetailname where funccode='AMZWLK' and vid='$sid'";
//$checkres = mysql_query($check);
//$checknum = mysql_num_rows($checkres);

if ($totalcharged < 60) {
    $funccost = "0.00";
} else {
//    if ($checknum > 0) {
//        $funccost = number_format($totalcharged - 30, 2);
//    } else {
        $funccost = $totalcharged;
//    }
}


// build invoice	
$html_invoice = '';
if (!isset($thepath)) {
    $thepath = '';
}
$invoice_template_path = $thepath . 'includes/invoice_template2.php';

$invoice_info = implode('', file($invoice_template_path));
// strip in registrant info, invoice # and date
$invoice_info = str_replace("{sid}", $sid, $invoice_info);
$date = date('F j, Y');
$invoice_info = str_replace("{date}", $date, $invoice_info);
$invoice_info = str_replace("{fname}", $fname, $invoice_info);
$invoice_info = str_replace("{lname}", $lname, $invoice_info);
$invoice_info = str_replace("{company}", $compan013y, $invoice_info);
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
//				// strip in billing info if any
//				if($billing_email!=""){
//					$billing_replace = '<tr>
//																<td width="80" align="left" valign="top" nowrap >
//																	<p><strong>Bill To:</strong> </p>
//																</td><td colspan="3"><p>';
//					if($billing_fname!=""){ $billing_replace .= $billing_fname." ".$billing_lname."<br>"; }
//					$billing_replace .= $billing_company."<br>";
//					$billing_replace .= $billing_address1;
//					if($billing_address2){ $billing_replace .= ", ".$billing_address2; }
//					$billing_replace .= "<br>".$billing_city;
//					if($billing_state){ $billing_replace .=", ".$billing_state; }
//					$billing_replace .= ", ".$billing_country."&nbsp;&nbsp;".$billing_zip;
//					$billing_replace .="</p></td></tr>";
//				} else {
//					$billing_replace="";
//				}
//				$invoice_info = str_replace("{billing_info}", $billing_replace,$invoice_info);
//				//////////////////////////////////////////////////////////////////////////////
//				// strip in invoice details///////////////////////////////////////////////////
//				if($regstatus=="CANCELLED"){
//					$invoice_info = str_replace("{special_notes}", "<p class='red'>THIS REGISTRATION HAS BEEN CANCELLED</p>",$invoice_info);
//				} else if($regstatus=="JUNK"){
//					$invoice_info = str_replace("{special_notes}", "<p class='red'>THIS REGISTRATION HAS BEEN MARKED AS JUNK</p>",$invoice_info);
//				} else {
//					$invoice_info = str_replace("{special_notes}", "",$invoice_info);
//				}
                        $invoice_details = "";

                        $funccost = number_format($totalcharged, 2);
                        $invoice_details .= "<tr><td colspan=\"3\" align=\"left\">";
                        if ($sponcode == "PTRN") {
                            $invoice_details .= "<p><strong>Patron [$sponcode] (3 complementary workshop registrations)</strong></p></td><td align=\"right\">$funccost</td>";
                        } else if ($sponcode == "SPNS") {
                            $invoice_details .= "<p><strong>Sponsor [$sponcode] (2 complementary workshop registrations)</strong></p></td><td align=\"right\">$funccost</td>";
                        } else {
                            $invoice_details .= "<p><strong>Coffee Breaks [$sponcode] (2 complementary workshop registrations)</strong></p></td><td align=\"right\">$funccost</td>";
                        }
     
                        $invoice_details .= "</tr>";
  
                        
                        // add promo code in one new line
                        $psel = "select * from $tablepromo where invoiceSponsor='$sid'";
                        $pres = mysql_query($psel) or die("There was an error retrieving the promotion code" . mysql_error());
                        $n = mysql_num_rows($pres);
                        $invoice_details .= "<tr><td colspan='4'><hr /></td></tr>";
                        $invoice_details .= "<tr><td align=\"left\" valign=\"top\" width=\"100\" class=\"dottheline\" colspan=\"4\">";
                        if ($n == 0) { // no promotion code
                            $invoice_details .= "<p><strong>The promotion codes will be generated when we receive your payment.</strong></p>";
                        } else {
                            $invoice_details .= "<p><strong>Promotion Codes:</p> ";
                            while($row = mysql_fetch_array($pres)){
                                $promoCode = $row['promoCode'];
                                $invoice_details .= "<p>$promoCode</p> ";
                            }
                            $invoice_details .= "</strong></p>";
                        }
							$invoice_details .= "<p>You can use the promotional codes for your complimentary workshop registrations once the workshop registration opens. Please keep this email for your records.</p>";
                        $invoice_details .= "</td></tr>";

                        $invoice_info = str_replace("{invoice_details}", $invoice_details, $invoice_info);
//					$details="select c.*, d.funccode as dfunccode, n.funccode as regtype from $conference c, $tabledetailname d, $tablesponsor n where n.vid=d.vid and d.funccode=c.funccode and d.vid='$sid' order by c.date, c.startTime asc";
//					$deresult = mysql_query($details) or die("Query failed : " . mysql_error());
//					
//						$monday = array();
//						$tuesday = array();
//						$wednesday = array();
//					
//					while($deline = mysql_fetch_array($deresult)){
//						$funccode = $deline['regtype'];
//						if($deline['date']=="2013-04-08") {
//						array_push($monday,$deline);
//						} else if($deline['date']=="2013-04-09"){
//							array_push($tuesday,$deline);
//						} else if($deline['date']=="2013-04-10") {
//							array_push($wednesday,$deline);
//						} 
//					}
//						$mondayL = sizeof($monday);
//						$tuesdayL = sizeof($tuesday);
//						$wednesdayL = sizeof($wednesday);
//						$invoice_details .= "<tr><td colspan=\"3\" align=\"left\">";
//						if($funccode=="FULL"){ $invoice_details .= "<p><strong>Full Registration (includes all lunches)</strong></p></td><td align=\"right\">$funccost</td>"; } else { $invoice_details .= "<p><strong>One Day Registration (includes lunch)</strong></p></td><td align=\"right\">$funccost</td>"; }
//						$invoice_details .= "</tr>";
//						//echo "<tr><td>".$mondayL."  ".$confticksL."  ".$conftutsL."</td></tr>";
//						if($mondayL>0){
//							$invoice_details .= "<tr><td colspan='4'><hr /></td></tr>";
//							$invoice_details .= "<tr><td colspan='4'><p><strong>Monday, ".convertDate($monday[0]['date'])."</strong></p></td></tr>";
//							for($a=0;$a<$mondayL;$a++){
//								$invoice_details .= "<tr><td align=\"left\" valign=\"top\" width=\"100\" class=\"dottheline\"><p>[". $monday[$a]['funccode'] . "]</p></td><td colspan=\"2\" align=\"left\" valign=\"top\" class=\"dottheline\"><p> " . $monday[$a]['funcdescr'];
//								if($monday[$a]['funccost']=="--"){ $thecost = "--"; } else { $thecost = number_format($monday[$a]['funccost'],2); }
//								$invoice_details .= "</p></td> <td align='right' class=\"dottheline\"><p>$thecost</p></td></tr>" ;
//								if($monday[$a]['funccode']!=$monday[$a]['dfunccode']){
//									$invoice_details .= "<tr><td class=\"red\" colspan=\"4\"><p>Please note that this session has changed since you registered. The day presented here is the most up to date.</p></td></tr>";
//								}
//							}
//							$invoice_details .= "<tr><td align=\"left\" valign=\"top\" width=\"100\"><p></p></td><td colspan=\"2\" align=\"left\" valign=\"top\"><p>Lunch</p></td> <td align='right'><p>--</p></td></tr>" ;
//						}
//						if($tuesdayL>0){
//							$invoice_details .= "<tr><td colspan='4'><hr /></td></tr>";
//							$invoice_details .= "<tr><td colspan='4'><p><strong>Tuesday, ".convertDate($tuesday[0]['date'])."</strong></p></td></tr>";
//							for($a=0;$a<$tuesdayL;$a++){
//
//								$invoice_details .= "<tr><td align=\"left\" valign=\"top\" width=\"100\" class=\"dottheline\"><p>[". $tuesday[$a]['funccode'] . "]</p></td><td colspan=\"2\" align=\"left\" valign=\"top\" class=\"dottheline\"><p> " . $tuesday[$a]['funcdescr']."</p>";
//								if($tuesday[$a]['funccost']=="--"){ $thecost = "--"; } else { $thecost = number_format($tuesday[$a]['funccost'],2); }
//								if($tuesday[$a]['funccode']!=$tuesday[$a]['dfunccode']){
//									$invoice_details .= "<p class=\"red\">Please note that the session [".$tuesday[$a]['dfunccode']."] has changed to [".$tuesday[$a]['funccode']."] since you registered. The session presented here is the most up to date.</p>";
//								}
//								$invoice_details .= "</td>  <td align='right' class=\"dottheline\"><p>$thecost</p></td></tr>" ;
//							}
//							$invoice_details .= "<tr><td align=\"left\" valign=\"top\" width=\"100\"><p>&nbsp;</p></td><td colspan=\"2\" align=\"left\" valign=\"top\"><p>Lunch</p></td> <td align='right'><p>--</p></td></tr>" ;
//						}
//						if($wednesdayL>0){
//							$invoice_details .= "<tr><td colspan='4'><hr /></td></tr>";
//							$invoice_details .= "<tr><td colspan='4'><p><strong>Wednesday, ".convertDate($wednesday[0]['date'])."</strong></p></td></tr>";
//							for($a=0;$a<$wednesdayL;$a++){
//
//								$invoice_details .= "<tr><td align=\"left\" valign=\"top\" width=\"100\" class=\"dottheline\"><p>[". $wednesday[$a]['funccode'] . "]</p></td><td colspan=\"2\" align=\"left\" valign=\"top\" class=\"dottheline\"><p> " . $wednesday[$a]['funcdescr']."</p>";
//								if($wednesday[$a]['funccost']=="--"){ $thecost = "--"; } else { $thecost = number_format($wednesday[$a]['funccost'],2); }
//								if($wednesday[$a]['funccode']!=$wednesday[$a]['dfunccode']){
//									$invoice_details .= "<p class=\"red\">Please note that the session [".$wednesday[$a]['dfunccode']."] has changed to [".$wednesday[$a]['funccode']."] since you registered. The session presented here is the most up to date.</p>";
//								}
//								$invoice_details .= "</td>  <td align='right' class=\"dottheline\"><p>$thecost</p></td></tr>" ;
//							}
//							$invoice_details .= "<tr><td align=\"left\" valign=\"top\" width=\"100\"><p>&nbsp;</p></td><td colspan=\"2\" align=\"left\" valign=\"top\"><p>Lunch</p></td> <td align='right'><p>--</p></td></tr>" ;
//						}
//						if($funccode=="FULL"){ 
//							$invoice_details .= "<tr><td colspan='4'><hr /></td></tr>";
//							$invoice_details .= "<tr><td colspan='4'><p><strong>Thursday, April 11</strong></p></td></tr>";
//								$invoice_details .= "<tr><td width=\"100\" class=\"dottheline\">&nbsp;</td><td colspan=\"2\" class=\"dottheline\"><p>Working Group Co-Chair Reports and Summaries</p></td>  <td align='right' class=\"dottheline\"><p>--</p></td></tr>" ;
//								$invoice_details .= "<tr><td width=\"100\" class=\"dottheline\">&nbsp;</td><td colspan=\"2\" class=\"dottheline\"><p>Coffee Break/Networking</p></td>  <td align='right' class=\"dottheline\"><p>--</p></td></tr>" ;
//								$invoice_details .= "<tr><td width=\"100\" class=\"dottheline\">&nbsp;</td><td colspan=\"2\" class=\"dottheline\"><p>Open Forum Discussion</p></td>  <td align='right' class=\"dottheline\"><p>--</p></td></tr>" ;
//								$invoice_details .= "<tr><td width=\"100\" class=\"dottheline\">&nbsp;</td><td colspan=\"2\" class=\"dottheline\"><p>Lunch</p></td>  <td align='right' class=\"dottheline\"><p>--</p></td></tr>" ;
//						 }
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
$paymenthist = "select * from $tablePaymentSponsor where sid='$sid' order by id asc";
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
        if ($hist['transaction_type'] == "PROMO" && $totalcharged == 0) {
            $promoItem = true;
        }
        $payment_line .= '
									<tr>
										<td colspan="3" align="right" valign="top"' . $selectclass . '>
											<p>' . $payorrefund . ' ' . convertDate($hist['date_paid']) . ' (' . $hist['transaction_type'] . ' #' . $hist['response_id'] . '):</p>
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
    $invoice_info = str_replace("{refund_message}", "<h2 class='red'>Changes in your registration have resulted in a refund. We have been notified and will contact you regarding your refund.<br />Please note that all refunds are subject to a $10 processing fee.</h2>", $invoice_info);
}
$totaldue = sprintf("%01.2f", $totaldue);
$invoice_info = str_replace("{totaldue}", $totaldue, $invoice_info);


$html_invoice = $invoice_info;
$html_header = '<style type="text/css"><!--';
$css_path = $fullURL . 'css/asmebanffstyles.css';
$html_header .= implode('', file($css_path));
$html_header .= '--></style>';
$html_header .= '<table width="80%" cellpadding="0" cellspacing="0"><tr><td colspan="3">
<img src="' . $webURL . '/images/email_top_banner.jpg" alt="Banff/2015 Pipeline Workshop Header">
</td></tr><tr><td width="100" align="left" valign="top"><img src="' . $webURL . '/images/email_side_banner.jpg" alt="Banff/2015 Pipeline Workshop Header"></td><td>&nbsp;&nbsp;&nbsp;</td><td>
<div id="regarea" style="padding:0px; 20px;">
<h1>Invoice</h1>
';
$html_footer = '';
$html_BNKfooter = '<h2><strong>You have indicated you will be paying via bank transfer.</strong></p>
			<p>For instructions with how to proceed, please email Donna Menuz at <a href="mailto:DonnaMenuz@cepa.com">DonnaMenuz@cepa.com</a></h2>';

if (isset($promoItem) && $promoItem) {
    $html_CCfooter = '<h2>Please print out this invoice and bring it to the Banff/2015 Pipeline Workshop pre-registration desk to eliminate any delays.</h2>';
} else {
    $html_CCfooter = '<h2>Please print out this invoice along with the email Credit Card Confirmation from the payment gateway and
					  bring both to the Banff/2015 Pipeline Workshop pre-registration desk to eliminate any delays.</h2>';
}


$html_closingfooter = "";

$registrant_message = '';

$billing_message = '
<h2>You have been listed as the Banff/2015 Pipeline Workshop Sponsor Registration billing contact for ' . $strName . '</h2><p>Please keep this email as a confirmation of payment.</p><p>&nbsp;</p>';

$refund_message = '
<h2>A refund needs to be issued for ' . $strName . '</h2><p>Contact them to arrange, if they supplied billing information contact the billing name.';
if ($billing == "yes" && $billing_email == "") {
    $refund_message .='<br><strong><em>Please note that this record has had a previous billing contact removed!! Check payment records to see is payment was made by a different person before processing.</em></stong>';
}
$refund_message .= '</p><p>&nbsp;</p>';
//echo "<h1>payOpt: ".$payOpt."</h1>";
if ($payOpt == "CC") {
    $mail = new mime_mail();
    $mail->from = "Banff/2015 Pipeline Workshop Sponsor Registration <mail@idassociates.ab.ca>";
    $mail->headers = "Errors-To: mail@idassociates.ab.ca";
    $mail->to = $email;
    //$mail->to = "heidi@idassociates.ab.ca";
    $mail->subject = "Banff/2015 Pipeline Workshop Invoice";
    $mail->body = $html_header . $registrant_message . $html_invoice . $html_CCfooter . $html_closingfooter;
    $mail->send();
    //echo $html_header.$registrant_message.$html_invoice.$html_CCfooter.$html_closingfooter;
} else if ($payOpt == "BANK") {
    $mail = new mime_mail();
    $mail->from = "Banff/2015 Pipeline Workshop Sponsor Registration <mail@idassociates.ab.ca>";
    $mail->headers = "Errors-To: mail@idassociates.ab.ca";
    $mail->to = $email;
    //$mail->to = "heidi@idassociates.ab.ca";
    $mail->subject = "Banff/2015 Pipeline Workshop Invoice";
    $mail->body = $html_header . $registrant_message . $html_invoice . $html_BNKfooter . $html_closingfooter;
    $mail->send();
    //echo $html_header.$registrant_message.$html_invoice.$html_BNKfooter.$html_closingfooter;
} else {
    $mail = new mime_mail();
    $mail->from = "Banff/2015 Pipeline Workshop Sponsor Registration <mail@idassociates.ab.ca>";
    $mail->headers = "Errors-To: mail@idassociates.ab.ca";
    $mail->to = $email;
    //$mail->to = "heidi@idassociates.ab.ca";
    $mail->subject = "Banff/2015 Pipeline Workshop Invoice";
    $mail->body = $html_header . $registrant_message . $html_invoice . $html_footer . $html_closingfooter;
    $mail->send();
    //echo $html_header.$registrant_message.$html_invoice.$html_footer.$html_closingfooter;
}

if ($billing_email != "") {
    $mail = new mime_mail();
    $mail->from = "Banff/2015 Pipeline Workshop Sponsor Registration <mail@idassociates.ab.ca>";
    $mail->headers = "Errors-To: mail@idassociates.ab.ca";
    $mail->to = $billing_email;
    //$mail->to = "heidi@idassociates.ab.ca";
    $mail->subject = "Banff/2015 Pipeline Workshop Invoice for " . $fname . " " . $lname;
    $mail->body = $html_header . $billing_message . $html_invoice . $html_footer . $html_closingfooter;
    $mail-> send();
    //echo $html_header.$billing_message.$html_invoice.$html_footer.$html_closingfooter;
}


if ($totaldue < 0) {
    $mail = new mime_mail();
    $mail->from = "Banff/2015 Pipeline Workshop Sponsor Registration <mail@idassociates.ab.ca>";
    $mail->headers = "Errors-To: mail@idassociates.ab.ca";
    $mail->to = "mike@idassociates.ab.ca";
    //$mail->to = "heidi@idassociates.ab.ca";
    $mail->subject = "REFUND NOTICE!! Banff/2015 Pipeline Workshop REFUND needed for " . $fname . " " . $lname;
    $mail->body = $html_header . $refund_message . $html_invoice . $html_footer;
    $mail->send();
}

$mail = new mime_mail();
$mail->from = "mail@idassociates.ab.ca";
$mail->headers = "Errors-To: mail@idassociates.ab.ca";
$mail->to = "mike@idassociates.ab.ca";
$mail->subject = "Banff Workshop BEWARE Someone Ordered Something";
$mail->body = $html_header . $html_invoice . $html_footer;
$mail->send();
//echo "<h1 style=\"display:none;\">end of line</h1>";
mysql_close($link);
?>