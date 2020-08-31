<?php

declare(strict_types=1);

function removePunctuationMarks(string $string): string
{
    return str_replace(
        ['.', ',', '!','?'],
        '' ,
        $string);
}

function removeWhiteSpace(string $string): string
{
    return preg_replace("/\s+/", " ", $string);
}

function cutToArray(string $string): array
{
    return explode(" ", $string);
}

function getWordsWithMoreThenThreeLetters(array $array): array
{
   return array_values(
       array_filter($array, fn(string $string) => strlen($string) > 3));
}

function convertToLowerCase(array $array): array
{
    return array_map(fn(string $string) => strtolower($string), $array);
}

function sortByWordCountDESCThenByWordASC(array $array): array
{
    $word_count = array_keys($array);
    $word = array_values($array);
    array_multisort($word, SORT_DESC, $word_count, SORT_ASC);
    return array_combine($word_count, $word);
}

function normalize(array $array): array
{
    return array_map(function ($word, $count) {
        return [
            'word' => $word,
            'count'  => $count,
            'stars' => ''
        ];
    }, array_keys($array), $array);
}

function addStars(array $array): array
{
    $counter = 1;
    foreach ($array as &$element) {
        switch ($counter) {
            case 1:
                $element['stars'] = '***';
                break;
            case 2:
                $element['stars'] = '**';
                break;
            case 3:
                $element['stars'] = '*';
                break;
            default:
                $element['stars'] = '-';
        }
        $counter++;
    }

    return $array;
}

function transform(string $string): array
{
    return compose(
        'removePunctuationMarks',
        'removeWhiteSpace',
        'cutToArray',
        'getWordsWithMoreThenThreeLetters',
        'convertToLowerCase',
        'array_count_values',
        'sortByWordCountDESCThenByWordASC',
        'normalize',
        'addStars'
    )($string);
}

function compose(...$functions)
{
    return array_reduce(
        $functions,
        function ($chain, $function) {
            return function ($input) use ($chain, $function) {
                return $function($chain($input));
            };
        },
        fn($value) => $value
    );
}