<?php include('../config_include/connect.php'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Banff/2013 Pipeline Workshop Registration</title>
<link rel="stylesheet" title="Disabled for Preview-in-Browser: ../css/asmebanffstyles.css" type="text/css">
<style type="text/css">

/* CSS Document */

body {
    background-position: center bottom;
    margin-right: auto;
    margin-left: auto;
    background-repeat: no-repeat;
    margin-top: 0px;
    margin-bottom: 0px;
    font-size: 14px;
    font-family: Arial, Helvetica, sans-serif;
    background-attachment: fixed;
    color: #333333;
    min-height:400px;
}
#wrapper {
    margin: 0px;
    padding: 0px;
    background-attachment: scroll;
    background-repeat: no-repeat;
    background-position: center top;
    border-top-width: 1px;
    border-top-style: solid;
    background-image: url(../images/headerimage.jpg);
    text-align: center;
}
#floater {
    float: right;
    width: 229px;
    padding: 3px;
    text-align: center;
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    border-radius: 10px;
    background-image: url(../images/transparentwhite.png);
    margin-top: 65px;
    margin-right: -40px;
}
#floater .reservations {
    font-size: 100%;
    font-weight: bold;
    color: #666666;
    text-align: center;
    margin: 10px 0px 0px 0px;
}
#floater .reservations a {
    color: #333333;
}
#floater p {
    font-size: 75%;
    width: 100%;
    margin: 10px 0px 0px 0px;
    text-align: center;
}
#floater img {
    margin-top: 10px;
}
#floater    a   {
    color: #333333;
    text-decoration:underline;
    font-weight: bold;
}
#floater  a:hover, #floater a:visited  {
    color: #999999;
    text-decoration:underline;
    font-weight: bold;
}
#header {
    margin-top: 0px;
    margin-bottom: 0px;
    height: 159px;
    width: 850px;
    margin-right: auto;
    margin-left: auto;
    display: block;
    padding: 1px 0px;
    text-align: left;
}
#header h1 {
    margin: 60px 0px 0px 160px;
    padding: 0px;
    font-size: 200%;
}
#header h2 {
    margin: 0px 0px 0px 200px;
    font-size: 175%;
}
#header h3 {
    font-size: 180%;
    margin: 0px 0px 0px 220px;
}
#content {
    font-size: 100%;
    width: 700px;
    text-align: left;
    margin: 0px auto;
    padding-left: 100px;
    padding-top: 10px;
}
#content label {
    margin-right: 10px;
}
#content h1 {
    font-size: 130%;
    margin: 10px 0px;
}
#content h3 {
    margin: 5px 0px 20px 0px;
}
#content h4 {
    margin: 5px 0px 5px 0px;
}
#content p {
    margin: 0px 0px 10px 0px;
}
#content ol {
    margin-top: 0px;
    margin-bottom: 10px;
}
.scheduleLink  {
    font-weight: bold;
    color: #000000;
    text-decoration: underline;
    cursor: pointer;
}
#schedule {
    text-align: left;
    margin: 0px auto;
    width: 100%;
}
#schedule h3 {
    margin-top: 3px;
    margin-right: 10px;
    margin-bottom: 3px;
    margin-left: 0px;
    text-align: left;
    float: left;
}
#schedule p {
    text-align: left;
    margin: 3px 0px;
    clear: left;
}
#schedule table {
    background-color: #ffffff;
    margin: 10px 0px 0px 0px;
    width: 100%;
    /*border: 1px solid #ffffff;*/
    border-spacing: 1px;
    font-size: 80%;
}
#schedule th {
    color: #FFFFFF;
    background-color: #666666;
    padding: 5px 2px 5px 10px;
    text-align: left;
    /*border: 1px solid #E7E7E7;*/
}
#schedule td {
    text-align: left;
    border: 1px solid #E7E7E7;
    margin: 0px;
    padding: 0px;
    background-color:#E1E1E1;
}
#schedule .times {
    background-color: #999999;
    color: #fff;
    text-align: center;
    margin:5px;
}
#schedule .alignCentre {
    text-align: center;
}
#schedule .scheduleItem, #schedule .scheduleItemNonSelect {
    font-weight: bold;
    background-color: #FFFFFF;
    padding: 5px;
    vertical-align:top;
}
#schedule .scheduleItem p {
    padding: 0px;
    margin:0px;
}
#schedule .scheduleItem:hover {
    background-color:#F2F2F2;
    color:#333333;
}
#schedule .selected, #schedule .selected:hover {
    background-color: #8E9990;
    color:#ffffff;
}
#schedule label {
    cursor:pointer;
    display: block;
    margin: 0px 15px;
    text-align:left;
}
#schedule input {
    float:left;
    margin: 0px 0px 0px -15px;
}
#schedule .workgroup {
    cursor:pointer;
    display: block;
    margin: auto 18px;
    text-align:left;
}
label, input {
    cursor:pointer;
}
.dottheline {
    border-bottom-width: 1px;
    border-bottom-style: dotted;
    border-bottom-color: #999999;
}

