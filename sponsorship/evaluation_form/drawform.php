<?php include('../config_include/connect.php'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Banff/2013 Pipeline Workshop Sponsor Registration</title>
        <link href="../css/asmebanffstyles.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="../jquery/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="../jquery/colorbox/jquery.colorbox-min.js"></script>
        <script type="text/javascript" src="js/draw.js"></script>
        <link href="../jquery/colorbox/colorbox.css" rel="stylesheet" type="text/css">
        <link href="../css/regform.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="wrapper">
            <?php include('includes/header.php'); ?>
            <div id="content">
                <form name="registration" id="registration" method="post" action="">
                    <input name="drawtype" type="hidden" id="drawtype">
                    <input name="attendeeids" type="hidden" id="attendeeids">
                    <input name="exhibitorids" type="hidden" id="exhibitorids">
                    <h1>Banff/2015 Pipeline Workshop</h1>
                    <h2><a href="../evaluation_form.php"></a>Draw random names</h2>
                    <h3>To draw a name click the button to draw a name from the evaluation pool you wish to select from.</h3>
                    <h3>The scripts will pick a name and display it below. To draw additional names simply press the button again. The additional names will be added to the winner list.</h3>

                    <p>
                        <input name="attendee" type="button" class="transformButtonStyle draw" id="attendee" value="Draw Attendee Name">
                        <input name="exhibitor" type="button" class="transformButtonStyle draw" id="exhibitor" value="Draw Exhibitor Name">
                    </p>
                    <div id="processResponse"> </div>
                    <div id="processingHolder" style="display: none; float:left;">
                        <h3>Please wait . . . <br>
                            <img src="../images/ajax-loader.gif" title="Loader" alt="Loader" /></h3>
                    </div>
                    <div id="result">
                    </div>
                </form>
            </div>
            <div id="footer">
                <p>&nbsp;</p>
            </div>
        </div>
    </body>
</html>
