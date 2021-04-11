<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    public function creates(Request $request)
    {
        foreach ($request->input('categories') as $category) {
            if ('0' !== $category) {
                $entry = new Entry;
                $entry->category_id = (int) $category;
                $entry->entrant_id = (int) $request->input('entrant');
                $entry->year = (int) config('app.year');
                $entry->save();
            }
        }
        return redirect()->route('entrants.show', ['entrant' => $request->input('entrant')]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * referenced by nova
     */
    public function printallcards(Request $request)
    {
        $show = $this->getShowFromRequest($request);

        $categoryData = [];
        $entriesQuery = Entry::join('entrants', 'entries.entrant_id', '=', 'entrants.id')
            ->join('users', 'users.id', '=', 'entrants.user_id')
            ->join('categories', 'categories.id', '=', 'entries.category_id')
            ->where('categories.show_id', $show->id)
            ->orderBy('users.lastname')
            ->orderBy('entrants.familyname')
            ->orderBy('entrant_id');

        if ($request->filled('users')) {
            $entriesQuery->whereIn('users.id', (array) $request->users);
        }
        if ($request->filled('entrants')) {
            $entriesQuery->whereIn('entrants.id', (array) $request->entrants);
        }
        if ($request->filled('since')) {
            $entriesQuery->where('entries.updated_at', '>', Carbon::now()->subMinutes((int)$request->since));
        }
        $cardFronts = [];
        $cardBacks = [];

        foreach ($entriesQuery->get() as $entry) {
            /**
             * @var Entry $entry
             */
            if ($entry->category) {
                $categoryData[$entry->category->id] = $entry->category;
                $cardFronts[] = $entry->getCardFrontData();
                $cardBacks[] = $entry->getCardBackData();
            }
        }

        return view('cards.printcards', [
            'card_fronts' => $cardFronts,
            'card_backs' => $cardBacks,
        ]);
    }
}
