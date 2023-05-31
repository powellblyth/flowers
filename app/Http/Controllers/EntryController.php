<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Entrant;
use App\Models\Entry;
use App\Models\Section;
use App\Models\Show;
use App\Models\User;
use App\Traits\Controllers\HasShowSwitcher;
use App\Traits\MakesCards;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EntryController extends Controller
{
    use HasShowSwitcher;
    use MakesCards;

    public function creates(Request $request): RedirectResponse
    {
//        foreach ($request->input('categories') as $category) {
//            if (0 !== (int)$category) {
//                die('hi');
//                $entry = new Entry;
//                $entry->category_id = (int) $category;
//                $entry->entrant_id = (int) $request->input('entrant');
//                $entry->year = (int) config('app.year');
//                $entry->save();
//            }
//        }
        return redirect()->route('entrants.show', ['entrant' => $request->input('entrant')]);
    }

    /**
     * referenced by nova
     */
    public function printAllCards(Request $request, Show $show): Application|Factory|\Illuminate\Contracts\View\View
    {
        $entriesQuery = $this->getEntriesQuery($show);
        if ($request->filled('since')) {
            $entriesQuery->where('entries.updated_at', '>', Carbon::now()->subMinutes((int) $request->since));
        }

        $cardData = $this->getCardDataFromEntries($entriesQuery->get());

        return view('cards.printcards', [
            'card_fronts' => $cardData['fronts'],
            'card_backs' => $cardData['backs'],
        ]);
    }

    /**
     * @param Request $request
     * @param User|null $user
     * @return View
     * @throws AuthorizationException
     */
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

        $this->authorize('view', $user);

        return view('entries.entryCard', [
            'user' => $user,
            'categories' => $show
                ->categories
                ->reject(fn(Category $category) => $category->private === true),
            'show' => $show,
            'showId' => $show->id,
            'can_enter' => !$show->isClosedToEntries(),
            'sections' => Section::all(),
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Request $request, User $user = null): Redirector|Application|RedirectResponse
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
            $entrant
                ->entries()
                ->where('show_id', $show->id)
                ->whereNotIn('category_id', array_keys($entries))
                ->delete();

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
