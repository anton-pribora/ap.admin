<?php

/* @var $this ApCode\Executor\RuntimeInterface */

$fileId = $this->param('id');
$file   = \Project\File::getInstance($fileId);

if (empty($file->id())) {
    ReturnJsonError('Файл не найден', 'id_not_found');
}

$thumbnail = $file->getThumbnail('big');
$source = $file->getThumbnail('source');

ob_start();
?>
<div class="text-center">
  <figure class="figure">
    <img src="<?=ShortUrl($thumbnail->path(), [], true)?>" class="figure-img img-fluid rounded" alt="<?=Html($file->name())?>">
    <figcaption class="figure-caption">
      <a href="<?=$file->urlAsset('url.download')?>" target="_blank" rel="noopener noreferrer"><i class="bi bi-box-arrow-up-right small me-1"></i>Исходный файл</a>
      [<?=$source->width()?>x<?=$source->height()?>, <?=formatBytes($file->size())?>]
    </figcaption>
  </figure>
</div>


<?php

ReturnJson([
    'title'   => 'Просмотр изображения «' . $file->name() . '»',
    'content' => ob_get_clean(),
    'size'    => 'lg',  // Размер модального окна '', 'sm', 'lg', 'xl'
]);