#schedule .number {
    float: left;
    margin: 0px 0px 0px -20px;
}
#displayCost {
    font-weight: bold;
    font-size: 120%;
    float: right;
    margin: 0px 50px 10px 10px;
    width: auto;
    background-color: white;
    padding: 5px 10px;
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    border-radius: 10px;
}
#displayCost   p {
    clear: right;
}
#displayCost  .priceDisp {
    float: right;
}
#footer {
    height: 300px;
    display: block;
    clear: both;
}
#comments {
    clear: both;
    margin-top: 10px;
}
#comments .commentField {
    background-color: #FFFFFF;
    padding: 10px;
}
#conditions {
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    border-radius: 10px;
    background-color: #666666;
    color:#FFFFFF;
    padding: 10px 20px;
    clear: left;
    margin: 20px 0px 10px 0px;
}
#conditions a:link {
    color:#FFFFFF;
}
.red {
    color:#990000;
}
.makeitsmall {
    font-size: 80%;
    margin: 10px 0px;
    list-style-type: none;
}
#totaling h3, #totaling p {
    margin:3px 0px;
}
.floatLeft {
	float:left;	
}
.floatRight {
	float:right;	
}
.clearLeft {
	clear:left;
}
.clearRight {
	clear:right;	
}
.clearBoth {
	clear:both;	
}
.halfCol {
	width: 45%;
}


</style>
<script type="text/javascript" src="../jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../jquery/colorbox/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="../js/regForm.php"></script>
<script type="text/javascript">
function CentreWindow(newpage, newname, cw, ch, scroll) {
var centl = (screen.width - cw) / 2;
var centt = (screen.height - ch) / 2;
centprops = 'height='+ch+',width='+cw+',top='+centt+',left='+centl+',scrollbars=yes,resizable'
centwin = window.open(newpage, newname, centprops)
if (parseInt(navigator.appVersion) >= 4) { centwin.window.focus(); }
}
</script>
<link rel="stylesheet" title="Disabled for Preview-in-Browser: ../jquery/colorbox/colorbox.css" type="text/css">
<style type="text/css">

/*
    ColorBox Core Style:
    The following CSS is consistent between example themes and should not be altered.
*/
#colorbox, #cboxOverlay, #cboxWrapper{position:absolute; top:0; left:0; z-index:9999; overflow:hidden;}
#cboxOverlay{
    position:fixed;
    width:100%;
    height:100%;
}
#cboxMiddleLeft, #cboxBottomLeft{clear:left;}
#cboxContent{position:relative;}
#cboxLoadedContent{overflow:auto;}
#cboxTitle{margin:0;}
#cboxLoadingOverlay, #cboxLoadingGraphic{position:absolute; top:0; left:0; width:100%;}
#cboxPrevious, #cboxNext, #cboxClose, #cboxSlideshow{cursor:pointer;}
.cboxPhoto{float:left; margin:auto; border:0; display:block;}
.cboxIframe{width:100%; height:100%; display:block; border:0;}

/* 
    User Style:
    Change the following styles to modify the appearance of ColorBox.  They are
    ordered & tabbed in a way that represents the nesting of the generated HTML.
*/
#cboxOverlay{background:#999999}
#colorbox{}
#cboxTopLeft{width:25px; height:25px; background:url(../jquery/colorbox/images/border1.png) no-repeat 0 0;}
#cboxTopCenter{height:25px; background:url(../jquery/colorbox/images/border1.png) repeat-x 0 -50px;}
#cboxTopRight{width:25px; height:25px; background:url(../jquery/colorbox/images/border1.png) no-repeat -25px 0;}
#cboxBottomLeft{width:25px; height:25px; background:url(../jquery/colorbox/images/border1.png) no-repeat 0 -25px;}
#cboxBottomCenter{height:25px; background:url(../jquery/colorbox/images/border1.png) repeat-x 0 -75px;}
#cboxBottomRight{width:25px; height:25px; background:url(../jquery/colorbox/images/border1.png) no-repeat -25px -25px;}
#cboxMiddleLeft{width:25px; background:url(../jquery/colorbox/images/border2.png) repeat-y 0 0;}
#cboxMiddleRight{width:25px; background:url(../jquery/colorbox/images/border2.png) repeat-y -25px 0;}
#cboxContent{background:#ffffff; overflow:hidden;}
#cboxError{padding:50px; border:1px solid #666666;}
#cboxLoadedContent{margin-top:30px;}
#cboxTitle{position:absolute; top:0px; left:0; text-align:left; width:100%; color:#ffffff; font-weight: bold; padding: 3px; background-color: #666666; font-size:130%;}
#cboxCurrent{position:absolute; bottom:0px; left:100px; border: 3px solid #ffffff;}
#cboxSlideshow{position:absolute; bottom:0px; right:42px; color:#666666;}
#cboxPrevious{position:absolute; bottom:0px; left:0; color:#666666;}
#cboxNext{position:absolute; bottom:0px; left:63px; color:#666666;}
#cboxLoadingOverlay{background:#ffffff url(../jquery/colorbox/images/loading.gif) no-repeat 5px 5px;}
#cboxClose{ position:absolute; top:0; right:0; display:block; color:#666666;background-color: #ffffff; font-size:100%; border: 1px solid #999999; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; padding: 2px 4px 2px 4px; margin: 3px 4px 0px 0px; }
#cboxClose:hover{color:#ffffff; background: #666666; }

/*
  The following fixes a problem where IE7 and IE8 replace a PNG's alpha transparency with a black fill
  when an alpha filter (opacity change) is set on the element or ancestor element.  This style is not applied to IE9.
*/
.cboxIE #cboxTopLeft,
.cboxIE #cboxTopCenter,
.cboxIE #cboxTopRight,
.cboxIE #cboxBottomLeft,
.cboxIE #cboxBottomCenter,
.cboxIE #cboxBottomRight,
.cboxIE #cboxMiddleLeft,
.cboxIE #cboxMiddleRight {
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#00FFFFFF,endColorstr=#00FFFFFF);
}

