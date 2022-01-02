<?php
RequireLib('vue3');
RequireLib('datepicker');
RequireLib('toast');
RequireLib('confirm');

Layout()->append('body.js.code', file_get_contents(__dir('plankton.js')));

Layout()->append('body.js.code', file_get_contents(__dir('inc/offices/store.js')));

Layout()->append('body.js.code', file_get_contents(__dir('inc/users/store.js')));
Layout()->append('content.end.html', file_get_contents(__dir('inc/users/viewForm.html')));
Layout()->append('body.js.code', file_get_contents(__dir('inc/users/viewFormController.js')));
Layout()->append('content.end.html', file_get_contents(__dir('inc/users/editDialog.html')));
Layout()->append('body.js.code', file_get_contents(__dir('inc/users/editDialogController.js')));

Layout()->append('content.end.html', file_get_contents(__dir('inc/json/viewForm.html')));
Layout()->append('body.js.code', file_get_contents(__dir('inc/json/viewFormController.js')));

Layout()->append('body.js.code', file_get_contents(__dir('mount.js')));

?>
<div class="card w-50">
  <div class="card-header">
    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Планктошки</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Офисы</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">JSON</button>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <users-view></users-view>
      </div>
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <h2>Офисы</h2>
        <div class="card">
          <div class="card-body pt-0">
            <!--#.include virtual="/plankton/offices/viewForm.html"-->
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        <h2>JSON</h2>
        <div class="card">
          <div class="card-body">
            <plankton-json></plankton-json>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
