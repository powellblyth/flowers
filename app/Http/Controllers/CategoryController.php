<?php

namespace App\Http\Controllers;

use App\Category;
use App\Entrant;
use App\Entry;
use App\Section;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\View\View;

class CategoryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    protected $templateDir = 'categories';
    protected $baseClass = 'App\Category';
    protected $sections = ['1 - Novices' => '1 - Novices',
        '2 - Flowers' => '2 - Flowers',
        '3 - Fruit' => '3 - Fruit',
        '4 - Vegetables' => '4 - Vegetables',
        '5 - Floral Arrangements' => '5 - Floral Arrangements',
        '6 - Cookery' => '6 - Cookery',
        '7 - Arts and Crafts' => '7 - Arts and Crafts',
        '8 - Childrens Floral, Fruit and Vegetables' => '8 - Childrens Floral, Fruit and Vegetables',
        '9 - Childrens Cookery, Arts & Crafts' => '9 - Childrens Cookery, Arts & Crafts',
        '7 - Arts and Crafts' => '7 - Arts and Crafts',
    ];

    public function index(array $extraData = []): View {
        $winners = array();
        $results = [];
        $categoryList = [];
        $sectionList = [];

        $sections = Section::orderBy('number', 'asc')->get();
        $things = Category::orderBy('sortorder', 'asc')
            ->where('year', env('CURRENT_YEAR', 2018))
            ->get();

        foreach ($sections as $section) {
            $sectionList[$section->id] = $section->id . ' ' . $section->name;
            $categoryList[$section->id] = [];
            $categories = $section->categories()->orderBy('sortorder', 'asc')
                ->where('year', env('CURRENT_YEAR', 2018))
                ->get();

            foreach ($categories as $category) {
                $categoryList[$section->id][$category->id] = $category;
                $placements = $category->entries()
                    ->whereNotNull('winningplace')
                    ->whereNotIn('winningplace', [''])
                    ->where('year', env('CURRENT_YEAR', 2018))
                    ->orderBy('winningplace')
                    ->get();
                $total = Entry::where('category_id', $category->id)
                    ->where('year', env('CURRENT_YEAR', 2018))
                    ->select(DB::raw('count(*) as total'))
                    ->groupBy('category_id')->first();

                $results[$category->id] = ['placements' => $placements,
                    'total_entries' => (($total !== null) ? $total->total : 0)];

                foreach ($placements as $placement) {
                    if (empty($winners[$placement->entrant_id])) {
                        $winners[$placement->entrant_id] = Entrant::find($placement->entrant_id);
                    }
                }
            }
        }
        return view($this->templateDir . '.index', array_merge($extraData,
            array(
                'things' => $things,
                'categoryList' => $categoryList,
                'sectionList' => $sectionList,
                'results' => $results,
                'winners' => $winners,
                'isAdmin' => Auth::check() && Auth::User()->isAdmin())));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

    public function create(array $extraData = []): View {
        return view($this->templateDir . '.create', ['sections' => $this->sections]);
    }

    public function resultsentry(Request $request): View {
        $entries = [];
        $winners = [];
        $section = Section::find($request->section);
        $categories = $section->categories()
            ->where('year', env('CURRENT_YEAR', 2018))
            ->orderby('sortorder')
            ->get();
        foreach ($categories as $category) {
            $thisEntries = $category->entries()
                ->where('year', env('CURRENT_YEAR', 2018))
                ->orderBy('entrant_id')->get();
            $entries[$category->id] = [];
            $winners[$category->id] = [];

            foreach ($thisEntries as $entry) {
                $entrant = Entrant::find($entry->entrant_id);
                if ('' != trim($entry->winningplace)) {
                    $winners[$category->id][$entry->entrant_id] = $entry->winningplace;
                }
                $entries[$category->id][$entry->id] = [
                    'entrant_id' => $entry->entrant_id,
                    'entrant_name' => $entrant->getName()
                ];
            }
        }
        return view($this->templateDir . '.resultsentry', array('categories' => $categories,
            'entries' => $entries,
            'section' => $request->section,
            'winners' => $winners,
            'isAdmin' => Auth::User()->isAdmin()));
    }

    public function storeresults(Request $request): \Illuminate\Http\RedirectResponse {
        foreach ($request->positions as $categoryId => $placings) {
            foreach ($placings as $entryId => $result) {
                if ('0' !== $result && '' != trim($result)) {
                    $entry = Entry::where(['id' => $entryId, 'category_id' => $categoryId])->first();
                    $entry->winningplace = $result;
                    $entry->save();
                }
            }
        }
        return redirect()->route('categories.index');
    }
}