/*
  The following provides PNG transparency support for IE6
*/
.cboxIE6 #cboxTopLeft{background:url(../jquery/colorbox/images/ie6/borderTopLeft.png);}
.cboxIE6 #cboxTopCenter{background:url(../jquery/colorbox/images/ie6/borderTopCenter.png);}
.cboxIE6 #cboxTopRight{background:url(../jquery/colorbox/images/ie6/borderTopRight.png);}
.cboxIE6 #cboxBottomLeft{background:url(../jquery/colorbox/images/ie6/borderBottomLeft.png);}
.cboxIE6 #cboxBottomCenter{background:url(../jquery/colorbox/images/ie6/borderBottomCenter.png);}
.cboxIE6 #cboxBottomRight{background:url(../jquery/colorbox/images/ie6/borderBottomRight.png);}
.cboxIE6 #cboxMiddleLeft{background:url(../jquery/colorbox/images/ie6/borderMiddleLeft.png);}
.cboxIE6 #cboxMiddleRight{background:url(../jquery/colorbox/images/ie6/borderMiddleRight.png);}

.cboxIE6 #cboxTopLeft,
.cboxIE6 #cboxTopCenter,
.cboxIE6 #cboxTopRight,
.cboxIE6 #cboxBottomLeft,
.cboxIE6 #cboxBottomCenter,
.cboxIE6 #cboxBottomRight,
.cboxIE6 #cboxMiddleLeft,
.cboxIE6 #cboxMiddleRight {
    _behavior: expression(this.src = this.src ? this.src : this.currentStyle.backgroundImage.split('"')[1], this.style.background = "none", this.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src=" + this.src + ", sizingMethod='scale')");
}


</style>
<link rel="stylesheet" title="Disabled for Preview-in-Browser: ../css/regform.css" type="text/css">
<style type="text/css">

#registration {
    clear: left;
}
#registration .formBlock h3 {
    margin:5px 0px 5px 0px;
}
#registration input[type=text], #registration select, #registration .whiteField {
    color: #000000;
    width: 95%;
    font-weight: bold;
    font-size: 110%;
    border: 1px solid #999999;
}
#registration .formBlock .leftCol {
    float: left;
    width: auto;
    margin: 0px 15px 10px 0px;
    -moz-border-radius: 8px;
    -webkit-border-radius: 8px;
    border-radius: 8px;
    background-color: #CCCCCC;
}
#registration .formBlock .leftCol p {
    font-size: 80%;
    /*white-space: normal;*/
    margin: 0;
    font-weight: bold;
}
#registration .formBlock .required {
    padding: 3px 8px;
    background-color: #999999;
}
#registration .formBlock .summaries {
    padding: 15px 15px 20px 15px;
    font-size: 120%;
}
#registration .formBlock .summaries p {
    margin: 10px 0px 10px 0px;
}
#registration .formBlock .required input[type=text], #registration .formBlock .required select, #registration .formBlock .requiredMarker {
    color: #333333;
}
#registration .formBlock .notRequired {
    padding: 3px 8px;
    background:#CCCCCC;
    -moz-border-radius: 8px;
    -webkit-border-radius: 8px;
    border-radius: 8px;
}
#registration .formBlock .notRequired input[type=text], #registration .formBlock .notRequired select {
    color: #333333;
    background-color: #ffffff;
    border:1px solid #CCCCCC;
}
#billing {
    background:#CCCCCC;
    -moz-border-radius: 15px;
    -webkit-border-radius: 15px;
    border-radius: 15px;
}
#billing  h4 {
    padding: 10px;
    font-weight: normal;
    font-size: 110%;
}

#billingInfo {
    padding: 0px 0px 0px 10px;
    width: 100%;
}
.errorfield, .processError {
    background:red;
    padding:5px 10px;
    width: auto;
    color: #ffffff;
    display: none;
    -moz-border-radius: 15px;
    -webkit-border-radius: 15px;
    border-radius: 15px;
    margin-left:10px;
}
#processResponse{
    margin: 5px 0px;
}
.processError {
    display: block;
    width: 90%;
    margin-bottom: 10px;
}
.processError h1, .processError h2, .processError h3, .processError p {
    margin: 0px;
}
.full {
    color: #999999;
    font-style:italic;
}
.transformButtonStyle {
    /* restyle buttons */
    font-size: 115%;
    border: none;
    background-color: #333333;
    font-weight: bold;
    color: #ffffff;
    width: auto;
    text-decoration: none;
    -moz-border-radius: 15px;
    -webkit-border-radius: 15px;
    border-radius: 15px;
    margin-top: 3px;
    margin-right: 20px;
    margin-bottom: 3px;
    margin-left: 0px;
    padding-top: 3px;
    padding-right: 8px;
    padding-bottom: 3px;
    padding-left: 8px;
    /*white-space: nowrap;*/
    display: inline-block;
}
.transformButtonStyle:hover {
    border: none;
    background-color: black;
    color: #ffffff;
    cursor: pointer;
}
.sponCategory {
    clear:left;
}


</style>
<link rel="stylesheet" title="Disabled for Preview-in-Browser: ../css/reports.css" type="text/css">
<style type="text/css">

/* CSS Document */

#regarea {
    text-align: left;
    margin-top: 0px;
    margin-bottom: 0px;
    padding: 0px 35px 50px 34px;
    min-height: 500px;
}
#regarea h1 {
    font-size: 18px;
    margin-top: 0px;
    margin-bottom: 0px;
    color: #FFFFFF;
    background: #666666;
    padding: 3px 3px 3px 10px;
}
#regarea h2 {
    font-size: 14px;
    color: #003366;
    margin-top: 15px;
    margin-bottom: 5px;
    padding: 5px;
}
#regarea h3 {
    font-size: 14px;
    color: #333333;
    margin-top: 0px;
    margin-bottom: 0px;
}

