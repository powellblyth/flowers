<?php

namespace App\Http\Controllers;

use App\Category;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SectionController extends Controller {
    protected $templateDir = 'sections';
    protected $baseClass = 'App\Section';
    public function index(array $extraData = []): View {
        $things = Section::orderBy('number', 'asc')
            ->get();

        return view($this->templateDir . '.index',
            [
                'things' => $things,
                'isAdmin' => Auth::check() && Auth::User()->isAdmin()
        ]);
    }    //
    public function forwebsite(array $extraData = []): View {
        $winners = array();
        $results = [];
        $lastSection = 'notasection';
        $categoryList = [];
        $things = Section::orderBy('number', 'asc')
            ->get();

        foreach ($things as $section) {
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
        return view($this->templateDir . '.forwebsite', [
                'things' => $things,
                'categoryList'=>$categoryList,
            ]
        );
    }}
