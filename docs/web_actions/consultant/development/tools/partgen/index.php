<?php

RequireLib('vue3');

Layout()->setVar('title', 'Генератор разделов');

Alert('Раздел в стадии разработки', 'warning');

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
      <input type="text" class="form-control" id="part[path]" name="part[path]" value="@consulant/elephant">
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <div class="form-check">
        <input type="checkbox" class="form-check-input" name="part[menu]" value="1" checked id="partMenu">
        <label class="form-check-label" for="partMenu">Добавить пункт меню</label>
      </div>
      <div class="">
        <input type="text" class="form-control" name="menuTitle" value="Слоны">
      </div>
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
      <td><input type="checkbox" class="form-check"></td>
      <td><input type="checkbox" class="form-check"></td>
      <td><input type="checkbox" class="form-check" checked></td>
      <td>id</td>
      <td><input class="form-control" value="Идентификатор записи"></td>
      <td><input class="form-control" value="id"></td>
      <td><input class="form-control" value="setId"></td>
      <td><select class="form-select">
          <option value="">Стандартный</option>
          <option value="json">JSON</option>
        </select></td>
    </tr>
    <tr>
      <td><input type="checkbox" class="form-check" checked></td>
      <td><input type="checkbox" class="form-check" checked></td>
      <td><input type="checkbox" class="form-check" checked></td>
      <td>name</td>
      <td><input class="form-control" value="Имя"></td>
      <td><input class="form-control" value="name"></td>
      <td><input class="form-control" value="setName"></td>
      <td><select class="form-select">
          <option value="">Стандартный</option>
          <option value="json">JSON</option>
        </select></td>
    </tr>
    <tr>
      <td><input type="checkbox" class="form-check" checked></td>
      <td><input type="checkbox" class="form-check" checked></td>
      <td><input type="checkbox" class="form-check"></td>
      <td>description</td>
      <td><input class="form-control" value="Описание"></td>
      <td><input class="form-control" value="description"></td>
      <td><input class="form-control" value="setDescription"></td>
      <td><select class="form-select">
          <option value="">Стандартный</option>
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
