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
                    <h2>
                        <?php $sid = $_GET['sid']; ?>
                    </h2>
                    <h2>Registration History for Invoice #<?php echo $sid; ?></h2>
                    <table border="0" cellspacing="5" cellpadding="5">
                        <tr>
                            <th bgcolor="#666666">Function Code</th>
                            <th bgcolor="#666666">Charged</th>
                            <th bgcolor="#666666">Day</th>
                            <th bgcolor="#666666">Date Changed</th>
                        </tr>
                        <?php
                        $findreg = "SELECT h.*, v.funccode as regtype FROM $holddetail h, $tablesponsor v WHERE v.sid=h.vid and h.vid=$sid order by id";
                        $regresults = mysql_query($findreg) or die(mysql_error());
                        while ($regcats = mysql_fetch_array($regresults)) {
                            ?>
                            <tr>
                                <td><p><?php echo $regcats['funccode']; ?></p></td>
                                <td><p><?php echo $regcats['charged']; ?></p></td>
                                <td><p><?php echo $regcats['regtype']; ?></p></td>
                                <td><p><?php echo $regcats['date_changed']; ?></p></td>
                            </tr>

                        <?php } ?>
                    </table>
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
