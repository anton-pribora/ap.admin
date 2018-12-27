<?php

Layout()->append('body.js.code', file_get_contents(__dir('edit_controller.js')));

Layout()->startGrab('content.end.html');
?>
<form name="form" ng-controller="consultantCommentsEditController">
    <div class="modal fade" id="consultantCommentsEditDialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">{{newItem ? 'Add comment' : 'Edit comment'}}</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Comment</label>
              <textarea class="form-control" ng-model="item.text" rows="10"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" ng-click="submit()">Save</button>
          </div>
        </div>
      </div>
    </div>
</form>
<?php
Layout()->endGrab();