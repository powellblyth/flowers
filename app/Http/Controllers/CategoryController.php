<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Entrant;
use App\Models\Entry;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $show = $this->getShowFromRequest($request);

        $sections = Section::orderBy('number', 'asc')->with(
            [
                'categories',
                'categories.entries',
            ]
        )
            ->get();


        return view(
            'categories.index',
            [
                'sections' => $sections,
                'show' => $show,
                'isLocked' => config('app.state') == 'locked',
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
     * @return Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy()
    {
        //
    }

    public function create(): View
    {
        $sections = Section::pluck('name', 'id');
        return view('categories.create', ['sections' => $sections]);
    }

    /**
     * This prints all the category cards for the show entries to put on the tables
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function printcards(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $show = $this->getShowFromRequest($request);
        $this->authorize('printCards', Entry::class);
        $categories = Category::where('show_id', $show->id)->get();
        $cardFronts = [];

        foreach ($categories as $category) {
            /**
             * @var Category $category
             */
            $cardFronts[] = [
                'class_number' => $category->number,
                'class_name' => $category->name
            ];
        }

        return view('categories.printcards', ['show' => $show, 'card_fronts' => $cardFronts]);
    }

    /**
     *
     * This prints the lookup sheet to look up where entry categories are
     */
    public function printlookups(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $show = $this->getShowFromRequest($request);
        $categories = Category::where('show_id', $show->id)
            ->orderBy('section_id')
            ->orderBy('sortorder')
            ->get();
        $cardFronts = [];

        foreach ($categories as $category) {
            /**
             * @var Category $category
             */
            $section = $category->section;
            $cardFronts[] = [
                'section' => $section->id,
                'section_name' => $section->name,
                'class_number' => $category->number,
                'class_name' => $category->name
            ];
        }

        return view('categories.printlookups', ['card_fronts' => $cardFronts]);
    }
}
