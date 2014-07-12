<?php

//============================================================
// batch replace copyright
//============================================================
// payment gateway variables
$beanstreamMarketName = "idAssociatesSB"; // login name given by Beanstream
$beanstreamMerchantID = "163960000";
$beanstreamVPusername = "IdAssociatesV01D";
$beanstreamVPpass = "V01DPurchases";

$beanstreamTransactionAddress = "https://www.beanstream.com/secure/$beanstreamMarketName/banff_paymentFormSponsorship.asp";
$beanstreamProfileTransactionAddress = "https://www.beanstream.com/scripts/process_transaction.asp";
$beanstreamReturnAddress = $fullURL . "paymentResponse.php";




///////////////////////////////////////////////////////////////////////////
// id sandbox account
//$beanstreamMarketName = "idAssociatesSB"; // login name given by Beanstream
//$beanstreamMerchantID = "163960000";
//$beanstreamProfilePass = "TKhV08CSb0d38Lxtbvw2JapxE71lCdQe";
//$beanstreamHashKey = "IdAssociatesSBHash";
//$beanstreamVPusername = "IdAssociatesV01D";
//$beanstreamVPpass = "V01DPurchases";
//
//$beanstreamProfileTransactionAddress = "https://www.beanstream.com/scripts/process_transaction.asp";
//$beanstreamTransactionAddress = "https://www.beanstream.com/secure/$beanstreamMarketName/banff_paymentForm.asp";
?>