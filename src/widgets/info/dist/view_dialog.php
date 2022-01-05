<?php

Layout()->append('body.js.code', file_get_contents(__dir('service.js')));
Layout()->append('body.js.code', file_get_contents(__dir('view_controller.js')));

Layout()->appendOnce('body.js.code', <<<JS
$(document).on('show.bs.modal', '.modal', function (event) {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function() {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});
JS
);

Layout()->startGrab('body.content.end');
?>
<!-- Modal -->
<div class="modal fade" id="infoViewDialog" ng-controller="infoViewController">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        <h4 class="modal-title">Заголовок</h4>
      </div>
      <div class="modal-body">
        <div ng-if="!loading" class="content"></div>
        <div ng-if="loading">Загрузка...</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="infoLoadDialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        <h4 class="modal-title">Загрузка</h4>
      </div>
      <div class="modal-body">
        <div class="progress">
          <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" style="width: 100%">Загрузка...</div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php 
Layout()->endGrab();
