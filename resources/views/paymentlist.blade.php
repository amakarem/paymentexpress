@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Transactions list</div>

                <div class="card-body">
                    <table class="table table-hover">
                    <thead class="bg-light">
                    <tr>
                    <th>ID</th>
                    <th>OrderID</th>
                    <th>Gateway</th>
                    <th>Transaction ID</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Details</th>
                    <th>Date time</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
    $result = DB::table('payment')->where('owner', Auth::user()->id)->get();
    $result = json_decode(json_encode($result), true);
    if (!empty($result)) {
        foreach ($result as $row) {
            echo "<tr><td>".$row['id']."</td><td>".$row['orderid']."</td><td>".$row['getway']."</td><td>".$row['txnid']."</td><td>".$row['amount']."</td><td>".$row['status']."</td><td>".$row['details']."</td><td>".$row['created_at']."</td></tr>";
        }
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
