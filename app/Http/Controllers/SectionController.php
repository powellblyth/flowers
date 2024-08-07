<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Section;
use App\Models\Show;
use App\Traits\Controllers\HasShowSwitcher;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SectionController extends Controller
{
    use HasShowSwitcher;

    public function index(Request $request): View
    {
        $show = $this->getShowFromRequest($request);
        $sections = $show->sections()->inOrder()->get();
        return view(
            'sections.index',
            [
                'things' => $sections,
                'isAdmin' => Auth::check() && Auth::User()->isAdmin()
            ]
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function resultsEntryForm(Request $request, Show $show, Section $section): View
    {
        if (!$show->exists) {
            $show = $this->getShowFromRequest($request);
        }

        $this->authorize('enterResults', Entry::class);
        $section->load([
            'categories',
            'categories.entries',
            'categories.entries.entrant',
        ]);
        return view('sections.resultsentry', array(
            'section' => $section,
            'winning_places' => [
                0 => 'Choose...',
                '1' => 'First Place',
                '2' => 'Second Place',
                '3' => 'Third Place',
                'commended' => 'Commended',
            ],
            'show' => $show,
        ));
    }

    /** @TODO why do I need the show here? */
    public function storeresults(Request $request, Show $show, Section $section): RedirectResponse
    {
        $winningPlaces = [
            'Choose...',
            '1',
            '2',
            '3',
            'commended' => 'Commended',
        ];
        $this->authorize('enterResults', Entry::class);
        foreach ($request->entries as $entryId => $placing) {
            if (array_key_exists($placing, $winningPlaces)) {
                $entry = Entry::findOrFail($entryId);
                $entry->winningplace = $placing;
                $entry->save();
            }
        }
        return redirect()->back();
    }

    public function forWebSite(): View
    {
        $categoryList = [];
        $sections = Section::inOrder()->get();
        foreach ($sections as $section) {
            /**
             * @var Section $section
             */
            $categoryList[$section->id] = $section->categories()
                ->where('year', config('app.year'))
                ->orderBy('sortorder', 'asc')
                ->get();
        }
        return view(
            'sections.forWebSite',
            [
                'things' => $sections,
                'categoryList' => $categoryList,
            ]
        );
    }
}
