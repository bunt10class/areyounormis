<?php
/**
 * @var \Core\Template\TemplateRenderer $this
 * @var array $user
 * @var array $votes_system
 * @var array $coefficients
 * @var array $movie_number
 * @var array $movie_votes
 */

$this->addData('title', 'Отчет пользователя');
$this->setExtend('layout/default');
?>

<div class="jumbotron">
    <div class="container">
        <h2 style="text-align: center;">Отчет по оценкам пользователя <?= $user['id'] ?> из Кинопоиска</h2>
        <p style="text-align: right;">Построен по <?= $movie_number ?> оцененным фильмам и сериалам</p>
    </div>
</div>

<?php foreach ($coefficients as $coefficient) { ?>
    <div class="card" style="margin-bottom: 5%">
        <div style="font-weight: bold; text-align: center;">
            <?= $coefficient['name']?>
        </div>
        <div style="text-align: center;">
            <?= $coefficient['description']?>
        </div>
        <br>
        <div style="width: 50%; margin: 0 auto; text-align: center; background-color: <?= $coefficient['level_color'] ?>">
            <?= $coefficient['value'] ?>
            <br>
            <?= $coefficient['level_description'] ?>
        </div>
    </div>
<?php } ?>

<?php
$top = [
    [
        'title' => 'Топ ' . $movie_votes['over_rates']['number'] . ' переоцененных тобой',
        'movie_votes' => $movie_votes['over_rates']['movie_votes'],
    ],
    [
        'title' => 'Топ ' . $movie_votes['under_rates']['number'] . ' недооцененных тобой',
        'movie_votes' => $movie_votes['under_rates']['movie_votes'],
    ],
];
foreach ($top as $data) {
?>

<div class="panel" style="margin-bottom: 5%">
    <p style="text-align: center; font-weight: bold;"><?= $data['title'] ?></p>
    <table class="table">
        <thead style="text-align: center;">
            <tr>
                <th>#</th>
                <th>Название</th>
                <th>Оценка на портале</th>
                <th>Твоя оценка</th>
                <th>Разница</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $number = 1;
            foreach ($data['movie_votes'] as $movieVote) {
            ?>
                <tr>
                    <td style="text-align: center;"><?= $number ?></td>
                    <td>
                        <a
                            href="<?= $movieVote['movie']['link'] ?>"
                            style="text-align: center;"
                        >
                            <?= $movieVote['movie']['name'] ?>
                        </a>
                    </td>
                    <td style="text-align: center;"><?= $movieVote['rate']['site_vote'] ?></td>
                    <td style="text-align: center;"><?= $movieVote['rate']['user_vote'] ?></td>
                    <td style="text-align: center;"><?= abs($movieVote['rate']['absolute_diff']) ?></td>
                </tr>
                <?php $number++ ?>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php } ?>

<div class="panel" style="margin-bottom: 5%">
    <p style="text-align: center; font-weight: bold;">Оценено также как на портале (всего: <?= $movie_votes['norm_rates']['number'] ?>)</p>
    <ul class="list-group">
        <?php foreach ($movie_votes['norm_rates']['movie_votes'] as $movieVote) { ?>
            <li class="list-group-item">
                <a href="<?= $movieVote['movie']['link'] ?>" style="text-align: center;">
                    <?= $movieVote['movie']['name'] ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>