#regarea td {
    padding: 0px;
}
#regarea p {
    font: 13px Arial, Helvetica, Verdana, sans-serif;
    margin-top: 5px;
    margin-bottom: 5px;
    padding-right: 0px;
    padding-left: 5px;
}
#regarea #login {
    background: #E5D7D3;
    margin-top: 0px;
    margin-bottom: 0px;
    padding: 10px;
    width: 300px;
}
#regarea #login p {
    font-size: 11px;
}
#regarea #login h1 {
    font-size: 12px;
    margin: 0px;
    padding: 0px;
    background: #E5D7D3;
    color: #000000;
}
#regarea #login .red {
    font-weight: bold;
    color: #CC0000;
}
#regarea .red {
    font-weight: bold;
    color: #CC0000;
}
#regarea .reportdisp {
    font-size: 10px;
    padding: 2px;
    border: 1px solid #000000;
    margin-right: 2px;
    margin-left: 2px;
    margin-top: 2px;
    margin-bottom: 2px;
    display: table-cell;
    line-height: 12px;
    background-color: #E3E3E3;
}
#regarea th {
    color: #FFFFFF;
}
#regarea .tableOutline {
    border: 2px solid #666666;
}
.enable {
    color: #FFFFFF;
    background-color: #336600;
}
.disable {
    color: #FFFFFF;
    background-color: #990000;
}


</style>
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
// On: On Summer Solstice!! 2006
// Why: Report amounts
// -------------------------------------------------


	$begindate = $_POST['begindate'];
	$showresults = $_POST['showresults'];
	$ordering = $_POST['ordering'];

	if(!isset($_POST['showresults'])){
		$showresults = "all";
	}
	
	if($showresults == "tutorialonly"){
		$tutonly = " and sponcode='' ";
	}

	if(!isset($_POST['orderit'])){
		$orderby = "sid";
	} else {
		$orderby = $_POST['orderit'];
	}
	$ordering = $_POST['ordering'];
	if(!isset($_POST['ordering'])){
		$ordering = "asc";
		$orderascdesc = " asc ";
	} else {
		$orderascdesc = " ".$_POST['ordering']." ";
	}

	$strNum = strlen($begindate);
	if($begindate!=""){
		$selectdate = " AND ".$tablePaymentSponsor.".date_paid >= '2010-".$begindate."-01' AND ".$tablePaymentSponsor.".date_paid <= '2010-".$begindate."-31' ";
		$selectdate2 = " AND invoicedate >= '2010-".$begindate."-01' AND invoicedate <= '2010-".$begindate."-31' ";
	}
	//echo "showresult: ".$showresults."<br>tutonly: ".$tutonly."   <br>orderby: ".$orderby."   <br>ordering: ".$ordering."   <br>orderasdesc: ".$orderascdesc."  <br>begindate: ".$begindate;
?>
<form method='post' action='' name='report' ENCTYPE='multipart/form-data' >
<h1>Quick Stats </h1>
<?php //////////////////////// grand totals all months ///////////////////////////////////

	$totalreg = "SELECT * FROM $tablesponsor WHERE reg_status='' and paytype!=''  ".$tutonly."  ORDER BY '".$orderby."'";
	$totalregResult = mysql_query($totalreg) or die(mysql_error());
	$totalregNum = mysql_num_rows($totalregResult);

	$totalpend = "SELECT * FROM $tablesponsor WHERE reg_status='' and paytype=''  ".$tutonly."  ORDER BY '".$orderby."'";
	$totalpendResult = mysql_query($totalpend) or die(mysql_error());
	$totalpendNum = mysql_num_rows($totalpendResult);

	$totalcancelled = "SELECT * FROM $tablesponsor WHERE reg_status='CANCELLED'  ".$tutonly."  ORDER BY '".$orderby."'";
	$totalcancelledResult = mysql_query($totalcancelled) or die(mysql_error());
	$totalcancelledNum = mysql_num_rows($totalcancelledResult);

	$totaljunk = "SELECT * FROM $tablesponsor WHERE reg_status='JUNK'  ".$tutonly."  ORDER BY '".$orderby."'";
	$totaljunkResult = mysql_query($totaljunk) or die(mysql_error());
	$totaljunkNum = mysql_num_rows($totaljunkResult);
	
	$dbTotal = $totalregNum + $totalpendNum + $totalcancelledNum + $totaljunkNum;
	
	//echo $dbTotal;


						$grandeTot = "SELECT ".$tablePaymentSponsor.".*, ".$tablesponsor.".*, COUNT(transaction_type), SUM(pay_amount) FROM ".$tablePaymentSponsor.", ".$tablesponsor." WHERE ".$tablePaymentSponsor.".sid=".$tablesponsor.".sid AND ".$tablesponsor.".reg_status!='JUNK' AND ".$tablesponsor.".reg_status!='CANCELLED' ".$tutonly."  GROUP BY transaction_type ORDER BY transaction_type"; 
										 
						$grandTotResult = mysql_query($grandeTot) or die(mysql_error());
						// Print out result
						while($gtrow = mysql_fetch_array($grandTotResult)){
										${$gtrow['transaction_type']} = $gtrow['COUNT(transaction_type)'];
										${$gtrow['transaction_type']."TOTAL"} = $gtrow['SUM(pay_amount)'];
										
										$activeGTsums = floatval(${$gtrow['transaction_type']."TOTAL"});
										$activeGTTotal = $activeGTTotal + $activeGTsums;
										
										$activeGTSummaries .= '
	<tr>
		<td bgcolor="#D6E8CE"><p>'.$gtrow['transaction_type'].'</p></td>
		<td align="center" bgcolor="#D6E8CE"><p>'.${$gtrow['transaction_type']}.'</p></td>
		<td align="right" bgcolor="#D6E8CE"><p>'.sprintf("%01.2f",${$gtrow['transaction_type']."TOTAL"}).'</p></td>
	</tr>';
						}				

						$grandeTot2 = "SELECT ".$tablePaymentSponsor.".*, ".$tablesponsor.".*, COUNT(transaction_type), SUM(pay_amount) FROM ".$tablePaymentSponsor.", ".$tablesponsor." WHERE ".$tablePaymentSponsor.".sid=".$tablesponsor.".sid AND (".$tablesponsor.".reg_status='JUNK' or ".$tablesponsor.".reg_status='CANCELLED') ".$tutonly."  GROUP BY transaction_type ORDER BY transaction_type"; 
										 
						$grandTotResult2 = mysql_query($grandeTot2) or die(mysql_error());
						// Print out result
						while($gtrow2 = mysql_fetch_array($grandTotResult2)){
										${"INACTIVE".$gtrow2['transaction_type']} = $gtrow2['COUNT(transaction_type)'];
										${"INACTIVE".$gtrow2['transaction_type']."TOTAL"} = $gtrow2['SUM(pay_amount)'];
										
										$inactiveGTsums = floatval(${"INACTIVE".$gtrow2['transaction_type']."TOTAL"});
										
										$inactiveGTTotal = $inactiveGTTotal + $inactiveGTsums;
										
										$inactiveGTSummaries .= '
	<tr>
		<td bgcolor="#D0D1C0"><p>'.$gtrow2['transaction_type'].'</p></td>
		<td align="center" bgcolor="#D0D1C0"><p>'.${"INACTIVE".$gtrow2['transaction_type']}.'</p></td>
		<td align="right" bgcolor="#D0D1C0"><p>'.sprintf("%01.2f",${"INACTIVE".$gtrow2['transaction_type']."TOTAL"}).'</p></td>
	</tr>';
						}				

