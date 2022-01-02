<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Site\Consultant */

$consultant = $this->argument();
$enableEdit = $this->param('enableEdit');

if ($enableEdit) {
    Module('widgets')->execute('uploader/enable.php');
}

RequireLib('image-viewer');

?>
<div class="panel panel-default" ng-controller="consultantInformationViewController">
    <div class="panel-heading">
        <?php echo Icon('profile')?> Пользователь
<?php if ($enableEdit) {?>
        <div class="pull-right">
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-xs" ng-click="edit()">
                  <i class="fa fa-edit"></i> Изменить
                </button>
                  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="" ng-click="editLogin()"><i class="fa fa-key"></i> Логин и пароль</a></li>
                    <li class="divider"></li>
                    <li><a href="" ng-click="drop()"><?php echo Icon('remove')?> Удалить</a></li>
                  </ul>
            </div>
        </div>
<?php }?>
    </div>
      <div class="row">
        <div class="col-md-4" style="padding: 10px 0px 10px 30px;">
          <div class="text-center">
              <a ng-href="{{consultant.source.url}}" class="img-thumbnail image-view" ng-file-upload-func="upload" ng-file-upload-arg="consultant">
                <img ng-src="{{consultant.thumbnail.url}}" class="img img-responsive" width="{{consultant.thumbnail.width}}" height="{{consultant.thumbnail.height}}">
              </a>
          </div>
          
<?php if ($enableEdit) {?>
          <form>
            <input type="file" id="thumbnailPicker" style="display: none" onchange="doUploadThumbnail(this.files)" accept="image/x-png,image/gif,image/jpeg">
          </form>
        
          <div class="text-center" style="padding-top: 4px;">
            <!-- Split button -->
            <div class="btn-group">
              <button type="button" class="btn btn-default" title="Upload photo" ng-click="upload(null, consultant);">
                <i class="fa fa-upload"></i> Загрузить
              </button>
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li><a href="" ng-click="removePhoto()"><i class="fa fa-trash-o"></i> Удалить</a></li>
              </ul>
            </div>
          </div>
<?php }?>

        </div>

        <div class="col-md-8">
          <table class="table table-condensed" style="margin:0px;">
            <tr>
              <th>Имя</th>
              <td>{{consultant.display_name}}</td>
            </tr>
            <tr>
              <th>Должность</th>
              <td>{{consultant.post}}</td>
            </tr>
            <tr>
              <th>Роль</th>
              <td>{{consultant.role.name}}</td>
            </tr>
            <tr>
              <th>Почта</th>
              <td>
                <div ng-bind-html="consultant.email | linky"></div>
              </td>
            </tr>
            <tr>
              <th>Телефон</th>
              <td>
                <div ng-bind-html="consultant.phone | linky"></div>
              </td>
            </tr>
            <tr>
              <th>Skype</th>
              <td>{{consultant.skype}}</td>
            </tr>
          </table>
        </div>
      </div>
</div>