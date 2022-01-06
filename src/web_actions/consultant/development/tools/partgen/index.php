<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

RequireLib('vue3');

Layout()->setVar('title', 'Генератор разделов');

Alert('Раздел в стадии разработки', 'warning');

if (Request()->isPost()) {
//    echo '<pre>', print_r($_POST, 1), '</pre>';
    echo '<pre>';

    $this->setParam('part.key', Request()->get('part.key', 'record'));
    $this->setParam('part.name', Request()->get('part.name', '(Без названия)'));
    $this->setParam('part.path', Request()->get('part.path', '@consultant/unknown'));
    $this->setParam('part.table', Request()->get('part.table', 'unknown_table'));
    $this->setParam('part.menu', Request()->get('part.menu', false));
    $this->setParam('part.menuFile', Request()->get('part.menuFile', '@consultant/folder.meta.php'));
    $this->setParam('part.billet', Request()->get('part.billet', 'Project\\Unknown'));
    $this->setParam('part.repository', Request()->get('part.repository', 'Project\\UnknownRepository'));
    $this->setParam('part.recordIdKey', Request()->get('part.recordIdKey', 'record_id'));

    $this->setParam('text.afterRemove', Request()->get('text.afterRemove', 'Запись «{$record->name()}» была удалена'));
    $this->setParam('text.confirmRemove', Request()->get('text.confirmRemove', 'Вы действительно хотите удалить эту запись?'));

    $this->setParam('widget.path', Request()->get('widget.path', 'unknown'));
    $this->setParam('widget.name', Request()->get('widget.name', 'information'));

    $fields = Request()->get('fields', []);
    array_walk($fields, function (&$item) {
        $item += ['view' => false, 'edit' => false, 'search' => false];
    });

    $this->setParam('fields', $fields);

    foreach(glob(__dir('.generate/*.php')) as $file) {
        $this->include($file);
    }

    echo '</pre>';
    return true;
}

?>