///////////////////////////////////////////////////////////////////////////////////////////
?>
<table border="0" cellpadding="5" cellspacing="3">
  <tr>
    <td colspan="4" align="left" valign="top" bgcolor="#D5E0E8"><h1>TOTAL COUNTS</h1></td>
    </tr>
  <tr>
    <td align="left" valign="top" bgcolor="#D5E0E8"><p><strong>Total Number of Complete Registrants: <?php echo $totalregNum; ?></strong></p></td>
    <td align="left" valign="top" bgcolor="#D5E0E8"><strong>Total Number of Pending Registrants: <?php echo $totalpendNum; ?></strong></td>
    <td align="left" valign="top" bgcolor="#D5E0E8"><p><strong>Total Cancelled Registrants: <?php echo $totalcancelledNum; ?></strong></p></td>
    <td align="left" valign="top" bgcolor="#D5E0E8"><p><strong>Total Incomplete (Junk) Registrants: <?php echo $totaljunkNum; ?></strong></p></td>
  </tr>
  <tr>
    <td colspan="4" align="left" valign="top" bgcolor="#D5E0E8">
    <table border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td valign="top"><table border="0" cellpadding="5" cellspacing="3">
      <tr>
        <td colspan="3" bgcolor="#99F58A"><p><strong>Payment Summaries Active Registrations</strong></p></td>
      </tr>
      <tr>
        <td bgcolor="#D6F5BC"><p>Transaction Type</p></td>
        <td bgcolor="#D6F5BC"><p>Number of Transactions</p></td>
        <td bgcolor="#D6F5BC"><p>Total ($)</p></td>
      </tr>
      <?php echo $activeGTSummaries; ?>
      <tr>
        <td colspan="2" align="right" bgcolor="#D6F5BC"><p>TOTAL: &nbsp;</p></td>
        <td align="right" bgcolor="#D6F5BC"><p><?php echo sprintf("%01.2f",$activeGTTotal);  ?></p></td>
      </tr>
    </table></td>
    <td valign="top"><table border="0" cellpadding="5" cellspacing="3">
      <tr>
        <td colspan="3" bgcolor="#999999"><p><strong>Payment Summaries Cancelled/Incomplete Registrations</strong></p></td>
      </tr>
      <tr>
        <td bgcolor="#999999"><p>Transaction Type</p></td>
        <td bgcolor="#999999"><p>Number of Transactions</p></td>
        <td bgcolor="#999999"><p>Total ($)</p></td>
      </tr>
      <?php echo $inactiveGTSummaries; ?>
      <tr>
        <td colspan="2" align="right" bgcolor="#999999"><p>TOTAL:&nbsp; </p></td>
        <td align="right" bgcolor="#999999"><p><?php echo sprintf("%01.2f",$inactiveGTTotal); ?></p></td>
      </tr>
    </table></td>
  </tr>
</table></td>
    </tr>
</table>
<!--<h1>COUNTS BY MONTH
  <?php //if($begindate!=""){ echo " - ".strftime("%B", mktime(0, 0, 0, $begindate+1, 0, 0)); } else { echo " - All Months"; } ?>
</h1>
<h3>
  Choose month:
    <select name="begindate" onChange="document.report.submit();">
      			      <option value="" selected <?php //if (!(strcmp("", "$begindate"))) {echo "selected=\"selected\"";} ?>>All</option> 
      <option value="06" <?php //if (!(strcmp("06", "$begindate"))) {echo "selected=\"selected\"";} ?>>June </option>
      <option value="07" <?php //if (!(strcmp("07", "$begindate"))) {echo "selected=\"selected\"";} ?>>July </option>
      <option value="08" <?php //if (!(strcmp("08", "$begindate"))) {echo "selected=\"selected\"";} ?>>August </option>
      <option value="09" <?php //if (!(strcmp("09", "$begindate"))) {echo "selected=\"selected\"";} ?>>September </option>
    </select>
