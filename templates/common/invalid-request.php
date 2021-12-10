<?php
/**
 * @var \Core\Template\TemplateRenderer $this
 * @var $error_message
 */

$this->addData('title', 'Ошибка');
$this->setExtend('layout/default');
?>

<div class="text-center">
    <p style="color: red">Не валидный запрос: <?= $error_message ?></p>
</div>