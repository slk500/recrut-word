<?php

use PHPUnit\Framework\TestCase;

// I use snake_case for functional tests for better readability - I know it's against PSR
class FunctionalTest extends TestCase
{
    public function test_case_insensitive_when_comparing_words()
    {
        $input = 'hello world Hello World';

        $output = transform($input);

        $this->assertSame(
            [
                ['word' => 'hello', 'count' => 2, 'stars' => '***'],
                ['word' => 'world', 'count' => 2, 'stars' => '**']
            ],
            $output);
    }

    public function test_only_words_with_more_than_three_letters_should_be_considered()
    {
        $input = 'hello world Hello World php';
        $output = transform($input);

        $this->assertSame(
            [
                ['word' => 'hello', 'count' => 2, 'stars' => '***'],
                ['word' => 'world', 'count' => 2, 'stars' => '**']
            ],
            $output);
    }

    public function test_the_result_is_sorted_first_by_word_count_DESC_and_then_by_word_ASC()
    {
        $input = 'elixir elixir elixir boom boom aircraft aircraft doom close';

        $output = transform($input);

        $this->assertSame(
            [
                ['word' => 'elixir', 'count' => 3, 'stars' => '***'],
                ['word' => 'aircraft', 'count' => 2, 'stars' => '**'],
                ['word' => 'boom', 'count' => 2, 'stars' => '*'],
                ['word' => 'close', 'count' => 1, 'stars' => '-'],
                ['word' => 'doom', 'count' => 1, 'stars' => '-'],
            ],
            $output);
    }

    public function test_stars_are_displayed_for_the_first_3_words_3_2_1_a_dash_for_rest()
    {
        $input = 'elixir elixir elixir boom boom aircraft aircraft doom close';

        $output = transform($input);

        $this->assertSame($output[0]['stars'], '***');
        $this->assertSame($output[1]['stars'], '**');
        $this->assertSame($output[2]['stars'], '*');
        $this->assertSame($output[3]['stars'], '-');
        $this->assertSame($output[4]['stars'], '-');
    }
}