</h3>
-->
<input name="begindate" type="hidden" id="begindate">
<?php //////////////////////// grand totals selected month ///////////////////////////////////
						$query = "SELECT ".$tablePaymentSponsor.".*, ".$tablesponsor.".*, COUNT(transaction_type), SUM(pay_amount) FROM ".$tablePaymentSponsor.", ".$tablesponsor." WHERE ".$tablePaymentSponsor.".sid=".$tablesponsor.".sid AND ".$tablesponsor.".reg_status!='JUNK' AND ".$tablesponsor.".reg_status!='CANCELLED' ".$tutonly." ".$selectdate." GROUP BY transaction_type ORDER BY transaction_type"; 
										 
						$result = mysql_query($query) or die(mysql_error());
						// Print out result
						while($row = mysql_fetch_array($result)){
										${$row['transaction_type']} = $row['COUNT(transaction_type)'];
										${$row['transaction_type']."TOTAL"} = $row['SUM(pay_amount)'];
										
										$activesums = floatval(${$row['transaction_type']."TOTAL"});
										$activeTotal = $activeTotal + $activesums;
										
										$activeSummaries .= '
	<tr>
		<td bgcolor="#D6E8CE"><p>'.$row['transaction_type'].'</p></td>
		<td align="center" bgcolor="#D6E8CE"><p>'.${$row['transaction_type']}.'</p></td>
		<td align="right" bgcolor="#D6E8CE"><p>'.${$row['transaction_type']."TOTAL"}.'.00</p></td>
	</tr>';
						}				

						$query2 = "SELECT ".$tablePaymentSponsor.".*, ".$tablesponsor.".*, COUNT(transaction_type), SUM(pay_amount) FROM ".$tablePaymentSponsor.", ".$tablesponsor." WHERE ".$tablePaymentSponsor.".sid=".$tablesponsor.".sid AND (".$tablesponsor.".reg_status='JUNK' or ".$tablesponsor.".reg_status='CANCELLED') ".$tutonly." ".$selectdate." GROUP BY transaction_type ORDER BY transaction_type"; 
										 
						$result2 = mysql_query($query2) or die(mysql_error());
						// Print out result
						while($row2 = mysql_fetch_array($result2)){
										${"INACTIVE".$row2['transaction_type']} = $row2['COUNT(transaction_type)'];
										${"INACTIVE".$row2['transaction_type']."TOTAL"} = $row2['SUM(pay_amount)'];
										
										$inactivesums = floatval(${"INACTIVE".$row2['transaction_type']."TOTAL"});
										
										$inactiveTotal = $inactiveTotal + $inactivesums;
										
										$inactiveSummaries .= '
	<tr>
		<td bgcolor="#D0D1C0"><p>'.$row2['transaction_type'].'</p></td>
		<td align="center" bgcolor="#D0D1C0"><p>'.${"INACTIVE".$row2['transaction_type']}.'</p></td>
		<td align="right" bgcolor="#D0D1C0"><p>'.${"INACTIVE".$row2['transaction_type']."TOTAL"}.'.00</p></td>
	</tr>';
						}				
						
//////////////////////// pull records to view and sort through ///////////////////////////////////
						$recordsperpage = 100;
						$pagenum = $_POST['pagenum'];
						if($pagenum==""){ $pagenum = 0; } else { $pagenum = $pagenum-1; }
						$nextrecords = $pagenum*$recordsperpage;
						
						$selectTotal = "SELECT * FROM $tablesponsor WHERE sid!='' ".$tutonly." ".$selectdate2." ";
						$resultTotal = mysql_query($selectTotal) or die(mysql_error());
						$resultNum = mysql_num_rows($resultTotal);
						
						
						
//						echo "<h1>".$resultNum."</h1>";
						
						$numPages = ceil($resultNum/$recordsperpage);
						$pagenav = "<table width=\"100%\"><tr><td><h3>Display Page: ";
						
						for($i=1;$i<=$numPages;$i++){
							if($i!=($pagenum+1)) { 
								$pagenav .= "<a href=\"#\" onClick=\"document.report.pagenum.value=";
								$pagenav .= $i;
								$pagenav .= "; document.report.submit();\">";
							}
							$pagenav .= $i;
							if($i!=$pagenum+1) { 
								$pagenav .= "</a>";
							}
							$pagenav .= " &nbsp;";
						}
						
						$pagenav .= "</h3></td></tr></table>";
						
						$query3 = "SELECT * FROM $tablesponsor WHERE sid!='' ".$tutonly." ".$selectdate2." ORDER BY ".$orderby." ".$orderascdesc." LIMIT $nextrecords,$recordsperpage";
						$result3 = mysql_query($query3) or die(mysql_error());
						
						
						$goodrecords = array();
						$badrecords = array();
						$cancelledrecords = array();

						while ($reg = mysql_fetch_array($result3)){
							if($reg['reg_status']=="JUNK"){
								array_push($badrecords,$reg);
							} else if ($reg['reg_status']=="CANCELLED"){
								array_push($cancelledrecords,$reg);
							} else if ($reg['reg_status']=="") {
								array_push($goodrecords,$reg);
							} 
						}
						$goodrecordsnum = sizeof($goodrecords);
						$badrecordsnum = sizeof($badrecords);
						$cancelledrecordsnum = sizeof($cancelledrecords);
						
							
	?>
