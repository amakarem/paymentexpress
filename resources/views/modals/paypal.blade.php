<?php
$paypalsandbox = '';
$paypalemail = '';
$paypaldisabled = '';
$paypalcallback = '';
if (isset($data['paypal'])) {
    $paypalemail = $data['paypal']['email'];
    $paypalcallback = $data['paypal']['callback'];
    if ($data['paypal']['sandbox'] == 1) {
        $paypalsandbox = 'checked';
    }
    if ($data['paypal']['disabled'] == 1) {
      $paypaldisabled = 'checked';
  }
}
?>
<div id="paypal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Paypal Setting</h4>
      </div>
      <form action="{{ route('gatewaysetup') }}" method="POST">
      {{csrf_field()}}
        <div class="modal-body">
          <div class="form-group">
            <label for="email">Paypal Account Email:</label>
            <input type="hidden" id="gateway" name="gateway" value="paypal">
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="{{$paypalemail}}" required>
          </div>
          <div class="form-group">
            <label for="callback">Callback URL:</label>
            <input type="url" class="form-control" id="callback" placeholder="Enter Callback URL" name="callback" value="{{$paypalcallback}}">
          </div>
          <div class="checkbox">
            <label><input type="checkbox" {{$paypalsandbox}} name="sandbox"> Sandbox</label>
          </div>
          <div class="checkbox text-danger">
            <label><input type="checkbox" {{$paypaldisabled}} name="disabled"> Disabled</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
