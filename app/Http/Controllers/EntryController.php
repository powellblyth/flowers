<?php

namespace App\Http\Controllers;

use App\Models\Entrant;
use App\Models\Entry;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
     * referenced by nova
     */
    public function printallcards(Request $request): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $show = $this->getShowFromRequest($request);

        $categoryData = [];
        $entriesQuery = Entry::join('entrants', 'entries.entrant_id', '=', 'entrants.id')
            ->join('users', 'users.id', '=', 'entrants.user_id')
            ->join('categories', 'categories.id', '=', 'entries.category_id')
            ->where('categories.show_id', $show->id)
            ->orderBy('users.last_name')
            ->orderBy('entrants.family_name')
            ->orderBy('entrant_id');

        if ($request->filled('users')) {
            $entriesQuery->whereIn('users.id', (array) $request->users);
        }
        if ($request->filled('entrants')) {
            $entriesQuery->whereIn('entrants.id', (array) $request->entrants);
        }
        if ($request->filled('since')) {
            $entriesQuery->where('entries.updated_at', '>', Carbon::now()->subMinutes((int) $request->since));
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

    public function entryCard(Request $request, User $user = null): View
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        $user->load(['entrants', 'entrants.entries']);
        /**
         * Default show
         */
        $show = $this->getShowFromRequest($request);
//        $show->load('categories');

        $this->authorize('view', $user);

        return view('entries.entryCard', [
            'user' => $user,
            'show' => $show,
            'showId' => $show->id,
            'can_enter' => !$show->isClosedToEntries(),
            'sections' => \App\Models\Section::all(),
        ]);
    }

    public function update(Request $request, User $user = null)
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        $user->load(['entrants', 'entrants.entries']);
        /**
         * Default show
         */
        $show = $this->getShowFromRequest($request);

        $this->authorize('enterCategories', $show);
        foreach ($request->entries as $entrantId => $entries) {
            /** @var Entrant $entrant */
            $entrant = $user->entrants->where('id', $entrantId)->firstOrFail();
            $this->authorize('createEntries', $entrant);
            $entrant->entries()->where('show_id', $show->id)->whereNotIn('category_id', array_keys($entries))->delete();
            foreach ($entries as $categoryId => $discarded) {
                Entry::firstOrCreate(
                    [
                        'category_id' => $categoryId,
                        'entrant_id' => $entrant->id,
                        'show_id' => $show->id,
                    ]
                );
            }
        }
        return redirect(route('entries.entryCard', ['show_id' => $show->id]));
    }
}