<input name="pagenum" type="hidden" value="">
<?php if ($begindate!=""){ ?>
<table border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td valign="top"><table border="0" cellpadding="5" cellspacing="3">
      <tr>
        <td colspan="3" bgcolor="#99F58A"><p><strong>Payment Summaries Active Registrations</strong></p></td>
      </tr>
      <tr>
        <td bgcolor="#D6F5BC"><p>Transaction Type</p></td>
        <td bgcolor="#D6F5BC"><p>Number of Transactions</p></td>
        <td bgcolor="#D6F5BC"><p>Total ($)</p></td>
      </tr>
      <?php echo $activeSummaries; ?>
      <tr>
        <td colspan="2" align="right" bgcolor="#D6F5BC"><p>TOTAL: &nbsp;</p></td>
        <td align="right" bgcolor="#D6F5BC"><p><?php echo $activeTotal; ?>.00</p></td>
      </tr>
    </table></td>
    <td valign="top"><table border="0" cellpadding="5" cellspacing="3">
      <tr>
        <td colspan="3" bgcolor="#999999"><p><strong>Payment Summaries Cancelled/Incomplete Registrations</strong></p></td>
      </tr>
      <tr>
        <td bgcolor="#999999"><p>Transaction Type</p></td>
        <td bgcolor="#999999"><p>Number of Transactions</p></td>
        <td bgcolor="#999999"><p>Total ($)</p></td>
      </tr>
      <?php echo $inactiveSummaries; ?>
      <tr>
        <td colspan="2" align="right" bgcolor="#999999"><p>TOTAL:&nbsp; </p></td>
        <td align="right" bgcolor="#999999"><p><?php echo $inactiveTotal; ?>.00</p></td>
      </tr>
    </table></td>
  </tr>
</table>
<?php } ?>
<h2>Page will automatically refresh when you make your selection.</h2>
<h3><strong>Registrant Summaries</strong></h3>
<p><strong>Show:</strong> 
  <input name="showresults" type="radio" id="showresults"  onclick="document.report.submit();" value="all"  <?php if (!(strcmp("$showresults","all"))) {echo "checked=\"checked\"";} ?>>
  All Registrations&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  <input <?php if (!(strcmp("$showresults","tutorialonly"))) {echo "checked=\"checked\"";} ?> name="showresults" type="radio" id="showresults2" value="tutorialonly"  onclick="document.report.submit();">
  Tutorial 
  
  Only Registrations</p>
<p><strong>Sort Results by:</strong> 
  <input <?php if (!(strcmp("$orderby","sid"))) {echo "checked=\"checked\"";} ?> name="orderit" type="radio" id="invoicenum" value="sid" onclick="document.report.submit();">
  Invoice #&nbsp;&nbsp;
  <input <?php if (!(strcmp("$orderby","lname,fname"))) {echo "checked=\"checked\"";} ?> type="radio" name="orderit" id="invoicenum2" value="lname,fname" onclick="document.report.submit();">
  Last Name
  &nbsp;&nbsp;
  <input <?php if (!(strcmp("$orderby","totalpaid"))) {echo "checked=\"checked\"";} ?> type="radio" name="orderit" id="invoicenum3" value="totalpaid" onclick="document.report.submit();">
  Total Paid
  &nbsp;&nbsp;
  <input <?php if (!(strcmp("$orderby","totaldue"))) {echo "checked=\"checked\"";} ?> type="radio" name="orderit" id="invoicenum4" value="totaldue" onclick="document.report.submit();"> 
  Total Owing&nbsp;&nbsp;
  <input <?php if (!(strcmp("$orderby","paytype"))) {echo "checked=\"checked\"";} ?> type="radio" name="orderit" id="invoicenum5" value="paytype" onClick="document.report.submit();">
  Pay Type  </p>
<p><strong>Order Results by:</strong> 
  <input <?php if (!(strcmp("$ordering","asc"))) {echo "checked=\"checked\"";} ?> name="ordering" type="radio" id="radio" value="asc" onclick="document.report.submit();">
  ascending 
  <input  <?php if (!(strcmp("$ordering","desc"))) {echo "checked=\"checked\"";} ?> name="ordering" type="radio" id="radio2" value="desc" onclick="document.report.submit();">
  descending</p>
