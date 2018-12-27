<?php

use Site\Consultant;

/* @var $this ApCode\Executor\RuntimeInterface */

$consultantId = $this->param('consultantId');
$consultant   = Consultant::getInstance($consultantId);

$info = $consultant->info();

if (empty($consultant->id())) {
    ReturnJsonError('Пользователь не найден', 'id_fot_found');
}

$data = [
    'Должность' => $info->post(),
    'Телефон'   => activateUrls($info->phone()),
    'Почта'     => activateUrls($info->email()),
    'Skype'     => $info->skype(),
];

ob_start();
?>
<div class="row">
  <div class="col-md-4">
    <div class="text-center">
      <img src="<?php echo $consultant->thumbnail('medium')->url()?>" class="img-responsive img-rounded">
    </div>
  </div>
  <div class="col-md-8">
    <div>
          <table class="table table-condensed">
<?php foreach ($data as $name => $value) {?>
              <tr>
                <th style="white-space: nowrap; width: 1%;"><?php echo $name?></th>
                <td><?php echo $value?></td>
              </tr>
<?php }?>
          </table>
    </div>
  </div>
</div>

<?php

ReturnJson([
    'title'   => $consultant->name(),
    'content' => ob_get_clean(),
    'large'   => false,
]);