 <div class="modal fade" id="payment-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Payment </h4><small>Permit Billing</small>
        </div>
        <div class="modal-body">
        <box class="header">
          <p class="fee-name"></p>
        </box>
          <div class="box-body">
            <input type="hidden" class="fee-id">
            <div class="form-group">
              <label class="control-label">Fee : </label>
              <input class="form-control fee-price" disabled>
            </div>
            <div class="form-group">
              <label class="control-label"> OR # : </label>
              <input class="form-control fee-or-no" type="text">
            </div>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button id="pay-fee" type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
