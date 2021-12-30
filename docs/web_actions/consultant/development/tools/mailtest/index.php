<?php

Layout()->setVar('title', 'Отправить письмо');

$errors   = [];
$messages = [];

$defaultConfig = [
    'defaultFrom' => Config()->get('mail.defaultFrom', 'mymail@example.org'),
    'onError'     => function($error) use (&$errors) { $errors[] = $error; },
    'afterSend'   => function($text) use (&$messages) { $messages[] = $text; },
    'transports'  => [
        'smtp' => ['smtp', 'host' => 'smtp.yandex.ru', 'ssl' => 'true', 'port' => '465', 'login' => '****@yandex.ru', 'password' => '******'],
    ],
];

foreach (Config()->get('mail.transports') as $row) {
    if ($row['type'] == 'smtp') {
        $defaultConfig['transports']['smtp'] = $row;
        $defaultConfig['transports']['smtp']['password'] = 123;
    }
}

$config = array_replace_recursive($defaultConfig, Request()->get('config', []));

$configValue = function ($key, $default = NULL) use ($config) {
    $key = '["'. strtr($key, ['.' => '"]["']) .'"]';
    return eval("return isset(\$config{$key}) ? \$config{$key} : \$default;");
};

$messageFrom    = Request()->get('from'    , '');
$messageTo      = Request()->get('to'      , 'test@example.com');
$messageReplyTo = Request()->get('reply-to', 'test@example.com');
$messageSubject = Request()->get('subject' , 'Проверка связи');
$messageText    = Request()->get('text'    , "<p>Привет, мир!</p>");

if (Request()->get('send')) {
    Mailer()->init($config);

    $message = Mailer()->newHtmlMessage();

    if ($messageSubject) {
        $message->setSubject($messageSubject);
    }

    if ($messageFrom) {
        $message->setSenderEmail($messageFrom);
    }

    if ($messageTo) {
        $message->addRecipient($messageTo);
    }

    if ($messageReplyTo) {
        $message->addReplyTo($messageReplyTo);
    }

    $layout = Layout('@layout.mail');
    $layout->reset();
    $layout->append('body.content', $messageText);

    $message->setContent($layout->display(true));

    if (isset($_FILES['attachment']['size']) && $_FILES['attachment']['size'] > 0) {
        $message->addAttachmentFile(
            $_FILES['attachment']['tmp_name'],
            $_FILES['attachment']['name'],
            $_FILES['attachment']['type']
        );
    }

    Mailer()->sendMessage($message);
}

?>
    <form action="" method="post" enctype="multipart/form-data">
      <fieldset>
        <div class="form-group">
          <label class="col-2 col-form-label">Отправитель по умолчанию</label>
          <div class="col-10">
            <input class="form-control" type="text" name="config[defaultFrom]" value="<?=Html($configValue('defaultFrom'))?>">
          </div>
        </div>

        <div class="form-group">
          <label class="col-2 col-form-label">SMTP</label>
          <div class="col-10">
            <input type="hidden" name="config[transports][smtp][0]" value="smtp">
            <label>
              SSL
              <select class="form-select" name="config[transports][smtp][ssl]">
                <option value="true" <?=in_array((string) $configValue('transports.smtp.ssl'), ['true', '1']) ? 'selected' : ''?>>Да</option>
                <option value="false" <?=in_array((string) $configValue('transports.smtp.ssl'), ['false', '', '0']) ? 'selected' : ''?>>Нет</option>
              </select>
            </label>
            <label>
              Хост
              <input class="form-control" type="text" name="config[transports][smtp][host]" value="<?=Html($configValue('transports.smtp.host'))?>">
            </label>
            <label>
              Порт
              <input class="form-control" type="text" name="config[transports][smtp][port]" value="<?=Html($configValue('transports.smtp.port'))?>">
            </label>
            <label>
              Логин
              <input class="form-control" type="text" name="config[transports][smtp][login]" value="<?=Html($configValue('transports.smtp.login'))?>">
            </label>
            <label>
              Пароль
              <input class="form-control" type="text" name="config[transports][smtp][password]" value="<?=Html($configValue('transports.smtp.password'))?>">
            </label>
          </div>
        </div>

      </fieldset>

<?php foreach ($messages as $text) {?>
<div class="alert alert-info">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <div><?php echo $text?></div>
</div>
<?php }?>

<?php foreach ($errors as $text) {?>
<div class="alert alert-danger">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <div><?php echo $text?></div>
</div>
<?php }?>

      <fieldset>
        <legend>Сообщение</legend>

        <div class="form-group">
          <label class="col-2 col-form-label">От</label>
          <div class="col-10">
            <input class="form-control" type="text" name="from" value="<?=Html($messageFrom)?>">
            <p class="help-block small text-muted">Если значение не указано, будет использоваться Отправитель поумолчанию</p>
          </div>
        </div>

        <div class="form-group">
          <label class="col-2 col-form-label">Кому</label>
          <div class="col-10">
            <input class="form-control" type="text" name="to" value="<?=Html($messageTo)?>">
          </div>
        </div>

        <div class="form-group">
          <label class="col-2 col-form-label">Обратный адрес (reply to)</label>
          <div class="col-10">
            <input class="form-control" type="text" name="reply-to" value="<?=Html($messageReplyTo)?>">
          </div>
        </div>

        <div class="form-group">
          <label class="col-2 col-form-label">Тема</label>
          <div class="col-10">
            <input class="form-control" type="text" name="subject" value="<?=Html($messageSubject)?>">
          </div>
        </div>

        <div class="form-group">
          <label class="col-2 col-form-label">Текст сообщения</label>
          <div class="col-10">
            <textarea class="form-control" name="text" rows="10"><?=Html($messageText)?></textarea>
          </div>
        </div>

        <div class="form-group">
          <label class="col-2 col-form-label">Вложение</label>
          <div class="col-10">
            <input class="form-control-file" type="file" name="attachment">
          </div>
        </div>

        <div class="form-group">
          <label class="col-2 col-form-label"></label>
          <div class="col-10">
            <input class="btn btn-primary" type="submit" name="send" value="Отправить">
          </div>
        </div>

      </fieldset>
    </form>
