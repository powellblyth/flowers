<?php

namespace App\Services;

use App\Models\Cup;
use App\Models\CupDirectWinner;
use App\Models\CupWinnerArchive;
use App\Models\CupWinnerArchiveWinner;
use App\Models\Show;
use Illuminate\Support\Facades\DB;

class CupCalculatorService
{
    public function __construct(public Show $show, public Cup $cup)
    {

    }

    /**
     * TODO make this a service
     * @return CupWinnerArchive
     */
    public function calculateWinnerFromPoints(): CupWinnerArchive
    {
        /**
         * @trying to make this select the model iwth the other columns as extra
         * maybe copy this method and keep original for comparison
         */
        $categoryIds = $this->cup->getValidCategoryIdsForShow($this->show);
        $results = collect(DB::select(
            "
            select sum(if(winningplace = '1', 4,0)) as first_place_points, 
                sum(if(winningplace = '2', 3,0) ) as second_place_points, 
                sum(if(winningplace = '3', 2,0)) as third_place_points, 
                sum(if(winningplace = 'commended', 1,0)) as commended_points, 
                sum(
                    if(winningplace = '1', 4,0) 
                        + if(winningplace = '2', 3,0) 
                        + if(winningplace = '3', 2,0) 
                        + if(winningplace = 'commended', 1,0)
                    ) as total_points,
                entrant_id
            
            from entries 
            LEFT JOIN entrants on entrants.id=entries.entrant_id
            where 
                category_id in (" . implode(',', $categoryIds) . ")
                AND entries.show_id = ?
            
            group by entrant_id
            
            having (total_points > 0)
            order by (total_points) desc
",
            [$this->show->id]
        ));

        $cupWinnerArchive = $this->cup->getWinnerArchiveForShow($this->show);
        // Here I clear out ALL the winners and recreate them
        $cupWinnerArchive->winners->each(fn(CupWinnerArchiveWinner $winner) => $winner->delete());

        $counter = 0;
        $counterExDuplicates = 0;
        $lastWinnerPoints = null;
        // I have to save this here because I need the ID
        $cupWinnerArchive->save();
        foreach ($results as $result) {
            $cupWinnerEntrant = new CupWinnerArchiveWinner();
            $cupWinnerEntrant->cupWinnerArchive()->associate($cupWinnerArchive);
            $cupWinnerEntrant->points = $result->total_points;
            $cupWinnerEntrant->entrant_id = $result->entrant_id;

            // If this is not equal placing, then reset the counter to the number required
            if ($lastWinnerPoints !== $result->total_points) {
                $counterExDuplicates++;
            }
            // Now reset the winner points
            $lastWinnerPoints = $result->total_points;
            $cupWinnerEntrant->sort_order = ++$counter;

            $cupWinnerEntrant->save();
            if ($counterExDuplicates >= $this->cup->num_display_results) {
                break;
            }
        }
        return $cupWinnerArchive;
    }

    /**
     * TODO this should be a service
     * @return CupWinnerArchive
     */
    public function calculateWinnerFromJudgeNotes(): CupWinnerArchive
    {
        //TODO no more cupWinner
        /** @var CupDirectWinner $cupWinner */
        $cupWinner = $this->cup->cupDirectWinner()
            ->forShow($this->show)
            ->first();
        $winnerArchive = $this->cup->getWinnerArchiveForShow($this->show);
        $winnerArchive->cupWinner()->associate($cupWinner->entrant);
        // TODO merge these two concepts, create the archive when the winner is selected
        $entry = $cupWinner->winningEntry;

        // Maybe the entry has been added? or removed?
        if ($entry) {
            $winnerArchive->entry()->associate($entry);
            $winnerArchive->cupWinner()->associate($entry->entrant);
        } else {
            $winnerArchive->entry()->dissociate();
            $winnerArchive->cupWinner()->dissociate();
        }
        $winnerArchive->save();
        return $winnerArchive;
    }

}
