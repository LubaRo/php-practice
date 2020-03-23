<?php

function displayHistogram(int $roundsAmount, callable $rollDie)
{
    $roundsEmptySet = array_fill(0, $roundsAmount, null);
    $roundsResults = array_map($rollDie, $roundsEmptySet);

    $resultsCount = array_count_values($roundsResults);
    $sides = range(1, 6);
    
    $sidesResults = array_map(function ($side) use ($resultsCount, $roundsAmount) {
        $repeats = $resultsCount[$side] ?? 0;
        $rate = $repeats > 0 ? round(($repeats / $roundsAmount) * 100) : 0;

        return [
            'side' => $side,
            'repeats' => $repeats,
            'rate' => $rate
        ];
    }, $sides);

    $rowsAmount = max($resultsCount) + 1;

    $scaleRows = [];
    for ($i = 1; $i <= $rowsAmount; $i++) {
        $resultsRow = array_map(function ($side) use ($i) {
            $repeats = $side['repeats'];
            if ($repeats && $repeats + 1 == $i) {
                $rate = $side['rate'] . '%';
                return str_pad($rate, 3, ' ');
            }
            return $repeats < $i ? '   ' : '###';
        }, $sidesResults);

        $scaleRows[] = implode(' ', $resultsRow);
    }

    $histogramRows = array_reverse($scaleRows);

    $histogramRows[] = str_repeat('-', count($sides) * 3 + count($sides) - 1);
    $histogramRows[] = implode(' ', array_map(function ($side) {
        return " $side ";
    }, $sides));

    $result = implode("\n", $histogramRows);

    echo $result;
}

$func = function () {
    return rand(1, 6);
};

displayHistogram(100, $func);
