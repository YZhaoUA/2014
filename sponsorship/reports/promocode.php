<?php include('../config_include/connect.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Banff/2013 Pipeline Workshop Sponsor Registration</title>
        <link href="../css/asmebanffstyles.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="../jquery/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="js/promo.js"></script>
        <link href="../jquery/colorbox/colorbox.css" rel="stylesheet" type="text/css">
        <link href="../css/regform.css" rel="stylesheet" type="text/css">
        <link href="../css/reports.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="wrapper">
            <?php include('../includes/header.php'); ?>
            <div id="content">
                <div id="regarea">
                    <p><strong><a href="index.php">Back to admin index</a>. </strong></p>
                    <h1>Generate New Promotion Code </h1>
                    <?php
                    include_once('../func_include/randomString.php');
                    if (isset($_POST['company']) && $_POST['company'] != "") {
                        $company = $_POST['company'];
                        $dateCreated = date('Y-m-d');
                        $timeCreated = date('H:i:s');

                        // insert new promo code into table
                        $in = "insert into $tablepromo (company, dateCreated, timeCreated, enabled)
													values
													('$company', '$dateCreated', '$timeCreated', '1')";
                        $res = mysql_query($in) or die("There was an error creating the promotion code.<br />" . mysql_error());

                        // retrieve promo record to create code
                        $sel = "select id from $tablepromo where company='$company' and dateCreated='$dateCreated' and timeCreated='$timeCreated' order by id desc limit 1";
                        $ressel = mysql_query($sel) or die(mysql_error());
                        $r = mysql_fetch_array($ressel);
                        $id = $r['id'];
                        $idpad = sprintf("%04s", $id);
                        $veristring = strtoupper(genRandomString(4));
                        $promoCode = "BN.$veristring.$idpad";

                        $up = "update $tablepromo set promoCode='$promoCode' where id='$id'";
                        $upr = mysql_query($up);

                        echo "<h2 class=\"red\">$company promotion code is: $promoCode (entry is highlighted below)</h2><p class=\"red\"><strong>Do not refresh this page as it will cause duplication of records.</strong></p>";
                    }
                    ?>
                    <form action="" method="post" enctype="multipart/form-data" name="promo" id="registration">
                        <div id="registrantInfo" class="formBlock" style="clear:left; width:100%;margin-top:10px;">
                            <div class="leftCol notRequired" style="width:80%;">
                                <p>Name or Company Name associated with the promotional code</p>
                                <p>
                                    <input name="company" type="text" id="company"  class="noreqfield"/>
                                </p>
                            </div>
                            <div style="clear:left;">
                                <input name="generate" type="submit" class="transformButtonStyle" id="generate" value="Generate Code">
                            </div>
                        </div>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <h1>Existing Promotion Codes&nbsp;&nbsp;&nbsp;&nbsp;
                        </h1>
                        <label style="float:right;">
                            <input name="refresh" type="button" class="transformButtonStyle" id="refresh" onClick="document.promo.company.value = '';
                                    document.promo.submit();" value="Refresh Code List">
                        </label>
                        <p>&nbsp;</p>
                        <?php
                        if (isset($_POST['formaction']) && $_POST['formaction'] == "delete") {
                            $pid = $_POST['pid'];
                            $delete = "delete from $tablepromo where id='$pid'";
                            $delres = mysql_query($delete);

                            echo "<h2 class=\"red\">The promotion code was successfully deleted.</h2>";
                        }
                        if (isset($_POST['formaction']) && ($_POST['formaction'] == 'Enable' || $_POST['formaction'] == "Disable")) {
                            $action = $_POST['formaction'];
                            $promoCode = $_POST['pid'];

                            if ($action == "Enable") {
                                $a = 1;
                            } else {
                                $a = 0;
                            }

                            $update = "update $tablepromo set enabled='$a' where promoCode='$promoCode'";
                            $updateres = mysql_query($update) or die("There was an error updating the promotion status." . mysql_error());

                            echo "<h2 class=\"red\">The promotion code, $promoCode, was successfully " . $action . "d</h2>";
                        }

                        // get all promo records
                        $sel = "select * from $tablepromo order by company, dateCreated, timeCreated";
                        $result = mysql_query($sel) or die("There was an error retrieving the promotion code records.<br>" . mysql_error() . $sel);
                        $num = mysql_num_rows($result);

                        if ($num == 0) {
                            echo "<h2>No promotion codes have been entered</h2>";
                        } else {
                            ?>
                            <input name="pid" type="hidden" id="pid" value="">
                            <input name="formaction" type="hidden" id="formaction" value="">
                            <table width="100%" border="0" cellpadding="0" cellspacing="5"  >
                                <tr>
                                    <td align="center" valign="bottom" class="dottheline"><p><strong>Code ID</strong></p></td>
                                    <td align="center" valign="bottom" class="dottheline"><p><strong>Promotion Code</strong></p></td>
                                    <td align="center" valign="bottom" class="dottheline"><p><strong>Name</strong></p></td>
                                    <td align="center" valign="bottom" class="dottheline"><p><strong>Date Created</strong></p></td>
                                    <td align="center" valign="bottom" class="dottheline"><p><strong>Time Created</strong></p></td>
                                    <td align="center" valign="bottom" class="dottheline"><p><strong>Sponsor Invoice</strong></p></td>
                                    <td align="center" valign="bottom" class="dottheline"><p><strong>Fullfilled</strong></p></td>
                                    <td align="center" valign="bottom" class="dottheline"><p>&nbsp;</p></td>
                                    <td align="center" valign="bottom" class="dottheline">&nbsp;</td>
                                </tr>
                                <?php
                                while ($row = mysql_fetch_array($result)) {
                                    ?>
                                    <tr <?php
                                    if (isset($promoCode) && $promoCode != "" && $promoCode == $row['promoCode']) {
                                        echo "style=\"background-color:#cccccc;\"";
                                    }
                                    ?>>
                                        <td align="center" valign="middle" nowrap class="dottheline"><p><?php echo $row['id']; ?></p></td>
                                        <td align="center" valign="middle" nowrap class="dottheline"><p><?php echo $row['promoCode']; ?></p></td>
                                        <td align="center" valign="middle" nowrap class="dottheline"><p><?php echo $row['company']; ?></p></td>
                                        <td align="center" valign="middle" nowrap class="dottheline"><p><?php echo $row['dateCreated']; ?></p></td>
                                        <td align="center" valign="middle" nowrap class="dottheline"><p><?php echo $row['timeCreated']; ?></p></td>
                                        <td align="center" valign="middle" nowrap class="dottheline"><p><?php
                                                if ($row['invoiceSponsor'] == "") {
                                                    echo "--";
                                                } else {
                                                    echo "<a href=\"showInvoice.php?sid=" . $row['invoiceSponsor'] . "\" target=\"_blank\">BPS-" . $row['invoiceSponsor'] . "</a>";
                                                }
                                                ?></p></td>
                                        <td align="center" valign="middle" nowrap class="dottheline"><p><?php
                                                if ($row['invoice'] == "") {
                                                    echo "--";
                                                } else {
                                                    // Column Fulfilled is corresponding to visitor's invoice, not sponsor's.
                                                    // echo "<a href=\"showVisitorInvoice.php?vid=" . $row['invoice'] . "\" target=\"_blank\">BPV-" . $row['invoice'] . "</a>";
                                                    echo "BPV-" . $row['invoice'];
                                                }
                                                ?></p></td>
                                        <td align="center" valign="middle" class="dottheline"><p>
                                                <?php if ($row['invoice'] == "") { ?>
                                                    <?php if ($row['enabled'] == 1) { ?>
                                                        <input name="toggleButton" type="button" class="transformButtonStyle toggleButton disable" id="de<?php echo $row['promoCode']; ?>" value="Disable" style="font-size:90%;">
                                                    <?php } else { ?>
                                                        <input name="toggleButton" type="button" class="transformButtonStyle toggleButton enable" id="de<?php echo $row['promoCode']; ?>" value="Enable" style="font-size:90%;">
                                                    <?php } ?>
                                                <?php } ?>
                                            </p></td>
                                        <td align="center" valign="middle" class="dottheline">
                                            <?php if ($row['invoice'] == "") { ?>
                                                <p><input name="deletebutton<?php echo $row['id']; ?>" type="button" class="transformButtonStyle delete" id="d<?php echo $row['id']; ?>" value="Delete Code" style="font-size:90%;">
                                                </p>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        <?php } ?>
                    </form>
                </div>
            </div>
            <div id="footer">
                <p>&nbsp;</p>
            </div>
        </div>
    </body>
</html>
