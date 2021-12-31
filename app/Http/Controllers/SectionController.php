<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Entry;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SectionController extends Controller
{
    public function index(): View
    {
        $sections = Section::orderBy('number', 'asc')
            ->get();
        return view(
            'sections.index',
            [
                'things' => $sections,
                'isAdmin' => Auth::check() && Auth::User()->isAdmin()
            ]
        );
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function resultsentry(Request $request): View
    {
        $show = $this->getShowFromRequest($request);
        $this->authorize('enterResults', Entry::class);
        $entries = [];
        $winners = [];
        $section = Section::findOrFail($request->section);
        $categories = $section->categories()
            ->with(['entries', 'entries.entrant'])
            ->where('show_id', $show->id)
            ->orderby('sortorder')
            ->get();

        foreach ($categories as $category) {
            /** @var Category $category */
            $thisEntries = $category
                ->entries()
                ->orderBy('entrant_id')
                ->get();

            $entries[$category->id] = [];
            $winners[$category->id] = [];

            foreach ($thisEntries as $entry) {
                /** @var Entry $entry */
                if (!empty($entry->winningplace)) {
                    $winners[$category->id][$entry->entrant->id] = $entry->winningplace;
                }
                $entries[$category->id][$entry->id] = [
                    'entrant_id' => $entry->entrant->id,
                    'entrant_name' => $entry->entrant->full_name,
                    'entrant_number' => $entry->entrant->entrant_number,
                ];
            }
        }
        return view('sections.resultsentry', array(
            'categories' => $categories,
            'entries' => $entries,
            'section' => $section,
            'winners' => $winners,
            'show' => $show
        ));
    }

    public function storeresults(Request $request): RedirectResponse
    {
        $this->authorize('enterResults', Entry::class);
        foreach ($request->positions as $categoryId => $placings) {
            foreach ($placings as $entryId => $result) {
                if ('0' !== $result && '' != trim($result)) {
                    $entry = Entry::where(
                        [
                            'id' => $entryId,
                            'category_id' => $categoryId
                        ])->first();
                    $entry->winningplace = $result;
                    $entry->save();
                }
            }
        }
        return redirect()->route('categories.index');
    }

    public function forwebsite(): View
    {
        $categoryList = [];
        $sections = Section::orderBy('number', 'asc')
            ->get();
        foreach ($sections as $section) {
            /**
             * @var Section $section
             */
            $categoryList[$section->id] = $section->categories()
                ->where('year', config('app.year'))
                ->orderBy('sortorder', 'asc')
                ->get();
//
//            if ($lastSection !== $category->section) {
//                $categoryList[$category->section] = [];
//            }
//            $categoryList[$category->section][$category->id] = $category;
//
//            $lastSection = $category->section;
        }
        //var_dump(count($categoryList[9]));die();
        return view(
            'sections.forwebsite',
            [
                'things' => $sections,
                'categoryList' => $categoryList,
            ]
        );
    }
}
