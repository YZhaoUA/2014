<?php include('../config_include/connect.php'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Banff/2013 Pipeline Workshop Sponsor Registration</title>
        <link href="../css/asmebanffstyles.css" rel="stylesheet" type="text/css">
        <link href="../css/reports.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="../jquery/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="../jquery/colorbox/jquery.colorbox-min.js"></script>
        <script type="text/javascript" src="../js/regForm.php"></script>
        <link href="../jquery/colorbox/colorbox.css" rel="stylesheet" type="text/css">
        <link href="../css/regform.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="wrapper">
            <?php include('../includes/header.php'); ?>
            <div id="content">
                <div id="regarea">
                    <h1>Invoice List</h1>
                    <?php
                    $alphabet = $_GET['alphabet'];
                    $select = "SELECT * FROM $tablesponsor WHERE LEFT(lname,1) = '$alphabet' ORDER BY lname, fname, sid";
                    $result = mysql_query($select);
                    ?>
                    <table width='100%' cellpadding="0" cellspacing="5">
                        <tr>
                            <td width="11%" nowrap class="fullreg">
                                <p><b>Invoice #</b></p></td>
                            <td width="51%" class="fullreg">
                                <p><b> Name  </b></p></td>
                            <td width="8%" nowrap class="fullreg"><p><strong>Last Paytype</strong></p></td>
                            <td width="17%" align="center" nowrap class="fullreg">
                                <p><b>Find  Invoice</b></p></td>
                            <td width="13%" nowrap class="fullreg"><p><strong>Status</strong></p></td>
                        </tr>
                        <?php
                        $resultsnumber = mysql_num_rows($result);
                        $alternate = "2";
                        $row = array();
                        while ($row = mysql_fetch_array($result)) {
                            $sid = $row['sid'];
                            $fname = $row['fname'];
                            $lname = $row['lname'];
                            $regstatus = $row['reg_status'];

                            if ($alternate == "1") {
                                $color = "#ffffff";
                                $alternate = "2";
                            } else {
                                $color = "#efefef";
                                $alternate = "1";
                            }
                            ?>
                            <tr <?php
                            if ($regstatus == "JUNK") {
                                echo "bgcolor=\"#CCCCCC\"";
                            }
                            ?>>
                                <td >
                                    <?php echo 'BPS-' . $row['sid']; ?></td>
                                <td>
                                    <?php echo strtoupper($row['lname']) . ', ' . strtoupper($row['fname']); ?></td>
                                <td align="center"><?php echo $row['paytype']; ?></td>
                                <td align="center">
                                    <a href="showInvoice.php?sid=<?php echo $row['sid']; ?>"><strong>This One</strong></a></td>
                                <td nowrap><?php
                                    if ($regstatus) {
                                        echo $regstatus;
                                    }
                                    ?></td>
                            </tr>
                            <?php
                        }
                        if ($resultsnumber == "0") {
                            ?>
                            <h3 align=center>Sorry - no entries under this letter</h3>
                            <br>
                            <br>
                            <?php
                        }
                        $alpha = "invoice.php?alphabet";
                        ?>
                    </table>
                    </center>
                    <BR>
                    <BR>
                    <h1 align=center>Select the alphabet to find their Last Name. </h1>
                    <?php
                    $alpha = "invoiceList.php?alphabet";
                    ?>
                    <h2 align=center><a href='<?php echo $alpha; ?>=a'>A</a> | <a href='<?php echo $alpha; ?>=b'>B</a> | <a href='<?php echo $alpha; ?>=c'>C</a> | <a href='<?php echo $alpha; ?>=d'>D</a> | <a href='<?php echo $alpha; ?>=e'>E</a> | <a href='<?php echo $alpha; ?>=f'>F</a> | <a href='<?php echo $alpha; ?>=g'>G</a> | <a href='<?php echo $alpha; ?>=h'>H</a> | <a href='<?php echo $alpha; ?>=i'>I</a> | <a href='<?php echo $alpha; ?>=j'>J</a> | <a href='<?php echo $alpha; ?>=k'>K</a> | <a href='<?php echo $alpha; ?>=l'>L</a> | <a href='<?php echo $alpha; ?>=m'>M</a> | <br>
                        <a href='<?php echo $alpha; ?>=n'>N</a> | <a href='<?php echo $alpha; ?>=o'>O</a> | <a href='<?php echo $alpha; ?>=p'>P</a> | <a href='<?php echo $alpha; ?>=q'>Q</a> | <a href='<?php echo $alpha; ?>=r'>R</a> | <a href='<?php echo $alpha; ?>=s'>S</a> | <a href='<?php echo $alpha; ?>=t'>T</a> | <a href='<?php echo $alpha; ?>=u'>U</a> | <a href='<?php echo $alpha; ?>=v'>V</a> | <a href='<?php echo $alpha; ?>=w'>W</a> | <a href='<?php echo $alpha; ?>=x'>X</a> | <a href='<?php echo $alpha; ?>=y'>Y</a> | <a href='<?php echo $alpha; ?>=z'>Z</a> |</h2>
                    <h2 align=center>This list is sorted by Last Name.</h2>
                    <p align=center><a href="index.php">Back to admin index</a> </p>
                    <?php
                    mysql_close($link);
                    ?>
                </div>
            </div>
            <div id="footer">
                <p>&nbsp;</p>
            </div>
        </div>
    </body>
</html>
