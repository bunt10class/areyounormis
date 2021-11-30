<?php

declare(strict_types=1);

namespace  Tests\Unit\Kinopoisk\Factories;

class HtmlMoviesFactory extends HtmlFactory
{
    protected string $movieListOpening = '<table id="list"><tr><td><div><div class="profileFilmsList">';
    protected string $movieListClosing = '</div></div></td></tr></table>';

    public function getMovieList(array $movies = []): string
    {
        return $this->movieListOpening . $this->getMovieElements($movies) . $this->movieListClosing;
    }

    public function getMovieElements(array $movies): string
    {
        $movieElements = '';

        $numberInOrder = 1;
        foreach ($movies as $movie) {
            if (!is_array($movie)) {
                continue;
            }
            $movieElements .= $this->getMovieElement($movie, $numberInOrder);
            $numberInOrder++;
        }

        return $movieElements;
    }

    public function getMovieElement(array $movie, int $numberInOrder = 1): string
    {
        $numberInOrderElement = $this->collectElement('div', ['class' => 'num'], (string)$numberInOrder);
        $class = $numberInOrder % 2 ? 'item' : 'item even';
        $movieData = $this->collectMovieData($movie);

        return $this->collectElement('div', ['class' => $class], $numberInOrderElement . $movieData);
    }

    protected function collectMovieData(array $movie): string
    {
        $infoElement = $this->collectElement('div', ['class' => 'info'], $this->collectInfoElement($movie));

        $voteDate = $movie['vote_date'] ?? $this->faker->date('d.m.Y, H:i');
        $voteDateElement = $this->collectElement('div', ['class' => 'date'], (string)$voteDate);

        $userVote = $movie['user_vote'] ?? $this->faker->numberBetween(1, 10);
        $userVoteElement = $this->collectElement('div', ['class' => 'vote'], (string)$userVote);

        return $infoElement . $voteDateElement . $userVoteElement;
    }

    protected function collectInfoElement(array $movie): string
    {
        $ruNameElement = $this->collectRuNameElement($movie);

        $enName = $movie['en_name'] ?? $this->faker->domainName;
        $enNameElement = $this->collectElement('div', ['class' => 'nameEng'], (string)$enName);

        $ratingElement = $this->collectRatingElement($movie);

        return $ruNameElement . $enNameElement . $ratingElement;
    }

    protected function collectRuNameElement(array $movie): string
    {
        $link = $movie['link'] ?? 'https://' . $this->faker->domainName;
        $ruName = $movie['ru_name'] ?? $this->faker->domainName;
        $linkElement = $this->collectElement('a', ['href' => $link], (string)$ruName);

        return $this->collectElement('div', ['class' => 'nameRus'], $linkElement);
    }

    protected function collectRatingElement(array $movie): string
    {
        $kpVote = $movie['kp_vote'] ?? $this->faker->randomFloat(3, 1, 10);
        $kpVoteElement = $this->collectElement('b', [], (string)$kpVote);

        $voteNumber = $movie['vote_number'] ?? $this->faker->numberBetween(1, 1000000);
        $voteNumberElement = $this->collectElement('span', [], '(' . $voteNumber . ')');

        $durationInMinutes = $movie['duration_in_minutes'] ?? $this->faker->numberBetween(1, 300);
        $durationElement = $this->collectElement('span', [], $durationInMinutes . ' мин.');

        return $this->collectElement(
            'div',
            ['class' => 'rating'],
            $kpVoteElement . $voteNumberElement . $durationElement
        );
    }
}