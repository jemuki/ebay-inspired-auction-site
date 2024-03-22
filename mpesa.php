<?php
session_start();
// M-Pesa API credentials
$consumerKey = 'GTWADFxIpUfDoNikNGqq1C3023evM6UH';
$consumerSecret = 'amFbAoUByPV2rM5A';

// M-Pesa API endpoints
$authUrl = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
$paymentUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

// Generate access token
$credentials = base64_encode($consumerKey . ':' . $consumerSecret);
$authHeaders = array(
    'Content-Type: application/json',
    'Authorization: Basic ' . $credentials
);

$authResponse = json_decode(file_get_contents($authUrl, false, stream_context_create(array(
    'http' => array(
        'method' => 'GET',
        'header' => implode("\r\n", $authHeaders)
    )
))), true);

$accessToken = $authResponse['access_token'];

$id = $_POST['id'];
$bid = $_POST['bid'];
$mpesanum = $_POST['mpesanum'];


// Construct M-Pesa request
$requestData = array(
    'BusinessShortCode' => '174379',
    'Password' => base64_encode('174379' . 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919' . date('YmdHis')),
    'Timestamp' => date('YmdHis'),
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $bid, 
    'PartyA' => $mpesanum, 
    'PartyB' => '174379',
    'PhoneNumber' => $mpesanum, // Customer phone number
    'CallBackURL' => 'https://chapo.rf.gd/callback.php',
    'AccountReference' => 'account',
    'TransactionDesc' => 'account'
);

// Make payment request
$paymentHeaders = array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $accessToken
);

$paymentResponse = json_decode(file_get_contents($paymentUrl, false, stream_context_create(array(
    'http' => array(
        'method' => 'POST',
        'header' => implode("\r\n", $paymentHeaders),
        'content' => json_encode($requestData)
    )
))), true);

// Handle payment response
if (isset($paymentResponse['ResponseCode']) && $paymentResponse['ResponseCode'] == '0') {
    $_SESSION['payment_id'] = $id;
    header("location: /ebay/pay.php");
    exit();
} else {
    echo 'Payment request failed. Error: ' . $paymentResponse['errorMessage'];
}
?>
