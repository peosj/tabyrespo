<?php

$fpx_msgType="AE";
$fpx_msgToken="01";
$fpx_sellerExId="EX00005331";
$fpx_sellerExOrderNo=date('YmdHis');
$fpx_sellerTxnTime=date('YmdHis');
$fpx_sellerOrderNo=date('YmdHis');
$fpx_sellerId="SE00006118";
$fpx_sellerBankCode="01";
$fpx_txnCurrency="MYR";
$fpx_txnAmount='100';
$fpx_buyerEmail="peosjohn@gmail.com";
$fpx_checkSum="";
$fpx_buyerName="";
$fpx_buyerBankId='TEST0021';
$fpx_buyerBankBranch="";
$fpx_buyerAccNo="";
$fpx_buyerId="";
$fpx_makerName="";
$fpx_buyerIban="";
$fpx_productDesc = 'Prepaid Reload';
$fpx_version="6.0";


/* Generating signing String */
$data=$fpx_buyerAccNo."|".$fpx_buyerBankBranch."|".$fpx_buyerBankId."|".$fpx_buyerEmail."|".$fpx_buyerIban."|".$fpx_buyerId."|".$fpx_buyerName."|".$fpx_makerName."|".$fpx_msgToken."|".$fpx_msgType."|".$fpx_productDesc."|".$fpx_sellerBankCode."|".$fpx_sellerExId."|".$fpx_sellerExOrderNo."|".$fpx_sellerId."|".$fpx_sellerOrderNo."|".$fpx_sellerTxnTime."|".$fpx_txnAmount."|".$fpx_txnCurrency."|".$fpx_version;
/* Reading key */
//$priv_key = file_get_contents('FPX2015cert-and-key/e35fa_31dab_a82cdc20bbb7ae28329ed145316e9dea.key');
$priv_key = file_get_contents('/EX00005331.cer');
$pkeyid = openssl_get_privatekey($priv_key);
openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
$fpx_checkSum = strtoupper(bin2hex( $binary_signature ) );


/*

<input type="text" value="AR" name="fpx_msgType">
<input type="text" value="01" name="fpx_msgToken">
<input type="text" value="EX00005331" name="fpx_sellerExId">
<input type="text" value="Q2018KISTX4-20181011082737" name="fpx_sellerExOrderNo">
<input type="text" value="20181011082737" name="fpx_sellerTxnTime">
<input type="text" value="Q2018K-20181011082235" name="fpx_sellerOrderNo">
<input type="text" value="SE00006118" name="fpx_sellerId">
<input type="text" value="01" name="fpx_sellerBankCode">
<input type="text" value="MYR" name="fpx_txnCurrency">
<input type="text" value="10" name="fpx_txnAmount">
<input type="text" value="" name="fpx_checkSum">
<input type="text" value="" name="fpx_buyerName">
<input type="text" value="" name="fpx_buyerBankBranch">
<input type="text" value="" name="fpx_buyerAccNo">
<input type="text" value="" name="fpx_buyerId">
<input type="text" value="" name="fpx_makerName">
<input type="text" value="" name="fpx_buyerIban">
<input type="text" value="6.0" name="fpx_version">
<input type="text" value="Prepaid Reload" name="fpx_productDesc">

*/
// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    //CURLOPT_URL => 'https://uat.mepsfpx.com.my/FPXMain/RetrieveBankList',
    CURLOPT_URL => 'https://uat.mepsfpx.com.my/FPXMain/seller2DReceiver.jsp',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => array(
        fpx_msgType => 'AR',
        fpx_msgToken => '01',
        fpx_sellerExId => 'EX00005331',
        fpx_sellerExOrderNo => 'Q2018KISTX4-20181011082737',
        fpx_sellerTxnTime => '20181011082737',
        fpx_sellerOrderNo => 'Q2018K-20181011082235',
        fpx_sellerId => 'SE00006118',
        fpx_sellerBankCode => '01',
        fpx_txnCurrency => 'MYR',
        fpx_txnAmount => '100',
        fpx_buyerEmail => 'peosjohn@gmail.com',
        fpx_checkSum => '6A2EDC511F7D108447E57777F4607BBFFB89F0BC4947AF8B23E0837C76FFEA8893DF125C8A249F0B835D088E2E050E83AE9CDAC39CE07E10CAF7707A0992D0E0FF7A8AAFFFE0ED77CD39B10145470788AFA36FA5829DE6BB02BD15A527886C2D70BE8E10B926F5E5401DF7F26BDD2DC4BE1877FECC59328827F0FE8911B10015A668D48C6989281DBEF7169CA5F7D963B7339AD6D6D368805427E0C81929155B4806847E5FFAEE521402ABFCD15323051A150CDFAD09DB054594DBD7FE3069EDC9A15DF7F6E214633605D67673DCB12FFE61AEC8722067EF48B18F7CCF0AF58F910278C14AB17A468EAA36AE5BA30D2CE6AF5BE7EE688C717D006FCA00AE5508',
        fpx_buyerName => '',
        fpx_buyerBankId => 'TEST0021',
        fpx_buyerBankBranch => '',
        fpx_buyerAccNo => '',
        fpx_buyerId => '',
        fpx_makerName => '',
        fpx_buyerIban => '',
        fpx_version => '6.0',
        fpx_productDesc => 'Test for AE Message'
    )
));
// Send the request & save response to $resp
$resp = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);

 

print_r($resp);
?>