<?php
$paypalsandbox = '';
$paypalemail = '';
if (isset($data['paypal'])) {
    $paypalemail = $data['paypal']['email'];
    if ($data['paypal']['sandbox'] == 1) {
        $paypalsandbox = 'checked';
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
      <form action="{{ route('getwaysetup') }}" method="POST">
      {{csrf_field()}}
        <div class="modal-body">
          <div class="form-group">
            <label for="email">Paypal Account Email:</label>
            <input type="hidden" id="getway" name="getway" value="paypal">
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="{{$paypalemail}}" required>
          </div>
          <div class="checkbox">
            <label><input type="checkbox" {{$paypalsandbox}} name="sandbox"> Sandbox</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
