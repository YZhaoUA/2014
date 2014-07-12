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
                    <p><a href="index.php">Back to reports index</a></p>
                    <?php
// -------------------------------------------------
// Written for IPC by Heidi at id associates
// On: A rainy day June 11, 2006
// Why: Report interface
// -------------------------------------------------


                    $selectdate2 = "";
                    ?>
                    <h1>Quick Stats </h1>
                    <p>
                        <?php
                        $query4 = "SELECT vid, reg_status FROM $tablesponsor WHERE (" . $tablesponsor . ".reg_status='' and " . $tablesponsor . ".paytype!='')" . $selectdate2;
                        $result4 = mysql_query($query4) or die(mysql_error());
                        $goodrecords = mysql_num_rows($result4);

                        $query5 = "SELECT vid, reg_status FROM $tablesponsor WHERE (" . $tablesponsor . ".reg_status!='')" . $selectdate2;
                        $result5 = mysql_query($query5) or die(mysql_error());
                        $badrecords = mysql_num_rows($result5);

                        $query6 = "SELECT vid, reg_status, paytype FROM $tablesponsor WHERE (" . $tablesponsor . ".paytype='' and " . $tablesponsor . ".reg_status='')" . $selectdate2;
                        $result6 = mysql_query($query6) or die(mysql_error());
                        $pending = mysql_num_rows($result6);
                        ?>
                    </p>
                    <p>&nbsp; </p>
                    <table width="100%" border="0" cellpadding="10" cellspacing="1">
                        <tr align="left" valign="top">
                            <td colspan="6" align="left"><p><strong>Number of registrants:</strong>&nbsp;<?php echo $goodrecords; ?></p>
                                <p><strong>Pending registrants:</strong> <?php echo $pending; ?><br>
                                    (registrations that were not submitted with a payment type - also means they will not have received an invoice)</p>
                                <p><strong>Number of  registrants cancelled or marked as junk</strong>:&nbsp;<?php echo $badrecords . $badrecordstutonly; ?> <br>
                                </p></td>
                        </tr>
                        <tr>
                            <td align="center" valign="middle" bgcolor="#91ABBA"><p><b>Session Code:</b></p></td>
                            <td align="center" valign="middle" bgcolor="#91ABBA"><p><strong>Session Description</strong></p></td>
                            <td align="center" valign="middle" bgcolor="#91ABBA"><p><strong>Session Cap</strong></p></td>
                            <td align="center" valign="middle" bgcolor="#91ABBA"><p>Good Records<br>
                                    <strong>Total Count </strong><br>
                                </p></td>
                            <td align="center" valign="middle" bgcolor="#91ABBA"><p>Pending Records<br>
                                    <strong>Total Count </strong><br>
                                </p></td>
                            <td align="center" valign="middle" bgcolor="#91ABBA"><p>Records Marked <br>
                                    as Junk or Cancelled</p></td>
                        </tr>
                        <?php
//		// grab all our sessions
//		$sel = "select * from $conference";
//		echo $sel;
//		$res = mysql_query($sel) or die(mysql_error());
//		while ($row = mysql_fetch_array($res)){

                        $query = "select * from $conference order by date, startTime, funccode";
//						//$query = "SELECT funccode, COUNT(funccode) FROM $tabledetailname where funccode like 'TU%' GROUP BY funccode"; 
//							//echo $query;			 
                        $result = mysql_query($query) or die(mysql_error());
//						$n = mysql_num_rows($result);
////						
                        while ($row = mysql_fetch_array($result)) {
                            //echo "<p>".$row['funccode']."cap: ".$row['cap']." sold: ".$row['funccode'].": ".$row['count(d.funccode)']."</p>";
                            //}
                            ?>
                            <tr align="left" valign="top">
                                <td align="center" valign="top" bgcolor="#D9E7F4"><p><strong><?php echo $row['funccode']; ?></strong> </p></td>
                                <td align="left" valign="top" bgcolor="#D9E7F4"><p><?php echo $row['funcdescr']; ?></p></td>
                                <td align="center" valign="middle" bgcolor="#D9E7F4"><?php echo $row['cap']; ?></td>
                                <td align="center" valign="middle" bgcolor="#D9E7F4"><strong><?php
                                        $pend = "select d.funccode from $tabledetailname d, $tablesponsor n where d.funcid='" . $row['id'] . "' and d.vid=n.vid AND n.reg_status='' and n.paytype!=''";
                                        $pendr = mysql_query($pend) or die(mysql_error());
                                        $pendN = mysql_num_rows($pendr);
                                        echo $pendN;
                                        ?></strong></td>
                                <td align="center" valign="middle" bgcolor="#D9E7F4"><?php
                                    $pend = "select d.funccode from $tabledetailname d, $tablesponsor n where d.funcid='" . $row['id'] . "' and d.vid=n.vid AND n.reg_status='' and n.paytype=''";
                                    $pendr = mysql_query($pend) or die(mysql_error());
                                    $pendN = mysql_num_rows($pendr);
                                    echo $pendN;
                                    ?></td>
                                <td align="center" valign="middle" bgcolor="#D9E7F4"><?php
                                    $pend = "select d.funccode from $tabledetailname d, $tablesponsor n where d.funcid='" . $row['id'] . "' and d.vid=n.vid AND n.reg_status!=''";
                                    $pendr = mysql_query($pend) or die(mysql_error());
                                    $pendN = mysql_num_rows($pendr);
                                    echo $pendN;
                                    ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                    <p>&nbsp;</p>
                    <p>
                        <?php
                        mysql_close($link);
                        ?>
                    </p>
                </div>
            </div>
            <div id="footer">
                <p>&nbsp;</p>
            </div>
        </div>
    </body>
</html>
