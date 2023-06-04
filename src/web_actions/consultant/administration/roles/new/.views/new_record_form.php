<?php

/* @var $this ApCode\Template\Template */


$data = $this->argument(0, []);

$value = function ($name, $default = null) use ($data) {
    return isset($data[$name]) ? $data[$name] : $default;
};

?>
<form method="post" action="">
  <div class="row mb-3">
    <label for="input.tag" class="col-sm-2 col-form-label text-end">Коротая метка</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="tag" id="input.tag" value="<?=Html($value('tag'))?>">
    </div>
  </div>
  <div class="row mb-3">
    <label for="input.name" class="col-sm-2 col-form-label text-end">Название</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="name" id="input.name" value="<?=Html($value('name'))?>">
    </div>
  </div>
  <div class="row mb-3">
    <label for="input.comment" class="col-sm-2 col-form-label text-end">Описание</label>
    <div class="col-sm-10">
      <textarea class="form-control" rows="3" name="comment" id="input.comment"><?=Html($value('comment'))?></textarea>
    </div>
  </div>
  <div class="text-end">
    <button type="submit" class="btn btn-default" name="action" value="save"
            onclick="document.querySelector('#loader').className='spinner-border text-primary spinner-border-sm'; setTimeout(() => this.disabled = true)"
    >
      <i id="loader" class="bi bi-check-lg text-success"></i> Сохранить
    </button>
  </div>
</form>
