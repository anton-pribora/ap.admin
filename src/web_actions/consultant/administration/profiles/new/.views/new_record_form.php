<?php

/* @var $this ApCode\Template\Template */


$data = $this->argument(0, []);

$value = function ($name, $default = '') use ($data) {
    $params = explode('.', $name);
    return eval('return $data["'. join('"]["', $params) .'"] ?? $default;');
};

$labelClass = 'col-sm-2 col-form-label text-end';
$valueClass = 'col-sm-10 col-md-8 col-lg-6';

?>
<form method="post" action="">
  <div class="row mb-3 mt-5">
    <label for="input.name" class="<?= $labelClass ?>"></label>
    <div class="<?= $valueClass ?>">
      <div class="row">
        <div class="col">
          <div class="form-floating">
            <input type="text" class="form-control" value="<?= Html($value('name.last')) ?>" name="data[name][last]"
                   autocomplete="off" id="name.last" placeholder="Фамилия">
            <label for="name.last">Фамилия</label>
          </div>
          <div id="t_last" class="px-3 pt-2 small text-muted"></div>
        </div>
        <div class="col">
          <div class="form-floating">
            <input type="text" class="form-control" value="<?= Html($value('name.first')) ?>" name="data[name][first]"
                   autocomplete="off" id="name.first" placeholder="Имя">
            <label for="name.first">Имя</label>
          </div>
          <div id="t_first" class="px-3 pt-2 small text-muted"></div>
        </div>
        <div class="col">
          <div class="form-floating">
            <input type="text" class="form-control" value="<?= Html($value('name.middle')) ?>" name="data[name][middle]"
                   autocomplete="off" id="name.middle" placeholder="Отчество">
            <label for="name.middle">Отчество</label>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="mb-3 row">
    <label class="<?= $labelClass ?>"></label>
    <div class="<?= $valueClass ?>">
      <div class="form-floating">
        <input type="text" class="form-control" value="<?= Html($value('post')) ?>" name="data[post]" id="post"
               placeholder="Должность">
        <label for="post">Должность</label>
      </div>
    </div>
  </div>

  <div class="mb-3 row">
    <label class="<?= $labelClass ?>"></label>
    <div class="<?= $valueClass ?>">
      <div class="form-floating">
        <textarea class="form-control" name="data[comment]" id="comment" placeholder="Заметки" style="height: 100px"><?= Html($value('comment')) ?></textarea>
        <label for="comment">Заметки</label>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-2"></div>
    <div class="<?= $valueClass ?>">
      <div class="text-end">
        <button type="submit" class="btn btn-default ms-auto" name="action" value="save"
                onclick="document.querySelector('#loader').className='spinner-border text-primary spinner-border-sm'; setTimeout(() => this.disabled = true)"
        >
          <i id="loader" class="bi bi-check-lg text-success"></i> Сохранить
        </button>
      </div>
    </div>
  </div>
</form>
