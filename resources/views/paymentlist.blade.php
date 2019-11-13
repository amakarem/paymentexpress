<?php

$data = DB::table('paypal')->where('owner', Auth::user()->id)->get();
$data = json_decode(json_encode($data), true);

$client_id = $data[0]['username'];
$secret = $data[0]['password'];

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

function gettransactions($token)
{
    global $system;
    $queryUrl = $system . 'reporting/transactions?start_date=2019-09-01T00:00:00-0700&end_date=2019-09-30T23:59:59-0700&fields=transaction_info,payer_info&page_size=500&page=1';
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
    $result = $result['transaction_details'];
    return $result;
}

$token = token($client_id, $secret);

$result = gettransactions($token);
print_r($result);
/*
$transactions = array();
foreach ($result as $value) {
    if (!isset($value['transaction_info']['paypal_reference_id'])) {
        $payer = $value['payer_info']['email_address'];
        $value = $value['transaction_info'];
        $transactions[$value['transaction_id']]['ID'] = $value['transaction_id'];
        $transactions[$value['transaction_id']]['Date'] = $value['transaction_updated_date'];
        $transactions[$value['transaction_id']]['Currency'] = $value['transaction_amount']['currency_code'];
        $transactions[$value['transaction_id']]['value'] = $value['transaction_amount']['value'];
        $transactions[$value['transaction_id']]['payer'] = $payer;
    }
}
print_r($transactions);

?>

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">PayPal Transactions list</div>

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
            echo "<tr><td>".$row['id']."</td><td>".$row['value']."</td><td>".$row['Currency']."</td><td>".$row['payer']."</td><td>".$row['Date']."</td></tr>";
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
*/