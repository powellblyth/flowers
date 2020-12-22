<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    public function creates(Request $request)
    {
        if (0 < count($request->input('categories'))) {
            foreach ($request->input('categories') as $category) {
                if ('0' !== $category) {
                    $entry              = new Entry;
                    $entry->category_id = (int) $category;
                    $entry->entrant_id  = (int) $request->input('entrant');
                    $entry->year        = (int) config('app.year');
                    $entry->save();
                }
            }
        }
        return redirect()->route('entrants.show', ['entrant'=> $request->input('entrant')]);
    }

    public function printallcards()
    {
        $categoryData = [];
        $entries      = Entry::join('entrants', 'entries.entrant_id', '=', 'entrants.id')->join('users', 'users.id', '=', 'entrants.user_id')
            ->where('year', config('app.year'))->orderBy('users.lastname')->orderBy('entrants.familyname')->orderBy('entrant_id')->get();
        $cardFronts   = [];
        $cardBacks    = [];

        foreach ($entries as $entry) {
            if ($entry->category) {
                $categoryData[$entry->category->id] = $entry->category;
                $cardFronts[]                       = $entry->getCardFrontData();
                $cardBacks[]                        = $entry->getCardBackData();
            }
        }

        return view('cards.printcards', [
            'card_fronts' => $cardFronts,
            'card_backs'  => $cardBacks,
        ]);
    }
}
