<?php
session_start();
$closeit = date('Y-m-d');

if (!isset($_SESSION['registrationStep'])) {
    header('Location: error.php');
    die();
} else if ($closeit > '2015-05-12') {
    header('Location: closed.php');
    die();
}


include('config_include/connect.php');

if (isset($_POST['sid']) && $_POST['sid'] != "") {
    $sid = $_POST['sid'];

    // check if registration used promo code
//    $update = "update $tablepromo set invoiceSponsor='' where invoiceSponsor='$sid'";
//    $result = mysql_query($update);

    // udate the record and mark the status as cancelled
    $update = "update $tablesponsor set reg_status='JUNK' where sid='$sid'";
    $result = mysql_query($update);

    // remove any payment records associated with promo codes
//    $delete = "delete from $tablePaymentSponsor where sid='$sid' and transaction_type='PROMO'";
//    $result = mysql_query($delete);

    session_unset();
    session_destroy();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Banff/2013 Pipeline Workshop Sponsor Registration</title>
        <link href="css/asmebanffstyles.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="jquery/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="jquery/colorbox/jquery.colorbox-min.js"></script>
        <script type="text/javascript" src="js/regForm.php"></script>
        <link href="jquery/colorbox/colorbox.css" rel="stylesheet" type="text/css">
        <link href="css/regform.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="wrapper">
            <?php include('includes/header.php'); ?>
            <div id="content">
                <h1>The registration has been cancelled.</h1>
                <p>If you still wish to register, you will need to start over.</p>
            </div>
            <div id="footer">
                <p>&nbsp;</p>
            </div>
        </div>
    </body>
</html>
