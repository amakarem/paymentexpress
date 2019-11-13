<?php
function token($client_id, $secret)
{
    global $system;
    $queryUrl = $system . 'oauth2/token';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $queryUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
    curl_setopt($ch, CURLOPT_USERPWD, $client_id . ':' . $secret);
    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = 'Accept-Language: en_US';
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    $result = json_decode($result, true);
    curl_close($ch);
    if (isset($result['access_token'])) {
        $result = $result['access_token'];
    }
    return $result;
}
function gettransactions($token, $start, $end)
{
    global $system;
    $queryUrl = $system . 'reporting/transactions?start_date=' . $start . '&end_date=' . $end . '&fields=transaction_info,payer_info&page_size=500&page=1';
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $queryUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization: Bearer ' . $token;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    $result = json_decode($result, true);
    if (isset($result['transaction_details'])) {
        $result = $result['transaction_details'];
    } else {
        $result = array();
    }
    return $result;
}

if (isset($_POST['client_id']) && isset($_POST['secret'])) {
    $client_id = $_POST['client_id'];
    $secret = $_POST['secret'];
    $sandbox = 0;
    if (isset($_POST['sandbox'])) {
        $sandbox = 1;
    }
    global $system;
    $system = 'https://api.paypal.com/v1/';
    if ($sandbox == 1) {
        $system = 'https://api.sandbox.paypal.com/v1/';
    }
    $start = date("Y-m-d", strtotime("-1 month"));
    $end = date("Y-m-d");
    $start = $start . 'T00:00:00-0000';
    $end = $end . 'T23:59:59-0000';
    if (isset($_POST['start'])) {
        $start = $_POST['start'];
    }
    if (isset($_POST['end'])) {
        $end = $_POST['end'];
    }

    $token = token($client_id, $secret);

    $result = gettransactions($token, $start, $end);
    $transactions = array();
    foreach ($result as $value) {
        if (!isset($value['transaction_info']['paypal_reference_id']) && isset($value['payer_info']['email_address'])) {
            $payer = $value['payer_info']['email_address'];
            $value = $value['transaction_info'];
            $transactions[$value['transaction_id']]['id'] = $value['transaction_id'];
            $transactions[$value['transaction_id']]['date'] = $value['transaction_updated_date'];
            $transactions[$value['transaction_id']]['currency'] = $value['transaction_amount']['currency_code'];
            $transactions[$value['transaction_id']]['value'] = $value['transaction_amount']['value'];
            $transactions[$value['transaction_id']]['payer'] = $payer;
        }
    }
    $transactions = json_encode($transactions);
    print_r($transactions);
} else {
    print_r($_POST);
    echo "Access denied";
}
