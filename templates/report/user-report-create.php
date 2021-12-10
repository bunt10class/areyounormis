<?php
/**
 * @var \Core\Template\TemplateRenderer $this
 * @var $error_message
 */

$this->addData('title', 'Составить отчет');
$this->setExtend('layout/default');
?>

<?php if (isset($error_message)) { ?>
    <div class="text-center">
        <p style="color: red">Неверные данные: <?= $error_message ?></p>
    </div>
<?php } ?>

<form method="post" action="/collect">
    <h2 style="text-align: center; margin-bottom: 40px">Составить отчет</h2>

    <div style="text-align: center; margin-bottom: 40px">
        Ресурс
        <select name="resource">
            <option value="kinopoisk">Кинопоиск</option>
        </select>
    </div>

    <div style="text-align: center; margin-bottom: 40px">
    Твой идентификатор<br>на данном ресурсе<br>
    <input type="text" name="user_id">
    </div>

    <div style="text-align: center;">
        <input type="submit" value="Собрать">
    </div>
</form>