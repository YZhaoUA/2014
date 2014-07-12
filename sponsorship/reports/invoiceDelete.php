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
        <link href="../jquery/colorbox/colorbox.css" rel="stylesheet" type="text/css">
        <link href="../css/regform.css" rel="stylesheet" type="text/css">
        <link href="../css/reports.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="wrapper">
            <?php include('../includes/header.php'); ?>
            <div id="content">
                <div id="regarea">
                    <?php
                    $sid = $_POST['sid'];

                    if ($_POST['deleteYes']) {

                        $updatestmt = "UPDATE $tablesponsor SET reg_status = 'JUNK' WHERE '$sid' = sid ";
                        mysql_query($updatestmt) or die("The main update statement failed to execute with error: " . mysql_error() . ". <BR><BR>The statement is: " . $updatestmt);

                        // remove invoice number from promo table if it existed
//                        $update = "update $tablepromo set invoiceSponsor='' where invoiceSponsor='$vid'";
//                        $updateres = mysql_query($update);

                        // remove any payment records associated with promo codes
                        $delete = "delete from $tablePaymentSponsor where sid='$sid' and transaction_type='PROMO'";
                        $result = mysql_query($delete);
                        ?>
                        <h1>Delete Invoice </h1>
                        <p>Invoice Successfully Marked as Junk.</p>
                        <form method='post' action='' name='invoice' ENCTYPE='multipart/form-data' >

                            <p>
                                <input name="back" type="submit" class="transformButtonStyle" onclick="this.form.action = 'invoice.php';" value="Back to List">
                            </p>
                        </form>

                        <?php
                    } else {

                        $selectStmt = "SELECT * FROM $tablesponsor WHERE '$sid' = sid ";

                        $selectresult = mysql_query($selectStmt) or die("Picking SID Query failed : " . mysql_error() . "<BR><BR>The statement being executed is: " . $selectStmt);

                        $row = mysql_fetch_array($selectresult);

                        $fname = $row['fname'];
                        $lname = $row['lname'];
                        $address1 = $row['address1'];
                        $address1 = $row['address1'];
                        $city = $row['city'];
                        $state = $row['state'];
                        $zip = $row['zip'];
                        $country = $row['country'];
                        $invoicedate = $row['invoicedate'];
                        $paytype = $row['paytype'];
                        $miraresponse = $row['miraresponse'];
                        $strName = $fname . " " . $lname;
                        $totalcharged = $row['totalcharged'];
                        $totalpaid = $row['totalpaid'];
                        $totaldue = $row['totaldue'];
                        ?>

                        <form method='post' action='' name='invoice' ENCTYPE='multipart/form-data' >
                            <input type='hidden' name='sid' value='<?php
                            if ($sid) {
                                echo $sid;
                            }
                            ?>'>
                            <h1>Delete Invoice </h1>
                            <p>Are you sure you want to delete this invoice? <Br><br><b>This process is not reversable.</b></p>
                            <table width="772" border="0">
                                <tr>
                                    <td width="41"><strong>To:</strong></td>
                                    <td width="443"><?php echo $strName; ?></td>
                                    <td width="70" >
                                        <strong> Invoice #: </strong></td>
                                    <td width="190" >800<?php echo $sid; ?></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><?php
                                        echo $address1;
                                        if ($address2)
                                            echo "<BR>" . $address2;
                                        ?></td>
                                    <td >
                                        <strong>Date:</strong></td>
                                    <td ><?php echo $invoicedate; ?></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><?php echo $city . ", " . $state; ?> </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><?php echo $zip; ?></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><?php echo $country; ?></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>  </tr>
                                <tr>  </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><b>Total Charged: <?php echo $totalcharged; ?>.00</b></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><b>Total Paid: <?php echo $totalpaid; ?>.00</b></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><b>Total Due: <?php echo $totaldue; ?>.00</b></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>  </tr>
                                <tr>
                                </tr>
                            </table>

                            <h3><em>
                                    Summary Processing Information:</em></h3>
                            <br>
                            <table><?php
////////////////////////////////////////////////////////////////////////////////////
//////////////////////// grab payment history //////////////////////////////////////		

                                $paymenthist = "select * from $tablePaymentSponsor where sid='$sid'";
                                $paymenthistresult = mysql_query($paymenthist) or die("Query failed : " . mysql_error());

                                $histnum = mysql_num_rows($paymenthistresult);
                                $payment_line = '';
                                if ($histnum == 0) {
                                    $payment_line .= '
							<tr>
								<td colspan="2" align="right">
									<p><strong>Amount Paid:</strong></p>
								</td>
								<td align="right">
									<p>' . $totalpaid . '</p>
								</td>
							</tr>';
                                } else {
                                    while ($hist = mysql_fetch_array($paymenthistresult)) {
                                        if ($hist['pay_amount'] < 0) {
                                            $payorrefund = 'Refund Issued ';
                                        } else {
                                            $payorrefund = 'Payment Received ';
                                        }

                                        if ($hist['response'] == 'APPROVED') {
                                            $payment_line .= '
									<tr>
										<td colspan="2" align="right">
											<p>' . $payorrefund . ' ' . convertDate($hist['date_paid']) . ':</p>
										</td>
										<td align="right">
											<p>' . $hist['pay_amount'] . '</p>
										</td>
									</tr>';
                                        }
                                    }
                                }
                                echo $payment_line;

///////////////////////end of payment history //////////////////////////////////////	
                                ?>
                            </table>
                            <p>
                                <input name="back" type="submit" class="transformButtonStyle" onclick="this.form.action = 'invoice.php';" value="No - Back to List">
                                <input name="deleteYes" type="submit" class="transformButtonStyle" value="Mark as Junk">
                            </p>
                            <p><a href="index.php">Back to admin index</a> </p>
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
