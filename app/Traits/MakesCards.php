<?php

namespace App\Traits;

use App\Models\Entry;
use App\Models\Show;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;

trait MakesCards
{
    /**
     * @param Collection<Entry> $entries
     * @return array
     */
    public function getCardDataFromEntries(Collection $entries): array
    {
        $results = ['fronts' => [], 'backs' => []];
        foreach ($entries as $entry) {
            /** @var Entry $entry */
            if ($entry->category) {
                $results['fronts'][] = $entry->getCardFrontData();
                $results['backs'][] = $entry->getCardBackData();
            }
        }
        return $results;
    }

    public function getEntriesQuery(Show $show): Builder
    {
        return Entry::join('entrants', 'entries.entrant_id', '=', 'entrants.id')
            ->join('users', 'users.id', '=', 'entrants.user_id')
            ->join('categories', 'categories.id', '=', 'entries.category_id')
            ->where('categories.show_id', $show->id)
            ->orderBy('users.last_name')
            ->orderBy('entrants.family_name')
            ->orderBy('entrant_id');
    }
}
