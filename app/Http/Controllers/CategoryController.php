<?php

namespace App\Http\Controllers;

use App\Category;
use App\Entrant;
use App\Entry;
use App\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use \Illuminate\View\View;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index(Request $request): View
    {
        $year = $this->getYearFromRequest($request);

        $winners      = array();
        $results      = [];
        $categoryList = [];
        $sectionList  = [];

        $sections = Section::orderBy('number', 'asc')->get();

        foreach ($sections as $section) {
            $sectionList[$section->id]  = $section->id . ' ' . $section->name;
            $categoryList[$section->id] = [];
            $categories                 = $section->categories()->where('status', 'active')->orderBy('sortorder', 'asc')
                ->where('year', $year)
                ->get();

            foreach ($categories as $category) {
                /**
                 * @var Category $category
                 */
                $categoryList[$section->id][$category->id] = $category;
                $placements                                = $category->entries()
                    ->whereNotNull('winningplace')
                    ->whereNotIn('winningplace', [''])
                    ->where('year', $year)
                    ->orderBy('winningplace')
                    ->get();
                $total                                     = $category->entries()
                    ->where('year', $year)
                    ->select(DB::raw('count(*) as total'))
                    ->groupBy('category_id')->first();

                $results[$category->id] = [
                    'placements'    => $placements,
                    'total_entries' => (($total !== null) ? $total->total : 0)
                ];

                foreach ($placements as $placement) {
                    if (empty($winners[$placement->entrant_id])) {
                        $winners[$placement->entrant_id] = Entrant::find($placement->entrant_id);
                    }
                }
            }
        }
        return view(
            'categories.index',
            [
                'things'          => $categories,
                'categoryList'    => $categoryList,
                'sectionList'     => $sectionList,
                'results'         => $results,
                'winners'         => $winners,
                'year'            => $year,
                'is_current_year' => ($year == (int) date('Y')),
                'isLocked'        => config('app.state') == 'locked',
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function create(array $extraData = []): View
    {
        $sections = Section::pluck('name', 'id');
        return view('categories.create', ['sections' => $sections]);
    }

    public function resultsentry(Request $request): View
    {
        $this->authorize('enterResults', Entry::class);
        $entries    = [];
        $winners    = [];
        $section    = Section::findOrFail($request->section);
        $categories = $section->categories()
            ->where('year', config('app.year'))
            ->orderby('sortorder')
            ->get();
        foreach ($categories as $category) {
            $thisEntries            = $category->entries()
                ->where('year', config('app.year'))
                ->orderBy('entrant_id')->get();
            $entries[$category->id] = [];
            $winners[$category->id] = [];

            foreach ($thisEntries as $entry) {
                $entrant = Entrant::find($entry->entrant_id);
                if ('' != trim($entry->winningplace)) {
                    $winners[$category->id][$entry->entrant_id] = $entry->winningplace;
                }
                $entries[$category->id][$entry->id] = [
                    'entrant_id'     => $entry->entrant_id,
                    'entrant_name'   => $entrant->getName(),
                    'entrant_number' => $entrant->getEntrantNumber(),
                ];
            }
        }
        return view('categories.resultsentry', array(
            'categories' => $categories,
            'entries'    => $entries,
            'section'    => $section,
            'winners'    => $winners,
        ));
    }

    /**
     * This prints all the category cards for the show entries to put on the tabless
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|View
     */
    function printcards()
    {
        $this->authorize('printCards', Entry::class);
        $categories = Category::where('year', config('app.year'))->get();
        $cardFronts = [];

        foreach ($categories as $category) {
            $cardFronts[] = [
                'class_number' => $category->number,
                'class_name'   => $category->name
            ];
        }

        return view('categories.printcards', ['card_fronts' => $cardFronts]);
    }

    /**
     *
     * This prints the lookup sheet to look up where entry categories are
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|View
     */
    function printlookups()
    {
        $categories = Category::where('year', config('app.year'))->orderBy('section_id')->orderBy('sortorder')->get();
        $cardFronts = [];

        foreach ($categories as $category) {
            $section      = $category->section;
            $cardFronts[] = [
                'section'      => $section->id,
                'section_name' => $section->name,
                'class_number' => $category->number,
                'class_name'   => $category->name
            ];
        }

        return view('categories.printlookups', ['card_fronts' => $cardFronts]);
    }

    public function storeresults(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('enterResults', Entry::class);
        foreach ($request->positions as $categoryId => $placings) {
            foreach ($placings as $entryId => $result) {
                if ('0' !== $result && '' != trim($result)) {
                    $entry               = Entry::where(['id' => $entryId, 'category_id' => $categoryId])->first();
                    $entry->winningplace = $result;
                    $entry->save();
                }
            }
        }
        return redirect()->route('categories.index');
    }
}
