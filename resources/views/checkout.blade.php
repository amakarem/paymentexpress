@extends('layouts.app')

@section('content')
<div class="container">
<?php
if (!empty($_GET)) {
    $order = $_GET;
} 
if (!empty($_POST)) {
    $order = $_POST;
}
if (isset($order['account']) && isset($order['id']) && isset($order['details']) && isset($order['amount'])) {
    $paymentdata = array();
    $account = base64_decode($order['account']);
    $users = DB::table('users')->where('email', $account)->get();
    $users = json_decode(json_encode($users), true);
    if(!empty($users)) {
        foreach ($users as $user) {
            $accountname = $user['name'];
            //echo base64_encode($user->email);
            echo "<br>Order Number: " . $order['id'];
            echo "<br>Seller: " . $accountname;
            echo "<br>Order Details: " . $order['details'];
            echo "<br><b>Total</b>: $" . $order['amount'];
            echo "<hr><br><b>Available Paymet method:</b><br>";
            $paypal = DB::table('paypal')->where('owner', $user['id'])->get();
            $paypal = json_decode(json_encode($paypal), true);
            if (!empty($paypal)) {
                $paypalmethod = array(
                    'business' => $paypal[0]['email'],
                    'cmd' => '_xclick',
                    'notify_url' => '',
                    'item_name' => $order['details'],
                    'bn' => $order['id'],
                    'amount' => $order['amount'],
                );
                if($paypal[0]['sandbox'] != 0 ) {
                    echo '<span class="bg-warning mt-3 mp-3">Sandbox is Active</span>';
                    echo '<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">';
                } else {
                    echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">';
                }
                foreach ($paypalmethod as $key => $value) {
                    echo '<input type="hidden" name="' . $key . '" value="' . $value . '">';
                }
                echo '<input type="image" name="submit" border="0" src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_150x38.png" alt="PayPal - The safer, easier way to pay online">';
                echo '</form>';
            }
        }
    } else {
        echo "Account not found";
    }
} else {
    echo "WRONG REQUEST";
}
?>

</div>
@endsection