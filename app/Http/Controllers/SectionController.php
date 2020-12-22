<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SectionController extends Controller
{
    public function index(array $extraData = []): View
    {
        $sections = Section::orderBy('number', 'asc')
            ->get();

        return view(
            'sections.index',
            [
                'things'  => $sections,
                'isAdmin' => Auth::check() && Auth::User()->isAdmin()
            ]
        );
    }    //

    public function forwebsite(array $extraData = []): View
    {
        $winners      = array();
        $results      = [];
        $lastSection  = 'notasection';
        $categoryList = [];
        $sections       = Section::orderBy('number', 'asc')
            ->get();

        foreach ($sections as $section) {
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
                'things'       => $sections,
                'categoryList' => $categoryList,
            ]
        );
    }
}
