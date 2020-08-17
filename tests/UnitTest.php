<?php

use PHPUnit\Framework\TestCase;

class UnitTest extends TestCase
{
    public function testRemovePunctuationMarks()
    {
        $input = 'dot. comma, exclamation! question?';
        $output = removePunctuationMarks($input);

        $this->assertSame(
            'dot comma exclamation question',
            $output);
    }

    public function testRemoveWhiteSpace()
    {
        $input = "This   is a    simple \npiece\tof text";
        $output = removeWhiteSpace($input);
        $this->assertSame(
            'This is a simple piece of text',
            $output);
    }

    public function testCutToArray()
    {
        $input = 'hello world Hello World php';
        $output = cutToArray($input);

        $this->assertSame(
            ['hello', 'world', 'Hello', 'World', 'php'],
            $output);
    }

    public function testGetWordsWithMoreThenThreeLetters()
    {
        $input = ['one', 'two', 'three', 'four', 'six', 'seven'];
        $output = getWordsWithMoreThenThreeLetters($input);

        $this->assertSame(
            ['three', 'four', 'seven'],
            $output);
    }

    public function testConvertToLowerCase()
    {
        $input = ['Hello', 'world', 'hello', 'world', 'PHP'];
        $output = convertToLowerCase($input);

        $this->assertSame(
            ['hello', 'world', 'hello', 'world', 'php'],
            $output);
    }

    public function testCountWords()
    {
        $input = ['hello', 'world', 'hello', 'world', 'php'];
        $output = array_count_values($input);

        $this->assertSame(
            [
                'hello' => 2,
                'world' => 2,
                'php' => 1
            ],
            $output);
    }

    public function testSortByWordCountDESCThenByWordASC()
    {
        $input = [
            'e' => 3,
            'b' => 2,
            'a' => 2,
            'd' => 1,
            'c' => 1,
        ];

        $output = sortByWordCountDESCThenByWordASC($input);

        $this->assertSame(
            [
                'e' => 3,
                'a' => 2,
                'b' => 2,
                'c' => 1,
                'd' => 1,
            ],
            $output);
    }

    public function testNormalize()
    {
        $input = [
            'hello' => 2,
            'world' => 1
        ];

        $output = normalize($input);

        $this->assertSame(
            [
                ['word' => 'hello', 'count' => 2, 'stars' => ''],
                ['word' => 'world', 'count' => 1, 'stars' => '']
            ],
            $output
        );
    }

    public function testAddStars()
    {
        $input = [
            ['word' => 'one', 'count' => 5, 'stars' => ''],
            ['word' => 'two', 'count' => 4, 'stars' => ''],
            ['word' => 'three', 'count' => 3, 'stars' => ''],
            ['word' => 'four', 'count' => 2, 'stars' => ''],
            ['word' => 'five', 'count' => 1, 'stars' => ''],
        ];

        $output = addStars($input);

        $this->assertSame(
            [
                ['word' => 'one', 'count' => 5, 'stars' => '***'],
                ['word' => 'two', 'count' => 4, 'stars' => '**'],
                ['word' => 'three', 'count' => 3, 'stars' => '*'],
                ['word' => 'four', 'count' => 2, 'stars' => '-'],
                ['word' => 'five', 'count' => 1, 'stars' => '-'],
            ],
            $output);
    }

    public function testTransform()
    {
        $input = 'hello world Hello World. 
                  php.
                  Mario Brothers & Luigi';

       $output = transform($input);

        $this->assertSame(
            [
                ['word' => 'hello', 'count' => 2, 'stars' => '***'],
                ['word' => 'world', 'count' => 2, 'stars' => '**'],
                ['word' => 'brothers', 'count' => 1, 'stars' => '*'],
                ['word' => 'luigi', 'count' => 1, 'stars' => '-'],
                ['word' => 'mario', 'count' => 1, 'stars' => '-'],
            ],
            $output);
    }
}
