<?php
/**
 * @var \Core\Template\TemplateRenderer $this
 * @var string $user_id
 */

$this->addData('title', 'Сбор отчета');
$this->setExtend('layout/default');
?>

<div>
    <h3 style="text-align: center;">Отчет формируется</h3>
    <h5 style="text-align: center;">Для получение отчета перейдите по ссылке: <a href="/get?user_id=<?= $user_id ?>">отчет</a></h5>
</div>