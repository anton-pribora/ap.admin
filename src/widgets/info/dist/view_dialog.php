<?php

RequireLib('vue3');

Layout()->append('body.js.code', file_get_contents(__dir('view_controller.js')));

Layout()->startGrab('body.content.end');
?>
<div type="text/html" id="infoDialog">
  <div class="modal fade" tabindex="-1" ref="modal">
    <div class="modal-dialog" :class="['modal-' + modalSize]">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            <div v-if="loading">
              Загрузка...
            </div>
            <div v-if="!loading">{{title || 'Информация'}}</div>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div v-if="loading">
            <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
            Загрузка...
          </div>
          <div v-if="!loading" v-html="content"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
Layout()->endGrab();
