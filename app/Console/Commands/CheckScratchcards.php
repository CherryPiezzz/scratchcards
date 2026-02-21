<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CheckScratchcards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:scratchcards';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check scratchcards and calculate points based on the input data.';

    protected $input;
    
    /**
     * Execute the console command.
     */
    public function handle()
    {
        if(config('app.env') === 'testing') {
            $this->input = Storage::disk('local')->get('sample_scratchcards.txt');
        }
        else {
            $this->input = Storage::disk('public')->get('input.txt');
        }
        
        // ask if script 1 or script 2 should be run
        $script = $this->choice('Which script do you want to run?', ['Script 1', 'Script 2']);

        $json = $this->convertToJson();

        if($script === 'Script 1') {
            $this->info('Script 1: Convert to JSON');
            $this->info($json);
        }
        else {
            $this->info('Script 2: Calculate Points');

            $points = $this->calculatePoints($json);

            $this->info($points);
        }
    }

    /**
     * Read the input file, sort the data and convert it to a JSON format.
     * 
     * @return string
     */
    private function convertToJson(): string
    {
        $lines = array_filter(explode("\n", trim($this->input)));

        $cards = [];
        
        foreach($lines as $line) {
            $cardNum = explode(':', $line);

            $card = str_replace('Card', '', $cardNum[0]);
            $card = trim($card);

            $numbers = explode('|', $cardNum[1]);

            $winning = array_map('intval', array_filter(explode(' ', trim($numbers[0]))));
            $yours = array_map('intval', array_filter(explode(' ', trim($numbers[1]))));

            sort($winning);
            sort($yours);

            $cards[] = [
                'card' => $card,
                'winning' => $winning,
                'yours' => $yours
            ];
        }
        
        return json_encode($cards, JSON_PRETTY_PRINT);
    }

    /**
     * Calculate points for each card based on the number of matches between winning and yours.
     * 
     * @param string $json
     * @return string
     */
    private function calculatePoints(string $json): string
    {
        $cards = json_decode($json, true);

        $cardPoints = [];
        $totalPoints = 0;

        foreach($cards as &$card) {
            $points = 0;
            $matches = array_intersect($card['winning'], $card['yours']);
            $numMatches = count($matches);

            for($i = 1; $i <= $numMatches; $i++) {
                $points += $i;
            }

            $totalPoints += $points;

            $cardPoints[] = [
                'card' => $card['card'],
                'points' => $points
            ];
        }

        $cardPoints = [
            'cards' => $cardPoints,
            'total_points' => $totalPoints
        ];

        return json_encode($cardPoints, JSON_PRETTY_PRINT);
    }
}
