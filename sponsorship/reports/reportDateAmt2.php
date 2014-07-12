<?php include('../config_include/connect.php'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Banff/2013 Pipeline Workshop Registration</title>
<link href="../css/asmebanffstyles.css" rel="stylesheet" type="text/css">
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
		$tutonly = " and funccode='' ";
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
      	<td colspan="5"><strong><?php echo $goodrecords[$i]['funccode']; ?></strong></td>
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
        <td colspan="5"><p><strong><?php echo $cancelledrecords[$i]['funccode']; ?></strong></p></td>
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
        <td colspan="5"><p><strong><?php echo $badrecords[$i]['funccode']; ?></strong></p></td>
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
