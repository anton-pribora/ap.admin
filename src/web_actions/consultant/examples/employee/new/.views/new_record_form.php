<?php

/* @var $this ApCode\Template\Template */


$data = $this->argument(0, []);

$value = function ($name, $default = null) use ($data) {
    return isset($data[$name]) ? $data[$name] : $default;
};

?>
<form method="post" action="">
  <div class="row mb-3">
    <label for="input.name" class="col-sm-2 col-form-label text-end">ФИО</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="name" id="input.name" value="<?=Html($value('name'))?>">
    </div>
  </div>
  <div class="row mb-3">
    <label for="input.post" class="col-sm-2 col-form-label text-end">Должность</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="post" id="input.post" value="<?=Html($value('post'))?>">
    </div>
  </div>
  <div class="row mb-3">
    <label for="input.responsibilities" class="col-sm-2 col-form-label text-end">Обязанности</label>
    <div class="col-sm-10">
      <textarea class="form-control" rows="3" name="responsibilities" id="input.responsibilities"><?=Html($value('responsibilities'))?></textarea>
    </div>
  </div>
  <div class=" text-end">
    <button type="submit" class="btn btn-default">Сохранить</button>
  </div>
</form>