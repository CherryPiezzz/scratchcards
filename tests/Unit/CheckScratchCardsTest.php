<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Console\Commands\CheckScratchcards;

class CheckScratchCardsTest extends TestCase
{
    /**
     * Test for Script 1: Convert to JSON
     * 
     * @return void
     */
    public function testConvertToJson()
    {
        $expectedJson = $this->expectedJson();

        $this->artisan('check:scratchcards')
            ->expectsQuestion('Which script do you want to run?', 'Script 1')
            ->expectsOutput('Script 1: Convert to JSON')
            ->expectsOutput($expectedJson)
            ->assertExitCode(0);
    }

    /**
     * Test for Script 2: Calculate Points
     * 
     * @return void
     */
    public function testCalculatePoints()
    {
        $expectedPoints = $this->expectedPoints();

        $this->artisan('check:scratchcards')
            ->expectsQuestion('Which script do you want to run?', 'Script 2')
            ->expectsOutput('Script 2: Calculate Points')
            ->expectsOutput($expectedPoints)
            ->assertExitCode(0);
    }

    /**
     * Expected output for Script 1: Convert to JSON
     * 
     * @return string
     */
    private function expectedJson(): string
    {
        return json_encode([
            [
                'card' => '1',
                'winning' => [17, 41, 48, 83, 86],
                'yours' => [6, 9, 17, 31, 48, 53, 83, 86]
            ],
            [
                'card' => '2',
                'winning' => [2, 13, 16, 20, 32],
                'yours' => [2, 13, 16, 20, 24, 32, 61, 97]
            ],
            [
                'card' => '3',
                'winning' => [1, 21, 44, 53, 59],
                'yours' => [4, 16, 17, 36, 63, 69, 72, 82]
            ],
            [
                'card' => '4',
                'winning' => [41, 69, 73, 84, 92],
                'yours' => [14, 36, 39, 59, 69, 76, 84, 92]
            ],
            [
                'card' => '5',
                'winning' => [16, 23, 26, 66, 87],
                'yours' => [6, 16, 26, 40, 45, 66, 88, 91]
            ]
        ], JSON_PRETTY_PRINT);
    }

    /**
     * Expected output for Script 2: Calculate Points
     * 
     * @return string
     */
    private function expectedPoints(): string
    {
        return json_encode([
            'cards' => [
                [
                    'card' => '1',
                    'points' => 10
                ],
                [
                    'card' => '2',
                    'points' => 15
                ],
                [
                    'card' => '3',
                    'points' => 0
                ],
                [
                    'card' => '4',
                    'points' => 6
                ],
                [
                    'card' => '5',
                    'points' => 6
                ]
            ],
            'total_points' => 37
        ], JSON_PRETTY_PRINT);
    }
}
