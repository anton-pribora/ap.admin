<form class="row row-cols-lg-auto g-2 mb-3 align-items-center">
<?php
foreach (Url()->getStaticParams() as $name => $value) {
    echo new ApCode\Html\Element\Input($value, $name, 'hidden');
}
?>
  <div class="col-12">
    <label class="visually-hidden" for="inlineFormInput-tag">Коротая метка</label>
    <input type="text" class="form-control" id="inlineFormInput-tag" placeholder="Коротая метка" value="<?php echo Html($this->param('tag'))?>" name="tag">
  </div>  <div class="col-12">
    <label class="visually-hidden" for="inlineFormInput-name">Название</label>
    <input type="text" class="form-control" id="inlineFormInput-name" placeholder="Название" value="<?php echo Html($this->param('name'))?>" name="name">
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-default">Найти</button>
  </div>
</form>
