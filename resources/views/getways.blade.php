@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Payment Getways</div>

                <div class="card-body">
                    <table class="table table-hover">
                    <thead class="bg-light">
                    <tr>
                    <th>Getway</th>
                    <th>Status</th>
                    <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $getwaylist = array('paypal');
                    foreach ($getwaylist as $getway) {
                        $getwaystatus = DB::table($getway)->where('owner', Auth::user()->id)->get()->toArray();
                        if(!empty($getwaystatus)) {
                            $getwaystatus = $getwaystatus['email'];
                            $action = '<a href="" class="btn btn-sm btn-success">Edit</a>';
                            $action .= '<a href="" class="btn btn-sm btn-danger">Delete</a>';
                        } else {
                            $getwaystatus = 'Not set';
                            $action = '<a href="" class="btn btn-sm btn-success">Setup</a>';
                        }
                        $getway = ucfirst($getway);
                        echo "<tr><td>$getway</td><td>$getwaystatus</td><td>$action</td></tr>";
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
