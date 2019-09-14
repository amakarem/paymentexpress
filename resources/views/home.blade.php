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
                    <?php
                    $paymentkey = Auth::user()->paymentkey;
                        if ($paymentkey == '' || $paymentkey == '0') {
                            echo "<br><b>You don't have Payment Key </b>";
                            echo '<a class="btn btn-success" href="' . route('generatepaymentkey') . '">Generate Payment Key</a>';
                        } else {
                            echo "<b>Your payment Key is: </b><kbd>$paymentkey</kbd>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
