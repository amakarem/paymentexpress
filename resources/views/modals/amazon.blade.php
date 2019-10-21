<?php
$amazonsandbox = '';
$amazonmerchantId = '';
$amazondisabled = '';
$amazonaccessKey = '';
$amazonsecretKey = '';
$amazonclientid = '';
$amazoncallback = '';
if (isset($data['amazon'])) {
    $amazonmerchantId = $data['amazon']['merchantId'];
    $amazonaccessKey = $data['amazon']['accessKey'];
    $amazonsecretKey = $data['amazon']['secretKey'];
    $amazonclientid = $data['amazon']['clientid'];
    $amazoncallback = $data['amazon']['callback'];
    if ($data['amazon']['sandbox'] == 1) {
        $amazonsandbox = 'checked';
    }
    if ($data['amazon']['disabled'] == 1) {
      $amazondisabled = 'checked';
  }
}
?>
<div id="amazon" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Amazon Setting</h4>
      </div>
      <form action="{{ route('getwaysetup') }}" method="POST">
      {{csrf_field()}}
        <div class="modal-body">
          <div class="form-group">
            <label for="merchantId">Amazon SellerID/MerchantID:</label>
            <input type="hidden" id="getway" name="getway" value="amazon">
            <input type="text" class="form-control" id="merchantId" placeholder="Enter MerchantId" name="merchantId" value="{{$amazonmerchantId}}" required>
          </div>
          <div class="form-group">
            <label for="accessKey">Access Key:</label>
            <input type="text" class="form-control" id="accessKey" placeholder="Enter Access key" name="accessKey" value="{{$amazonaccessKey}}" required>
          </div>
          <div class="form-group">
            <label for="secretKey">Secret Key:</label>
            <input type="text" class="form-control" id="secretKey" placeholder="Enter Secret Key" name="secretKey" value="{{$amazonsecretKey}}" required>
          </div>
          <div class="form-group">
            <label for="clientid">Client ID:</label>
            <input type="text" class="form-control" id="clientid" placeholder="Enter Client ID" name="clientid" value="{{$amazonclientid}}" required>
          </div>
          <div class="form-group">
            <label for="callback">Callback URL:</label>
            <input type="url" class="form-control" id="callback" placeholder="Enter Callback URL" name="callback" value="{{$amazoncallback}}">
          </div>
          <div class="checkbox">
            <label><input type="checkbox" {{$amazonsandbox}} name="sandbox"> Sandbox</label>
          </div>
          <div class="checkbox text-danger">
            <label><input type="checkbox" {{$amazondisabled}} name="disabled"> Disabled</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
