@extends('layouts.app')

@section('content')
<div class="container">
<?php
if(!empty($_GET)) {
    $order = $_GET;
} elseif(!empty($_POST)) {
    $order = $_POST;
}
if(isset($order['account']) && isset($order['id']) && isset($order['details']) && isset($order['amount'])) {
    $paymentdata = array();
    $account = base64_decode($order['account']);
    $users = DB::table('users')->select('name', 'email')->where('email',$account)->get();
    foreach ($users as $user) {
        $accountname = $user->name;
        //echo base64_encode($user->email);
        //echo "<b>Order Details</b>";
        echo "<br>Order Number: " . $order['id'];
        echo "<br>Seller: " . $accountname;
        echo "<br>Order Details: " . $order['details'];
        echo "<br><b>Total</b>: $" . $order['amount'];
        echo "<hr><br><b>Available Paymet method:</b><br>";
        $paymentdata = array(
            'business' => 'paypal-facilitator-1@frontdeskhelpers.com',
            'cmd' => '_xclick',
            'notify_url' => '',
            'item_name' => $order['details'],
            'bn' => $order['id'],
            'amount' => $order['amount'],
        );
    }
} else {
    echo "WRONG REQUEST";
}
?>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="business" value="payment@wishmasterhost.com">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="notify_url" value="">
    <input type="hidden" name="item_name" value="bla bla bla">
    <input type="hidden" name="bn" value="<?php echo $order['id']; ?>">
    <input type="hidden" name="amount" value="100">
  <input type="image" name="submit" border="0"  src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_150x38.png" alt="PayPal - The safer, easier way to pay online">  
</form>

</div>
@endsection