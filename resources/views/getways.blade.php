@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">My Getways</div>

                <div class="card-body">
                    <table class="table table-hover">
                    <thead class="bg-light">
                    <tr>
                    <th>Getway</th>
                    <th>Account</th>
                    <th>Status</th>
                    <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
require app_path() . '/Lib/getways.php';
$data = array();
foreach ($getwaylist as $getway) {
    $result = DB::table($getway)->where('owner', Auth::user()->id)->get();
    $result = json_decode(json_encode($result), true);
    if (!empty($result)) {
        foreach ($result as $row) {
            $data[$getway] = $row;
            $getwaysaccount = $row['email'];
            $status = $row['sandbox'];
            if($row['disabled'] == 1) {
                $status = 2;
            }
        }
        if($status == 1) {
            $status = 'Sandbox';
        } elseif($status == 2) {
            $status = 'Disabled';
        } else {
            $status = 'Active';
        }
        $action = '<a href="" data-toggle="modal" data-target="#' . $getway . '" class="btn btn-sm btn-success">Edit</a> ';
        //$action .= '<a href="" class="btn btn-sm btn-danger">Delete</a>';
    } else {
        $getwaystatus = 'Not set';
        $getwaysaccount = 'Not set';
        $status = 'N/A';
        $action = '<a href="" data-toggle="modal" data-target="#' . $getway . '" class="btn btn-sm btn-success">Setup</a>';
    }
    $getway = ucfirst($getway);
    echo "<tr><td>$getway</td><td>$getwaysaccount</td><td>$status</td><td>$action</td></tr>";
}
?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.modals')
@endsection
