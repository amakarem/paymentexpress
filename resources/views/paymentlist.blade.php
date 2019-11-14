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

function gettransactions($token,$start,$end)
{
    global $system;
    $queryUrl = $system . 'reporting/transactions?start_date='.$start.'&end_date='.$end.'&fields=transaction_info,payer_info&page_size=500&page=1';
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
    if(isset($result['transaction_details'])) {
        $result = $result['transaction_details']; 
    } else {
        print_r($result);
        $result = array();
    }
    return $result;
}

$data = DB::table('paypal')->where('owner', Auth::user()->id)->get();
$data = json_decode(json_encode($data), true);

$client_id = $data[0]['username'];
$secret = $data[0]['password'];
$sandbox = $data[0]['sandbox'];
global $system;
$system = 'https://api.paypal.com/v1/';
if ($sandbox == 1) {
    $system = 'https://api.sandbox.paypal.com/v1/';
}
$start = date("Y-m-d",strtotime("-1 month"));
$end = date("Y-m-d");
if(isset($_GET['start'])) {
    $start = $_GET['start'];
}
if(isset($_GET['end'])) {
    $end = $_GET['end'];
}
$start = $start . 'T00:00:00-0000';
$end = $end . 'T23:59:59-0000';

$date1 = date_create($start);
$date2 = date_create($end);
$diff = date_diff($date1, $date2);
$age = $diff->format("%a");

$transactions = array();
if($age <= 31) {
    $token = token($client_id, $secret);
    $result = gettransactions($token,$start,$end);
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
} else {
    $error = '<span class="bg-danger text-white">Date range is greater than 31 days</span>';
}
?>

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">PayPal Transactions list from {{$start}} to {{$end}} <?php if(isset($error)) { echo $error; } ?></div>

                <div class="card-body">
                    <table class="table table-hover">
                    <thead class="bg-light">
                    <tr>
                    <th>Transaction ID</th>
                    <th>Amount</th>
                    <th>Currency</th>
                    <th>Payer</th>
                    <th>Date time</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
foreach ($transactions as $row) {
    echo "<tr><td>" . $row['id'] . "</td><td>" . $row['value'] . "</td><td>" . $row['currency'] . "</td><td>" . $row['payer'] . "</td><td>" . $row['date'] . "</td></tr>";
}
?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