<?php echo $pagenav; ?>
<table width="100%" border="0" cellpadding="5" cellspacing="3">
  <tr>
    <th bgcolor="#006600" colspan="6"><p><strong>Active Registrations</strong> (Pending Records in Blue)</p></th>
  </tr>
    <?php for($i=0;$i<$goodrecordsnum;$i++){ 
	?>
      <tr bgcolor="#<?php if($goodrecords[$i]['paytype']!="") { echo "D6F5BC"; } else { echo "66CCFF"; } ?>">
      	<td valign="top"><p><strong>Invoice #: <?php echo $goodrecords[$i]['sid']; ?></strong></p></td>
      	<td valign="top"><p><?php echo $goodrecords[$i]['lname'].", ".$goodrecords[$i]['fname']; ?></p></td>
      	<td valign="top"><p><strong>Paid: <?php echo $goodrecords[$i]['totalpaid']; ?></strong></p></td>
      	<td valign="top"><p><strong>Owing: <?php echo $goodrecords[$i]['totaldue']; ?></strong></p></td>
      	<td valign="top"><p><strong>Payment Type: </strong><?php echo $goodrecords[$i]['paytype']; ?> <br>
      		Password Set: <?php if($goodrecords[$i]['user_password']!=""){ echo "Yes"; } else { echo "No"; } ?> </p></td>
      	<td ><p><a href="showInvoice.php?sid=<?php echo $goodrecords[$i]['sid']; ?>" target="_blank">View Invoice</a></p></td>
      	</tr>
      <tr>
      	<td nowrap>Registration Summary:</td>
      	<td colspan="5"><strong><?php echo $goodrecords[$i]['sponcode']; ?></strong></td>
      	</tr>
      <tr>
      	<td nowrap><p>Payment History:</p></td>
      	<td colspan="5"><p>
      		<?php 
			$findpay = "SELECT * FROM $tablePaymentSponsor WHERE sid='".$goodrecords[$i]['sid']."' ORDER BY id asc";
			$payresults =  mysql_query($findpay) or die(mysql_error());
			while($payhist = mysql_fetch_array($payresults)){
				echo "<span class='reportdisp'> ".$payhist['date_paid'].", ".$payhist['pay_amount'].", ".$payhist['transaction_type']." </span>";
			}
		?>
      		</p></td>
      	</tr>
      <tr>
        <td colspan="6"><hr></td>
      </tr>
    <?php  } ?>





      <tr>
        <td colspan="6"><hr></td>
      </tr>

    <tr>
      <td colspan="6" ><?php echo $pagenav; ?></td>
    </tr>
      <tr>
        <td colspan="6"><hr></td>
      </tr>
    <tr bgcolor="#A7B08E">
    <th bgcolor="#990000" colspan="6"><p><strong>Cancelled Registrations</strong></p></th>
  </tr>
    <?php for($i=0;$i<$cancelledrecordsnum;$i++){ ?>
      <tr>
        <td bgcolor="#CEAFAA"><p><strong>Invoice #: <?php echo $cancelledrecords[$i]['sid']; ?></strong></p></td>
        <td bgcolor="#CEAFAA"><p><?php echo $cancelledrecords[$i]['lname'].", ".$cancelledrecords[$i]['fname']; ?></p></td>
        <td bgcolor="#CEAFAA"><p><strong>Paid: <?php echo $cancelledrecords[$i]['totalpaid']; ?></strong></p></td>
        <td bgcolor="#CEAFAA"><p><strong>Owing: <?php echo $cancelledrecords[$i]['totaldue']; ?></strong></p></td>
        <td bgcolor="#CEAFAA"><p><strong>Payment Type: </strong><?php echo $cancelledrecords[$i]['paytype']; ?></p></td>
        <td bgcolor="#CEAFAA"><p><a href="showInvoice.php?sid=<?php echo $cancelledrecords[$i]['sid']; ?>" target="_blank">View Invoice</a></p></td>
      </tr>
      <tr>
        <td nowrap><p>Registration Summary:</p></td>
        <td colspan="5"><p><strong><?php echo $cancelledrecords[$i]['sponcode']; ?></strong></p></td>
      </tr>
      <tr>
        <td nowrap><p>Payment History:</p></td>
        <td colspan="5"><p>
        <?php 
			$findpay = "SELECT * FROM $tablePaymentSponsor WHERE sid='".$cancelledrecords[$i]['sid']."' ORDER BY id asc";
			$payresults =  mysql_query($findpay) or die(mysql_error());
			while($payhist = mysql_fetch_array($payresults)){
				echo "<span class='reportdisp'> ".$payhist['date_paid'].", ".$payhist['pay_amount'].", ".$payhist['transaction_type']." </span>";
			}
		?>
        </p></td>
      </tr>
      <tr>
        <td colspan="6"><hr></td>
      </tr>
    <?php } ?>
  <tr bgcolor="#A7B08E">
    <th bgcolor="#333333" colspan="6"><p><strong>Incomplete Registrations</strong></p></th>
  </tr>
    <?php for($i=0;$i<$badrecordsnum;$i++){ ?>
      <tr>
        <td bgcolor="#CCCCCC"><p><strong>Invoice #: <?php echo $badrecords[$i]['sid']; ?></strong></p></td>
        <td bgcolor="#CCCCCC"><p><?php echo $badrecords[$i]['lname'].", ".$badrecords[$i]['fname']; ?></p></td>
        <td bgcolor="#CCCCCC"><p><strong>Paid: <?php echo $badrecords[$i]['totalpaid']; ?></strong></p></td>
        <td bgcolor="#CCCCCC"><p><strong>Owing: <?php echo $badrecords[$i]['totaldue']; ?></strong></p></td>
        <td bgcolor="#CCCCCC"><p><strong>Payment Type: </strong><?php echo $badrecords[$i]['paytype']; ?></p></td>
        <td bgcolor="#CCCCCC"><p><a href="showInvoice.php?sid=<?php echo $badrecords[$i]['sid']; ?>" target="_blank">View Invoice</a></p></td>
      </tr>
      <tr>
        <td nowrap><p>Registration Summary:</p></td>
        <td colspan="5"><p><strong><?php echo $badrecords[$i]['sponcode']; ?></strong></p></td>
      </tr>
      <tr>
        <td nowrap><p>Payment History:</p></td>
        <td colspan="5"><p>
        <?php 
			$findpay = "SELECT * FROM $tablePaymentSponsor WHERE sid='".$badrecords[$i]['sid']."' ORDER BY id asc";
			$payresults =  mysql_query($findpay) or die(mysql_error());
			while($payhist = mysql_fetch_array($payresults)){
				echo "<span class='reportdisp'> ".$payhist['date_paid'].", ".$payhist['pay_amount'].", ".$payhist['transaction_type']." </span>";
			}
		?>
        </p></td>
      </tr>
      <tr>
        <td colspan="6"><hr></td>
      </tr>
    <?php } ?>
</table>
<p>&nbsp;</p>
<p>&nbsp;&nbsp;&nbsp;</p>
</form>
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