<form method="post" action="">

  <h4>Свойства раздела</h4>
  <div class="row mb-3">
    <div class="col">
      <label class="" for="part[name]">Название</label>
      <input type="text" class="form-control" id="part[name]" name="part[name]" value="Слоны">
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="" for="part[key]">Ключ записи</label>
      <input type="text" class="form-control" id="part[key]" name="part[key]" value="elephant">
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <div class="form-check">
        <input type="checkbox" class="form-check-input" name="part[menu]" value="1" checked id="partMenu">
        <label class="form-check-label" for="partMenu">Добавить раздел в левое меню</label>
      </div>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="" for="part[menuFile]">Путь к файлу с меню</label>
      <input type="text" class="form-control" id="part[menuFile]" name="part[menuFile]" value="@consultant/folder.meta.php">
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="" for="part[table]">Базовая таблица</label>
      <input type="text" class="form-control" id="part[table]" name="part[table]" value="elephant">
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="" for="part[billet]">Класс записи</label>
      <input type="text" class="form-control" id="part[billet]" name="part[billet]" value="Project\Elephant">
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="" for="part[repository]">Класс репозитория</label>
      <input type="text" class="form-control" id="part[repository]" name="part[repository]" value="Project\ElephantRepository">
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="" for="part[path]">Путь раздела</label>
      <input type="text" class="form-control" id="part[path]" name="part[path]" value="@consultant/elephant">
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="" for="part[path]">GET-параметр</label>
      <input type="text" class="form-control" id="part[recordIdKey]" name="part[recordIdKey]" value="elephant_id">
    </div>
  </div>

  <h4>Widget</h4>
  <div class="row mb-3">
    <div class="col">
      <label class="" for="widget[path]">Путь виджета</label>
      <input type="text" class="form-control" id="widget[path]" name="widget[path]" value="elephant">
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="" for="widget[name]">Название для виджета свойств</label>
      <input type="text" class="form-control" id="widget[name]" name="widget[name]" value="information">
    </div>
  </div>

  <h4>Запросы и уведомления</h4>
  <div class="row mb-3">
    <div class="col">
      <label class="" for="text[confirmRemove]">Подтверждение удаления</label>
      <input type="text" class="form-control" id="text[confirmRemove]" name="text[confirmRemove]" value="Вы действительно хотите удалить этого слона?">
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="" for="text[afterRemove]">Уведомление после удаления</label>
      <input type="text" class="form-control" id="text[afterRemove]" name="text[afterRemove]" value="Слон «{$record->name()}» был удалён">
    </div>
  </div>


  <h4>Поля записи</h4>
  <table class="table table-striped table-bordered">
    <tr>
      <th title="Просмотр"><i class="bi bi-sunglasses"></i></th>
      <th title="Редактирование"><i class="bi bi-pencil"></i></th>
      <th title="Поиск"><i class="bi bi-search"></i></th>
      <th>Поле</th>
      <th>Название</th>
      <th>Геттер</th>
      <th>Сеттер</th>
      <th>Формат</th>
    </tr>
    <tr>
      <td><input type="checkbox" class="form-check" name="fields[id][view]" value="1"></td>
      <td><input type="checkbox" class="form-check" name="fields[id][edit]" value="1"></td>
      <td><input type="checkbox" class="form-check" name="fields[id][search]" value="1" checked></td>
      <td><input class="form-control" name="fields[id][prop]" value="id"></td>
      <td><input class="form-control" name="fields[id][title]" value="Идентификатор записи"></td>
      <td><input class="form-control" name="fields[id][getter]" value="id"></td>
      <td><input class="form-control" name="fields[id][setter]" value="setId"></td>
      <td><select class="form-select" name="fields[id][format]">
          <option value="">(Не указано)</option>
          <option value="string">Строка</option>
          <option value="text">Текст</option>
          <option value="json">JSON</option>
        </select></td>
    </tr>
    <tr>
      <td><input type="checkbox" class="form-check" name="fields[name][view]" value="1" checked></td>
      <td><input type="checkbox" class="form-check" name="fields[name][edit]" value="1" checked></td>
      <td><input type="checkbox" class="form-check" name="fields[name][search]" value="1" checked></td>
      <td><input class="form-control" name="fields[name][prop]" value="name"></td>
      <td><input class="form-control" name="fields[name][title]" value="Имя"></td>
      <td><input class="form-control" name="fields[name][getter]" value="name"></td>
      <td><input class="form-control" name="fields[name][setter]" value="setName"></td>
      <td><select class="form-select" name="fields[name][format]">
          <option value="">(Не указано)</option>
          <option value="string" selected>Строка</option>
          <option value="text">Текст</option>
          <option value="json">JSON</option>
        </select></td>
    </tr>
    <tr>
      <td><input type="checkbox" class="form-check" name="fields[description][view]" value="1" checked></td>
      <td><input type="checkbox" class="form-check" name="fields[description][edit]" value="1" checked></td>
      <td><input type="checkbox" class="form-check" name="fields[description][search]" value="1"></td>
      <td><input class="form-control" name="fields[description][prop]" value="description"></td>
      <td><input class="form-control" name="fields[description][title]" value="Описание"></td>
      <td><input class="form-control" name="fields[description][getter]" value="description"></td>
      <td><input class="form-control" name="fields[description][setter]" value="setDescription"></td>
      <td><select class="form-select" name="fields[description][format]">
          <option value="">(Не указано)</option>
          <option value="string">Строка</option>
          <option value="text" selected>Текст</option>
          <option value="json">JSON</option>
        </select></td>
    </tr>
  </table>

  <div class="row">
    <div class="col">

    </div>
    <div class="col-1 col-md-2 col-sm-3">
      <button type="submit" class="form-control btn-default">Готово</button>
    </div>
  </div>
</form>
