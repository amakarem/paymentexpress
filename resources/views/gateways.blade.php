@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">My Gateways</div>

                <div class="card-body">
                    <table class="table table-hover">
                    <thead class="bg-light">
                    <tr>
                    <th>Gateway</th>
                    <th>Account</th>
                    <th>Status</th>
                    <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
require app_path() . '/Lib/gateways.php';
$data = array();
foreach ($gatewaylist as $gateway) {
    $result = DB::table($gateway)->where('owner', Auth::user()->id)->get();
    $result = json_decode(json_encode($result), true);
    if (!empty($result)) {
        foreach ($result as $row) {
            $data[$gateway] = $row;
            if(isset($row['email'])) {
                $gatewaysaccount = $row['email'];
            } else {
                $gatewaysaccount = $row['merchantId'];
            }
            $status = $row['sandbox'];
            if ($row['disabled'] == 1) {
                $status = 2;
            }
        }
        if ($status == 1) {
            $status = 'Sandbox';
        } elseif ($status == 2) {
            $status = 'Disabled';
        } else {
            $status = 'Active';
        }
        $action = '<a href="" data-toggle="modal" data-target="#' . $gateway . '" class="btn btn-sm btn-success">Edit</a> ';
        //$action .= '<a href="" class="btn btn-sm btn-danger">Delete</a>';
    } else {
        $gatewaystatus = 'Not set';
        $gatewaysaccount = 'Not set';
        $status = 'N/A';
        $action = '<a href="" data-toggle="modal" data-target="#' . $gateway . '" class="btn btn-sm btn-success">Setup</a>';
    }
    $gateway = ucfirst($gateway);
    echo "<tr><td>$gateway</td><td>$gatewaysaccount</td><td>$status</td><td>$action</td></tr>";
}
?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach ($gatewaylist as $gatewaye)
     @include('modals.' . $gatewaye)
@endforeach
@endsection
