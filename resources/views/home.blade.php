@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                    <br>
                    <pre>
                    <?php
$paymentkey = Auth::user()->paymentkey;
if ($paymentkey == '' || $paymentkey == '0') {
    echo "<br><b>You don't have Payment Key </b>";
    echo '<a class="btn btn-success" href="' . route('generatepaymentkey') . '">Generate Payment Key</a>';
} else {
    echo "<b>Your payment Key is: </b><kbd>$paymentkey</kbd>";
    echo "<hr><b>Here is your simple HTML code for integration</b><br>";
    echo '
<textarea rows="10" cols="60" name="code">
<form method="GET" action="https://' . $_SERVER['REQUEST_URI'] . '/checkout">
    <input type="hidden" name="account" value="' . $paymentkey . '">
    <input type="hidden" name="id" value="2">
    <input type="text" name="details" value="details for the order">
    <input type="text" name="amount" value="100">
    <input type="submit" value="submit">
</form>
</textarea>';
}
?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
