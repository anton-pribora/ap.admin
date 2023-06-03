<?php

/* @var $this ApCode\Template\Template */


$data = $this->argument(0, []);

$value = function ($name, $default = null) use ($data) {
    return isset($data[$name]) ? $data[$name] : $default;
};

?>
<form method="post" action="">
  <div class="row mb-3">
    <label for="input.type" class="col-sm-2 col-form-label text-end">Тип профиля</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="type" id="input.type" value="<?=Html($value('type'))?>">
    </div>
  </div>
  <div class="row mb-3">
    <label for="input.name" class="col-sm-2 col-form-label text-end">name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="name" id="input.name" value="<?=Html($value('name'))?>">
    </div>
  </div>
  <div class=" text-end">
    <button type="submit" class="btn btn-default">Сохранить</button>
  </div>
</form>
