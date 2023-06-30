<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Entry;
use App\Models\Section;
use App\Models\Show;
use App\Traits\Controllers\HasShowSwitcher;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
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
            ]
        );
    }

    /**
     * This prints all the category cards for the show entries to put on the tables
     * @throws AuthorizationException
     */
    public function printCards(Request $request, Show $show): Factory|View
    {
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
    public function printLookups(Request $request, Show $show): Factory|View
    {
        $categories = Category::forShow($show)
            ->inOrder()
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
