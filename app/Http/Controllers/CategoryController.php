<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Entry;
use App\Models\Section;
use App\Models\Show;
use App\Traits\Controllers\HasShowSwitcher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    use HasShowSwitcher;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function index(Request $request): RedirectResponse
    {
        $show = $this->getShowFromRequest($request);
        return redirect(route('show.categories', ['show' => $show]), 301);
    }

    /**
     * Display a listing of the resource.
     */
    public function forShow(Request $request, Show $show): View
    {
        $sections = Section::orderBy('number', 'asc')->get();

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
     * This prints all the category cards for the show entries to put on the tables
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function printcards(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $show = $this->getShowFromRequest($request);
        $this->authorize('printCards', Entry::class);
        $categories = Category::where('show_id', $show->id)->inOrder()->get();
        $cardFronts = [];

        foreach ($categories as $category) {
            /** @var Category $category */
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
