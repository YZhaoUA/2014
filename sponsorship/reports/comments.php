<?php include('../config_include/connect.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Banff/2013 Pipeline Workshop Sponsor Registration</title>
        <link href="../css/asmebanffstyles.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="../jquery/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="js/comment.js"></script>
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
                    <form action="" method="post" enctype="multipart/form-data" name="promo" id="registration">
                        <h1>Comments&nbsp;&nbsp;&nbsp;&nbsp;
                        </h1>
                        <label style="float:right;">
                            <input name="refresh" type="button" class="transformButtonStyle" id="refresh" onClick="document.promo.submit();" value="Refresh Comment List">
                        </label>
                        <p>&nbsp;</p>
                        <?php
                        if (isset($_POST['formaction']) && $_POST['formaction'] == "delete") {
                            $pid = $_POST['pid'];
                            $delete = "delete from $tablecomments where id='$pid'";
                            $delres = mysql_query($delete);
                            //echo $delete;

                            echo "<h2 class=\"red\">The comment was successfully deleted.</h2>";
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
                        $sel = "select c.id, c.invoice, c.workgroup, c.comments, v.fname, v.lname, w.title from $tablecomments c, $tablesponsor v, $tablegroups w where c.workgroup=w.workgroup and  v.vid=c.invoice order by workgroup";
                        $result = mysql_query($sel) or die("There was an error retrieving the promotion code records.<br>" . mysql_error() . $sel);
                        $num = mysql_num_rows($result);

                        if ($num == 0) {
                            echo "<h2>No comments have been entered</h2>";
                        } else {
                            ?>
                            <input name="pid" type="hidden" id="pid" value="">
                            <input name="formaction" type="hidden" id="formaction" value="">
                            <table width="100%" border="0" cellpadding="0" cellspacing="5"  >
                                <tr>
                                    <td width="30%" align="left" valign="top" class="dottheline"><p><strong>Working Group</strong></p></td>
                                    <td width="30%" align="left" valign="top" class="dottheline"><p><strong>Comment</strong></p></td>
                                    <td align="center" valign="top" class="dottheline"><p><strong>Registrant</strong><strong></strong></p>												</td>
                                    <td align="center" valign="top" class="dottheline">&nbsp;</td>
                                </tr>
                                <?php
                                while ($row = mysql_fetch_array($result)) {
                                    ?>
                                    <tr <?php
                                    if (isset($promoCode) && $promoCode != "" && $promoCode == $row['promoCode']) {
                                        echo "style=\"background-color:#cccccc;\"";
                                    }
                                    ?>>
                                        <td align="left" valign="top" class="dottheline"><p><?php echo $row['workgroup'] . ": " . $row['title']; ?></p></td>
                                        <td align="left" valign="top" class="dottheline"><p><?php echo $row['comments']; ?></p></td>
                                        <td align="left" valign="top" class="dottheline"><p>
                                                <?php
                                                if ($row['invoice'] == "") {
                                                    echo "--";
                                                } else {
                                                    echo "<a href=\"showInvoice.php?vid=" . $row['invoice'] . "\" target=\"_blank\">BPS-" . $row['invoice'] . "</a>";
                                                }
                                                ?>
                                                <br>
                                                <?php echo $row['fname'] . " " . $row['lname']; ?></p>												<p>&nbsp;</p></td>
                                        <td align="center" valign="top" class="dottheline">
                                            <p><input name="deletebutton<?php echo $row['id']; ?>" type="button" class="transformButtonStyle delete" id="d<?php echo $row['id']; ?>" value="Delete" style="font-size:90%;">
                                            </p>										</td>
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
